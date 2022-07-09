<!-- 
validateNew.php
Validates data inputted at new.php and either sends back or saves and sends on to view
-->

<?php

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(true);

// Set up variables
$pageError = false;

$errFile = '';

// Validate and get uploaded file, adapted from https://www.w3schools.com/php/php_file_upload.asp
// There is very very minimal validation done on this data other than checking it is a valid file simply because it would be extremely difficult 
// and it is assumed only trained admins will be inputting data, and will be able to use a template or other system to consistently input a correctly formatted file
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["valFile"]["name"]);
$pageError = false;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["valFile"]["size"] > 500000) {
    $errFile = "Sorry, your file is too large.";
    $pageError = true;
}

// Allow certain file formats
if($fileType != "csv") {
    $errFile = "Sorry, only CSV files are allowed";
    $pageError = true;
}

// if everything is ok, try to upload file
if (!$pageError) {
    if (!move_uploaded_file($_FILES["valFile"]["tmp_name"], $target_file)) {
        $errFile = "Sorry, there was an error uploading your file.";
    }
}

// If error send back, else continue with calculation and saving
if ($pageError) {
    $_SESSION['errFile'] = $errFile;
    header('refresh:0; url=new.php');
}

// CALCULATION
// Read csv into var
$calcData = array();
$fileHandler = fopen($target_file, "r");
while (!feof($fileHandler)) { // Loop CSV and save data
    $curLine = fgetcsv($fileHandler, 1024);
    array_push($calcData, $curLine);
}
fclose($fileHandler);

// Get current interest settings
$interestSettings = array();
$fileHandler = fopen("data/interestSettings.csv", "r");
while (!feof($fileHandler)) { // Loop CSV and save data
    $curLine = fgetcsv($fileHandler, 1024);
    array_push($interestSettings, $curLine);
}
fclose($fileHandler);

// Determine if deposit or loan
if (substr($calcData[0][2],0,1) == "1") {
    $isLoan = false;
} else {
    $isLoan = true;
}

// Change the opening balance to be a date
$calcData[0][0] = "01 " . substr($calcData[1][0],3,7);

// Get general information
$output = array(5);
$output[0] = $calcData[0][2]; // Acc num
$output[1] = substr($calcData[0][0],3,2) . "/" . substr($calcData[0][0],6,4); // Date
$output[2] = $calcData[0][1]; // opening bal
$output[3] = $calcData[count($calcData)-1][1]; //Closing bal

// Do calculation
$interest = 0;


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Processing</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>
    <body>
    </body>
</html>