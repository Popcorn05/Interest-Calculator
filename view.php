<!-- 
view.php
allows for the viewing of data
-->

<?php

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(false);

// Get search criteria
$startDate = (empty($_GET['startDate']) ? "-" : "'" . $_GET['startDate'] . "'");
$endDate = (empty($_GET['endDate']) ? "-" : "'" . $_GET['endDate'] . "'");
$accNum = (empty($_GET['accNum']) ? "-" : "'" . $_GET['accNum'] . "'");

// Save this seach to session for returning
$_SESSION['lastStart'] = $_GET['startDate'];
$_SESSION['lastEnd'] = $_GET['endDate'];
$_SESSION['lastAccNum'] = $_GET['accNum'];

// make array of all dates inbetween the start and end date
$curMonth = (int)substr($startDate,1,2);
$curYear = (int)substr($startDate,4,4);
$mToSearch = array();
while ($curMonth < (int)substr($endDate,1,2) || $curYear < (int)substr($endDate,4,4)) {
    $curMonthText = ($curMonth < 10 ? "0$curMonth" : (string)$curMonth);
    array_push($mToSearch, "$curMonthText/$curYear");
    $curMonth += 1;
    if ($curMonth == 13) {
        $curMonth = 1;
        $curYear += 1;
    }
}
$curMonthText = ($curMonth < 10 ? "0$curMonth" : (string)$curMonth);
array_push($mToSearch,"$curMonthText/$curYear");

// get data from db and save
// From https://www.w3schools.com/php/php_mysql_select_where.asp
$conn = new mysqli("localhost","root","","dbinterestcalculator");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// make query
$q = "SELECT DataID, AccountNum, Date, OpeningBal, ClosingBal, Interest FROM tblaccountdata";
if ($accNum != "-" || ($startDate != "-" && $endDate != "-")) {
    $q = $q . " WHERE";
}

if ($accNum != "-") {
    $q = $q . " AccountNum=$accNum";
}

if ($accNum != "-" && ($startDate != "-" && $endDate != "-")) {
    $q = $q . " AND";
}

if ($startDate != "-" && $endDate != "-") {
    $q = $q . " (Date='$mToSearch[0]'";
    for ($i = 1; $i < count($mToSearch); $i++) {
        $q = $q . " OR Date='$mToSearch[$i]'";
    }
    $q = $q.")";
}

$result = $conn->query($q);

if ($result->num_rows > 0) {
    $isResults = true;
    $searchResults = array();
    $i = 0;
    // output data of each row
    while($row = $result->fetch_array(MYSQLI_NUM)) {
        $searchResults[$i] = $row;
        $i++;
    }
    array_multisort(array_column($searchResults, 1), SORT_ASC, $searchResults); // Sort by account number
    $_SESSION['lastResults'] = $searchResults;
  } else {
    $isResults = false;
}
$conn->close();

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>Selected Interest Data</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>

    <body>
        <!-- Load heading with current logged in user access level -->
        <?php loadHeader($_SESSION['userAccess']); ?>
        <?php 
        if ($_SESSION['userAccess'] == 1) {
            print <<< EOT
                <div id="wrapper" style="margin-top:6px; min-height: calc(100vh - 166px);">
            EOT;
        } else {
            print <<< EOT
                <div id="wrapper" style="margin-top:4px; min-height: calc(100vh - 164px);">
            EOT;
        }
        ?>
        
            <table width="80%" style="border-collapse: collapse; margin-left: auto; margin-right: auto; font-size: 16pt;">
            <?php
            if ($isResults) {
                if ($_SESSION['userAccess'] == 1) {
                    print <<< EOT
                        <tr>
                            <th style="width: 19%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;" >Account Number</th>
                            <th style="width: 19%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Date</th>
                            <th style="width: 19%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Opening Balance</th>
                            <th style="width: 19%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Closing Balance</th>
                            <th style="width: 19%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Interest</th>
                            <th style="width: 5%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Delete</th>
                        </tr>
                    EOT;
                    for ($i = 0; $i < count($searchResults); $i++) {
                        echo "<tr>";
                        for ($j = 1; $j < 6; $j++) {
                            echo "<td style=\"text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;\">{$searchResults[$i][$j]}</td>";
                        }
                        echo "<td style=\"text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;\"><a href=\"delete.php?id={$searchResults[$i][0]}\"><button style=\"width: 18px; font-size: 16pt;\">X</button></a></td></tr>";
                    }
                } else { // if access is viewer print without delete button
                    print <<< EOT
                        <tr>
                            <th style="width: 20%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;" >Account Number</th>
                            <th style="width: 20%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Date</th>
                            <th style="width: 20%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Opening Balance</th>
                            <th style="width: 20%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Closing Balance</th>
                            <th style="width: 20%; text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Interest</th>
                        </tr>
                    EOT;
                    for ($i = 0; $i < count($searchResults); $i++) {
                        echo "<tr>";
                        for ($j = 1; $j < 6; $j++) {
                            echo "<td style=\"text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;\">{$searchResults[$i][$j]}</td>";
                        }
                    }
                }
            } else {
                print <<< EOT
                    <tr><th style="font-size: 20pt; padding-top: 50px;">No results</th></tr>
                EOT;
            }
            ?>
            <tr><td colspan=6 id="exportButton"><a href="export.php"><button>Export</button></a></td></tr>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>