<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$sid = $_SESSION['sid'];
$statusChanged=false;
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';


if(isset($_POST['status'])){
    $oid=$_POST["oid"];
    $status=$_POST["status"];
    $sql_post="UPDATE `offeredjobs` SET `status`='$status' WHERE `oid`=$oid";
    $result_post= mysqli_query($conn,$sql_post);
    if($result_post)
    $statusChanged=true;
}

$sql = "SELECT `offeredjobs`.`status`, `jname`, `cname`, `odate`,`message`,`oid` AS `date` FROM `offeredjobs` JOIN `job` ON `offeredjobs`.`jid`=`job`.`jid` JOIN `company` ON `job`.`cid`=`company`.`cid` WHERE `offeredjobs`.`sid`=$sid ORDER BY `date` DESC";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);


$pageTitle = "Job Offers: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
echo "<script> const rows=".json_encode($rows)."</script>";
?>
<div class="col-6 mx-auto mt-3 border p-4 text-center justify-content-center" style="background-color:#bfdee3;">
<?php if ($statusChanged)
                echo "<div class='alert alert-success text-center col-10 mx-auto bg-light' role='alert'>Status updated successfully!</div>";
      ?>          
<div class="row">
        <h1>Job Offers</h1>
    </div>
<div class="row m-3 p-3 overflow-auto">
    <?php
    if ($rows == null)
        echo "
    <div class='row p-3 m-3'>
    <h3>No job offers</h3>
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
      <th scope='col'>Offered Date</th>
      <th scope='col'>Status</th>
      <th scope='col'>Message</th>
      <th scope='col'> Accept/Reject</th>  
      </tr>
        </thead>
        <tbody>
        ";
        foreach ($rows as $job) {
            echo "
            <tr>
            <th scope='row'>$row_num</th>
            <td>".ucwords($job[1])."</td>
            <td>".ucwords($job[2])."</td>
            <td>$job[3]</td>
            <td>$job[0]</td>
            <td>$job[4]</td>
            <td>"; if($job[0]!="rejected" && $job[0]!="accepted"):?>
            <svg onclick="submitForm(<?php echo $row_num-1?>,'accepted',event)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
</svg>
<svg onclick="submitForm(<?php echo $row_num-1?>,'rejected',event)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
</svg>
<?php endif ?>
            </td>
        </tr>
<?php
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
<form action="" method="post" name="conform">
<input type="hidden" name="status">
<input type="hidden" name="oid">
</form>
<script>
    function submitForm(num,status,event){
        document.forms["conform"]["oid"].value=rows[num][4];
        document.forms["conform"]["status"].value=status;
       document.forms["conform"].submit();

    }
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>