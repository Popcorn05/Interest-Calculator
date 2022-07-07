<!-- 
index.php
Landing site for website
Acts as login page
-->

<?php

// Include library
include("resources.php");

// Init session and variables
session_start();

$_SESSION['userLoggedIn'] = false; //Just always making sure that users can't get in without logging in

$userEmail = '';
$userPassword = '';

$pageErrorText = '';

// If session variables not empty, pass in to local
if (isset($_SESSION["userEmail"])) {
    $userEmail = $_SESSION["userEmail"];
    $userPassword = $_SESSION["userPassword"];

    $pageErrorText = $_SESSION["pageErrorText"];
}

?>

<!DOCTYPE html>

<html>
    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>iRepairs</title>
    </head>

    <body>
        <div id="wrapper">
            <!-- Keeps everything in centre column -->
            <table width="32%" style="margin-top: 8%;" class="centre">
            <tbody>
                <tr>
                    <td>
                        <!-- Logo -->
                        <img src="media/logo.png" width="50%" class="centre" style="display: block;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- Form and table -->
                        <form id="login" name="login" method="post">
                        <table id="loginInputTable">
                        <tr>
                            <td style="width: 20%; text-align: right;"><label for="email">Email:</label></td>
                            <td style="width: 80%; "><input type="email" name="email" id="email" value="<?php echo $userEmail; ?>" maxlength="64" style="margin-left: 2%; width: 96%;"></td>
                        </tr>
                        <tr>
                            <td style="padding-top: 2%; text-align: right;"><label for="password">Password:</label></td>
                            <td style="padding-top: 2%"><input type="password" name="password" id="password" value="<?php echo $userPassword; ?>" maxlength="64" style="margin-left: 2%; width: 96%;"></td>
                        </tr>
                        <!-- Print errors, will be empty if not returning from authentication page -->
                        <tr><td colspan="2"><p style="color: red; text-align: right;"><?php echo $pageErrorText; ?></p></td></tr> 
                        <tr><td></td><td><p><input type="submit" id="submit" value="Login" formaction="authenticate.php" style="display: block; margin-left: auto; margin-right: 0;"></p></td></tr>
                        </table>
                        </form>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </body>
</html>