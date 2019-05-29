<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload files</title>
</head>
<body>

<form method="post" enctype="multipart/form-data">

Upload your CSV file:<br>
<input type="file" name="books_file"><br>

<input type="submit" value="Upload file">
</form>


<h2>Files</h2>

<pre>
<?php
if (isset($_FILES)) {
    $check = true;
    if ($_FILES['books_file']['type'] !== 'text/csv') {
        $check = false;
    }
    if ($check) {
        $date = date('Ymd_His');
        $file_id = uniqid();
        // $path = realpath('./') . '/uploaded_files/' . $file_id; // . '_' . $_FILES['books_file']['name'];
        $path = realpath('./') . '/uploaded_files/' . $_FILES['books_file']['name'];
        // $sql = "INSERT INTO files (file, file_name) VALUES ('$file_id', '$_FILES["books_file"]["name"]')";
        move_uploaded_file($_FILES['books_file']['tmp_name'], "$path");
    }
}
?>

</body>
</html>