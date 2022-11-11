<?php
session_start();
$pageTitle="About Us";
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_template.php';
?>
<div class="row justify-content-center align-items-center text-center bg-info" style="height: 200px;">
<h1>About Us</h1>
</div>
<div class="row" style="height: 200px; background-color:#6fcca9">
    <div class="col-2"></div>
<div class="col m-3 justify-content-center text-center">
We are a group of highly efficient developers.
</div>
<div class="col-2"></div>
</div>

<script>
    document.body.background="";
    document.body.bgcolor="#d63384"
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_footer.php'
?>