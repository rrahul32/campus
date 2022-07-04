<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_redirect.php';
$pass_match = true;
$success = false;
$duplicate = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/config.php';
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  $email = $_POST['email'];
  $duplicate_query = "SELECT * FROM `student` WHERE `email`='$email';";
  $duplicate_result = mysqli_query($conn, $duplicate_query);
  $duplicate_rows = mysqli_num_rows($duplicate_result);
  if ($duplicate_rows)
    $duplicate = true;
  if (($password == $cpassword)&&(!$duplicate))
  {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $sql = "INSERT INTO `student` (`pwd`, `email`, `fname`, `lname`) VALUES ('$password', '$email', '$fname', '$lname');";
    $result = mysqli_query($conn, $sql);
    if ($result)
      $success=true;
  }
  if ($password != $cpassword)
        $pass_match = false;
}

$pageTitle = "Signup To Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_template.php';
?>
<form action="/campus/student/signup.php" method="post">
  <div class="container mt-5 border border-3 rounded col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10 px-5 py-3">
    <div class="row">
      <h1 class="text-center">
        Sign Up
      </h1>
      <p class="text-center">Already a member? <a href="/campus/student/login.php">Login</a></p>
    </div>
    <div class="row">
            <?php
            if ($success)
                echo "<div class='alert alert-success text-center col-10 mx-auto' role='alert'>Signed up successfully!</div>";
            if ($duplicate)
                echo "<div class='alert alert-danger text-center col-10 mx-auto' role='alert'>Email already in use!</div>";
            else if(!$pass_match)
                echo "<div class='alert alert-danger text-center col-10 mx-auto' role='alert'>Passwords do not match!</div>";
            ?>
        </div>
    <div class="row">
      <div class="form-floating col-6 mb-3">
        <input type="text" class="form-control " id="floatingInput" placeholder="Mark" name="fname" required>
        <label for="floatingInput" style="left:auto">First Name</label>
      </div>
      <div class="form-floating col-6 mb-3">
        <input type="text" class="form-control" id="floatingInput" placeholder="Woods" name="lname" required>
        <label for="floatingInput" style="left:auto">Last Name</label>
      </div>
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
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php'
?>
<?php

?>