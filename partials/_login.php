<?php
// echo var_dump($_SESSION);
session_start();
if (isset($_SESSION['type']) && ($_SESSION['type'] == 'student')) //check if student
{
  $student = true;
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
}
?> 