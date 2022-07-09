<!-- 
search.php
Allows for user to input search criteria
-->

<?php

// Include library
include("resources.php");

// Session init
start_session();

// Validate authentication
validateAuth(false);

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
                <!-- Inputs -->
                <form id="settings" name="settings" method="post">
                <tr>
                    <td style="width: 50%; text-align: right;"><label for="valLoanRate">Loan Rate:&nbsp;</label></td>
                    <td style="width: 15%; "><input type="text" name="valLoanRate" id="valLoanRate" value="<?php echo $valLoanRate; ?>" maxlength="4" style="width: 150px; text-align: right;" required> %/year</td>
                    <td style="width: 35%; text-align: left; color: red;"><?php echo $errLoanRate; ?></td>
                </tr>
                <tr><td height="50px"></td></tr>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>