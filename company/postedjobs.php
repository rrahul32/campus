<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$cid = $_SESSION['cid'];

//getting applied jobs
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
$sql = "SELECT `jname`,`jdesc`,`jdate`,`vacancy_no`,`salary`, COUNT(`appid`) FROM `job` JOIN `applied` ON `job`.`jid`=`applied`.`jid` WHERE `cid`=$cid ORDER BY `jdate` DESC;";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);

$pageTitle = "Jobs Applied: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<div class="col-9 mx-auto mt-3 border p-4 text-center justify-content-center" style="background-color:#bfdee3;">
    <div class="row">
        <h1>Posted Jobs</h1>
    </div>
<div class="row m-3 p-3 overflow-auto">
    <?php
    if ($rows == null)
        echo "
    <div class='row p-3 m-3'>
    <h3>No jobs applied</h3>
    </div>
    ";
    else {
        $row_num=1;
        echo "<table class='table'>
        <thead>
        <tr>
        <th scope='col'>S.No.</th>
      <th scope='col'>Job Title</th>
      <th scope='col'>Job Description</th>
      <th scope='col'>Posted Date</th>
      <th scope='col'>Vacancies</th>
      <th scope='col'>Salary</th>
      <th scope='col'>No. of Applications</th>
        </tr>
        </thead>
        <tbody>
        ";
        foreach ($rows as $job) {
            echo "
            <tr>
            <th scope='row'>$row_num</th>
            <td>".ucwords($job[0])."</td>
            <td>".ucfirst($job[1])."</td>
            <td>$job[2]</td>
            <td>$job[3]</td>
            <td>$job[4]</td>
            <td>$job[5]</td>
          </tr>
          ";
          $row_num++;
        }
        echo "
        </tbody>
        </table>
        ";
    }

    ?>
</div>
</div>

</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>