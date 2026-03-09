<?php
<<<<<<< HEAD
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
=======
// =============================================================================
// Exercise 8-10: Book Active Record Class
//
// TODO: Implement this class following the Active Record pattern.
//
// The class should represent the 'books' table with these columns:
// - id (INT, auto-increment primary key)
// - title (VARCHAR)
// - author (VARCHAR)
// - publisher_id (INT, foreign key to publishers table)
// - year (INT)
// - isbn (VARCHAR)
// - description (TEXT)
// - cover_filename (VARCHAR)
//
// Required methods:
// - __construct($data = []) - Hydrate object from data array
// - findAll() - Static method returning all books
// - findById($id) - Static method returning single book or null
// - findByPublisher($publisherId) - Static method returning books by publisher
// - save() - Instance method to INSERT or UPDATE
// - delete() - Instance method to DELETE
// - toArray() - Instance method to convert to array
// =============================================================================
class Book
{
    // public properties for each database column
    public $id;
    public $title;
    public $author;
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
    public $publisher_id;
    public $year;
    public $isbn;
    public $description;
    public $cover_filename;
<<<<<<< HEAD

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
=======
 
    // private $db property for database connection
    private $db;
 
    // =========================================================================
    // Exercise 8: Book Class Basics
    // =========================================================================
    public function __construct($data = [])
    {
        // TODO: Get database connection from DB singleton
        // TODO: If $data is not empty, populate properties using null coalescing operator
        $this->db = DB::getInstance()->getConnection();
       
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->author = $data['author'] ?? null;
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
            $this->publisher_id = $data['publisher_id'] ?? null;
            $this->year = $data['year'] ?? null;
            $this->isbn = $data['isbn'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->cover_filename = $data['cover_filename'] ?? null;
<<<<<<< HEAD
        }
    }

    /**
     * Find all books ordered by title
     *
     * @return Book[] Array of Book objects
     */
=======
 
 
        }
    }
 
    // =========================================================================
    // Exercise 9: Finder Methods
    // =========================================================================
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
    public static function findAll()
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books ORDER BY title");
        $stmt->execute();
<<<<<<< HEAD

=======
 
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new Book($row);
        }
<<<<<<< HEAD

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
        $stmt = $db->prepare("SELECT * FROM books WHERE publisher_id = :publisher_id ORDER BY title");
        $stmt->execute(['publisher_id' => $genreId]);

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
=======
 
        return $books;
    }
 
    // =========================================================================
    // Exercise 9: Finder Methods
    // =========================================================================
    public static function findById($id)
    {
        // TODO: Implement this method
 
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute(["id" => $id]);
 
        $book = $stmt->fetch();
        if ($book) {
            return new Book($book);
        }
 
        return null;
    }
 
    // =========================================================================
    // Exercise 9: Finder Methods
    // =========================================================================
    public static function findByPublisher($publisherId)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE publisher_id = :publisher_id");
        $stmt->execute(["publisher_id" => $publisherId]);
 
        $rows = $stmt->fetchAll();
 
        $books = [];
 
        foreach ($rows as $row) {
            $books[] = new Book($row);
        }
 
        return $books;
    }
 
 
    // =========================================================================
    // Exercise 10: Complete Active Record
    // =========================================================================
    public function save()
    {
        if ($this->id) {
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
            // Update existing record
            $stmt = $this->db->prepare("
                UPDATE books
                SET title = :title,
<<<<<<< HEAD
                    year = :year,
                    publisher_id = :publisher_id,
=======
                    author = :author,
                    publisher_id = :publisher_id,
                    year = :year,
                    isbn = :isbn,
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
                    description = :description,
                    cover_filename = :cover_filename
                WHERE id = :id
            ");
<<<<<<< HEAD

            $params = [
                'title' => $this->title,
                'year' => $this->year,
                'publisher_id' => $this->publisher_id,
=======
 
            $params = [
                'title' => $this->title,
                'author' => $this->author,
                'publisher_id' => $this->publisher_id,
                'year' => $this->year,
                'isbn' => $this->isbn,
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
                'description' => $this->description,
                'cover_filename' => $this->cover_filename,
                'id' => $this->id
            ];
        } else {
            // Insert new record
            $stmt = $this->db->prepare("
<<<<<<< HEAD
                INSERT INTO books (title, year, publisher_id, description, cover_filename)
                VALUES (:title, :year, :publisher_id, :description, :cover_filename)
            ");

            $params = [
                'title' => $this->title,
                'year' => $this->year,
                'publisher_id' => $this->publisher_id,
=======
                INSERT INTO books (title, author, publisher_id, year, isbn, description, cover_filename)
                VALUES (:title, :author, :publisher_id, :year, :isbn, :description, :cover_filename)
            ");
 
            $params = [
                'title' => $this->title,
                'author' => $this->author,
                'publisher_id' => $this->publisher_id,
                'year' => $this->year,
                'isbn' => $this->isbn,
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
                'description' => $this->description,
                'cover_filename' => $this->cover_filename
            ];
        }
<<<<<<< HEAD

        // Execute statement
        $status = $stmt->execute($params);

=======
 
        // Execute statement
        $status = $stmt->execute($params);
 
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
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
<<<<<<< HEAD

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
=======
 
        // Ensure one row affected
        if ($stmt->rowCount() !== 1) {
            throw new Exception("Failed to save book.");
        }
 
        // Set ID for new records
        if ($this->id === null) {
            $this->id = $this->db->lastInsertId();
        }
    }
 
    // =========================================================================
    // Exercise 10: Complete Active Record
    // =========================================================================
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
    public function delete()
    {
        if (!$this->id) {
            return false;
        }
<<<<<<< HEAD

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
            'year' => $this->year,
            'publisher_id' => $this->publisher_id,
            'description' => $this->description,
            'cover_filename' => $this->cover_filename
        ];
    }
}
=======
 
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }
 
    // =========================================================================
    // Exercise 8: Book Class Basics
    // =========================================================================
    public function toArray()
    {
 
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'publisher_id' => $this->publisher_id,
            'year' => $this->year,
            'isbn' => $this->isbn,
            'description' => $this->description,
            'cover_filename' => $this->cover_filename
 
        ];
    }
}
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
