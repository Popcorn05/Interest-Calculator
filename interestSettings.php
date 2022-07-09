<!-- 
interestSettings.php
Page allows editing of interest settings
-->

<?php

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(true);

// Setup variables
$errLoanRate = '';

$errDepositThres1 = '';
$errDepositThres2 = '';

$errDepositRate1 = '';
$errDepositRate2 = '';
$errDepositRate3 = '';

$valLoanRate = 0;

$valDepositThres1 = 0;
$valDepositThres2 = 0;

$valDepositRate1 = 0;
$valDepositRate2 = 0;
$valDepositRate3 = 0;

$settingsData = array();

$successMessage = '';

// Check if returning from changing
$runChange = false;
if (isset($_POST['valLoanRate'])) {
    $runChange = true;
}

if ($runChange == true) { // IF settings have been changed and new data must be validated and saved
    $pageError = false; // If any data is incorrect this will be set to true and nothing will be saved
    // Pass changed values into temp vars for validation
    $valLoanRateNew = testInput($_POST['valLoanRate']);

    $valDepositThres1New = testInput($_POST['valDepositThres1']);
    $valDepositThres2New = testInput($_POST['valDepositThres2']);

    $valDepositRate1New = testInput($_POST['valDepositRate1']);
    $valDepositRate2New = testInput($_POST['valDepositRate2']);
    $valDepositRate3New = testInput($_POST['valDepositRate3']);

    // Also pass in these values into variables that show in text boxes. They still fill in even if data is invalid for easier editing
    $valLoanRate = $valLoanRateNew;

    $valDepositThres1 = $valDepositThres1New;
    $valDepositThres2 = $valDepositThres2New;

    $valDepositRate1 = $valDepositRate1New;
    $valDepositRate2 = $valDepositRate2New;
    $valDepositRate3 = $valDepositRate3New;

    // VALIDATE DATA
    // Validation is done in this order because the more important checks are done last. This means the more important errors will override less important (e.g. empty overrides out of bounds)
    // Check => 0 and other checks
    if ($valLoanRateNew < 0 || $valLoanRateNew > 100) {
        $pageError = true;
        $errLoanRate = "Loan rate must be equal to or greater than 0 and less than or equal to 100";
    }

    if ($valDepositThres1New < 0) {
        $pageError = true;
        $errDepositThres1 = "Deposit threshold 1 must be equal to or greater than 0";
    }

    if ($valDepositThres2New < 0) {
        $pageError = true;
        $errDepositThres2 = "Deposit threshold 2 must be equal to or greater than 0";
    }

    if ($valDepositRate1New < 0 || $valDepositRate1New > 100) {
        $pageError = true;
        $errDepositRate1 = "Deposit rate 1 must be equal to or greater than 0 and less than or equal to 100";
    }

    if ($valDepositRate2New < 0 || $valDepositRate2New > 100) {
        $pageError = true;
        $errDepositRate2 = "Deposit rate 2 must be equal to or greater than 0 and less than or equal to 100";
    }

    if ($valDepositRate3New < 0 || $valDepositRate3New > 100) {
        $pageError = true;
        $errDepositRate3 = "Deposit rate 3 must be equal to or greater than 0 and less than or equal to 100";
    }

    //Check if float/int depending on value
    if (!is_numeric($valLoanRateNew)) {
        $pageError = true;
        $errLoanRate = "Loan rate must be a number";
    }

    if ($valDepositThres1New != (int)$valDepositThres1New) {
        $pageError = true;
        $errDepositThres1 = "Deposit threshold 1 must be a whole number";
    }

    if ($valDepositThres2New != (int)$valDepositThres2New) {
        $pageError = true;
        $errDepositThres2 = "Deposit threshold 2 must be a whole number";
    }

    if (!is_numeric($valDepositRate1New)) {
        $pageError = true;
        $errDepositRate1 = "Deposit rate 1 must be a number";
    }

    if (!is_numeric($valDepositRate2New)) {
        $pageError = true;
        $errDepositRate2 = "Deposit rate 2 must be a number";
    }

    if (!is_numeric($valDepositRate3New)) {
        $pageError = true;
        $errDepositRate3 = "Deposit rate 3 must be a number";
    }

    // Check empty
    if (empty($valLoanRateNew)) {
        $pageError = true;
        $errLoanRate = "No loan rate";
    }
    
    if (empty($valDepositThres1New)) {
        $pageError = true;
        $errDepositThres1 = "No deposit threshold 1";
    }

    if (empty($valDepositThres2New)) {
        $pageError = true;
        $errDepositThres2 = "No deposit threshold 2";
    }

    if (empty($valDepositRate1New)) {
        $pageError = true;
        $errDepositRate1 = "No deposit rate 1";
    }
    
    if (empty($valDepositRate2New)) {
        $pageError = true;
        $errDepositRate2 = "No deposit rate 2";
    }

    if (empty($valDepositRate3New)) {
        $pageError = true;
        $errDepositRate3 = "No deposit rate 3";
    }

    // If no errors then save
    if ($pageError == false) {
        $fileHandler = fopen("data/interestSettings.csv", "w") or die ("cannot open file");
        $s = "{$valLoanRateNew}\n{$valDepositThres1New}\n{$valDepositThres2New}\n{$valDepositRate1New}\n{$valDepositRate2New}\n{$valDepositRate3New}\n";
        fwrite($fileHandler, $s);
        fclose($fileHandler);

        // Change message to show that data saved
        $successMessage = "Data saved successfully";
    }

} else { // else, meaning settings have not been changed
    // Import current settings
    $fileHandler = fopen("data/interestSettings.csv", "r");

    while (!feof($fileHandler)) { // Loop CSV and save data
        $curLine = fgetcsv($fileHandler, 1024);
        array_push($settingsData, $curLine);
    }
    fclose($fileHandler);

    // move array data into holder variables
    $valLoanRate = $settingsData[0][0];

    $valDepositThres1 = $settingsData[1][0];
    $valDepositThres2 = $settingsData[2][0];

    $valDepositRate1 = $settingsData[3][0];
    $valDepositRate2 = $settingsData[4][0];
    $valDepositRate3 = $settingsData[5][0];
}

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>Interest Settings</title>
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
                <tr><td height="100px" colspan="3" style="color: darkgreen; text-align: center; font-weight: bold;"><?php echo $successMessage; ?></td></tr>
                <!-- Inputs -->
                <form id="settings" name="settings" method="post">
                <tr>
                    <td style="width: 50%; text-align: right;"><label for="valLoanRate">Loan Rate:&nbsp;</label></td>
                    <td style="width: 15%; "><input type="text" name="valLoanRate" id="valLoanRate" value="<?php echo $valLoanRate; ?>" maxlength="4" style="width: 100px; text-align: right;" required> %/year</td>
                    <td style="width: 35%; text-align: left; color: red;"><?php echo $errLoanRate; ?></td>
                </tr>
                <tr><td height="50px"></td></tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valDepositThres1">Deposit Threshold 1: $</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valDepositThres1" id="valDepositThres1" value="<?php echo $valDepositThres1; ?>" maxlength="10" style="width: 100px; text-align: right;" required></td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errDepositThres1; ?></td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valDepositThres2">Deposit Threshold 2: $</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valDepositThres2" id="valDepositThres2" value="<?php echo $valDepositThres2; ?>" maxlength="10" style="width: 100px; text-align: right;" required></td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errDepositThres2; ?></td>
                </tr>
                <tr><td height="50px"></td></tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valDepositRate1">Deposit Rate 1:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valDepositRate1" id="valDepositRate1" value="<?php echo $valDepositRate1; ?>" maxlength="10" style="width: 100px; text-align: right;" required> %/year</td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errDepositRate1; ?></td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valDepositRate2">Deposit Rate 2:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valDepositRate2" id="valDepositRate2" value="<?php echo $valDepositRate2; ?>" maxlength="10" style="width: 100px; text-align: right;" required> %/year</td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errDepositRate2; ?></td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; text-align: right;"><label for="valDepositRate3">Deposit Rate 3:&nbsp;</label></td>
                    <td style="padding-top: 10px;"><input type="text" name="valDepositRate3" id="valDepositRate3" value="<?php echo $valDepositRate3; ?>" maxlength="10" style="width: 100px; text-align: right;" required> %/year</td>
                    <td style="padding-top: 10px; text-align: left; color: red;"><?php echo $errDepositRate3; ?></td>
                </tr>
                <tr><td></td><td style="padding-top: 10px;"><p><input type="submit" id="submit" value="Submit" formaction="interestSettings.php" style="padding: 3px;"></p></td></tr>
                </form>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>