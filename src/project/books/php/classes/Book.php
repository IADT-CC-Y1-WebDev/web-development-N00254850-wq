<?php
/**
 * Book Active Record Class
 *
 * This class implements the Active Record pattern for the books table.
 * Each instance represents a single book record.
 *
 * Usage:
 *   // Find books
 *   $books = Book::findAll();
 *   $book = Book::findById(1);
 *
 *   // Create new book
 *   $book = new Book();
 *   $book->title = "New Book";
 *   $book->save();
 *
 *   // Update existing book
 *   $book = Book::findById(1);
 *   $book->title = "Updated Title";
 *   $book->save();
 *
 *   // Delete book
 *   $book->delete();
 */
class Book
{
    public $id;
    public $title;
    public $release_date;
    public $genre_id;
    public $description;
    public $image_filename;

    private $db;

    /**
     * Constructor - optionally hydrate from data array
     */
    public function __construct($data = [])
    {
        $this->db = DB::getInstance()->getConnection();

        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->release_date = $data['release_date'] ?? null;
            $this->genre_id = $data['genre_id'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->image_filename = $data['image_filename'] ?? null;
        }
    }

    /**
     * Find all books ordered by title
     *
     * @return Book[] Array of Book objects
     */
    public static function findAll()
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books ORDER BY title");
        $stmt->execute();

        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new Book($row);
        }

        return $books;
    }

    /**
     * Find a book by its ID
     *
     * @param int $id The book ID
     * @return Book|null The book object or null if not found
     */
    public static function findById($id)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if ($row) {
            return new Book($row);
        }

        return null;
    }

    /**
     * Find books by genre
     *
     * @param int $genreId The genre ID
     * @return Book[] Array of Book objects
     */
    public static function findByGenre($genreId)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE genre_id = :genre_id ORDER BY title");
        $stmt->execute(['genre_id' => $genreId]);

        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new Book($row);
        }

        return $books;
    }

    /**
     * Find books by platform (uses JOIN)
     *
     * @param int $platformId The platform ID
     * @return Book[] Array of Book objects
     */
    public static function findByPlatform($platformId)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT b.*
            FROM books b
            INNER JOIN book_platform bp ON b.id = bp.book_id
            WHERE bp.platform_id = :platform_id
            ORDER BY b.title
        ");
        $stmt->execute(['platform_id' => $platformId]);

        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new Book($row);
        }

        return $books;
    }

    /**
     * Save the book (INSERT if new, UPDATE if existing)
     *
     * @throws Exception If save fails
     */
    public function save()
    {
        $isUpdate = !empty($this->id);

        if ($isUpdate) {
            // Update existing record
            $stmt = $this->db->prepare("
                UPDATE books
                SET title = :title,
                    release_date = :release_date,
                    genre_id = :genre_id,
                    description = :description,
                    image_filename = :image_filename
                WHERE id = :id
            ");

            $params = [
                'title' => $this->title,
                'release_date' => $this->release_date,
                'genre_id' => $this->genre_id,
                'description' => $this->description,
                'image_filename' => $this->image_filename,
                'id' => $this->id
            ];
        } else {
            // Insert new record
            $stmt = $this->db->prepare("
                INSERT INTO books (title, release_date, genre_id, description, image_filename)
                VALUES (:title, :release_date, :genre_id, :description, :image_filename)
            ");

            $params = [
                'title' => $this->title,
                'release_date' => $this->release_date,
                'genre_id' => $this->genre_id,
                'description' => $this->description,
                'image_filename' => $this->image_filename
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
                throw new Exception("Failed to save book.");
            }
        } else {
            $lastId = $this->db->lastInsertId();
            if (empty($lastId)) {
                throw new Exception("Failed to save book.");
            }
            $this->id = $lastId;
        }
    }

    /**
     * Delete this book from the database
     *
     * @return bool True if deleted successfully
     */
    public function delete()
    {
        if (!$this->id) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
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
            'title' => $this->title,
            'release_date' => $this->release_date,
            'genre_id' => $this->genre_id,
            'description' => $this->description,
            'image_filename' => $this->image_filename
        ];
    }
}
