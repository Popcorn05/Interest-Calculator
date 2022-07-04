<?php

// loadHeader()
// Prints website header
function loadHeader() {
    print <<< EOT
        <div class="menubar">
            <table width="100%" border="0" cellspacing="0" cellpadding="8">
            <tbody>
                <tr>
                    <td colspan="5" background-color="#e6e6fa"><img src="media/irepairsLogo.png" width="248" height="93" alt="" text-align="left"/></td>
                </tr>
                <tr class="menubar">
                    <td width="20%"><a href="index.php" class="menulink">Home</a></td>
                    <td width="20%"><a href="allcust.php" class="menulink">All Customers</a></td>
                    <td width="20%"><a href="profits.php" class="menulink">Profits</a></td>
                    <td width="20%"><a href="incomplete.php" class="menulink">Incomplete Jobs</a></td>
                    <td width="20%"><a href="newcust.php" class="menulink">New Customer</a></td>
                </tr>
            </tbody>
            </table>
        </div>
    EOT;
}

// loadFooter()
// Prints website footer
function loadFooter() {
    print <<< EOT
        <div class="footer">
            <table width="100%">
            <tbody>
                <tr>
                    <td class="menubar">
                        ©2022 iRepairs
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    EOT;
}

// testInput(data)
// validates input to remove code and other illegal characters
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>