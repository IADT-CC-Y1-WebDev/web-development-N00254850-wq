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
<<<<<<< HEAD
    $genres = Genre::findAll();
    $platforms = Platform::findAll();
=======
    $publishers = Publisher::findAll();
    $formats = Format::findAll();
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
}
catch (PDOException $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());
    redirect('/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <title>View Book</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
            <div class="width-12">
                <h1>Create Book</h1>
            </div>
            <div class="width-12">
                <form action="book_store.php" method="POST" enctype="multipart/form-data">
                    <div class="input">
                        <label class="special" for="title">Title:</label>
                        <div>
                            <input type="text" id="title" name="title" value="<?= old('title') ?>" required>
                            <p><?= error('title') ?></p>
                        </div>
                    </div>
                    <div class="input">
<<<<<<< HEAD
                        <label class="special" for="release_date">Release Year:</label>
                        <div>
                            <input type="date" id="release_date" name="release_date" value="<?= old('release_date') ?>" required>
                            <p><?= error('release_date') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="genre_id">Genre:</label>
                        <div>
                            <select id="genre_id" name="genre_id" required>
                                <?php foreach ($genres as $genre) { ?>
                                    <option value="<?= h($genre->id) ?>" <?= chosen('genre_id', $genre->id) ? "selected" : "" ?>>
                                        <?= h($genre->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p><?= error('genre_id') ?></p>
=======
                        <label class="special" for="year">Release year:</label>
                        <div>
                            <input type="date" id="year" name="year" value="<?= old('year') ?>" required>
                            <p><?= error('year') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="publisher_id">Publisher:</label>
                        <div>
                            <select id="publisher_id" name="publisher_id" required>
                                <?php foreach ($publishers as $publisher) { ?>
                                    <option value="<?= h($publisher->id) ?>" <?= chosen('publisher_id', $publisher->id) ? "selected" : "" ?>>
                                        <?= h($publisher->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p><?= error('publisher_id') ?></p>
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="description">Description:</label>
                        <div>
                            <textarea id="description" name="description" required><?= old('description') ?></textarea>
                            <p><?= error('description') ?></p>
                        </div>
                    </div>
                    <div class="input">
<<<<<<< HEAD
                        <label class="special">Platforms:</label>
                        <div>
                            <?php foreach ($platforms as $platform) { ?>
                                <div>
                                    <input type="checkbox" 
                                        id="platform_<?= h($platform->id) ?>" 
                                        name="platform_ids[]" 
                                        value="<?= h($platform->id) ?>"
                                        <?= chosen('platform_ids', $platform->id) ? "checked" : "" ?>
                                        >
                                    <label for="platform_<?= h($platform->id) ?>"><?= h($platform->name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <p><?= error('platforms_ids') ?></p>
=======
                        <label class="special">Formats:</label>
                        <div>
                            <?php foreach ($formats as $format) { ?>
                                <div>
                                    <input type="checkbox" 
                                        id="format_<?= h($format->id) ?>" 
                                        name="format_ids[]" 
                                        value="<?= h($format->id) ?>"
                                        <?= chosen('format_ids', $format->id) ? "checked" : "" ?>
                                        >
                                    <label for="format_<?= h($format->id) ?>"><?= h($format->name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <p><?= error('formats_ids') ?></p>
>>>>>>> dfd7591cc3003c60befc11e780e5f1e4f2206d1d
                    </div>
                    <div class="input">
                        <label class="special" for="image">Image (required):</label>
                        <div>
                            <input type="file" id="image" name="image" accept="image/*" required>
                            <p><?= error('image') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <button  class="button" type="submit">Store Book</button>
                        <div class="button"><a href="index.php">Cancel</a></div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
// Clear form data after displaying
clearFormData();
// Clear errors after displaying
clearFormErrors();
?>