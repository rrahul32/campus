<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$sid = $_SESSION['sid'];
$passChanged = false;
$passSame = false;
$passEqual = true;
$newPassSame = true;
if (isset($_POST["changePassword"])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
    $currentpass = $_POST["currentPassword"];
    $sql = "SELECT `pwd` FROM `student` WHERE `sid`=$sid;";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_row($result);
        if ($row[0] != $currentpass)
            $passEqual = false;
        else {
            $newPass = $_POST['newPassword'];
            $cNewPass = $_POST['confirmNewPassword'];
            if ($newPass != $cNewPass)
                $newPassSame = false;
            else {
                if ($currentpass == $newPass)
                    $passSame = true;
                else {
                    $sql = "UPDATE `student` SET `pwd`='$newPass' WHERE `sid`=$sid;";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        $passChanged=true;
                    }
                }
            }
        }
    }
}
$pageTitle = "Search for Jobs: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<div class="col-6 mx-auto mt-3 border p-4" style="background-color:#bfdee3;">
    <form action="" method="post">
        <div class="mb-3 row justify-content-center text-center pt-3">
            <h3>Change Password</h3>
        </div>
        <div class="row">
            <?php
            if (!$passEqual)
                echo "<div class='alert alert-danger text-center col-10 mx-auto bg-light' role='alert'>Incorrect current password!</div>";
            else if (!$newPassSame)
                echo "<div class='alert alert-danger text-center col-10 mx-auto bg-light' role='alert'>Passwords do not match!</div>";
            else if ($passSame)
                echo "<div class='alert alert-danger text-center col-10 mx-auto bg-light' role='alert'>New and old password are same!</div>";
            else if ($passChanged)
                echo "<div class='alert alert-success text-center col-10 mx-auto bg-light' role='alert'>Password updated successfully!</div>";
            ?>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" required>
            <label for="curretnPassword">Current Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password should contain atleast one digit, uppercase letter and lowercase letter and should be atleast 8 characters in length" required>
            <label for="newPassword">New Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" required>
            <label for="confirmNewPassword">Confirm New Password</label>
        </div>
        <div class="row mb-3">
            <input type="submit" name="changePassword" value="Change Password" id="changePassword" class="btn btn-primary col-3 ms-3">
        </div>
    </form>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>