<nav class="navbar navbar-expand-md bg-dark navbar-dark pt-1 pb-0">
  <div class="container-fluid">
    <a class="navbar-brand" href="/campus">
        <div class="row">
    <img class="col m-0" src="/campus/images/index.png" alt="CRP" width="50" height="50" class="d-inline-block align-text-top">
      <div class="col">Campus Recruitment Portal<br><center><em><small>Company</small></em></center></div>
    
    </div></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/campus/company/post.php">Post Jobs</a>
        </li>
        <li class="nav-item">
                    <a class="nav-link" href="/campus/company/students.php">Students</a>
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
                        $cid=$_SESSION['cid'];
                        include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';
                        $noNotifications = true;
                        $sql_noti = "SELECT `fname`,`lname`,`jname` FROM `applied` JOIN `student` ON `applied`.`sid`=`student`.`sid` JOIN `job` ON `applied`.`jid`=`job`.`jid`  WHERE `applied`.`jid` IN (SELECT `jid` FROM `job` WHERE `cid`=$cid) ORDER BY `appdate`;";
                        $result_noti = mysqli_query($conn, $sql_noti);
                        $rows_noti = mysqli_fetch_all($result_noti);
                        if ($rows_noti != null) {
                            $noNotifications=false;
                            foreach ($rows_noti as $noti) {
                                echo" <li class='border border-dark m-2'><small class='text-center dropdown-item'>$noti[0] $noti[1] has applied for $noti[2] job.</small></li> ";
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
                    <li><a class="dropdown-item " href="/campus/company/profile.php">Profile</a></li>
                    <li><a class="dropdown-item " href="/campus/company/changepass.php">Change Password</a></li>
                    <li><a class="dropdown-item " href="/campus/company/postedjobs.php">Jobs Posted</a></li>
                    <li><a class="dropdown-item " href="/campus/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>