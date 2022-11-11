<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title id='title'><?php echo $pageTitle; ?></title>
  <link href="/campus/css/bootstrap.min.css" rel="stylesheet">
  <script src="/campus/js/popper.js"></script>
  <script src="/campus/js/bootstrap.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", ()=>
    {
      padding=document.getElementsByTagName('footer')[0].clientHeight;
      //console.log(padding);
      padding+=10;
      document.getElementsByTagName('body')[0].style.paddingBottom=`${padding}px`;
    }
    );
</script>
</head>

<body class="bg-light" background="/campus/images/bg.png">
  <header>
    <?php 
   if(!isset($_SESSION['loggedin']))
   include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_navbar_nologin.php';
   else
   {
     if($_SESSION['type']=='student')
     include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_navbar_student.php';
     else if($_SESSION['type']=='admin')
     include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_navbar_admin.php';
     else if($_SESSION['type']=='company')
     include_once $_SERVER['DOCUMENT_ROOT'].'/campus/partials/_navbar_company.php';
     
   }
    ?>
  </header>
  