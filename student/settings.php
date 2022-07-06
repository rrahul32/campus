<?php
session_start();
if (isset($_SESSION['loggedin'])) {
     if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$pageTitle="Search for Jobs: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_template.php';
?>


<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php';
?>