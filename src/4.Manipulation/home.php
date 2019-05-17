<?php
session_start();
$anArray = ["Seed1", "Seed2", "Seed3", "Seed4"];
$_SESSION['simpleArray'] = $anArray;
$anAssocArray = ["Seed1" => "Seed1", "Seed2" => "Seed2", "Seed3" => "Seed3", "Seed4" => "Seed4"];
$_SESSION['assocArray'] = $anAssocArray;
$anObject = new stdClass();
$anObject->seed1 = "Seed1";
$anObject->seed2 = "Seed2";
$anObject->seed3 = "Seed3";
$anObject->seed4 = "Seed4";
$_SESSION['anObject'] = $anObject;

function is_assoc2(&$array)
{
    echo ("\nTesting if associative array ...");
    if (!is_array($array)) return false;
    if (count(array_filter(array_keys($array), 'is_string'))) echo ("YES");
    return count(array_filter(array_keys($array), 'is_string')) > 0;
}

function status()
{
    echo ("\n\nCurrent state: \n\n");
    var_dump($_SESSION);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Object Manipulation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <header>
        <nav class="navbar bg-dark navbar-dark fixed-top">
            <span class="navbar-brand">PHP Intro: <?php echo $_SERVER['SCRIPT_FILENAME'] ?></span>
        </nav>
    </header>

    <div class="container-fluid mt-3 pt-5">

        <h1>Object Manipulation</h1>
        <ol>
            <li>Create an array, an associative array and an object in <code>home.php</code>.</li>
            <li>What are the differences between an array, an associative array and an object?
                <ul>
                    <li>Array: no key, only an index. address items as $array[index].</li>
                    <li>Associative array: every item of the array consists of a key-value pair. Items can be addressed as $array[key].</li>
                    <li>Object: is an instance of a class. It is simply a specimen of a class and has a memory allocated. Elements in the object can be addressed using the property names as keys. </li>
                </ul>
            </li>
            <li>Write a for-loop that adds an item to all of the above.</li>
            <li>Write an if-statement that has a 20% chance to edit a random item of one of the above.</li>
            <li>Put this if statement in a loop so every array/object has a random chance of having a random item changed</li>
            <li>Divide the array in half (if uneven items half-1, unless half-1 makes it empty)</li>
            <li>Remove the last item of the associative array</li>
            <li>Add the arrays to the object as <code>arr1</code> and <code>arr2</code></li>
            <li>Loop through the associative array adding all items to the object as <code>key =&gt; value</code></li>
            <li>Save the object in the <code>$_COOKIE</code> superglobal</li>
            <li>Find a way to print this final object on the homepage, in an easily readable way</li>
        </ol>

        <pre>

        <h2>Iteration 1 (Step 3)</h2>
        <?php


        foreach ($_SESSION as $member => $value) {
            echo ("\n\nMember: {$member}");

            $valueToAdd = "Added by loop";
            if (is_array($value)) {
                if (is_assoc2($value)) {
                    $value["AddedByLoop"] = $valueToAdd;
                } else {
                    array_push($value, $valueToAdd);
                }
            } else {
                $value->addedByLoop = $valueToAdd;
            }
            $_SESSION[$member] = $value;
        }

        status();

        ?>

        <h2>Iteration 2 (Steps 4 and 5)</h2>

        <?php

        foreach ($_SESSION as $member => $value) {

            $randomValue = "This value was randomly changed";

            if (is_array($value)) {
                $arrayLength = count($value);
                $randomIndex = rand(0, $arrayLength * 5);

                echo ("\nLength of {$member} is " . $arrayLength . "\nRandom index is {$randomIndex}\n");

                if ($randomIndex < $arrayLength) {
                    $keys = array_keys($value);
                    $theKey = $keys[$randomIndex];
                    echo ("\nRandom key is {$theKey}");
                    echo ("\nRandom item is {$value[$theKey]}\n");
                    $value[$theKey] = $randomValue;
                    $_SESSION[$member] = $value;
                } else {
                    echo ("Random index larger than length - no change.\n");
                }
            }

            if (is_object($value)) {
                $objLength = count(get_object_vars($value));
                $randomIndex = rand(0, $objLength * 5);

                echo ("\nLength of {$member} is " . $objLength . "\nRandom index is {$randomIndex}\n");

                if ($randomIndex < $objLength) {
                    $keys = array_keys(get_object_vars($value));
                    $theKey = $keys[$randomIndex];
                    echo ("\nRandom key is {$theKey}");
                    echo ("\nRandom item is {$value->$theKey}\n");
                    $value->$theKey = $randomValue;
                    $_SESSION[$member] = $value;
                } else {
                    echo ("Random index larger than length - no change.\n");
                }
            }
        }

        status();

        ?>

        <h2>Iteration 3 (Step 6)</h2>

        <p>Either array_chunk and keep the first chunk, or array_slice.</p>

        <?php
        foreach ($_SESSION as $member => $value) {

            if (is_array($value)) {
                $arrayLength = count($value);
                $splitPos = floor($arrayLength / 2);
                if (is_assoc2($value)) {
                    $value = array_chunk($value, $splitPos, true)[0];
                } else {
                    $value = array_slice($value, 0, $splitPos, true);
                }
            }
            $_SESSION[$member] = $value;
        }

        status();
        ?>
        </pre>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>