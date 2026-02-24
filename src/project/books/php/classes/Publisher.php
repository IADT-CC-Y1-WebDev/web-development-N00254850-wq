<?php
class Publisher
{
    public $id;
    public $name;

    private $db;

    /**
     * Constructor - optionally hydrate from data array
     */
    public function __construct($data = [])
    {
        $this->db = DB::getInstance()->getConnection();

        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
        }
    }

    /**
     * Find all publishers ordered by name
     *
     * @return Publisher[] Array of Publisher objects
     */
    public static function findAll()
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM publishers ORDER BY name");
        $stmt->execute();

        $publishers = [];
        while ($row = $stmt->fetch()) {
            $publishers[] = new Publisher($row);
        }

        return $publishers;
    }

    /**
     * Find a publisher by its ID
     *
     * @param int $id The publisher ID
     * @return Publisher|null The publisher object or null if not found
     */
    public static function findById($id)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM publishers WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if ($row) {
            return new Publisher($row);
        }

        return null;
    }

    /**
     * Find publishers by genre
     *
     * @param int $genreId The genre ID
     * @return Publisher[] Array of Publisher objects
     */
    public static function findByGenre($genreId)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM publishers WHERE genre_id = :genre_id ORDER BY name");
        $stmt->execute(['genre_id' => $genreId]);

        $publishers = [];
        while ($row = $stmt->fetch()) {
            $publishers[] = new Publisher($row);
        }

        return $publishers;
    }

    /**
     * Find publishers by platform (uses JOIN)
     *
     * @param int $platformId The platform ID
     * @return Publisher[] Array of Publisher objects
     */
    public static function findByPlatform($platformId)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT b.*
            FROM publishers b
            INNER JOIN publisher_platform bp ON b.id = bp.publisher_id
            WHERE bp.platform_id = :platform_id
            ORDER BY b.name
        ");
        $stmt->execute(['platform_id' => $platformId]);

        $publishers = [];
        while ($row = $stmt->fetch()) {
            $publishers[] = new Publisher($row);
        }

        return $publishers;
    }

    /**
     * Save the publisher (INSERT if new, UPDATE if existing)
     *
     * @throws Exception If save fails
     */
    public function save()
    {
        $isUpdate = !empty($this->id);

        if ($isUpdate) {
            // Update existing record
            $stmt = $this->db->prepare("
                UPDATE publishers
                SET name = :name
                WHERE id = :id
            ");

            $params = [
                'name' => $this->name,
                'id' => $this->id
            ];
        } else {
            // Insert new record
            $stmt = $this->db->prepare("
                INSERT INTO publishers (name)
                VALUES (:name)
            ");

            $params = [
                'name' => $this->name
            ];
        }

        // Execute statement
        $status = $stmt->execute($params);

        // Check for errors
        if (!$status) {
            $error_info = $stmt->errorInfo();
            $message = sprintf(
                "SQLSTATE error code: %s; error message: %s",
                $error_info[0],
                $error_info[2]
            );
            throw new Exception($message);
        }

        // For updates ensure one row affected; for inserts rely on lastInsertId
        if ($isUpdate) {
            if ($stmt->rowCount() !== 1) {
                throw new Exception("Failed to save publisher.");
            }
        } else {
            $lastId = $this->db->lastInsertId();
            if (empty($lastId)) {
                throw new Exception("Failed to save publisher.");
            }
            $this->id = $lastId;
        }
    }

    /**
     * Delete this publisher from the database
     *
     * @return bool True if deleted successfully
     */
    public function delete()
    {
        if (!$this->id) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM publishers WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }

    /**
     * Convert to array for JSON output
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
