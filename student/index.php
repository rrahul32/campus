<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
    }
    // echo var_dump($_GET);
    if(isset($_GET['search']))
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/config.php';
        $search=$_GET['search'];
        $sql="SELECT * FROM `job` WHERE `jname`='$search';";
        $result=mysqli_query($conn,$sql);
        $rows=mysqli_fetch_row($result);
        echo var_dump($rows);
    }
$pageTitle = "Search for Jobs: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<div class="container-flex border">

    <form class=" col-6 mx-auto py-5" action="" method="GET">
        <div class="row">
            <div class="form-floating form-control-sm col-9 mx-auto">
                <input type="text" class="form-control" id="search" placeholder="Company" name="search" required>
                <label for="search" style="left:auto;">Enter job title</label>
            </div>
            <!-- <div class="form-floating col">
<input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
      <label for="floatingInput">Email address</label>
</div> -->
            <div class="d-flex col-3 py-1">
                <input class="btn btn-primary" type="submit" name="submit" value="Find Jobs">
            </div>
        </div>
    </form>
</div>
<div class="container px-auto text-center p-2">
    <div class="row">
        <h3>Recent Search</h3>
    </div>
    <div class="row" id="recentSearch">

    </div>

</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>