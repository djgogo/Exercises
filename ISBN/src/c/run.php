<?php
declare(strict_types = 1);
require_once 'autoload.php';

/* GroupNumber Validation */
$invalidGroupNo = '978-8-86680-192-9';
try {
    $invalidGroupNo = new ISBN('978-8-86680-192-9');
} catch (InvalidIsbnException $e) {
    printf ("\nInvalid ISBN Group-Number: %s \n", $invalidGroupNo);
}

$validGroupNo = '978-7-86680-192-9';
try {
    $validGroupNo = new ISBN('978-7-86680-192-9');
} catch (InvalidIsbnException $e) {
    printf ("\nInvalid ISBN Group-Number: %s \n", $validGroupNo);
}

$invalidGroupNo = '979-13-86680-192-9';
try {
    $invalidGroupNo = new ISBN('979-13-86680-192-9');
} catch (InvalidIsbnException $e) {
    printf ("\nInvalid ISBN Group-Number: %s \n", $invalidGroupNo);
}

$validGroupNo = '979-10-86680-192-9';
try {
    $validGroupNo = new ISBN('979-10-86680-192-9');
} catch (InvalidIsbnException $e) {
    printf ("\nInvalid ISBN Group-Number: %s \n", $validGroupNo);
}

