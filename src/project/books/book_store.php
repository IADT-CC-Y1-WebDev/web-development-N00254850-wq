<?php
/**
 * User Registration Handler - Exercise
 *
 * Follow the steps below to progressively implement form handling.
 * Each step corresponds to an example in /examples/04-php-forms/
 *
 * This file processes the form submission from book_create.php
 */
 
 
// =============================================================================
// Write your code here
// =============================================================================
// Include the required library files
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';
 
$data = [];
$errors = [];
 
// Start the session
startSession();
 
 
try {
 
 
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }
 
    $data = [
        "title" => $_POST["title"] ?? null,
        "author" => $_POST["author"] ?? null,
        "publisher_id" => $_POST["publisher_id"] ?? null,
        "year" => $_POST["year"] ?? null,
        "isbn" => $_POST["isbn"] ?? null,
        "format_ids" => $_POST["format_ids"] ?? [],
        "description" => $_POST["description"] ?? null,
        "cover" => $_FILES["cover"] ?? null,
 
    ];
 
 
 
    
    $rules = [
        "title" => "required|noempty|min:5|max:255",
        "author" => "required|noempty|min:5|max:255",
        "publisher_id" => "required|noempty|integer",
        "year" => "required|noempty|integer|minvalue:1900|maxvalue:2026",
        "isbn" => "required|noempty|min:13|max:13",
        "format_ids" => "required|noempty|array|min:1|max:4",
        "description" => "required|noempty|min:10",
        "cover" => "required|file|image|mimes:jpg,jpeg,png|max_file_size:5242880",
 
    ];
    $validator = new Validator($data, $rules);
 
    if ($validator->fails()) {
        foreach ($validator->errors() as $fields => $fieldErrors) {
            $errors[$fields] = $fieldErrors[0];
        }
        throw new Exception("Validation failed");
    }
 
    $uploader = new ImageUpload();
    $imageFilename = $uploader->process($_FILES["cover"]);
 
    $book = new Book();
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->publisher_id = $data['publisher_id'];
    $book->year = $data['year'];
    $book->isbn = $data['isbn'];
    $book->format_ids = $data['format_ids'];
    $book->description = $data['description'];
    $book->cover_filename = $imageFilename;
    $book->save();
 
    // Create format associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $formatId) {
            // Verify format exists before creating relationship
            if (Format::findById($formatId)) {
                BookFormat::create($book->id, $formatId);
            }
        }
    }
    clearFormData();
    clearFormErrors();
   
 
    setFlashMessage("success", "Form validated successfully!");
    redirect("book_view.php?id=" . $book->id);
}
catch (Exception $e) {
 
    setFormErrors($errors);
 
    setFormData($data);
 
    setFlashMessage("error", "Form validation failed!");
 
    redirect("book_create.php");
}