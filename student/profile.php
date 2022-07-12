<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/config.php';
$updated=false;
$sid=$_SESSION['sid'];
// echo var_dump($_SESSION);
//POST Request
if(isset($_POST['save']))
{

    $lname=$_POST['lname'];
    $fname=$_POST['fname'];
    $sql="UPDATE `student` SET `lname`='$lname',`fname`='$fname' WHERE `sid`='$sid'";
    $result= mysqli_query($conn, $sql);
    if($result)
    {
        $updated=true;
    }
    
}
//Obtain Student Details
$sql="SELECT `fname`,`lname`,`coursename`,`percentage` FROM `student` JOIN `student_academic` ON `student`.`email`=`student_academic`.`semail` WHERE `sid`='$sid'";
$result= mysqli_query($conn, $sql); 
if($result)
{
    $rows=mysqli_fetch_row($result);
    $email=$_SESSION['email'];
    $fname=$rows[0];
    $lname=$rows[1];
    $coursename=$rows[2];
    $percentage=$rows[3];
}
$pageTitle = "View Profile: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<script>
    function editable() {
        fname=document.getElementById("fname");
       lname=document.getElementById("lname");
       fname.readOnly=false;
       fname.style.backgroundColor="white";
       lname.style.backgroundColor="white";
       lname.readOnly=false;
            document.getElementById('save').hidden=false;
        document.getElementById('edit').hidden=true;
        
    }
</script>
<div class="col-6 mx-auto mt-3 border p-4" style="background-color:#bfdee3;">
    <form action="" method="post">
        <div class="mb-3 row justify-content-center text-center pt-3">
            <h3>Profile</h3>
        </div>
        <div class="row">
            <?php
        if ($updated)
                echo "<div class='alert alert-success text-center col-10 mx-auto bg-light' role='alert'>Profile updated successfully!</div>";
            ?>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="email" id="email" value="<?php echo $email;?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="fname" class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="fname" id="fname" value="<?php echo $fname;?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="lname" id="lname" value="<?php echo $lname;?>" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="course" class="col-sm-2 col-form-label">Course</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="course" id="course" value="<?php echo $coursename;?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="percentage" class="col-sm-2 col-form-label">Percentage</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="percentage" id="percentage" value="<?php echo $percentage;?>">
            </div>
        </div>
        
        <div class="row mb-3">
            <input type="submit" name="save" value="Save" id="save" class="btn btn-primary col-2 ms-3" hidden>
            <a class="btn btn-primary col-2 ms-3" onclick="editable()" id="edit">Edit</a>
        </div>
    </form>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>