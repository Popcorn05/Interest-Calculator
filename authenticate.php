<!-- 
authenticate.php
Authenticates login info, sends back if incorrect
-->

<?php

// Include library
include("resources.php");

// Init error vars and pass in values from post into input variables
$pageError = False;
$pageErrorText = '';

$userEmail = testInput($_POST["email"]);
$userPassword = testInput($_POST["password"]);

// Session init and saving
session_start();

$_SESSION['userLoggedIn'] = false; //Defaults for logged in user, setting these should help prevent abuse
$_SESSION['userAccess'] = -1;
$_SESSION['userName'] = "";

$_SESSION['userEmail'] = $userEmail;
$_SESSION['userPassword'] = $userPassword;

$_SESSION['pageErrorText'] = $pageErrorText;

// Not any real input validation required; inputs have already been made safe, 
// and because no data is being saved, only searched, other errors don't matter

// Import auth info to check against
$authData = array();
$fileHandler = fopen("authInfo.csv", "r");

while (!feof($fileHandler)) { // Loop CSV and save data
    $curLine = fgetcsv($fileHandler, 1024);
    array_push($authData, $curLine);
}
fclose($fileHandler);

// Make array of only emails
$authEmails = array();

for ($i = 0; $i < count($authData); $i++) { // Loop through data and add to array
    $authEmails[$i] = $authData[$i][2];
}

// Search through emails, handle result
$emailSearch = bsearch($authEmails, $userEmail);

if ($emailSearch != -1) {
    if ($authData[$emailSearch][3] == $userPassword) {
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['userAccess'] = $authData[$emailSearch][4];
        $_SESSION['userName'] = $authData[$emailSearch][1];
    } else {
        $pageError = true;
        $pageErrorText = "Password invalid";
    }
} else {
    $pageError = true;
    $pageErrorText = "Email not found";
}

// If error send back, else, clear email and password and continue to home
if ($pageError) {
    $_SESSION['pageErrorText'] = $pageErrorText;
    header('refresh:0; url=index.php');
} else { 
    $_SESSION['userEmail'] = '';
    $_SESSION['userPassword'] = '';
    header('refresh:0; url=home.php');
}

?>