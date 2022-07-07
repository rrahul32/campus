<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
if (!isset($_SESSION['recent'])) {
    $_SESSION['recent'] = array();
    $_SESSION['index'] = 0;
}
if (isset($_GET['search'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
    $search = $_GET['search'];
    if (($_SESSION['index'] == 4)&&!in_array($search, $_SESSION['recent'])) {
        $_SESSION['index'] = 3;
        for($i=0;$i<3;$i++)
        $_SESSION['recent'][$i]=$_SESSION['recent'][$i+1];
    }
    if (!in_array($search, $_SESSION['recent']))
        $_SESSION['recent'][$_SESSION['index']++] = $search;
    //echo var_dump($_SESSION['recent']);
    $searchLower=strtolower($search);
    $sql="SELECT * FROM `job` WHERE `jname`='$searchLower';";
    $result=mysqli_query($conn,$sql);
    $rows=mysqli_fetch_row($result);
    //echo var_dump($rows);
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
    <ul class="nav flex-column col-6 mx-auto bg-white">
    <?php
    if(isset($_SESSION['recent']))
    {
         for($i=3;$i>=0;$i--)
        {
            if(!isset($_SESSION['recent'][$i]))
            continue;
            $value=$_SESSION['recent'][$i];
            if($value!=NULL)
            echo "<li class='nav-item border border-light'>
            <a class='nav-link text-primary' href='/campus/student//?search=$value&submit=Find+Jobs'>
            $value
            </a>
            </li>";
        }
    }
    ?>
    </ul>

</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>