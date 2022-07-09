<!-- 
logout.php
handles manual user logout
-->

<?php

// Include library
include("resources.php");

// Init session
session_start();

// Clear variables and log user out
$_SESSION['userLoggedIn'] = false;
$_SESSION['userAccess'] = -1;
$_SESSION['userName'] = '';
$_SESSION['pageErrorText'] = '';

// Send back to login page
header('refresh:0; url=index.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Logout</title>
        <link rel="icon" type="image/x-icon" href="media/logo.png">
    </head>
    <body>
    </body>
</html>