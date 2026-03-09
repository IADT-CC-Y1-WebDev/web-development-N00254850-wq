<?php
$topics = [
    'php' => [
        'title' => 'PHP Exercises',
        'items' => [
            '01-php-introduction' => 'Introduction',
            '02-php-classes-objects' => 'Classes and Objects',
            '03-php-cookies-sessions' => 'Cookies and Sessions',
            '04-php-forms' => 'Forms',
            '05-php-database' => 'Database Access',
            '06-php-database' => 'Database Access',
        ]
    ],
    'js' => [
        'title' => 'JavaScript Exercises',
        'items' => [
            '06-js-classes-objects' => 'Classes and Objects',
            '07-js-dom' => 'The Document Object Model',
            '08-js-events' => 'Event Handling',
            '09-js-form-validation' => 'Form Validation',
        ]
    ]
];

// Helper function to list files in a directory
function listFiles($dir) {
    $files = [];
    if (is_dir($dir)) {
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..' && !is_dir($dir . '/' . $item)) {
                $files[] = $item;
            }
        }
    }
    return $files;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Exercises - Assessment View</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Page-specific overrides */
        .topic h3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <h1>Student Exercises - Assessment View</h1>

    <div class="back-link">
        <a href="index.php">&larr; Back to Main Index</a>
    </div>

    <?php foreach ($topics as $section): ?>
        <h2><?= htmlspecialchars($section['title']) ?></h2>

        <?php foreach ($section['items'] as $folder => $name): ?>
            <?php $exerciseDir = __DIR__ . '/' . $folder . '/exercises'; ?>
            <?php $files = listFiles($exerciseDir); ?>
            <div class="topic">
                <h3>
                    <?= htmlspecialchars($name) ?>
                    <a href="<?= $folder ?>/exercises/">Open folder</a>
                </h3>
                <?php if (empty($files)): ?>
                    <p class="empty">No exercises submitted yet</p>
                <?php else: ?>
                    <ul class="file-list">
                        <?php foreach ($files as $file): ?>
                            <li><a href="<?= $folder ?>/exercises/<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <h2>Capstone Project</h2>
    <?php $capstoneFiles = listFiles(__DIR__ . '/capstone'); ?>
    <div class="topic capstone">
        <h3>
            Final Assignment
            <a href="capstone/">Open folder</a>
        </h3>
        <?php
        // List all files/folders in capstone except starter
        $capstoneDir = __DIR__ . '/capstone';
        $capstoneItems = [];
        if (is_dir($capstoneDir)) {
            $items = scandir($capstoneDir);
            foreach ($items as $item) {
                if ($item !== '.' && $item !== '..' && $item !== 'starter') {
                    $capstoneItems[] = $item;
                }
            }
        }
        ?>
        <?php if (empty($capstoneItems)): ?>
            <p class="empty">No capstone work submitted yet</p>
        <?php else: ?>
            <ul class="file-list">
                <?php foreach ($capstoneItems as $item): ?>
                    <li><a href="capstone/<?= htmlspecialchars($item) ?>"><?= htmlspecialchars($item) ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
