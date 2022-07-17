<!-- 
delete.php
Pass in an id and confim for deletion
-->

<?php

// Include library
include("resources.php");

// start session
session_start();

// Validate authentication
validateAuth(true);

// setup variables
$id = -1;
$data = array();

// pass in
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_SESSION['lastResults'])) {
    $id = $_GET['id'];
    $data = $_SESSION['lastResults'];
} else {
    header("refresh:0; url=view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}");
}

// Get specific data row
$i = bsearch(array_column($data,0),$id);
if ($i != -1) {
    $row = $data[$i];
} else {
    header("refresh:0; url=view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}");
}

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
            <table width="70%" style="border-collapse: collapse; margin-left: auto; margin-right: auto;">
            <tbody>
                <!-- Heading -->
                <tr>
                    <td colspan="10"><p style="font-size: 24pt; color: #27247b; text-align: center; padding-top: 30px;">Delete</p></td>
                </tr>
                <tr><td height="150px" colspan="10"><p style="color: black; text-align: center; vertical-align: bottom;">Are you sure you want to delete this line of data?</p></td></tr>
                <!-- Data -->
                <tr>
                    <th width="20%" style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Account Number</th>
                    <th width="20%" style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Date</th>
                    <th width="20%" style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Opening Balance</th>
                    <th width="20%" style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Closing Balance</th>
                    <th width="20%" style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;">Interest</th>
                </tr>
                <tr>
                    <td style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;"><?php echo $row[1]; ?></td>
                    <td style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;"><?php echo $row[2]; ?></td>
                    <td style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;"><?php echo $row[3]; ?></td>
                    <td style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;"><?php echo $row[4]; ?></td>
                    <td style="text-align: center; border: 1px solid darkslategrey; border-collapse: collapse;"><?php echo $row[5]; ?></td>
                </tr>
                <tr><td height="50px" colspan="10"></td></tr>
                <!-- Buttons -->
                <tr>
                    <td width="20%"></td>
                    <td width="20%" style="text-align: center;"><a href="<?php echo "view.php?startDate={$_SESSION['lastStart']}&endDate={$_SESSION['lastEnd']}&accNum={$_SESSION['lastAccNum']}"; ?>"><button style="width: 100px; font-size: 12pt; background-color: white; border: 1px solid lightslategrey; border-radius: 3px;">Cancel</button></a></td>
                    <td width="20%"></td>
                    <td width="20%" style="text-align: center;"><a href="deleteSuccess.php?id=<?php echo $_GET['id']; ?>"><button style="width: 100px; font-size: 12pt; background-color: white; border: 1px solid lightslategrey; border-radius: 3px;">Yes</button></a></td>
                    <td width="20%"></td>
                </tr>
            </tbody>
            </table>
        </div>
        <!-- Load footer -->
        <?php loadFooter(); ?>
    </body>

</html>