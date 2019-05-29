<pre>
<?php
$filename = 'books.csv';
// The nested array to hold all the arrays
$books = [];
$books[] = ['ISBN', 'Book title', 'Author'];
// Open the file for reading
if ($file_handle = fopen($filename, 'r')) {
    // Read one line from the csv file, use comma as separator
    while ($data = fgetcsv($file_handle)) {
        $books[] = fill_book($data[0]);
    }
    // Close the file
    fclose($file_handle);
}
// Display the code in a readable format
//var_dump($books);
if ($books) {
    $filename = 'new_books.csv';
    $file_to_write = fopen($filename, 'w');
    $everything_is_awesome = true;
    foreach ($books as $book) {
//        $book = fill_book($book[0]);
        //var_dump($book);
        $everything_is_awesome = $everything_is_awesome && fputcsv($file_to_write, $book);
    }
    fclose($file_to_write);
    if ($everything_is_awesome) {
        echo '<a href="' . $filename . '">Everything is awesome</a>';
    } else {
        echo 'Everything is NOT awesome';
    }
}
function fill_book($isbn)
{
    $book = [];
    $book[0] = $isbn;
    $book[1] = 'Harry Potter';
    $book[2] = 'J K Rowling';
    return $book;
}
/*
if ($books) {
    $file_to_write = fopen('new_books.csv', 'w');
    foreach ($books as $book) {
        $book = fill_book($book[0]);
        //var_dump($book);
        fputcsv($file_to_write, $book);
    }
    fclose($file_to_write);
}
function fill_book($isbn)
{
    $book = [];
    $book[0] = $isbn;
    $book[1] = 'Harry Potter';
    $book[2] = 'J K Rowling';
    return $book;
}
*/
/*
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sample.csv"');
$user_CSV[0] = array('first_name', 'last_name', 'age');
// very simple to increment with i++ if looping through a database result 
$user_CSV[1] = array('Quentin', 'Del Viento', 34);
$user_CSV[2] = array('Antoine', 'Del Torro', 55);
$user_CSV[3] = array('Arthur', 'Vincente', 15);
$file_to_write = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($file_to_write, $line, ',');
}
fclose($file_to_write);
*/