<!DOCTYPE html>

<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload files</title>
    <style>
#upload {
        height: 167px;
        width: 400px;
        background-color: burlywood;
        padding: 26px;
        position: absolute;
        top: 56px;
        left: 428px;


}
#form2 {
        height: 167px;
        width: 327px;
        background-color: burlywood;
        margin-left: 421px;
        padding: 26px;
        position: absolute;
        top: 312px;
        left: 249px;
}

#listItems {
        width: 300px;
        height: auto;
        background-color: cadetblue;
        color: aliceblue;
        padding: 12px;
        list-style: none;
        position: absolute;
        top: 333px;
        left: 338px;
}
#header {
        width: 320px;
        height: 33px;
        background-color: coral;
        color: aliceblue;
        position: absolute;
        top: 296px;
        left: 338px;
        line-height: 1.5em;
        padding: 2px;
}

         </style>
    </head>
<body>

<form id='upload' method="post" enctype="multipart/form-data">

Upload your CSV file:<br>
<input type="file" name="books_file"><br>

<input type="submit" name='submit' value="Upload file">
</form>



<?php


$div = '';
$error = array();
    if (isset($_FILES) && isset($_POST['submit'])) {
        $fileType = $_FILES['books_file']['type'];
        $div = TRUE;
        $check = true;}else{$fileType = '';}
    if ($fileType !== 'application/octet-stream') {
        $check = false;
        $div = FALSE;
        echo 'we accept here just csv';
            }else{
        $check = true;
}
    if ($check) {
        $path = realpath('./') . '\\uploaded_files\\' . $_FILES['books_file']['name'];
        move_uploaded_file($_FILES['books_file']['tmp_name'], "$path");
}

$header = "<h2 id='header'>Here is your books</h2>";
$filename = 'uploaded_files/books.csv';

    if (!$fileType){
        echo '';}elseif ($file_handle = fopen($filename, 'r')) {
    
        echo $header;
        $div = '<ul id="listItems">';
        // Read one line from the csv file, use comma as separator
    while ($data = fgetcsv($file_handle)) {
          
    for($i=0; $i <= sizeof($data) - 1; $i++) {
                
        $div .= '<li>' . $data[$i] . '</li>';
           
}

}
        // Close the file
    
        fclose($file_handle);
        $div .= '</ul>';
        echo $div;
}

    if($div){

        $form = "<form id='form2' action='' method='' > ";
        $form .= " Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name'> </br> </br>";
        $form .= "Adress: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='adress'> </br> </br>";
        $form .= "Telephone nr: <input type='tel' name='tel'>";

        echo $form;
    }else   {$form ='';}
?>


</body>
</html>