<?php
$pass_match=true;
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/config.php';
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $email = $_POST['email'];
    $duplicate_query = "SELECT * FROM `company` WHERE `email`=$email;";
    $duplicate_result = mysqli_query($conn, $duplicate_query);
    $duplicate_rows = mysqli_num_rows($duplicate_result);
    if ($duplicate_result)
        $duplicate = true;
    else
        $duplicate = false;
    if (($password == $cpassword) && (!$duplicate)) {
        $cname = $_POST['cname'];
        $loc = $_POST['loc'];
        $sql = "INSERT INTO `company` (`pwd`, `email`, `cname`, `loc`) VALUES ('$password', '$email', '$cname', '$loc');";
        $result = mysqli_query($conn, $sql);
        if ($result)
            $success = true;
    }
    else
    $pass_match=false;

}
$pageTitle = "Signup To Campus Recruitment Portal";
include_once 'partials/_template.php';
?>
<form action="" method="POST">
    <div class="container my-5 col-10 border border-3 rounded px-5 py-3">
        <div class="row">
            <h1 class="text-center">
                Sign Up
            </h1>
            <p class="text-center">Already a member? <a href="company_login.php">Login</a></p>
        </div>
        <div class="row">
            <?php
           if($success)
            echo "<div class='alert alert-success text-center col-3 mx-auto' role='alert'>Signed up successfully!</div>";
            if(!$pass_match)
            echo "<div class='alert alert-danger text-center col-3 mx-auto' role='alert'>Passwords do not match!</div>";
            ?>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="eg:Infosys" name="cname" required>
            <label for="floatingInput">Company Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="eg:Infosys" name="loc" required>
            <label for="floatingInput">Location</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating pb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating pb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Confirm Password" name="cpassword" required>
            <label for="floatingPassword">Confirm Password</label>
        </div>
        <div class="d-grid">
            <input class="btn btn-primary" type="submit" value="Sign Up">
        </div>
    </div>
</form>
<?php
include_once 'partials/_footer.php'
?>