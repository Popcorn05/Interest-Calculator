<!-- 
home.php
Home page for the site, leads to different functions
-->

<?php

// Include library
include("resources.php");

// Validate authentication
validateAuth(false);

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>Home</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>

    <body>
        <!-- Load heading with current logged in user access level -->
        <?php loadHeader($_SESSION['userAccess']); ?>
        <div id="wrapper">
            <table width="60%" class="centre" style="table-layout: fixed;">
            <tbody>
                <tr>
                    <!-- Okay so this bit is really scuffed, but I played around with the CSS for about 4 hours and could not get anything to work other than this -->
                    <td><p style="font-style: italic; font-size: 24pt; color: white; text-align: center; padding-top: 30px;">Welcome back, <?php echo $_SESSION['userName']; ?>!</p></td>
                    <td><p style="font-style: italic; font-size: 24pt; color: #27247b; text-align: center; padding-top: 30px;">Welcome back, <?php echo $_SESSION['userName']; ?>!</p></td>
                </tr>
                <tr height="200px"></tr>
                <tr>
                    <?php
                    if ($_SESSION['userAccess'] == 1) { // If admin print both buttons
                        print <<< EOT
                            <td height="150px" width="40%"><a href="search.php"><button class="homeButton">Search/View Data</button></a></td>
                            <td width="20%"></td>
                            <td height="150px" width="40%"><a href="new.php"><button class="homeButton">New Calculation</button></a></td>
                        EOT;
                    } else { // Else print single button
                        print <<< EOT
                            <td width="30%">&nbsp;</td>
                            <td height="150px" width="40%"><a href="search.php"><button class="homeButton">Search/View Data</button></a></td>
                            <td width="30%">&nbsp;</td>
                        EOT;
                    }
                    
                    ?>
                </tr>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>