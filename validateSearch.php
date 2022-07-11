<!-- 
validateSearch.php
Validates search and reformats to put into view
-->

<?php

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(false);

// Setup variables
$valStartDate = '';
$valEndDate = '';
$valAccNum = '';

$errStartDate = '';
$errEndDate = '';
$errAccNum = '';

$useDate = false;
$useAcc = false;

$pageError = false;

// Get variables
if (isset($_POST['valUseDate'])) {
    $valStartDate = testInput($_POST['valStartDate']);
    $valEndDate = testInput($_POST['valEndDate']);
    $useDate = true;
}

if (isset($_POST['valUseAcc'])) {
    $valAccNum = testInput($_POST['valAccNum']);
    $useAcc = true;
}

// validate
// validate date
if ($useDate) {
    // check empty
    if (empty($valStartDate)) {
        $errStartDate = "To use date for search, a start date must be provided";
        $pageError = true;
    }
    if (empty($valEndDate)) {
        $errEndDate = "To use date for search, an end date must be provided";
        $pageError = true;
    }

    // check format
    if (!preg_match("/^\d\d\/\d\d\d\d/",$valStartDate)) {
        $errStartDate = "Start date does not match MM/YYYY format";
        $pageError = true;
    }
    if (!preg_match("/^\d\d\/\d\d\d\d/",$valEndDate)) {
        $errEndDate = "End date does not match MM/YYYY format";
        $pageError = true;
    }

    // check end date not before start and check month valid
    if (!$pageError) { // only do this if not an error yet becuase these rely on the other two condition being valid
        $startDateNum = (((float)substr($valStartDate,0,2)-1)/12) + (float)substr($valStartDate,3,4);
        $endDateNum = (((float)substr($valEndDate,0,2)-1)/12) + (float)substr($valEndDate,3,4);
        if ($startDateNum>$endDateNum) {
            $errEndDate = "End date must be equal to or greater than start date";
            $pageError = true;
        }
        
        if ((int)substr($valStartDate,0,2) < 1 || (int)substr($valStartDate,0,2) > 12) {
            $errStartDate = "Starting date month must be between 1 and 12 inclusive";
            $pageError = true;
        }
        if ((int)substr($valEndDate,0,2) < 1 || (int)substr($valEndDate,0,2) > 12) {
            $errEndDate = "Ending date month must be between 1 and 12 inclusive";
            $pageError = true;
        }
    }
}

// validate account number
if ($useAcc) {
    // check empty
    if (empty($valAccNum)) {
        $errAccNum = "To use account number for search, an account number must be provided";
        $pageError = true;
    }
    // check format
    if (!preg_match("/^\d\d\d\d/",$valAccNum) && !empty($valAccNum)) {
        $errAccNum = "Account number does not match 4 number format";
        $pageError = true;
    }
}

// if error send back else go to view
if ($pageError) {
    $_SESSION['errStartDate'] = $errStartDate;
    $_SESSION['errEndDate'] = $errEndDate;
    $_SESSION['errAccNum'] = $errAccNum;
    $_SESSION['valStartDate'] = $valStartDate;
    $_SESSION['valEndDate'] = $valEndDate;
    $_SESSION['valAccNum'] = $valAccNum;
    $_SESSION['valUseDate'] = (isset($_POST['valUseDate'])) ? "y" : "n";
    $_SESSION['valUseAcc'] = (isset($_POST['valUseAcc'])) ? "y" : "n";
    header('refresh:0; url=search.php');
} else {
    header("refresh:0; url=view.php?startDate=$valStartDate&endDate=$valEndDate&accNum=$valAccNum");
}

?>