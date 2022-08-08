<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/config.php';
$updated=false;
$cid=$_SESSION['cid'];
// echo var_dump($_SESSION);
//POST Request
if(isset($_POST['save']))
{

    $name=$_POST['name'];
    $loc=$_POST['loc'];
    $ceo=$_POST['ceo'];
    $website=$_POST['website'];
    $sql="UPDATE `company` SET `cname`='$name',`loc`='$loc', `ceo`='$ceo', `website`='$website' WHERE `cid`='$cid'";
    $result= mysqli_query($conn, $sql);
    if($result)
    {
        $updated=true;
    }
    
}
//Obtain Student Details
$sql="SELECT `cname`,`loc`,`ceo`,`website` FROM `company` WHERE `cid`='$cid'";
$result= mysqli_query($conn, $sql); 
if($result)
{
    $rows=mysqli_fetch_row($result);
    $email=$_SESSION['email'];
    $name=$rows[0];
    $loc=$rows[1];
    $ceo=$rows[2];
    $website=$rows[3];
}
$pageTitle = "View Profile: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<script>
    function editable() {
    //     name=document.getElementById("name");
    //    loc=document.getElementById("loc");
    //    name.readOnly=false;
    //    name.style.backgroundColor="white";
    //    lname.style.backgroundColor="white";
    //    lname.readOnly=false;
    document.profile.querySelectorAll('input').forEach((ele)=>{
        if(ele.id!='email' && ele.id!='save')
        {
            ele.readOnly=false;
            ele.style.background='white';
        }
    })
            document.getElementById('save').hidden=false;
        document.getElementById('edit').hidden=true;
        
    }
</script>
<div class="col-6 mx-auto mt-3 border p-4" style="background-color:#bfdee3;">
    <form action="" method="post" name="profile">
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
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="name" id="name" value="<?php echo ucwords($name);?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="loc" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="loc" id="loc" value="<?php echo ucwords($loc);?>" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="ceo" class="col-sm-2 col-form-label">CEO</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="ceo" id="ceo" value="<?php echo ucwords($ceo);?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="website" class="col-sm-2 col-form-label">Website</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext border border-primary" name="website" id="website" value="<?php echo $website;?>">
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