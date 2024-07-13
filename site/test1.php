<?php

$link = mysqli_connect('localhost', 'root', 'admin1234');
if (!$link) {
    die('Not connected : ' . mysqli_error());
}

// make foo the current db
$db_selected = mysqli_select_db('test', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysqli_error());
}
echo "merge";
//$cerere="select nume, data_conectarii from users, detalii2 where users.id = detalii2.id order by nume ASC, data_conectarii DESC ";
$cerere="SELECT COUNT(id) as num from detalii2 where id=1";

$resursa =mysqli_query($conn,$cerere);
$total=mysqli_result($resursa,0);
print $total;

/*while($row=mysqli_fetch_array($resursa))

{
print "Numele utiluzatorului este:".$row['nume']." end \n";
print "data este".$row['data_conectarii']."end <br>";
}
*/
?>
