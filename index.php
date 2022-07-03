<?php
include_once 'partials/_login.php';
if (isset($_SESSION['loggedin'])) {
     if ($_SESSION['type'] == "company")
        header("Location: company_dashboard.php");
    else if ($_SESSION['type'] == "admin")
        header("Location: admin_dashboard.php");
}
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