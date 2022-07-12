<!-- 
deleteSuccess.php
Confirms deletion to user and actually performs deletion on backend
-->

<?php

// Include library
include("resources.php");

// session init
session_start();

// Validate authentication
validateAuth(true);

// Set up variables
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("refresh:0; url=view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}");
}

// Run query
// From https://www.w3schools.com/php/php_mysql_delete.asp
$conn = new mysqli("localhost","root","","dbinterestcalculator");
if ($conn->connect_error) {
    header("refresh:0; url=view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}");
}

$q = "DELETE FROM tblaccountdata WHERE DataID=$id";

if ($conn->query($q) !== TRUE) {
    header("refresh:0; url=view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}");
}
$conn->close();

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>iRepairs</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>

    <body>
        <!-- Load heading with current logged in user access level -->
        <?php loadHeader($_SESSION['userAccess']); ?>
        <div id="wrapper">
            <table width="100%">
            <tbody>
                <tr>
                    <td><p style="font-size: 24pt; color: #27247b; text-align: center; padding-top: 30px;">Deletion Successful</p></td>
                </tr>
                <tr><td height="150px"></td></tr>
                <tr><td style="text-align: center;"><a style="text-decoration: underline; color: black; font-size: 14pt;" href="view.php?<?php echo "startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}"; ?>">Go back</a></td></tr>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>