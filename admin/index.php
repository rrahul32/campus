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
<style>
    .list-group-item:hover{
        background-color: blue;
        color:white;
    }
</style>
<div class="col-xl-6 col text-center border mx-auto bg-white mt-5" id="contents">
    <h2 class="p-3 ">Admin Dashboard</h2>
    <div class="list-group" >
  <a href="/campus/admin/registeredcomp.php" class="list-group-item list-group-item-action" >Manage Registered Companies</a>
  <a href="/campus/admin/stuacademic.php" class="list-group-item list-group-item-action">Manage Students Academic Details</a>
  <a href="/campus/admin/registeredstu.php" class="list-group-item list-group-item-action">Manage Registered Students </a>
  <a href="/campus/admin/postedjobs.php" class="list-group-item list-group-item-action">Manage Posted Jobs</a>
  <a href="/campus/admin/applications.php" class="list-group-item list-group-item-action">Manage Applications</a>
</div>
    

</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php'
?>