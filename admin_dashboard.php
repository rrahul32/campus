<?php
include_once 'partials/_login.php';
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: student_dashboard.php");
    else if ($_SESSION['type'] == "company")
        header("Location: company_dashboard.php");
}
$pageTitle="About Us";
include_once 'partials/_template.php';
?>


<?php
include_once 'partials/_footer.php'
?>