<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$cid = $_SESSION['cid'];
$posted = false;
if (isset($_POST['submit'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
    $title = strtolower($_POST['title']);
    $desc = strtolower($_POST['desc']);
    $vacancy = $_POST['vacancy'];
    $salary = $_POST['salary'];
    $sql = "INSERT INTO `job` (`jname`,`cid`,`jdesc`,`vacancy_no`,`salary`) VALUES ('$title', $cid, '$desc', $vacancy, $salary);";
    $result = mysqli_query($conn, $sql);
    if ($result)
        $posted = true;
}

$pageTitle = "Post Job: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<!-- form design -->
<div class="col-6 mx-auto mt-3 border p-4 pb-1" style="background-color:#bfdee3;">
    <form action="" method="post" name="postjob" onsubmit="return validate()">
        <div class="mb-3 row justify-content-center text-center pt-3">
            <h3>Post Job</h3>
        </div>
        <div class="row">
            <?php
            if ($posted)
                echo "<div class='alert alert-success text-center col-10 mx-auto bg-light' role='alert'>Job posted successfully!</div>";
            ?>
        </div>
        <div class="row mb-3">
            <label for="title" class="col-sm-2 col-form-label">Job Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control border border-primary" name="title" id="title" placeholder="Title for the job" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="desc" class="col-sm-2 col-form-label">Job Description</label>
            <div class="col-sm-10">
                <!-- <input type="text" class="form-control border border-primary" name="desc" id="desc"  placeholder="Description for your job" style="min-height: 20vh;"> -->
                <textarea class="form-control border border-primary" name="desc" id="desc" placeholder="Description for the job" rows="4" required></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <label for="vacancy" class="col-sm-2 col-form-label">Vacancies</label>
            <div class="col-sm-4">
                <input type="text" class="form-control border border-primary" name="vacancy" id="vacancy" placeholder="Number of vacancies" required>
                <div class="invalid-feedback">
                    Please provide a valid number.
                </div>
            </div>
            <label for="salary" class="col-sm-2 col-form-label text-end">Salary</label>
            <div class="col-sm-4">
                <input type="text" class="form-control border border-primary" name="salary" id="salary" placeholder="Salary per annum" required>
                <div class="invalid-feedback">
                    Please provide a valid number.
                </div>
            </div>
        </div>
        <div class="row mb-3 justify-content-center">
            <div class="col-3 text-center">
                <button type="submit" class="btn btn-primary" name="submit" id="submit">
                    Post Job
                </button>
            </div>
        </div>
    </form>
</div>
<!-- form design end -->

<script>
    //prevent form resubmission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }


    //validate form on submit

    function validate() {
        const form = document.postjob;
        const vacancy = form.querySelector('#vacancy');
        const salary = form.querySelector('#salary');
        console.log(Number(vacancy.value));
        console.log(Number(salary.value));
        if (isNaN(vacancy.value)) {
            vcValid = false;
            vacancy.setAttribute("class", vacancy.getAttribute("class") + " is-invalid")

        } else
            vcValid = true;
        if (isNaN(salary.value)) {
            slValid = false;
            salary.setAttribute("class", salary.getAttribute("class") + " is-invalid")
        } else
            slValid = true;
        if (vcValid && slValid)
            return true;
        else
            return false;
    }
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>