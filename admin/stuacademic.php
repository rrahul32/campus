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
if(isset($_POST['email']))
{
  //echo var_dump($_POST);
  $sname=$_POST['name'];
  $semail=$_POST['email'];
  $coursename=$_POST['coursename'];
  $percentage=$_POST['percentage'];
  $sql="UPDATE `student_academic` SET `sname`='$sname', `coursename`='$coursename', `percentage`=$percentage WHERE `semail`='$semail';";
  $result=mysqli_query($conn, $sql);
  if($result)
  $updated=true;

}
//end post request

//get student details
$sql = "SELECT `sname`, `semail`, `coursename` , `percentage` FROM `student_academic`;";
$result = mysqli_query($conn, $sql);
if ($result)
  $rows = mysqli_fetch_all($result);
else
  $rows = null;

//end get

//passing rows to javascript
$pageTitle = "Manage Student Academics: Welcome to Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
echo "<script>const rows=".json_encode($rows)."</script>";
?>
<div class="container mt-5">
  <h2 class="text-center mb-3"><strong>Student Academic Details</strong></h2>
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
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Course Name</th>
        <th scope="col">Percentage</th>
        <th scope="col">Edit Details</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows != null) : ?>
        <?php $sno = 1;
        foreach ($rows as $row) : ?>
          <tr>
            <td><?php echo $sno++ ?></td>
            <?php for ($i = 0; $i < 4; $i++) : ?>
              <?php if ($row[$i] == null || $row[$i] == "")
                $row[$i] = "-";
              ?>
              <td> <?php echo $i==0?ucwords($row[$i]):$row[$i] ?></td>
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
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" readonly required>
          </div>
          <div class="mb-3">
            <label for="coursename" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="coursename" name="coursename" required>
          </div>
          <div class="mb-3">
            <label for="percentage" class="form-label">Percentage</label>
            <input type="text" class="form-control" id="percentage" name="percentage" required>
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
  //setForm
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
    for(i=0;i<4;i++)
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