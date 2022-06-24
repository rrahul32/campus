<?php
include 'partials/_template.php';
include 'partials/_navbar.php';
include 'config.php';
?>
<script>
  document.getElementById('title').innerText='Signup';
  </script>
<div class='container'>
  <form action="signup.php" method="POST">
<div class="row">
  <div class="col">
    <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="fname" required>
  </div>
  <div class="col">
    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="lname" required>
  </div>
</div>
  <div class="mb-3">
   <!-- <label for="exampleInputEmail1" class="form-label">Email address</label> -->
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email address" name="email" required>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
     <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
  </div>
  <div class="mb-3">
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder=" Re-enter password" name="cpassword" required>
  </div>
  <!--<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>-->
  <button type="submit" class="btn btn-primary">Signup</button>
</form>
</div>
<?php
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
$password=$_POST["password"];
$cpassword=$_POST["cpassword"];
if($password==$cpassword)
{
  $email=$_POST['email'];
  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $sql = "INSERT INTO `student` (`pwd`, `email`, `fname`, `lname`) VALUES ('$password', '$email', '$fname', '$lname');";
  $result= mysqli_query($conn,$sql);
  if($result)
  {
    echo "Successfully signed up";
  }
}
  }
?>