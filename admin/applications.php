<?php
session_start();
if (isset($_SESSION['loggedin'])) {
  if ($_SESSION['type'] == "student")
    header("Location: /campus/student");
  else if ($_SESSION['type'] == "company")
    header("Location: /campus/company");
} else
  header("Location: /campus");
$updated = false;
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';

//post request
//end post request

//get company details
$sql = "SELECT `applied`.`appid`, CONCAT(`student`.`fname`, \" \", `student`.`lname`) AS name, `student`.`email`, `jname`, `cname`, `appdate`,
`appstatus` FROM `appstatus` JOIN `applied` ON `appstatus`.`appid`=`applied`.`appid` JOIN `student` ON `student`.`sid`=
`applied`.`sid` JOIN `job` ON `job`.`jid`=`applied`.`jid` JOIN `company` ON `company`.`cid`=`job`.`cid`;";
$result = mysqli_query($conn, $sql);
if ($result)
  $rows = mysqli_fetch_all($result);
else
  $rows = null;

//end get

//passing rows to javascript
$pageTitle = "Manage Applications: Welcome to Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
echo "<script>const rows=" . json_encode($rows) . "</script>";
?>
<div class="container mt-5">
  <h2 class="text-center mb-3"><strong>Application Details</strong></h2>
  <?php if ($updated) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Record deleted succesfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif ?>
  <table class="table table-bordered" style="background-color:#d08181">
    <thead>
      <tr>
        <th scope="col">S.No.</th>
        <th scope="col">Applicant Name</th>
        <th scope="col">Applicant Email</th>
        <th scope="col">Vacancy Name</th>
        <th scope="col">Company Name</th>
        <th scope="col">Applied Date</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows != null) : ?>
        <?php $sno = 1;
        foreach ($rows as $row) : ?>
          <tr>
            <td><?php echo $sno++ ?></td>
            <?php for ($i = 1; $i < 7; $i++) : ?>
              <?php if ($row[$i] == null || $row[$i] == "")
                $row[$i] = "-";
              ?>
              <td> <?php echo $row[$i] ?></td>
            <?php endfor ?>
          </tr>
        <?php endforeach ?>
      <?php else : ?>
        <th class="text-center" colspan="7">No Records</th>
      <?php endif ?>
    </tbody>
  </table>
</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php'
?>