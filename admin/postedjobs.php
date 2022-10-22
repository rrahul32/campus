<?php
session_start();
if (isset($_SESSION['loggedin'])) {
  if ($_SESSION['type'] == "student")
    header("Location: /campus/student");
  else if ($_SESSION['type'] == "company")
    header("Location: /campus/company");
} else
  header("Location: /campus");
  $updated=false;
  include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/config.php';

//post request
if(isset($_POST['id']))
{
  $jid=$_POST['id'];
  $jname=$_POST['jname'];
  $jdesc=$_POST['desc'];
  $jdate=$_POST['jdate'];
  $vacancy_no=$_POST['vacancy_no'];
  $salary=$_POST['salary'];
  $sql="UPDATE `job` SET `jname`='$jname', `jdesc`='$jdesc', `vacancy_no`=$vacancy_no, `salary`=$salary WHERE `jid`='$jid';";
  $result=mysqli_query($conn, $sql);
  if($result)
  $updated=true;

}
//end post request

//get company details
$sql = "SELECT `jid`, `jname`, `cname` , `jdesc`, `jdate`, `vacancy_no`, `salary` FROM `job` JOIN `company` ON `job`.`jid`=`company`.`cid`;";
$result = mysqli_query($conn, $sql);
if ($result)
  $rows = mysqli_fetch_all($result);
else
  $rows = null;

//end get

//passing rows to javascript
$pageTitle = "Manage Jobs: Welcome to Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
echo "<script>const rows=".json_encode($rows)."</script>";
?>
<div class="container mt-5">
  <h2 class="text-center mb-3"><strong>Job Details</strong></h2>
  <?php if($updated):?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  Details updated succesfully!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <?php endif ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">S.No.</th>
        <th scope="col">Title</th>
        <th scope="col">Company Name</th>
        <th scope="col">Description</th>
        <th scope="col">Date Posted</th>
        <th scope="col">Vacancies</th>
        <th scope="col">Salary</th>
        <th scope="col">Edit Details</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows != null) : ?>
        <?php $sno = 1;
        foreach ($rows as $row) : ?>
          <tr>
            <td><?php echo $sno++ ?></td>
            <?php for ($i = 1; $i < 7; $i++) : ?>
              <?php if ($row[$i] == null || $row[$i] == "")
                $row[$i] = "-";
              ?>
              <td> <?php echo $row[$i] ?></td>
            <?php endfor ?>
            <td class="text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDetails" data-bs-sno="<?php echo $sno-2 ?>">
                Edit
              </button>
            </td>
          </tr>
        <?php endforeach ?>
      <?php else : ?>
        <th class="text-center" colspan="7">No Records</th>
      <?php endif ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="editDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label for="jname" class="form-label">Title</label>
            <input type="text" class="form-control" id="jname" name="jname" required>
          </div>
          <div class="mb-3">
            <label for="cname" class="form-label">Company Name</label>
            <input type="text" class="form-control" id="cname" name="cname" readonly required>
          </div>
          <div class="mb-3">
            <label for="desc" class="form-label">Description</label>
            <input type="text" class="form-control" id="desc" name="desc" required>
          </div>
          <div class="mb-3">
            <label for="jdate" class="form-label">Date Posted</label>
            <input type="text" class="form-control" id="jdate" name="jdate" readonly>
          </div>
          <div class="mb-3">
            <label for="vacancy_no" class="form-label">Vacancies</label>
            <input type="text" class="form-control" id="vacancy_no" name="vacancy_no" required>
          </div>
          <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="text" class="form-control" id="salary" name="salary" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  //altering modal content
  const modal = document.getElementById('editDetails')
  modal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const sno = button.getAttribute('data-bs-sno')
    // Update the modal's content.
    //console.log(rows[sno])
    const row=rows[sno];
    const input=modal.querySelectorAll('input')
    for(i=0;i<7;i++)
    {
      input[i].value=row[i];
    }
    const form=modal.querySelector('form');
    const submit=modal.querySelector('#submitForm');
    submit.addEventListener('click',()=>{
      if(confirm("Are you sure you want to submit the details?"))
      form.submit();
    })
  })

</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php'
?>