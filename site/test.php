<?php
require_once('config.php');
include("connect.php");
//print $_SESSION['user'];
//print $_GET['mod'];
$cerere2="select * from random where 1";
$resursa2=mysqli_query($conn,$cerere2);
$row=mysqli_fetch_array($resursa2);
print $row['rand']; 
?>