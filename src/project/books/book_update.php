<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';
<<<<<<< HEAD
require_once 'php/classes/Validator.php';
=======
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d

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
<<<<<<< HEAD
        'release_date' => $_POST['release_date'] ?? null,
        'genre_id' => $_POST['genre_id'] ?? null,
        'description' => $_POST['description'] ?? null,
        'platform_ids' => $_POST['platform_ids'] ?? [],
=======
        'year' => $_POST['year'] ?? null,
        'publisher_id' => $_POST['publisher_id'] ?? null,
        'description' => $_POST['description'] ?? null,
        'format_ids' => $_POST['format_ids'] ?? [],
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
        'image' => $_FILES['image'] ?? null
    ];

    // Define validation rules
    $rules = [
        'id' => 'required|integer',
        'title' => 'required|notempty|min:1|max:255',
<<<<<<< HEAD
        'release_date' => 'required|notempty',
        'genre_id' => 'required|integer',
        'description' => 'required|notempty|min:10|max:5000',
        'platform_ids' => 'required|array|min:1|max:10',
=======
        'year' => 'required|notempty',
        'publisher_id' => 'required|integer',
        'description' => 'required|notempty|min:10|max:5000',
        'format_ids' => 'required|array|min:1|max:10',
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
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

<<<<<<< HEAD
    // Verify genre exists
    $genre = Genre::findById($data['genre_id']);
    if (!$genre) {
        throw new Exception('Selected genre does not exist.');
    }

    // Verify platforms exist
    foreach ($data['platform_ids'] as $platformId) {
        if (!Platform::findById($platformId)) {
            throw new Exception('One or more selected platforms do not exist.');
=======
    // Verify publisher exists
    $publisher = Publisher::findById($data['publisher_id']);
    if (!$publisher) {
        throw new Exception('Selected publisher does not exist.');
    }

    // Verify formats exist
    foreach ($data['format_ids'] as $formatId) {
        if (!Format::findById($formatId)) {
            throw new Exception('One or more selected formats do not exist.');
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
        }
    }

    // Process the uploaded image (validation already completed)
    $imageFilename = null;
    $uploader = new ImageUpload();
    if ($uploader->hasFile('image')) {
        // Delete old image
<<<<<<< HEAD
        $uploader->deleteImage($book->image_filename);
=======
        $uploader->deleteImage($book->cover_filename);
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
        // Process new image
        $imageFilename = $uploader->process($_FILES['image']);
        // Check for processing errors
        if (!$imageFilename) {
            throw new Exception('Failed to process and save the image.');
        }
    }

    // Update the book instance
    $book->title = $data['title'];
<<<<<<< HEAD
    $book->release_date = $data['release_date'];
    $book->genre_id = $data['genre_id'];
    $book->description = $data['description'];
    if ($imageFilename) {
        $book->image_filename = $imageFilename;
=======
    $book->year = $data['year'];
    $book->publisher_id = $data['publisher_id'];
    $book->description = $data['description'];
    $book->cover_filename = $book->cover_filename; // keep existing filename if no new image uploaded
    $book->isbn = $data['isbn'];
    if ($imageFilename) {
        $book->cover_filename = $imageFilename;
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
    }

    // Save to database
    $book->save();

<<<<<<< HEAD
    // Delete existing platform associations
    BookPlatform::deleteByBook($book->id);
    // Create new platform associations
    if (!empty($data['platform_ids']) && is_array($data['platform_ids'])) {
        foreach ($data['platform_ids'] as $platformId) {
            BookPlatform::create($book->id, $platformId);
=======
    // Delete existing format associations
    BookFormat::deleteByBook($book->id);
    // Create new format associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $formatId) {
            BookFormat::create($book->id, $formatId);
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
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
