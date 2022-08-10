<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['type'] == "student")
        header("Location: /campus/student");
    else if ($_SESSION['type'] == "admin")
        header("Location: /campus/admin");
} else
    header("location: /campus");
$cid = $_SESSION['cid'];
$appstatusUpdated=false;
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';

//post request

if(isset($_POST['status']))
{
    $status=$_POST['status'];
    if($status=="Accept")
        $status="accepted";
    else if($status=="Reject")
        $status="rejected";
    else
    $status=null;
    if($status!=null)
    {
        $appid=$_POST['appid'];
        $message=$_POST['message'];
        $sql="UPDATE `appstatus` SET `appstatus`='$status', `message`='$message' WHERE `appid`=$appid";
        $result=mysqli_query($conn,$sql);
        if($result)
        $appstatusUpdated=true;
    }
    
}

//post request completed

//getting all applications
$sql = "SELECT `applied`.`appid`, `appdate`, `jname`, `jdate`, `applied`.`sid`, `fname`, `lname`,`coursename`, `percentage`, `appstatus` FROM `applied` JOIN `job` ON `applied`.`jid`=`job`.jid JOIN `student` ON `applied`.`sid`=`student`.`sid` JOIN `student_academic` ON `student`.`email`=`student_academic`.`semail` JOIN `appstatus` ON `applied`.`appid`=`appstatus`.`appid` WHERE `applied`.`jid` IN (SELECT `jid` FROM `job` WHERE `cid`=$cid) ORDER BY `appdate` DESC ";
$result = mysqli_query($conn, $sql);
if ($result) {
    $rows = mysqli_fetch_all($result);
   // print_r($rows);
} else
    $rows = null;
//get request completed

$pageTitle = "Applications: Campus Recruitment Management System";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
?>
<!-- student applications -->
<div id="alert"></div>
<div class="container text-center mt-3 p-2 justify-content-center">
    <h2>
        Applications
    </h2>
            <div class="row g-3" id="card" >
            </div>
    <div id="detailCard"></div>
    <div id="modal"></div>
</div>
<script>

    //convert first letter of each word to string
    function firstLetterUpper(string) {
        const words = string.split(" ");

        for (let i = 0; i < words.length; i++) {
            words[i] = words[i][0].toUpperCase() + words[i].substr(1);
        }

        return words.join(" ");
    }

    //submitting form
    function submitForm(){
        if(confirm("Are you sure you want to submit?"))
            document.postForm.submit();
    }

//Create Modal for typing message
function createModal(status,appid){
    const target=document.getElementById('modal');
    target.innerHTML=`
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Optional Message</h5>
        <button type="button" class="btn-close" data-bs-target="#detailsModal" data-bs-toggle="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form name="postForm" method="post" action="" class="text-center">
        <input type="hidden" name="status" value=${status}>
        <input type="hidden" name="appid" value=${appid}>
        <textarea name="message" rows="10" cols="30" placeholder="Type your message here..."></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="submitForm()">${status}</button>
      </div>
    </div>
  </div>
</div>
    `;
    const modal= new bootstrap.Modal(document.getElementById("myModal"));
    modal.show();
}

    //view Detail Card
    function viewDetails(row) {
        //console.log(row);
        const target = document.getElementById('detailCard');
        /*target.innerHTML = `
        <div class="card">
  <div class="card-body">
    <h5 class="card-title">Job: ${firstLetterUpper(row[2])}</h5>
    <h6 class="card-subtitle mb-2 text-muted">Date Posted: ${row[3]}</h6>
    <h6 class="card-subtitle mb-2 text-muted">Applicant: ${firstLetterUpper(row[5])} ${firstLetterUpper(row[6])}</h6>
    <h6 class="card-title mb-2"><strong><u>Applicant Details</u></strong></h6>
    <p class="card-text mb-0">Course: ${firstLetterUpper(row[7])} </p>
    <p class="card-text mt-0">Percentage: ${row[8]} </p>
    <div id="modal"></div>
    <button class="btn btn-primary" onclick="createModal('Accept',${row[0]})">Accept</button>
    <button class="btn btn-primary" onclick="createModal('Reject',${row[0]})">Reject</button>

  </div>
</div>
        `;*/

    target.innerHTML =`
    <div class="modal fade" id="detailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <h5 class="card-title">Job: ${firstLetterUpper(row[2])}</h5>
    <h6 class="card-subtitle mb-2 text-muted">Date Posted: ${row[3]}</h6>
    <h6 class="card-subtitle mb-2 text-muted">Applicant: ${firstLetterUpper(row[5])} ${firstLetterUpper(row[6])}</h6>
    <h6 class="card-title mb-2"><strong><u>Applicant Details</u></strong></h6>
    <p class="card-text mb-0">Course: ${firstLetterUpper(row[7])} </p>
    <p class="card-text mt-0">Percentage: ${row[8]} </p>
      </div>
      <div class="modal-footer justify-content-center">
      <button class="btn btn-primary" data-bs-dismiss="modal" id="accept" onclick="createModal('Accept',${row[0]})">Accept</button>
    <button class="btn btn-primary" data-bs-dismiss="modal" id="reject" onclick="createModal('Reject',${row[0]})">Reject</button>
      </div>
    </div>
  </div>
</div>
    `;   
    const modal= new bootstrap.Modal(document.getElementById("detailsModal"));
    modal.show();
    }

    function showCards(rows) {
        const target = document.getElementById('card');
        for(i=0;i<5;i++)
        rows.forEach((row) => {
            //console.log(row);
            const col = document.createElement('div');
            col.setAttribute("class","col");
            col.innerHTML = `
            <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Job: ${firstLetterUpper(row[2])}</h5>
    <h6 class="card-subtitle mb-2 text-muted">Date Posted: ${row[3]}</h6>
    <h6 class="card-subtitle mb-2 text-muted">Applicant: ${firstLetterUpper(row[5])} ${firstLetterUpper(row[6])}</h6>
  </div>
</div>
            `;
            const card=col.querySelector('.card');
            if(row[9]=="accepted" || row[9]=="rejected")
            {
                card.setAttribute('class',card.getAttribute('class')+' text-bg-light')
                const color=row[9]=="accepted"?"text-success":"text-danger";
                col.querySelector(".card-body").innerHTML+=`<h5 class="card-subtitle ${color}"> ${firstLetterUpper(row[9])}</h6>`
            }
            else
            {
                const link= document.createElement('a');
                link.setAttribute('class','stretched-link')
                link.href=`javascript:void(0)`;
                link.addEventListener('click', () => {
                viewDetails(row);
            });
            card.appendChild(link);
            }
            target.appendChild(col);
        })
    }
</script>
<?php
if($appstatusUpdated)
echo `
<script>
document.getElementById('alert').innerHtml="
<div class='alert alert-success alert-dismissible' role='alert'>
  Application status updated succesfully!
</div>
";
</script>
`;
echo "<script>showCards(" . json_encode($rows) . ")</script>";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php';
?>