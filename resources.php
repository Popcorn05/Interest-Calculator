<?php

// loadHeader(isAdmin)
// Prints website header
// Only loads admin accessible if isAdmin is true
function loadHeader($isAdmin) {
    if ($isAdmin) {
        print <<< EOT
        <div id="menubar">
            <table width="100%" border="0" cellspacing="0" cellpadding="8">
            <tbody>
                <tr>
                    <td width="6.25%" class="menulink"><img src="media/logo.png" alt="ACTS Global Churches" style="text-align: left; height: 100px;"/></td>
                    <td width="6.25%" class="menulink"><a href="home.php">Home</a></td>
                    <td width="6.25%" class="menulink"><a href="search.php">Search</a></td>
                    <td width="6.25%" class="menulink"><a href="new.php">New</a></td>
                    <td width="50%" class="menulink" id="menuMainHeading">Interest Calculator</td>
                    <td width="12.5"></td>
                    <td width="6.25%" class="menulink"><a href="interestSettings.php">Settings</a></td>
                    <td width="6.25%" class="menulink"><a href="logout.php" id="logoutButton">Logout</a></td>
                </tr>
            </tbody>
            </table>
        </div>
        EOT;
    } else {
        print <<< EOT
        <div id="menubar">
            <table width="100%" border="0" cellspacing="0" cellpadding="8">
            <tbody>
                <tr>
                <td width="6.25%" class="menulink"><img src="media/logo.png" alt="ACTS Global Churches" style="text-align: left; height: 100px;"/></td>
                <td width="6.25%" class="menulink"><a href="home.php">Home</a></td>
                <td width="6.25%" class="menulink"><a href="search.php">Search</a></td>
                <td width="6.25%" class="menulink"></td>
                <td width="50%" class="menulink" id="menuMainHeading">Interest Calculator</td>
                <td width="12.5"></td>
                <td width="6.25%" class="menulink"></td>
                <td width="6.25%" class="menulink"><a href="logout.php" id="logoutButton">Logout</a></td>
                </tr>
            </tbody>
            </table>
        </div>
        EOT;
    }
}

// loadFooter()
// Prints website footer
function loadFooter() {
    print <<< EOT
        <div id="footer">
            <table style="width: 100%; border-top: 2px solid darkslategrey; background-color: #27247b;">
            <tbody>
                <tr>
                    <td style="padding: 10px; color: white;">
                        ©Acts Global Churchs, 2022
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

// bSearch(searchData, searchItem)
// searchs through array searchData and returns location of searchItem
// returns -1 if searchItem not in searchData
function bsearch($searchData, $searchItem) {
    sort($searchData);
    $first = 0;
    $last = count($searchData)-1;
    $mid = 0;
    while ($first <= $last) {
        $mid = ($first+$last)>>1;
        if ($searchData[$mid] == $searchItem) {
            return $mid;
        } else if ($searchData[$mid] > $searchItem) {
            $last = $mid-1;
        } else {
            $first = $mid+1;
        }
    }
    return -1;   
}

// validateAuth(checkAdmin)
// validates that user is logged in and sends home if not
// checkAdmin is a bool that determines whether authentication for admin status should be applied
function validateAuth($checkAdmin) {
    if (session_status() === PHP_SESSION_NONE) { // From https://stackoverflow.com/questions/6249707/check-if-php-session-has-already-started
        session_start();
    }

    if (isset($_SESSION['userLoggedIn'])) {
        if ($_SESSION['userLoggedIn'] != true) { // I did nested if statement because I'm not whether PHP always evaluates both statements
            $_SESSION['pageErrorText'] = "User not logged in";
            header('refresh:0; url=index.php');
            exit;
        }
    } else {
        $_SESSION['pageErrorText'] = "User not logged in";
        header('refresh:0; url=index.php');
        exit;
    }

    if ($checkAdmin == true) { // If admin-only auth required then check for admin and boot to home if viewer
        if ($_SESSION['userAccess'] != 1) {
            header('refresh:0; url=home.php');
            exit;
        }
    }
}

?>