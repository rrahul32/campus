<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
}
$pageTitle="About Us";
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_template.php';
?>


<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php'
?>