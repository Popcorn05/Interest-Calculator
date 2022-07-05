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
        <title>iRepairs</title>
    </head>

    <body>
        <?php loadHeader($_SESSION['userAccess']); ?>
        <div id="wrapper">
        
            

            <table width="100%">
            <tbody>
                <tr>
                    <td>
                    </td>
                </tr>
            </tbody>
            </table>

        </div>
        <?php loadFooter(); ?>
    </body>

</html>