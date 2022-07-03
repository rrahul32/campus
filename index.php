<?php
session_start();
// echo var_dump($_SESSION);
if (isset($_SESSION['type']) && ($_SESSION['type'] == 'student')) //check if student
{
  $student = true;
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $pageTitle = "Welcome $fname $lname";
} else
  $pageTitle = "Welcome to Campus Recruitment Portal";
include_once 'partials/_template.php';
?>
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once 'partials/_footer.php' ?>