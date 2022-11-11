<?php

?>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand p-0" href="/campus/student">
            <div class="row">
                <img class="col" src="/campus/images/index.png" alt="CRP" width="50" height="50" class="d-inline-block align-text-top">
                <div class="col text-center">Campus Recruitment Portal<br>
                    <em><small>Student</small></em>
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/campus/student">Search Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/campus/student/companies.php">Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/campus/aboutus.php">About Us</a>
                </li>

            </ul>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link pe-5" href="#" id="notifications" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/campus/images/notifications.svg" alt="Account" height="25" width="25">
                </a>
                <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end" aria-labelledby="notifications" style="min-width:350px">
        
                        <?php
                        //Checking for notifications
                        $sid=$_SESSION['sid'];
                        include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
                        $noNotifications = true;
                        //CHECKING FOR APPLIED JOB Status
                        // $sql_noti = "SELECT `appstatus`,`jname`,`cname` FROM `appstatus` JOIN `applied` ON `appstatus`.`appid`=`applied`.`appid` JOIN `job` ON `applied`.`jid`=`job`.`jid` JOIN `company` ON `company`.`cid`=`job`.`cid` WHERE `appstatus`.`appid`IN (SELECT `appid` FROM `applied` WHERE `sid`=$sid) ORDER BY `up_date`;";
                        // $result_noti = mysqli_query($conn, $sql_noti);
                        // $rows_noti = mysqli_fetch_all($result_noti);
                        // if ($rows_noti != null) {
                        //     foreach ($rows_noti as $noti) {
                        //         if ($noti[0] != "under review") {
                        //             $noNotifications=false;
                        //             if($noti[0]=="accepted")
                        //             {
                        //                echo" <li class='m-2'><small class='text-center dropdown-item dropdown-item'>$noti[2] has accepted your application for $noti[1] job.</small></li> ";
                        //             }
                        //             else if($noti[0]=="rejected")
                        //             {
                        //                echo" <li class='m-2'><small class='text-center dropdown-item'>$noti[2] has rejected your application for $noti[1] job.</small></li> ";
                        //             }

                        //         }
                        //     }
                        // }
                        // //checking for job offers
                        // $sql_offer="SELECT `cname` FROM company WHERE `cid` IN (SELECT `cid` FROM `job` WHERE `jid` IN (SELECT `jid` FROM `offeredjobs` WHERE `sid`=$sid)) ORDER BY `odate`";
                        // $res_offer= mysqli_query($conn,$sql_offer);
                        // while($row=mysqli_fetch_row($res_offer))
                        // {
                        //     $noNotifications=false;
                        //     echo "<li class='m-2'><small class='text-center dropdown-item dropdown-item'>You have a new job offer from $row[0]</small></li>";
                        // }

                        //checking for notifications
                        $sql_noti= "SELECT `appstatus` AS `status`,`jname`,`cname`, `appdate` AS `date` FROM `appstatus` JOIN `applied` ON `appstatus`.`appid`=`applied`.`appid` JOIN `job` ON `applied`.`jid`=`job`.`jid` JOIN `company` ON `company`.`cid`=`job`.`cid` WHERE `appstatus`.`appid`IN (SELECT `appid` FROM `applied` WHERE `sid`=$sid) AND `appstatus` != 'under review'
                        UNION ALL 
                        SELECT `offeredjobs`.`status`, `jname`, `cname`, `odate` AS `date` FROM `offeredjobs` JOIN `job` ON `offeredjobs`.`jid`=`job`.`jid` JOIN `company` ON `job`.`cid`=`company`.`cid` WHERE `offeredjobs`.`sid`=$sid AND `offeredjobs`.`status`='pending'
                        ORDER BY `date` DESC
                        ";
                        $res_noti= mysqli_query($conn,$sql_noti);
                        while($row_noti= mysqli_fetch_row($res_noti))
                        {
                            if($row_noti[0]=='pending')
                            echo "<li class='m-2'><small class='text-center dropdown-item dropdown-item'>You have a new job offer from ".ucwords($row_noti[2])."</small></li>";
                            else
                            echo "<li class='m-2'><small class='text-center dropdown-item dropdown-item'>".ucwords($row_noti[2])." has $row_noti[0] your job application for ".ucwords($row_noti[1])."</small></li>";
                            $noNotifications=false;
                        }
                        if ($noNotifications)
                            echo "
                            <li>
                        <p class='text-center'>No Notifications</p>
                        </li>
                        ";
                        ?>
    
                    </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link pe-5" href="#" id="account" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/campus/images/account.svg" alt="Account" height="25" width="25">
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="account">
                    <li><a class="dropdown-item " href="/campus/student/profile.php">Profile</a></li>
                    <li><a class="dropdown-item " href="/campus/student/changepass.php">Change Password</a></li>
                    <li><a class="dropdown-item " href="/campus/student/appliedjobs.php">Jobs Applied</a></li>
                    <li><a class="dropdown-item " href="/campus/student/jobsoffered.php">Job Offers</a></li>
                    <li><a class="dropdown-item " href="/campus/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>