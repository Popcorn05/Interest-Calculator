<?php

// export.php
// Does export and provides button to retry if doesnt work

// Include library
include("resources.php");

// Session init
session_start();

// Validate authentication
validateAuth(false);

// get variables
if (isset($_SESSION['lastResults'])) {
    $data = $_SESSION['lastResults'];
}

// Start text
$dataText = "Account Number,Date,Opening Balance,Closing Balance,Interest\n";

// Open temp csv and overwrite with selected data
$fileHandler = fopen('temp/download.csv', 'w');
for ($i = 0; $i < count($data); $i++) {
    $dataText = $dataText . implode(",",array_slice($data[$i],1)) . "\n";
}
fwrite($fileHandler, $dataText);
fclose($fileHandler);

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>Export</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>

    <body>
        <!-- Load heading with current logged in user access level -->
        <?php loadHeader($_SESSION['userAccess']); ?>
        <div id="wrapper">
            <table width="100%">
            <tbody>
                <tr>
                    <td colspan="3"><p style="font-size: 24pt; color: #27247b; text-align: center; padding-top: 30px;">Export</p></td>
                </tr>
                <tr><td height="150px"></td></tr>
                <tr><td style="text-align: center; font-size: 14pt;"><a href="temp/download.csv" style="color: black;">Click here</a> to download</td></tr>
                <tr><td style="text-align: center; font-size: 14pt; padding-top: 50px;">To return to search page <a style="color: black;" href="<?php echo "view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}" ?>">click here</a></td></tr>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>