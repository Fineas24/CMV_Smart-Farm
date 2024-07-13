<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

//print '<link rel="stylesheet" type="text/css" href="style.css">';
require_once('config.php');
include("connect.php");
if(!isset($_GET['nume'])) $_GET['nume']='';
if(!isset($_GET['link'])) $_GET['link']='';

$link=$_GET['link'];
//print $link;
$cerere = "INSERT INTO `smartfarm`.`inreg_poze` (`nume`,`link`,`sters`,`obs`) VALUES ('','".$link."','NU','');";
//print $cerere;
mysqli_query($conn,$cerere);
print 'Poza trimisa';

?>