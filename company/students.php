<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}

//getting companies
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
$sql = "SELECT `email`, `fname`, `lname`, `coursename`, `percentage` FROM `student` JOIN `student_academic` WHERE `student`.`email`=`student_academic`.`semail`;";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);

$pageTitle = "Students: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<div class="container mx-auto mt-3 border p-4 text-center justify-content-center">
    <div class="row">
        <h1>Students</h1>
    </div>
<div class="row m-3 p-3 overflow-auto justify-content-center">
    <?php
    if ($rows == null)
        echo "
    <div class='row p-3 m-3'>
    <h3>No students registered</h3>
    </div>
    ";
    else {
        foreach($rows as $row)
        echo "<div class='card m-2' style='width: 18rem; background-color:beige;'>
  <div class='card-body'>
    <h5 class='card-title'>".ucfirst($row[1])." ".ucfirst($row[2])."</h5>
    <h6 class='card-subtitle mb-2 text-muted'> Course: ".ucfirst($row[3])."</h6>
    <h6 class='card-subtitle mb-2 text-muted'> Percentage: ".ucfirst($row[4])."</h6>
    <h6 class='card-subtitle mb-2 text-muted'> Email: $row[0]</h6>
  </div>
</div>";
    }

    ?>
</div>
</div>

</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>