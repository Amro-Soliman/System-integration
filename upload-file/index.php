<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload files</title>
    <style>
    form {
        height: 167px;
    width: 400px;
    background-color: burlywood;
    margin-left: 421px;
    margin-top: 151px;
    padding: 26px;

}
    </style>
</head>
<body>

<form method="post" enctype="multipart/form-data">

Upload your CSV file:<br>
<input type="file" name="books_file"><br>

<input type="submit" value="Upload file">
</form>




<pre>
<?php

$error = array();
if (isset($_FILES) && isset($_POST['submit'])) {
    $fileType = $_FILES['books_file']['type'];
    $check = true;}else{$fileType = '';}
    if ($fileType !== 'application/octet-stream') {
        $check = false;
    }else{
        $check = true;
    }
    if ($check) {
        $date = date('Ymd_His');
        $file_id = uniqid();
        // $path = realpath('./') . '/uploaded_files/' . $file_id; // . '_' . $_FILES['books_file']['name'];
        $path = realpath('./') . '\\uploaded_files\\' . $_FILES['books_file']['name'];
        // $sql = "INSERT INTO files (file, file_name) VALUES ('$file_id', '$_FILES["books_file"]["name"]')";
       
        move_uploaded_file($_FILES['books_file']['tmp_name'], "$path");
    }

?>
<h2>files</h2>
<?php


$filename = 'uploaded_files/books.csv';
if ($file_handle = fopen($filename, 'r')) {
    // Read one line from the csv file, use comma as separator
    while ($data = fgetcsv($file_handle)) {
      
        for($i=0; $i <= sizeof($data) - 1; $i++) {

        
        echo $data[$i] . '</br>';
        }
    }
    // Close the file
    fclose($file_handle);
}
?>

</body>
</html>