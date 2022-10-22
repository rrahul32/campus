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
  $email=$_POST['email'];
  $cname=$_POST['cname'];
  $loc=$_POST['loc'];
  $website=$_POST['website'];
  $ceo=$_POST['ceo'];
  $sql="UPDATE `company` SET `cname`='$cname', `loc`='$loc', `ceo`='$ceo', `website`='$website' WHERE `email`='$email';";
  $result=mysqli_query($conn, $sql);
  if($result)
  $updated=true;

}
//end post request

//get company details
$sql = "SELECT `email`, `cname`, `loc` , `ceo`, `website`, `pwd` FROM `company`;";
$result = mysqli_query($conn, $sql);
if ($result)
  $rows = mysqli_fetch_all($result);
else
  $rows = null;

//end get

//passing rows to javascript
$pageTitle = "Manage Registered Companies: Welcome to Campus Recruitment Portal";
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_template.php';
echo "<script>const rows=".json_encode($rows)."</script>";
?>
<div class="container mt-5">
  <h2 class="text-center mb-3"><strong>Company Details</strong></h2>
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
        <th scope="col">Email</th>
        <th scope="col">Company Name</th>
        <th scope="col">Location</th>
        <th scope="col">CEO</th>
        <th scope="col">Website</th>
        <th scope="col">Password</th>
        <th scope="col">Edit Details</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows != null) : ?>
        <?php $sno = 1;
        foreach ($rows as $row) : ?>
          <tr>
            <td><?php echo $sno++ ?></td>
            <?php for ($i = 0; $i < 5; $i++) : ?>
              <?php if ($row[$i] == null || $row[$i] == "")
                $row[$i] = "-";
              ?>
              <td> <?php echo $row[$i] ?></td>
            <?php endfor ?>
            <td><input class="form-control" type="password" value="<?php echo $row[5] ?>" aria-label="readonly input example" readonly style="width:auto;;display:inline">
              <a href="javascript:void(0);" onclick="toggleEye(this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye ms-2" viewBox="0 0 16 16">
                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                </svg></a>
            </td>
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
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" readonly required>
          </div>
          <div class="mb-3">
            <label for="cname" class="form-label">Company Name</label>
            <input type="text" class="form-control" id="cname" name="cname" required>
          </div>
          <div class="mb-3">
            <label for="loc" class="form-label">Location</label>
            <input type="text" class="form-control" id="loc" name="loc" required>
          </div>
          <div class="mb-3">
            <label for="ceo" class="form-label">CEO</label>
            <input type="text" class="form-control" id="ceo" name="ceo">
          </div>
          <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="text" class="form-control" id="website" name="website">
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
    for(i=0;i<5;i++)
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

  
  //toggleEye
  function toggleEye(target) {
    const input = target.parentNode.querySelector('input');
    if (input.type == "password") {
      input.type = "text";
      target.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash ms-2" viewBox="0 0 16 16">
  <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
  <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
  <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
</svg>`;
    } else {
      input.type = "password";
      target.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye ms-2" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg>`;

    }
  }
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/campus/partials/_footer.php'
?>