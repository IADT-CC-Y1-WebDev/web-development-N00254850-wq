<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exceptions - PHP Introduction</title>
    <link rel="stylesheet" href="/examples/css/style.css">
    <link rel="stylesheet" href="/examples/css/prism-tomorrow.min.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/exercises/01-php-introduction/08-exceptions.php">Go to Exercise &rarr;</a>
    </div>

    <h1>Exceptions</h1>

    <p>Exceptions provide a way to handle errors gracefully. Instead of your program crashing, you can catch errors and respond appropriately.</p>

    <!-- Example 1 -->
    <h2>Basic Try/Catch</h2>
    <p>The <code>try</code> block contains code that might cause an error. If an exception is thrown, the <code>catch</code> block handles it.</p>
    <pre><code class="language-php">function divide($a, $b) {
    if ($b == 0) {
        throw new Exception("Cannot divide by zero");
    }
    return $a / $b;
}

try {
    $result = divide(10, 2);
    echo "10 / 2 = $result&lt;br&gt;";

    $result = divide(10, 0);  // This will throw an exception
    echo "This line will not be reached";
} 
catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}</code></pre>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        function divide($a, $b) {
            if ($b == 0) {
                throw new Exception("Cannot divide by zero");
            }
            return $a / $b;
        }

        try {
            $result = divide(10, 2);
            echo "10 / 2 = $result<br>";

            $result = divide(10, 0);
            echo "This line will not be reached";
        } 
        catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>

    <!-- Example 2 -->
    <h2>Throwing Exceptions</h2>
    <p>Use the <code>throw</code> keyword to create an exception. You can include a message that describes what went wrong.</p>
    <pre><code class="language-php">function validateAge($age) {
    if ($age &lt; 0) {
        throw new Exception("Age cannot be negative");
    }
    if ($age &gt; 150) {
        throw new Exception("Age seems unrealistic");
    }
    return "Age $age is valid";
}

$testAges = [25, -5, 200];

foreach ($testAges as $age) {
    try {
        $result = validateAge($age);
        echo "$result&lt;br&gt;";
    } 
    catch (Exception $e) {
        echo "Invalid age ($age): " . $e->getMessage() . "&lt;br&gt;";
    }
}</code></pre>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        function validateAge($age) {
            if ($age < 0) {
                throw new Exception("Age cannot be negative");
            }
            if ($age > 150) {
                throw new Exception("Age seems unrealistic");
            }
            return "Age $age is valid";
        }

        $testAges = [25, -5, 200];

        foreach ($testAges as $age) {
            try {
                $result = validateAge($age);
                echo "$result<br>";
            } 
            catch (Exception $e) {
                echo "Invalid age ($age): " . $e->getMessage() . "<br>";
            }
        }
        ?>
    </div>

    <!-- Example 3 -->
    <h2>Exception Information</h2>
    <p>The Exception object contains useful information about the error, including the message, file, and line number where it occurred.</p>
    <pre><code class="language-php">function processOrder($quantity) {
    if ($quantity &lt;= 0) {
        throw new Exception("Quantity must be positive");
    }
    return "Processing order for $quantity items";
}

try {
    echo processOrder(-5);
} 
catch (Exception $e) {
    echo "Message: " . $e->getMessage() . "&lt;br&gt;";
    echo "File: " . basename($e->getFile()) . "&lt;br&gt;";
    echo "Line: " . $e->getLine();
}</code></pre>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        function processOrder($quantity) {
            if ($quantity <= 0) {
                throw new Exception("Quantity must be positive");
            }
            return "Processing order for $quantity items";
        }

        try {
            echo processOrder(-5);
        } 
        catch (Exception $e) {
            echo "Message: " . $e->getMessage() . "<br>";
            echo "File: " . basename($e->getFile()) . "<br>";
            echo "Line: " . $e->getLine();
        }
        ?>
    </div>

    <!-- Example 4 -->
    <h2>The Finally Block</h2>
    <p>The <code>finally</code> block always runs, whether an exception was thrown or not. It's useful for cleanup tasks.</p>
    <pre><code class="language-php">function riskyOperation($value) {
    if ($value &lt; 0) {
        throw new Exception("Negative value not allowed");
    }
    return "Success with value: $value";
}

$testValues = [10, -5];

foreach ($testValues as $value) {
    echo "Testing value: $value&lt;br&gt;";
    try {
        $result = riskyOperation($value);
        echo "Result: $result&lt;br&gt;";
    } 
    catch (Exception $e) {
        echo "Caught error: " . $e->getMessage() . "&lt;br&gt;";
    } 
    finally {
        echo "Cleanup complete&lt;br&gt;&lt;br&gt;";
    }
}</code></pre>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        function riskyOperation($value) {
            if ($value < 0) {
                throw new Exception("Negative value not allowed");
            }
            return "Success with value: $value";
        }

        $testValues = [10, -5];

        foreach ($testValues as $value) {
            echo "Testing value: $value<br>";
            try {
                $result = riskyOperation($value);
                echo "Result: $result<br>";
            } 
            catch (Exception $e) {
                echo "Caught error: " . $e->getMessage() . "<br>";
            } 
            finally {
                echo "Cleanup complete<br><br>";
            }
        }
        ?>
    </div>

    <!-- Example 5 -->
    <h2>Without Exception Handling</h2>
    <p>If an exception is not caught, it will cause a fatal error and stop your script. Always wrap risky code in try/catch blocks.</p>
    <pre><code class="language-php">// Without try/catch, this would crash the script:
// throw new Exception("Uncaught exception!");

// With try/catch, we handle it gracefully:
try {
    throw new Exception("This exception is caught");
} 
catch (Exception $e) {
    echo "Handled: " . $e->getMessage();
}</code></pre>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        try {
            throw new Exception("This exception is caught");
        } 
        catch (Exception $e) {
            echo "Handled: " . $e->getMessage();
        }
        ?>
    </div>

    <script src="/examples/js/prism-core.min.js"></script>
    <script src="/examples/js/prism-autoloader.min.js" data-autoloader-path="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/"></script>
</body>
</html>
