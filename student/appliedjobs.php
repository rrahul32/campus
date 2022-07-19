<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$sid = $_SESSION['sid'];

//getting applied jobs
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
$sql = "SELECT `jname`,`cname`,`appdate`,`appstatus` FROM `company` JOIN `job` ON `company`.`cid`=`job`.`cid` JOIN `applied` ON `job`.`jid`=`applied`.`jid` LEFT JOIN `appstatus` ON `applied`.`appid`=`appstatus`.`appid` WHERE `sid`=$sid;";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);

$pageTitle = "Jobs Applied: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<div class="col-6 mx-auto mt-3 border p-4 text-center justify-content-center" style="background-color:#bfdee3;">
    <div class="row">
        <h1>Applied Jobs</h1>
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
      <th scope='col'>Company Name</th>
      <th scope='col'>Applied Date</th>
      <th scope='col'>Job Status</th>
        </tr>
        </thead>
        <tbody>
        ";
        foreach ($rows as $job) {
            echo "
            <tr>
            <th scope='row'>$row_num</th>
            <td>$job[0]</td>
            <td>$job[1]</td>
            <td>$job[2]</td>
            <td>$job[3]</td>
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