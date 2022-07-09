<!-- 
new.php
Page for inputting information for new data
-->

<?php

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(true);

// Setup variables
$errFile = '';

$valFile = '';

// If returning with errors pass in to display and values
if (isset($_SESSION['errFile'])) {
    $errFile = $_SESSION['errFile'];
}

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>New Calculation</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>

    <body>
        <!-- Load heading with current logged in user access level -->
        <?php loadHeader($_SESSION['userAccess']); ?>
        <div id="wrapper">
            <table width="100%">
            <tbody>
                <tr>
                    <td colspan="3"><p style="font-size: 24pt; color: #27247b; text-align: center; padding-top: 30px;">New</p></td>
                </tr>
                <tr><td height="100px"></td></tr>
                <!-- Inputs -->
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 15%;"></td>
                    <td style="width: 35%;"></td>
                </tr>
                <tr><td height="10px"></td></tr>
                <form id="settings" name="settings" method="post" enctype="multipart/form-data">
                <tr>
                    <td colspan="2" style="padding-top: 10px; text-align: right;"><input type="file" name="valFile" id="valFile" style="text-align: center; margin-right: 170px;" required></td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errFile; ?></td>
                </tr>
                <tr><td height="25px"></td></tr>
                <tr><td></td><td><p><input type="submit" id="submit" value="Submit" formaction="validateNew.php" style="display: block; width: 75px; margin-left: 80px;"></p></td></tr>
                </form>
            </tbody>
            </table>

        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>