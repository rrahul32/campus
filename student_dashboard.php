<?php
session_start();
if (isset($_SESSION['loggedin'])) {
     if ($_SESSION['type'] == "company")
        header("Location: company_dashboard.php");
    else if ($_SESSION['type'] == "admin")
        header("Location: admin_dashboard.php");
}
$pageTitle="Dashboard";
include_once 'partials/_template.php';
?>


<?php
include_once 'partials/_footer.php'
?>