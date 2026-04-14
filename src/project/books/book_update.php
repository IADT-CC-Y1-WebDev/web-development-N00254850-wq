<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    // Initialize form data array
    $data = [];
    // Initialize errors array
    $errors = [];
    
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get form data
    $data = [
        'id' => $_POST['id'] ?? null,
        'title' => $_POST['title'] ?? null,
        "author" => $_POST["author"] ?? null,
        'year' => $_POST['year'] ?? null,
        "isbn" => $_POST["isbn"] ?? null,
        'publisher_id' => $_POST['publisher_id'] ?? null,
        'description' => $_POST['description'] ?? null,
        'format_ids' => $_POST['format_ids'] ?? [],
        'image' => $_FILES['image'] ?? null
    ];

    // Define validation rules
    $rules = [
        'id' => 'required|integer',
        'title' => 'required|notempty|min:1|max:255',
        "author" => "required|notempty|min:5|max:255",
        'year' => 'required|notempty',
        "isbn" => "required|notempty|min:13|max:13",
        'publisher_id' => 'required|integer',
        'description' => 'required|notempty|min:10|max:5000',
        'format_ids' => 'required|array|min:1|max:10',
        'image' => 'file|image|mimes:jpg,jpeg,png|max_file_size:5242880' // optional -- no required rule
    ];

    // Validate all data (including file)
    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        // Get first error for each field
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    // Find existing book
    $book = Book::findById($data['id']);
    if (!$book) {
        throw new Exception('Book not found.');
    }

    // Verify publisher exists
    $publisher = Publisher::findById($data['publisher_id']);
    if (!$publisher) {
        throw new Exception('Selected publisher does not exist.');
    }

    // Verify formats exist
    foreach ($data['format_ids'] as $formatId) {
        if (!Format::findById($formatId)) {
            throw new Exception('One or more selected formats do not exist.');
        }
    }

    // Process the uploaded image (validation already completed)
    $imageFilename = null;
    $uploader = new ImageUpload();
    if ($uploader->hasFile('image')) {
        // Delete old image
        $uploader->deleteImage($book->cover_filename);
        // Process new image
        $imageFilename = $uploader->process($_FILES['image']);
        // Check for processing errors
        if (!$imageFilename) {
            throw new Exception('Failed to process and save the image.');
        }
    }

    // Update the book instance
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->year = $data['year'];
    $book->publisher_id = $data['publisher_id'];
    $book->description = $data['description'];
    $book->cover_filename = $book->cover_filename; // keep existing filename if no new image uploaded
    $book->isbn = $data['isbn'];
    if ($imageFilename) {
        $book->cover_filename = $imageFilename;
    }

    // Save to database
    $book->save();

    // Delete existing format associations
    BookFormat::deleteByBook($book->id);
    // Create new format associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $formatId) {
            BookFormat::create($book->id, $formatId);
        }
    }

    // Clear any old form data
    clearFormData();
    // Clear any old errors
    clearFormErrors();

    // Set success flash message
    setFlashMessage('success', 'Book updated successfully.');

    // Redirect to book details page
    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    // Error - clean up uploaded image
    if ($imageFilename) {
        $uploader->deleteImage($imageFilename);
    }

    // Set error flash message
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    // Store form data and errors in session
    setFormData($data);
    setFormErrors($errors);

    // Redirect back to edit page if there is an ID; otherwise, go to index page
    if (isset($data['id']) && $data['id']) {
        redirect('book_edit.php?id=' . $data['id']);
    }
    else {
        redirect('index.php');
    }
}
