<?php
$AdresaBazaDate = "localhost";
 $UtilizatorBazaDate = "";
 $ParolaBazaDate = "";
 $NumeBazaDate = "12a_apetri";

 $conn = mysqli_connect($AdresaBazaDate,$UtilizatorBazaDate,$ParolaBazaDate,$NumeBazaDate) or die("Nu ma pot conecta la MySQL!");
 //mysqli_select_db($NumeBazaDate, $conn) or die("Nu gasesc baza de date");
 if (!$conn) {
  die("Nu gasesc baza de date" . mysqli_connect_error());
}


if (!function_exists('mysqli_result')) {
  function mysqli_result($res, $field=0) {
    $datarow = $res->fetch_array();
    return $datarow[$field];
  }
}
/*fisierul se conecteaza la baza de date dinainte creata, numita "dictionar", care
cuprinde cateva tabele : cuvinte, domenii, useri, etc.*/
?>
