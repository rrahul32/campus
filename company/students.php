<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
$cid = $_SESSION['cid'];
$offered = false;

//POST job offer
if (isset($_POST['submit'])) {
    $msg = $_POST['message'];
    $jid = $_POST['jid'];
    $sid = $_POST['sid'];
    $sql = "INSERT INTO `offeredjobs`(`jid`,`sid`,`message`,`status`)VALUES($jid,$sid,'$msg','pending')";
    $result = mysqli_query($conn, $sql);
    if ($result)
        $offered = true;
}
//end POST 

//getting students
$sql = "SELECT `email`, `fname`, `lname`, `coursename`, `percentage`, `student`.`sid` FROM `student` JOIN `student_academic` WHERE `student`.`email`=`student_academic`.`semail`;";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
//echo var_dump($rows);
//end getting students

//getting posted jobs
$sql = "SELECT `jid`, `jname`, `salary` FROM `job` WHERE `cid`=$cid ORDER BY `jdate` DESC";
$result = mysqli_query($conn, $sql);
if ($result)
    $jobs = mysqli_fetch_all($result);
else
    $jobs = null;
//end getting posted jobs
$pageTitle = "Students: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<style>
    thead>tr>th {
        cursor: pointer;
    }

    .arrow {
        display: block;
        height: 24px;
        width: 24px;
        margin-right: auto !important;
        margin-left: auto !important;
        background-image: url(/campus/images/arrow.svg);
        background-position: center;
        background-repeat: no-repeat;
        transition: transform 0.3s ease-in-out;
    }

    .up {
        transform: rotateZ(180deg);
    }
</style>
<div class="container mx-auto mt-3 border p-4 text-center justify-content-center">
    <div class="row">
        <h1><mark style='background-color:#d08181'>Students</mark></h1>
    </div>
    <div class="row">
        <?php
        if ($offered)
            echo "<div class='alert alert-dismissible alert-success text-center col-10 mx-auto bg-light' role='alert'>Job offer sent successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        ?>
    </div>
    <div class="row m-3 p-3 overflow-auto justify-content-center">
        <?php
        if ($rows == null)
            echo "
    <div class='row p-3 m-3'>
    <h3>No students registered</h3>
    </div>
    ";
        else {
            echo "<table class='table' style='background-color:#d08181'>
        <thead>
        <tr>
        <th scope='col' data-desc=true id='idColumn'>S.No. <span class='sort arrow'></span></th>
      <th scope='col' data-desc=false id='nameColumn'>Name<span class='sort'></span></th>
      <th scope='col' >Email</th>
      <th scope='col' data-desc=false id='courseColumn'>Course<span class='sort'></span></th>
      <th scope='col' data-desc=false id='percentageColumn'>Percentage<span class='sort'></span></th>";
            if ($jobs != null)
                echo " <th scope='col'>Send an Offer</th>";
            echo "</tr>
        </thead>
        <tbody>
        ";
            $row_num = 1;
            foreach ($rows as $row) {
                echo "
            <tr>
            <td scope='row'>$row_num</td>
            <td>" . ucfirst($row[1]) . " " . ucfirst($row[2]) . "</td>
            <td>" . $row[0] . "</td>
            <td>" . ucwords($row[3]) . "</td>
            <td>$row[4]</td>";
                $sqljob = "SELECT * FROM `offeredjobs` WHERE `sid`=$row[5] AND `jid` IN (SELECT `jid` FROM `job` WHERE `cid`=$cid)";
                $resultjob = mysqli_query($conn, $sqljob);
                if ($jobs != null && mysqli_num_rows($resultjob) == 0)
                    echo "<td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#sendOffer' data-bs-id='$row[5]'>Offer Job</button></td>";
                else if (mysqli_num_rows($resultjob) > 0) {
                    echo "<td>Job offer sent!</td>";
                }
                echo "</tr>";
                $row_num++;
            }
        }

        ?>
        <!-- Modal -->
        <div class="modal fade" id="sendOffer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-4"></div>
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Job Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" name="postjob" onsubmit="return confirm('Are you sure you want to send?')">
                            <div class="row mb-3">
                                <label for="jid" class="col-sm-3 col-form-label">Offered Job</label>
                                <div class="col-sm-9">
                                    <select name="jid" id="jid">
                                        <?php
                                        if ($jobs != null)
                                            foreach ($jobs as $job)
                                                echo "<option value='$job[0]'>Title:" . ucwords($job[1]) . " <br>Salary:$job[2]</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="message" class="col-sm-2 col-form-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea name="message" id="message" cols="30" rows="10" placeholder="Enter the message here..."></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="sid" id="sid">
                            <div class="row mb-3 justify-content-center">
                                <div class="col-3 text-center">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit">
                                        Send Offer
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
    //modal 
    const modal = document.getElementById("sendOffer")
    modal.addEventListener("show.bs.modal", (event) => {
        const button = event.relatedTarget
        const sid = button.getAttribute('data-bs-id')
        const target = document.getElementById('sid')
        target.value = sid
    })
    //modal
    function tableSort(id = 0, desc = false) {
        var table = document.querySelector('.table')
        var rows = table.rows;
        for (i = 1; i < rows.length - 1; i++) {
            min = rows[i].getElementsByTagName('td')[id].innerHTML.toLowerCase();
            minRow = i;
            for (j = i + 1; j < rows.length; j++) {
                if (!desc) {
                    if (min > rows[j].getElementsByTagName('td')[id].innerHTML.toLowerCase()) {
                        min = rows[j].getElementsByTagName('td')[id].innerHTML.toLowerCase()
                        minRow = j;
                    }
                } else {
                    if (min < rows[j].getElementsByTagName('td')[id].innerHTML.toLowerCase()) {
                        min = rows[j].getElementsByTagName('td')[id].innerHTML.toLowerCase()
                        minRow = j;
                    }
                }

            }
            if (minRow != i) {
                rows[i].parentNode.insertBefore(rows[minRow], rows[i])
            }
        }

    }

    function toggleClick(e, id) {
        target = e;
        //console.log(target)
        document.querySelectorAll('.sort').forEach((ele) => {
            if (ele.parentElement != target)
                ele.className = 'sort';
        })

        if (target.dataset.desc == 'false') {
            target.querySelector('span').classList.add('arrow')
            target.querySelector('span').classList.remove('up')
            tableSort(id, false);
            target.dataset.desc = 'true';
        } else {
            target.querySelector('span').classList.add('up')
            tableSort(id, true);
            target.dataset.desc = 'false';
        }
    }
    document.getElementById('idColumn').addEventListener('click', () => {
        // console.log(e.originalTarget)
        toggleClick(document.getElementById('idColumn'), 0)
    })
    document.getElementById('nameColumn').addEventListener('click', () => {
         //console.log(e)
        toggleClick(document.getElementById('nameColumn'), 1)

    })
    document.getElementById('courseColumn').addEventListener('click', () => {
        // console.log(e.originalTarget)
        toggleClick(document.getElementById('courseColumn'), 3)
    })
    document.getElementById('percentageColumn').addEventListener('click', () => {
        // console.log(e.originalTarget)
        toggleClick(document.getElementById('percentageColumn'), 4)
    })
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>