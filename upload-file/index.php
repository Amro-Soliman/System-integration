<!DOCTYPE html>

<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload files</title>
    <style>
    .StripeElement {
    background-color: white;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
}
.StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
}
.StripeElement--invalid {
    border-color: #fa755a;
}
.StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
}

#upload {
    height: 167px;
    width: 495px;
    background-color: cadetblue;
    padding: 26px;
    position: absolute;
    top: 56px;
    left: 361px;

}
#payment-form {
    height: 255px;
    width: 327px;
    background-color: cadetblue;
    color: aliceblue;
    margin-left: 421px;
    padding: 26px;
    position: absolute;
    top: 281px;
    left: 188px;
}

#listItems {
    width: 300px;
    height: auto;
    background-color: cadetblue;
    color: aliceblue;
    padding: 12px;
    list-style: none;
    position: absolute;
    top: 306px;
    left: 281px;
}
#header {
    width: 320px;
    height: 33px;
    background-color: coral;
    color: aliceblue;
    position: absolute;
    top: 266px;
    left: 281px;
    line-height: 1.5em;
    padding: 2px;
}
#submit {
        width: 177px;
        height: 49px;
        background-color: coral;
        color: azure;
}
#fileButton {
    color: whitesmoke;
    height: 40px;
}
#btn {
    height: 38px;
    width: 165px;
    background-color: coral;
    color: azure;
    margin-left: 77px;
}

         </style>
    </head>
<body>

<form id='upload' method="post" enctype="multipart/form-data">

<h2 style='color:azure;'>Upload your CSV file: </h2>
<input type="file" id='fileButton' name="books_file"><br><br><br>

<input type="submit" id='submit' name='submit' value="Upload file">
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

$header = "<h2 id='header'>Here is your ISBNs</h2>";
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

        $form =  "<form action='../stripe/charge.php' method='post' id='payment-form'>";
        $form .= "Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name'> </br> </br>";
        $form .= "Adress: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='adress'> </br> </br>";
        $form .= "Telephone nr: <input type='tel' name='tel'></br></br>";

        $form .= "<div class='form-row'></br>";
        $form .= "<label for='card-element'>Credit or debit card</label>";

        $form .= "<div id='card-element'>";
        // a Stripe Element will be inserted here.
        $form .= "</div>";
        //Used to display form errors
        $form .= "<div id='card-errors'></div>";
        $form .= "</div></br></br>";
        $form .= "<button id='btn'>Submit Payment</button>";
     
        $form .= "</form>";

       

        echo $form;
    }else   {$form ='';}
?>

  <!-- The needed JS files -->
<!-- JQUERY File -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<!-- Your JS File -->
<script src="../stripe/charge.js"></script>

    
    
    
  
</form>

</body>
</html>