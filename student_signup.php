<?php
$pageTitle="Signup To Campus Recruitment Portal";
include_once 'partials/_template.php';
?>
<script>
  document.getElementById('title').innerText = 'Student Sign Up';
</script>
<form action="" method="post">
<div class="container mt-5 border border-3 rounded col-10 px-5 py-3">
  <div class="row">
    <h1 class="text-center">
      Sign Up
    </h1>
    <p class="text-center">Already a member? <a href="student_login.php">Login</a></p>
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
include_once 'partials/_footer.php'
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/config.php';
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  if ($password == $cpassword) {
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $sql = "INSERT INTO `student` (`pwd`, `email`, `fname`, `lname`) VALUES ('$password', '$email', '$fname', '$lname');";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      echo "<div class='alert alert-success' role='alert'>Successfully Signed Up!</div>";
    }
  }
}
?>