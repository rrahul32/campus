<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
$cid = $_SESSION['cid'];
$updated=false;
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
//POST REQUEST
if(isset($_POST['submit']))
{
    $jid=$_POST['jid'];
    $title=$_POST['title'];
    $vacancy=$_POST['vacancy'];
    $salary=$_POST['salary'];
    $desc=$_POST['desc'];
    $sql="UPDATE `job` SET `jname`='$title', `jdesc`='$desc', `vacancy_no`=$vacancy, `salary`=$salary";
    $result= mysqli_query($conn,$sql);
    if($result)
    $updated=true;
}

//POST END

//getting applied jobs
$sql = "SELECT `jname`,`jdesc`,`jdate`,`vacancy_no`,`salary`, COUNT(`appid`),`job`.`jid` FROM `job` JOIN `applied` ON `job`.`jid`=`applied`.`jid` WHERE `cid`=$cid ORDER BY `jdate` DESC;";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);

$pageTitle = "Jobs Applied: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
echo "<script>const rows=".json_encode($rows)."</script>";
?>
<div class="col-9 mx-auto mt-3 border p-4 text-center justify-content-center" style="background-color:#bfdee3;">

    <div class="row">
        <h1>Posted Jobs</h1>
    </div>
    <div class="row">
            <?php
            if ($updated)
                echo "<div class='alert alert-dismissible alert-success text-center col-10 mx-auto bg-light' role='alert'>Job details updated successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            ?>
        </div>
<div class="row m-3 p-3 overflow-auto">
    <?php
    if ($rows == null)
        echo "
    <div class='row p-3 m-3'>
    <h3>No jobs applied</h3>
    </div>
    ";
    else {
        $row_num=1;
        echo "<table class='table'>
        <thead>
        <tr>
        <th scope='col'>S.No.</th>
      <th scope='col'>Job Title</th>
      <th scope='col'>Job Description</th>
      <th scope='col'>Posted Date</th>
      <th scope='col'>Vacancies</th>
      <th scope='col'>Salary</th>
      <th scope='col'>No. of Applications</th>
      <th scope='col'>Edit Details</th>
        </tr>
        </thead>
        <tbody>
        ";
        foreach ($rows as $job) {
            echo "
            <tr>
            <th scope='row'>$row_num</th>
            <td>".ucwords($job[0])."</td>
            <td>".ucfirst($job[1])."</td>
            <td>$job[2]</td>
            <td>$job[3]</td>
            <td>$job[4]</td>
            <td>$job[5]</td>
            <td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editDetails' data-bs-id='$row_num'>Edit</button></td>
          </tr>
          ";
          $row_num++;
        }
        echo "
        </tbody>
        </table>
        ";
    }
    ?>
    <!-- Modal -->
<div class="modal fade" id="editDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-4"></div>
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Job Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post" name="postjob" onsubmit="return validate()">
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
        <input type="hidden" name="jid" id="jid">
        <div class="row mb-3 justify-content-center">
            <div class="col-3 text-center">
                <button type="submit" class="btn btn-primary" name="submit" id="submit">
                    Update
                </button>
            </div>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal end -->
</div>
</div>
</div>
<script>
    //validate form
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

//set modal
targetModal= document.getElementById("editDetails")
targetModal.addEventListener("show.bs.modal", event=>{
const button= event.relatedTarget
const id= button.getAttribute("data-bs-id")-1
const title = targetModal.querySelector("#title");
const desc = targetModal.querySelector("#desc");
const vacancy = targetModal.querySelector("#vacancy");
const salary = targetModal.querySelector("#salary");
const jid = targetModal.querySelector("#jid");
title.value=rows[id][0]
desc.value=rows[id][1]
vacancy.value=rows[id][3]
salary.value=rows[id][4]
jid.value=rows[id][6]

})
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>