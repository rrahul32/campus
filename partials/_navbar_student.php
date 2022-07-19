<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand p-0" href="/campus/student">
            <div class="row">
                <img class="col" src="/campus/images/index.png" alt="CRP" width="50" height="50" class="d-inline-block align-text-top">
                <div class="col">Campus Recruitment Portal<br>
                    <center><em><small>Student</small></em></center>
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
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="notifications" style="min-width:350px">
        
                        <?php
                        //Checking for notifications
                        $noNotifications = true;
                        $sql_noti = "SELECT `appstatus`,`jname`,`cname` FROM `appstatus` JOIN `applied` ON `appstatus`.`appid`=`applied`.`appid` JOIN `job` ON `applied`.`jid`=`job`.`jid` JOIN `company` ON `company`.`cid`=`job`.`cid` WHERE `appstatus`.`appid`IN (SELECT `appid` FROM `applied` WHERE `sid`=$sid) ORDER BY `up_date`;";
                        $result_noti = mysqli_query($conn, $sql_noti);
                        $rows_noti = mysqli_fetch_all($result_noti);
                        if ($rows_noti != null) {
                            foreach ($rows_noti as $noti) {
                                if ($noti[0] != "under review") {
                                    $noNotifications=false;
                                    if($noti[0]=="accepted")
                                    {
                                       echo" <li class='border border-dark m-2'><small class='text-center dropdown-item'>$noti[2] has accepted your application for $noti[1] job.</small></li> ";
                                    }
                                    else if($noti[0]=="rejected")
                                    {
                                       echo" <li class='border border-dark m-2'><small class='text-center dropdown-item'>$noti[2] has rejected your application for $noti[1] job.</small></li> ";
                                    }

                                }
                            }
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
                    <li><a class="dropdown-item " href="/campus/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>