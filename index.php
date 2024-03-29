<?php
//echo $_SERVER['DOCUMENT_ROOT'];
session_start();
if (isset($_SESSION['loggedin'])) {
    //  if ($_SESSION['type'] == "company")
    //     header("Location: /campus/company");
    // else 
    if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
        else if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';


//GET search
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $searchLower = strtolower($search);
    $sql = "SELECT `jid`,`jname`,`cname`,`loc`,`jdesc`,`jdate`,`vacancy_no`,`salary` FROM `job` JOIN `company` ON `job`.`cid`=`company`.`cid` WHERE `jname` LIKE '%$searchLower%' ORDER BY `jid` DESC;";
    
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
        $rows[$key][1]=ucwords($row[1]);
        $rows[$key][2]=ucwords($row[2]);
        $rows[$key][3]=ucwords($row[3]);
        $rows[$key][4]=ucfirst($row[4]);
    }
    //echo var_dump($rows);
    $first = json_encode($rows[0]);
} else {
    $match = false;
}
//GET search end

$pageTitle = "Welcome to Campus Recruitment Portal";
 include_once $_SERVER['DOCUMENT_ROOT']."/campus/partials/_template.php";
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

    function showMore(num) {
       // console.log(num);

        title = document.getElementById("jobTitle");
        cname = document.getElementById("companyName");
        loc = document.getElementById("location");
        desc = document.getElementById("jobDescription");
        salary=document.getElementById("salary");
        title.innerText = `${num[1]}`;
        cname.innerText = `${num[2]}`;
        loc.innerText = `${num[3]}`;
        desc.innerText = `Description:\n${num[4]}`;
        salary.innerText=`Salary: ${num[7]}`;

    }
</script>
<div class="container-flex border py-5">
    <form class="col-6 mx-auto" action="" method="GET">
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
        <?php
            if ($match)
            {
              echo "<div class='col-4 text-center'>";
                foreach ($rows as $value) {
                    echo "<div class='card mt-3'>
                    <div class='card-body' style='background-color:#fdeed2'>
                        <h5 class='card-title'><b>$value[1]</b></h5>
                        <h6 class='card-title'>$value[2]</h6>
                        <h6 class='card-subtitle mb-2 text-muted'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-geo-alt' viewBox='0 0 16 16'>
                        <path d='M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z'/>
                        <path d='M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                      </svg>$value[3]</h6>";
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
                        <a href='javascript: showMore(".json_encode($value).");'  class='stretched-link'></a>
                    </div>
                </div>";
                }
                echo "</div>
                <div class='col-6 sticky-top overflow-auto' id='jobDetail'>
                    <div class='card pt-3' style='min-height:100%;background-color:#fdeed2'>
                        <div class='card-body text-center'>
                            <h3 class='card-title'><b id='jobTitle'></b></h3>
                            <h5 class='card-title' id='companyName'></h5>
                            <h6 class='card-subtitle mb-2 text-muted'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-geo-alt' viewBox='0 0 16 16'>
                            <path d='M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z'/>
                            <path d='M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                          </svg><span id='location'></span></h6>
                            <h6 class='card-subtitle mb-2 text-muted' id='salary'></h6>
                            <p class='card-text' id='jobDescription'></p>";
                            if(!isset($_SESSION['type']))
                            echo"
                            <a href='/campus/student/login.php' class='btn btn-primary card-text' id='login'> Login to Apply</a>";
                            echo "
                        </div>
                    </div>
                </div>";
            }
            else
                echo "<h2 class='col text-center'>No jobs found</h2>";

            ?>
        <div class='col-1'> </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php' ?>