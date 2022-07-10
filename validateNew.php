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

$valLoanRate = $interestSettings[0][0];
$valDepositThres1 = $interestSettings[1][0];
$valDepositThres2 = $interestSettings[2][0];
$valDepositRate1 = $interestSettings[3][0];
$valDepositRate2 = $interestSettings[4][0];
$valDepositRate3 = $interestSettings[5][0];

// Determine if deposit or loan
if (substr($calcData[0][2],0,1) == "1") {
    $isLoan = false;
} else {
    $isLoan = true;
}

// Change the opening & closing balance to be a date
$calcData[0][0] = "01 " . substr($calcData[1][0],3,7);


// Get general information
$output = array(5);
$output[0] = $calcData[0][2]; // Acc num
$output[1] = addslashes(substr($calcData[0][0],3,2) . "/" . substr($calcData[0][0],6,4)); // Date
$output[2] = $calcData[0][1]; // opening bal
$output[3] = $calcData[count($calcData)-1][1]; //Closing bal

// Set up variables for calculation
$interest = 0;
$curDay = 1;
$x = 1;
$curBal = (float)$calcData[0][1];

switch ((int)substr($calcData[0][0],3,2)) { // Set number of days in month
    case 1:
        $numDays = 31;
        break;
    case 2:
        $numDays = 28;
        break;
    case 3:
        $numDays = 31;
        break;
    case 4:
        $numDays = 30;
        break;
    case 5:
        $numDays = 31;
        break;
    case 6:
        $numDays = 30;
        break;
    case 7:
        $numDays = 31;
        break;
    case 8:
        $numDays = 31;
        break;
    case 9:
        $numDays = 30;
        break;
    case 10:
        $numDays = 31;
        break;
    case 11:
        $numDays = 30;
        break;
    case 12:
        $numDays = 31;
        break;
    default:
        $numDays = 31;
}

// do calculation
while ($curDay < $numDays+1) { // while still days left in month
    if ($curDay == (int)substr($calcData[$x][0],0,2)) { // if current day is equal to day of next transaction, set to new running bal
        $curBal = (float)$calcData[$x][1];
        $x++;
    }
    if ($isLoan) { // for calculation interest, whether to handle as deposit or loan. if loan only use the flat rate, otherwise if deposit u have to find based on threshold
        $curRate = (float)$valLoanRate;
    } else {
        if ($curBal < (int)$valDepositThres1) { // when deposit find the appropriate rate
            $curRate = (float)$valDepositRate1;
        } else {
            if ($curBal < (int)$valDepositThres2) {
                $curRate = (float)$valDepositRate2;
            } else {
                $curRate = (float)$valDepositRate3;
            }
        }
    }
    $interest += (($curRate/100)/365)*$curBal;
    $curDay++;
}
$output[4] = round($interest, 2);

// Save output into database
// From https://www.w3schools.com/php/php_mysql_insert.asp
$conn = new mysqli("localhost","root","","dbinterestcalculator");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$q = "INSERT INTO tblaccountdata VALUES ('', '$output[0]', '$output[1]', '$output[2]', '$output[3]', '$output[4]')";

if ($conn->query($q) === TRUE) {
    header('refresh:0; url=view.php');
} else {
    $_SESSION['errFile'] = "Error connecting to databse, try again";
    header('refresh:0; url=new.php');
}

$conn->close();

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