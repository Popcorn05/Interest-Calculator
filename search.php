<!-- 
search.php
Allows for user to input search criteria
-->

<?php

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(false);

// init variables
$valStartDate = '';
$valEndDate = '';
$valAccNum = '';

$errStartDate = '';
$errEndDate = '';
$errAccNum = '';

$valUseDate = false;
$valUseAcc = false;

// if in session pass through
if (isset($_SESSION['valStartDate'])) {
    $valStartDate = $_SESSION['valStartDate'];
    $valEndDate = $_SESSION['valEndDate'];
    $valAccNum = $_SESSION['valAccNum'];

    $errStartDate = $_SESSION['errStartDate'];
    $errEndDate = $_SESSION['errEndDate'];
    $errAccNum = $_SESSION['errAccNum'];

    if ($_SESSION['valUseDate'] == "y") {$valUseDate = true;}
    if ($_SESSION['valUseAcc'] == "y") {$valUseAcc = true;}
}

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
                <!-- Heading -->
                <tr>
                    <td colspan="3"><p style="font-size: 24pt; color: #27247b; text-align: center; padding-top: 30px;">Interest Settings</p></td>
                </tr>
                <tr><td height="100px" colspan="3"></td></tr>
                <!-- Inputs -->
                <form id="settings" name="settings" method="post">
                <tr>
                    <td style="width: 50%; text-align: right;"><label for="valUseDate">Search by Date:&nbsp;</label></td>
                    <td style="width: 15%;"><input type="checkbox" name="valUseDate" id="valUseDate" value="valUseDate" style="margin-left:" <?php if ($valUseDate) {echo "checked";} ?>></td>
                    <td style="width: 35%;">
                </tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valStartDate">Start Date:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valStartDate" id="valStartDate" value="<?php echo $valStartDate; ?>" maxlength="7" style="width: 100px; text-align: right;"></td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errStartDate; ?></td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valEndDate">End Date:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valEndDate" id="valEndDate" value="<?php echo $valEndDate; ?>" maxlength="7" style="width: 100px; text-align: right;"></td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errEndDate; ?></td>
                </tr>
                <tr><td height="50px"></td></tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valUseAcc">Search by Account:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="checkbox" name="valUseAcc" id="valUseAcc" value="valUseAcc" style="margin-left:" <?php if ($valUseAcc) {echo "checked";} ?>></td>
                    <td style="padding-top: 10px;">
                </tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valAccNum">Account Number:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valAccNum" id="valAccNum" value="<?php echo $valAccNum; ?>" maxlength="4" style="width: 100px; text-align: right;"></td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errAccNum; ?></td>
                </tr>
                <tr><td></td><td style="padding-top: 15px;"><p><input type="submit" id="submit" value="Submit" formaction="validateSearch.php" style="padding: 3px;"></p></td></tr>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>