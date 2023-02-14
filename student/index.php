<?php
session_start();
// redirect to other pages
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "company")
        header("Location: /campus/company");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
} else {
    header("Location: /campus/student/login.php");
}
//redirect end


include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
//GET search
$sid=$_SESSION['sid'];
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $searchLower = strtolower($search);
    $sql = "SELECT `jid`,`jname`,`cname`,`loc`,`jdesc`,`jdate`,`vacancy_no`,`salary` FROM `job` JOIN `company` ON `job`.`cid`=`company`.`cid` WHERE `jname` like '%$searchLower%' ORDER BY `jid` DESC;";
    
} else {
    $sql = "SELECT `jid`,`jname`,`cname`,`loc`,`jdesc`,`jdate`,`vacancy_no`,`salary` FROM `job` JOIN `company`ON `job`.`cid`=`company`.`cid` ORDER BY `jid` DESC;";
}
$result = mysqli_query($conn, $sql);
$row_length = mysqli_num_rows($result);
if ($row_length > 0) {
    $match = true;
    $rows = mysqli_fetch_all($result);
    foreach($rows as $key=>$row)
    {
        $rows[$key][1]=ucfirst($row[1]);
        $rows[$key][2]=ucfirst($row[2]);
        $rows[$key][3]=ucfirst($row[3]);
        $rows[$key][4]=ucfirst($row[4]);
    }
    //echo var_dump($rows);
    $first = json_encode($rows[0]);
} else {
    $match = false;
}
//GET search end

//POST-APPLY NOW
if(isset($_POST['applyNow'])){
    $jid=$_POST['jid'];
    $sql_applied="INSERT INTO `applied`(`jid`,`sid`) VALUES($jid,$sid)";
    $result_applied=mysqli_query($conn,$sql_applied);
    $sql_appstatus="INSERT INTO `appstatus`(`appid`) VALUES((SELECT `appid` FROM `applied` WHERE `jid`=$jid AND `sid`=$sid));";
    $result=mysqli_query($conn,$sql_appstatus);

}
$pageTitle = "View Jobs: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
if ($match)
    echo "<script>
        var match=true;
        var first_result=$first;
        </script>";
else
    echo "<script>match=false;</script>";
?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        target = document.getElementById('jobDetail');
        footer = document.getElementsByTagName('footer')[0];
        target.style.height = `${visualViewport.height - footer.clientHeight}px`;
        if (match) {
            document.getElementsByClassName('stretched-link')[0].click();

        } else {
            target.style.display = "none";
        }
    });

    function showMore(num,applied) {
       // console.log(num);

        title = document.getElementById("jobTitle");
        cname = document.getElementById("companyName");
        loc = document.getElementById("location");
        desc = document.getElementById("jobDescription");
        jid = document.getElementById("jid");
        salary=document.getElementById("salary");
        apply=document.getElementById("applyNow");
        if(applied)
        {
            apply.value="Applied"
            apply.disabled=true;
        }
        else{
        apply.value="Apply Now";
        apply.disabled=false;
        }
        jid.value=num[0];
        title.innerText = `${num[1]}`;
        cname.innerText = `${num[2]}`;
        loc.innerText = `${num[3]}`;
        desc.innerText = `Description:\n${num[4]}`;
        salary.innerText=`Salary: ${num[7]}`;

    }
</script>
<div class="container-flex border py-5">
    <form class=" col-6 mx-auto" action="" method="GET">
        <div class="row">
            <div class="form-floating form-control-sm col-9 mx-auto">
                <input type="text" class="form-control border-primary" id="search" placeholder="Company" name="search" required>
                <label for="search" style="left:auto;">Enter job title</label>
            </div>
            <div class="d-grid col-3 py-1">
                <input class="btn btn-primary" type="submit" name="submit" value="Find Jobs">
            </div>
        </div>
    </form>
</div>

<div class='container'>
    <div class='row'>
        <div class='col-1'></div>
        <div class='col-4 text-center'>
            <?php
            if ($match)
            {
            $sid=$_SESSION['sid'];
                foreach ($rows as $value) {
                    $sql="SELECT * FROM `applied` WHERE `jid`=$value[0] && `sid`=$sid;";
                    $result=mysqli_query($conn,$sql);
                    $applied=mysqli_num_rows($result)>0;
                    //echo var_dump($value);
                    echo "<div class='card mt-3'>
                    <div class='card-body' style='background-color:#fdeed2'>
                        <h5 class='card-title'><b>$value[1]</b></h5>
                        <h6 class='card-title'>$value[2]</h6>
                        <h6 class='card-subtitle mb-2 text-muted'>$value[3]</h6>";
                    $date = date_diff(date_create("now"), date_create($value[5]));
                    if ($date->format('%m') > 0) {
                        if ($date->format('%m') > 1)
                            $date_elapsed = $date->format('%m months ago');
                        else
                            $date_elapsed = $date->format('%m month ago');
                    } else if ($date->format('%d') > 0) {
                        if ($date->format('%m') > 1)
                            $date_elapsed = $date->format('%d days ago');
                        else
                            $date_elapsed = $date->format('%d day ago');
                    } else
                        $date_elapsed = "posted recently";
                    echo "<p class='card-subtitle mb-2 text-muted'>$date_elapsed</p>
                        <a href='javascript: showMore(" . json_encode($value) . ",$applied);'  class='stretched-link'></a>
                    </div>
                </div>";
                }
            }
            else
                echo "No jobs found";

            ?>
        </div>
        <div class='col-6 sticky-top overflow-auto' id='jobDetail'>
            <div class='card mt-3'>
                <div class='card-body text-center' style='background-color:#fdeed2'>
                    <h3 class='card-title'><b id="jobTitle"></b></h3>
                    <h5 class='card-title' id="companyName"></h5>
                    <h6 class='card-subtitle mb-2 text-muted' id="location"></h6>
                    <h6 class='card-subtitle mb-2 text-muted' id="salary"></h6>
                    <p class='card-text' id="jobDescription"></p>
                    <form action="" method="post" onsubmit="return confirm('Are you sure you want to apply?')">
                        <input type="hidden" name="jid" id="jid" value="">
                    <input type="submit" class='btn btn-primary' name='applyNow' id='applyNow' value=''>
                    </form>
                    

                </div>
            </div>
        </div>
        <div class='1'> </div>
    </div>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>