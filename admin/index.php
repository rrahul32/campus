<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
}
else
header("Location: /campus");
$pageTitle="Admin Dashboard: Welcome to Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_template.php';
?>
<div class="container text-center border border-2 mt-3 mx-auto" id="contents">
    <h2 class="p-3 ">Admin Dashboard</h2>
    <div class="col">
        <h5>Manage Students Details</h5>
    </div>
    <div class="col">
        <h5>Manage Registered Companies</h5>
    </div>
    <div class="col">
        <h5>Manage Posted Jobs</h5>
    </div>
    <div class="col">
        <h5>Manage Applications</h5>
    </div>
</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php'
?>