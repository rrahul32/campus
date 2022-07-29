<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
    else if($_SESSION['type']=='company')
    header("Location: /campus/");
}
else
header("Location: /campus/company/login.php");
?>