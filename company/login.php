<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_redirect.php';
$pageTitle = "Login To Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_template.php';
$exists = true;
$pass_match = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/config.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `company` WHERE `email`='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    if (!$row)
        $exists = false;
    else {
        $cname = $row[2];
        $loc = $row[3];
        $pass_match = ($password == $row[0]);
        if ($pass_match) {
            $_SESSION['cname'] = $cname;
            $_SESSION['loggedin'] = true;
            $_SESSION['type'] = "company";
            header("Location: /campus/company");
        }
    }
}
?>
<form action="/campus/company/login.php" method="post">
    <div class="container my-5 col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10 border border-3 rounded px-5 py-3">
        <div class="row text-center">
            <h2>Login</h2>
        </div>
        <div class="row">
            <?php
            if (!$exists)
                echo "<div class='alert alert-danger text-center col-10 mx-auto' role='alert'>No account found with this email!</div>";
            else if (!$pass_match)
                echo "<div class='alert alert-danger text-center col-10 mx-auto' role='alert'>Incorrect Password</div>";
            ?>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="eg:Infosys" name="email" required>
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="password" name="password" required>
            <label for="floatingInput">Password</label>
        </div>
        <div class="row text-center">
            <p>
                New user? <a href="/campus/company/signup.php">Sign Up</a>
            </p>
        </div>
        <div class="row">
            <input class="btn btn-primary" type="submit" value="Login">
        </div>
    </div>
</form>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php'
?>