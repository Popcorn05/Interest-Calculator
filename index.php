<!-- 
index.php
Landing site for website
Acts as login page
-->

<?php

// Include library
include("resources.php");

?>

<!DOCTYPE html>

<html>

    <head>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <title>iRepairs</title>
    </head>

    <body>
        <div id="wrapper">
        

            <table width="32%" style="margin-top: 8%;" class="centre">
            <tbody>
                <tr>
                    <td>
                        <img src="media/logo.png" width="50%" class="centre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <form id="login" name="login" method="post">
                        <table id="loginInputTable">
                        <tr>
                            <td style="width: 20%; text-align: right;"><label for="email">First Name:</label></td>
                            <td style="width: 80%; "><input type="text" name="email" id="email" maxlength="64" style="margin-left: 2%; width: 96%;"></td>
                        </tr>
                        <tr>
                            <td style="padding-top: 2%; text-align: right;"><label for="password">Surname:</label></td>
                            <td style="padding-top: 2%"><input type="password" name="password" id="password" maxlength="64" style="margin-left: 2%; width: 96%;"></td>
                        </tr>
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