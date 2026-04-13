<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inheritance Exercises - PHP Classes &amp; Objects</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to Classes &amp; Objects</a>
        <a href="/examples/02-php-classes-objects/04-inheritance.php">View Example &rarr;</a>
    </div>

    <h1>Inheritance Exercises</h1>

    <p><strong>Note:</strong> These exercises build on your <code>classes/Student.php</code> file. Make sure your Student class has <code>protected</code> properties so child classes can access them.</p>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Create an Undergrad Class</h2>
    <p>
        <strong>Task:</strong>
        Create a new file called <code>Undergrad.php</code> in the <code>classes/</code> folder.
        This class should:
    </p>
    <ul>
        <li>Use <code>require_once</code> to include <code>Student.php</code></li>
        <li>Extend the <code>Student</code> class</li>
        <li>Add two protected properties: <code>$course</code> and <code>$year</code></li>
        <li>Have a constructor that accepts all four values (name, number, course, year) and calls <code>parent::__construct()</code></li>
    </ul>
    <p>
        Create an Undergrad student and display their name using the inherited <code>getName()</code> method.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        // require_once __DIR__ . '/classes/Undergrad.php';
        require_once __DIR__ . '/classes/Undergrad.php';

        $Account = new Undergrad("Ryan Whelan", "N00254850", "Creative Computing", 2025);


        echo "Name: ".$Account->getName();
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Add Getter Methods</h2>
    <p>
        <strong>Task:</strong>
        Add <code>getCourse()</code> and <code>getYear()</code> methods to your
        Undergrad class.
    </p>
    <p>
        Create an Undergrad student and display all their information using all
        the getter methods (including the inherited <code>getName()</code> and
        <code>getNumber()</code> from Student).
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        // require_once __DIR__ . '/classes/Undergrad.php';

        require_once __DIR__ . '/classes/Undergrad.php';

        $Account1 = new Undergrad("Ryan Whelan", "N00254850", "Creative Computing", 2025);


        echo "Name: ".$Account1->getName(). "<br>";
        echo "Number: ".$Account1->getNumber(). "<br>";
        echo "Course: ".$Account1->getCourse(). "<br>";
        echo "Year: ".$Account1->getYear(). "<br>";
        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: Multiple Undergrad Students</h2>
    <p>
        <strong>Task:</strong>
        Create three Undergrad students with different courses and years.
        Display each student's information. Notice how they all inherit
        the same methods from Student.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        // require_once __DIR__ . '/classes/Undergrad.php';
        require_once __DIR__ . '/classes/Undergrad.php';        

        $acc1 = new Undergrad("Ryan Whelan", "N00254850", "Creative Computing", "2025");
        $acc2 = new Undergrad("Ryan Whelan", "N02540523235", "Professional Beanflicking", "2025");
        $acc3 = new Undergrad("Luke Murphy", "N025125236", "Putting the fries in the bag", "2025");

        echo "Name: ".$acc1->getName(). "<br>";
        echo "Number: ".$acc1->getNumber(). "<br>";
        echo "Course: ".$acc1->getCourse(). "<br>";
        echo "Year: ".$acc1->getYear(). "<br>";

        echo "Name: ".$acc2->getName(). "<br>";
        echo "Number: ".$acc2->getNumber(). "<br>";
        echo "Course: ".$acc2->getCourse(). "<br>";
        echo "Year: ".$acc2->getYear(). "<br>";

         echo "Name: ".$acc3->getName(). "<br>";
        echo "Number: ".$acc3->getNumber(). "<br>";
        echo "Course: ".$acc3->getCourse(). "<br>";
        echo "Year: ".$acc3->getYear(). "<br>";

        ?>
    </div>

</body>
</html>
