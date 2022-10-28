<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
$cid=$_SESSION['cid'];
$offered=false;

//POST job offer
if(isset($_POST['submit']))
{
    $msg=$_POST['message'];
    $jid=$_POST['jid'];
    $sid=$_POST['sid'];
    $sql="INSERT INTO `offeredjobs`(`jid`,`sid`,`message`,`status`)VALUES($jid,$sid,'$msg','pending')";
    $result=mysqli_query($conn,$sql);
    if($result)
    $offered=true;
}
//end POST 

//getting students
$sql = "SELECT `email`, `fname`, `lname`, `coursename`, `percentage`, `student`.`sid` FROM `student` JOIN `student_academic` WHERE `student`.`email`=`student_academic`.`semail`;";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);
//end getting students

//getting posted jobs
$sql="SELECT `jid`, `jname`, `salary` FROM `job` WHERE `cid`=$cid ORDER BY `jdate` DESC";
$result= mysqli_query($conn,$sql);
if($result)
$jobs=mysqli_fetch_all($result);
else
$jobs=null;
//end getting posted jobs
$pageTitle = "Students: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<div class="container mx-auto mt-3 border p-4 text-center justify-content-center">
    <div class="row">
        <h1>Students</h1>
    </div>
    <div class="row">
        <?php
        if ($offered)
            echo "<div class='alert alert-dismissible alert-success text-center col-10 mx-auto bg-light' role='alert'>Job offer sent successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                ?>
                </div>
<div class="row m-3 p-3 overflow-auto justify-content-center">
    <?php
    if ($rows == null)
        echo "
    <div class='row p-3 m-3'>
    <h3>No students registered</h3>
    </div>
    ";
    else 
    {
        echo "<table class='table'>
        <thead>
        <tr>
        <th scope='col'>S.No.</th>
      <th scope='col'>Name</th>
      <th scope='col'>Email</th>
      <th scope='col'>Course</th>
      <th scope='col'>Percentage</th>";
      if($jobs!=null)
      echo" <th scope='col'>Send an Offer</th>";
        echo "</tr>
        </thead>
        <tbody>
        ";
        $row_num=1;
        foreach($rows as $row){
            echo "
            <tr>
            <th scope='row'>$row_num</th>
            <td>".ucfirst($row[1])." ".ucfirst($row[2])."</td>
            <td>".$row[0]."</td>
            <td>".ucwords($row[3])."</td>
            <td>$row[4]</td>";
            if($jobs!=null)
            echo "<td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#sendOffer' data-bs-id='$row_num'>Offer Job</button></td>";
          echo "</tr>";
          $row_num++;
        }
    }

    ?>
    <!-- Modal -->
<div class="modal fade" id="sendOffer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-4"></div>
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Job Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post" name="postjob" onsubmit="return confirm('Are you sure you want to send?')">
      <div class="row mb-3">
            <label for="jid" class="col-sm-3 col-form-label">Offered Job</label>
            <div class="col-sm-9">
                <select name="jid" id="jid">
                <?php 
                if($jobs!=null)
                foreach($jobs as $job)
                echo "<option value='$job[0]'>Title:".ucwords($job[1])." <br>Salary:$job[2]</option>";
                ?>
                </select>
            </div>
      </div>
            <div class="row mb-3">
            <label for="message" class="col-sm-2 col-form-label">Message</label>
            <div class="col-sm-10">
                <textarea name="message" id="message" cols="30" rows="10" placeholder="Enter the message here..."></textarea>
            </div>
            </div>
        <input type="hidden" name="sid" id="sid">
        <div class="row mb-3 justify-content-center">
            <div class="col-3 text-center">
                <button type="submit" class="btn btn-primary" name="submit" id="submit">
                    Send Offer
                </button>
            </div>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal end -->
</div>
</div>
</div>
<script>
    //modal 
    const modal= document.getElementById("sendOffer")
    modal.addEventListener("show.bs.modal",(event)=>{
        const button=event.relatedTarget
        const sid=button.getAttribute('data-bs-id')
        const target=document.getElementById('sid')
        target.value=sid
    })
    //modal
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>