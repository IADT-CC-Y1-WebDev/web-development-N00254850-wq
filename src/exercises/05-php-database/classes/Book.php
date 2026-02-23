<?php
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
    public $publisher_id;
    public $year;
    public $isbn;
    public $description;
    public $cover_filename;
 
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
            $this->publisher_id = $data['publisher_id'] ?? null;
            $this->year = $data['year'] ?? null;
            $this->isbn = $data['isbn'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->cover_filename = $data['cover_filename'] ?? null;
 
 
        }
    }
 
    // =========================================================================
    // Exercise 9: Finder Methods
    // =========================================================================
    public static function findAll()
    {
        // $db = DB::getInstance()->getConnection();
        $stmt = $this->db->prepare("SELECT * FROM books ORDER BY title");
        $stmt->execute();
 
        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new Book($row);
        }
 
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
            return new book($book);
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
            // Update existing record
            $stmt = $this->db->prepare("
                UPDATE books
                SET title = :title,
                    author = :author,
                    publisher_id = :publisher_id,
                    year = :year,
                    isbn = :isbn,
                    description = :description,
                    cover_filename = :cover_filename
                WHERE id = :id
            ");
 
            $params = [
                'title' => $this->title,
                'author' => $this->author,
                'publisher_id' => $this->publisher_id,
                'year' => $this->year,
                'isbn' => $this->isbn,
                'description' => $this->description,
                'cover_filename' => $this->cover_filename,
                'id' => $this->id
            ];
        } else {
            // Insert new record
            $stmt = $this->db->prepare("
                INSERT INTO books (title, author, publisher_id, year, isbn, description, cover_filename)
                VALUES (:title, :author, :publisher_id, :year, :isbn, :description, :cover_filename)
            ");
 
            $params = [
                'title' => $this->title,
                'author' => $this->author,
                'publisher_id' => $this->publisher_id,
                'year' => $this->year,
                'isbn' => $this->isbn,
                'description' => $this->description,
                'cover_filename' => $this->cover_filename
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
    public function delete()
    {
        if (!$this->id) {
            return false;
        }
 
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