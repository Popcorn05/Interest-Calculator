<!-- 
delete.php
Pass in an id and confim for deletion
-->

<?php

// Include library
include("resources.php");

// Validate authentication
validateAuth(true);

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>Delete Data</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>

    <body>
        <!-- Load heading with current logged in user access level -->
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
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>