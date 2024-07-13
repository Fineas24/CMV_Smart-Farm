<script type="text/javascript" language="javascript">
        function RunFile() {
		WshShell = new ActiveXObject("WScript.Shell");
		WshShell.Run("c:/windows/system32/notepad.exe", 1, false);
        }
</script>


<script>
// Function to send AJAX request
function saveData(id) {
    var numeInput = document.getElementById('nume-' + id);
    var obsInput = document.getElementById('obs-' + id);
    var numeValue =  eInput.value;
    var obsValue = obsInput.value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_data.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            // Optionally, provide feedback to the user
            document.getElementById('status-' + id).innerHTML = xhr.responseText;
        }
    };
    xhr.send("id=" + id + "&nume=" + encodeURIComponent(numeValue) + "&obs=" + encodeURIComponent(obsValue));
}
</script>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

print '<link rel="stylesheet" type="text/css" href="style.css">';
require_once('config.php');
include("connect.php");
if(!isset($_GET['user'])) $_GET['user']='';
if(!isset($_GET['nume'])) $_GET['nume']='';
if(!isset($_GET['prenume'])) $_GET['prenume']='';
if(!isset($_GET['data1'])) $_GET['data1']='';
if(!isset($_GET['data2'])) $_GET['data2']='';

if(!isset($_POST['id'])) $_POST['id']='';
if(!isset($_POST['nume'])) $_POST['nume']='';
if(!isset($_POST['obs'])) $_POST['obs']='';
if(!isset($_POST['nume1'])) $_POST['nume1']='';
if(!isset($_POST['obs1'])) $_POST['obs1']='';
if(!isset($_POST['data1'])) $_POST['data1']='';
if(!isset($_POST['data2'])) $_POST['data2']='';
if(!isset($_POST['ora1'])) $_POST['ora1']='';
if(!isset($_POST['ora2'])) $_POST['ora2']='';
if(!isset($_POST['data1'])) $_POST['data1']='';
if(!isset($_POST['data'])) $_POST['data']='';

$ip='';

$output = shell_exec('gpio mode 0 out');
$output1 = shell_exec('gpio write 0 1');

$output = shell_exec('gpio mode 1 out');
$output1 = shell_exec('gpio write 1 1');

$output = shell_exec('gpio mode 2 out');
$output1 = shell_exec('gpio write 2 1');


if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';
if($_SESSION['logat'] != 'Da')
{
echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
      Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
	  Pentru a va inregistra, vorbiti cu root';
}
else
{
print '<a href="iesire.php">Delogare</a>';
print '<script language="JavaScript" type="text/JavaScript">

function MM_openBrWindow(theURL,winName,features) {
window.open(theURL,winName,features);
  

}
</script>';

print '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina principala</title>



</head>
<body>
<center>



<table width="1000" height="419" border="0">';

if($_SESSION['user']=="admin" || $_SESSION['user']=="portar" || $_SESSION['user']=="root")
 {

$cerere2 = "select * from setari where `nume`='ip_pico'";
$resursa2 =mysqli_query($conn,$cerere2);
$row=mysqli_fetch_array($resursa2);
  $ip=$row['val'];
 print' <tr>

    <td width="393" height="173">
    Pompe:
    <br><br>
   <form id="form1" name="form1" method="post" action="">
  <input type="submit" name="Pornire" id="1" value="Pornire P1" onClick="MM_openBrWindow(\'http://'.$ip.'/?pompa1=on\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Oprire" id="2" value="Inchidere P1" onClick="MM_openBrWindow(\'http://'.$ip.'/?pompa1=off\',\'\',\'width=500,height=100,valign=center \')">
  <br><br>
  <input type="submit" name="Automat" id="3" value="Pornire P2" onClick="MM_openBrWindow(\'http://'.$ip.'/?pompa2=on\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Pauza" id="4" value = "Inchidere P2" onClick="MM_openBrWindow(\'http://'.$ip.'/?pompa2=off\',\'\',\'width=500,height=100,valign=center \')">
  <br><br>
  <input type="submit" name="Automat" id="3" value="Pornire P3" onClick="MM_openBrWindow(\'http://'.$ip.'/?pompa3=on\',\'\',\'width=500,height=100,valign=center \')">
  <input type="submit" name="Pauza" id="4" value = "Inchidere P3" onClick="MM_openBrWindow(\'http://'.$ip.'/?pompa3=off\',\'\',\'width=500,height=100,valign=center \')">
  
        </form></td>
';
}
if($_SESSION['user']=="admin" || $_SESSION['user'] == "root"){

  print' 
  <tr>
    <td height="123"><form id="form2" name="form2" method="post" action="">
      Cautare avansata: 
      <table border="0">
      <tr>
      <form action="#" method="post">
      <td>
      ID_inreg: 
      </td>
       <td>
        <input type="text" name="id" id="id" />
        </td>
      <td> Nume:</td>
      
      <td><input type="text" name="nume"/></td>
      <td> Obs:</td>
      <td><input type="text" name="obs"/></td>
      </tr>
      <tr>
      <td>
      Data 1
      </td>
      <td>
        <input type="date" name="data1" id="data1" value="'.date('Y-m-d').'"/>
        </td>
      <td>
      Data 2
      </td>
      <td>
      <input type="date" name="data2" id="data2" value="'.date('Y-m-d').'"/>
      </td>
      </tr>
      <tr>
      <td>Ora 1</td>
      <td>
      <input type="time" name="ora1" id="ora1" value="00:00:01"/>
      </td>
      <td>Ora 2</td>
      <td>
      <!--<input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" name="timefrom">-->
	<input type="time" name="ora2" id="ora2" value="'.date('H:i:s').'"/>
      </td>
	<td></td>

     <td><input name="cauta" type="submit" value="cauta" /></td>
	<td><input name="reset" type="reset" value="reset" /></td>
      </tr>
      </table>
    </form></td>
    <td> <!--&nbsp;-->';
    /*
    if($_SESSION['user'] == "root"){
    
    print '
    <center><a href=gestionare.php?mod=adaugare>Adaugare utilizator nou</a></center><br>
	<center><a href=gestionare.php?mod=modificare>Modificare utilizator</a></center><br>
	<center><a href=gestionare.php?mod=stergere>Stergere utilizator</a></center><br>';
	}
*/
  print'
  </td>
  </tr>
  
  <tr >
    <td height="113">
    
    <table border="1">
    <tr>
    <td>Id: </td>
    <td>Poza: </td>
    <td>Data intrarii: </td>
    <td>Nume: </td>
    <td>Obs: </td>';

	if($_SESSION['user'] == "root"){
    //print '<td><input type="button" name="sterge_tot" value="sterge tot" onClick="MM_openBrWindow(\'gestionarebaza.php?com=confirm_inreg_cauta\',\'\',\'width=500,height=100,valign=center \')" ></td>';
	}
print'
    
    </tr>
    ';
//$cerere="select * from users, pontaje where users.id = pontaje.id and ID =".$_POST['user']." LIKE '%".$_POST['nume']."%' and Prenume LIKE '%".$_POST['prenume']."%' order by Data DESC, Ora DESC ";
/*if($_POST['user']=='' && $_POST['nume']=='' && $_POST['prenume']=='' && $_POST['data1']=='' && $_POST['data2']==''){
$cerere="select * from users, pontaje where users.id = pontaje.id order by Data DESC, Ora DESC ";
}
elseif($_POST['user']!=''){
$cerere="select * from users, pontaje where users.id = pontaje.id and users.id =".$_POST['user']." and data >= '".$_POST['data1']."' and data <= '".$_POST['data2']."' order by Data DESC, Ora DESC ";
print $cerere;
}elseif($_POST['nume']!='' || $_POST['prenume']!=''){
$cerere="select * from users, pontaje where users.id = pontaje.id and (nume LIKE '%".$_POST['nume']."%' and prenume LIKE '%".$_POST['prenume']."%') order by Data DESC, Ora DESC ";
}*/
$cerere="UPDATE pontaje SET sters='nu'";
$resursa =mysqli_query($conn,$cerere);

$cerere="select * from `inreg_poze` where 1 ";
if($_POST['id']!=''){$cerere=$cerere." and id =".$_POST['id'];}
if($_POST['nume']!=''){$cerere=$cerere." and nume LIKE '%".$_POST['nume']."%'";}
if($_POST['obs']!=''){$cerere=$cerere." and obs LIKE '%".$_POST['obs']."%'";}
if($_POST['data1']!=''){$cerere=$cerere." and data >= '".$_POST['data1']." ".$_POST['ora1']."'";}
if($_POST['data2']!=''){$cerere=$cerere." and data <= '".$_POST['data2']." ".$_POST['ora2']."'";}
//if($_POST['ora1']!=''){$cerere=$cerere." and ora >= '".$_POST['ora1']."'";}
//if($_POST['ora2']!=''){$cerere=$cerere." and ora <= '".$_POST['ora2']."'";}

//$cerere="select * from `inreg_poze` where 1 order by data DESC";
$cerere=$cerere." order by data DESC";
//print $cerere;
$resursa =mysqli_query($conn,$cerere);
$culoare="white";

while($row=mysqli_fetch_array($resursa))

{
    if($culoare == "white"){
	$culoare="orange";
}	
else{$culoare="white";}

    print '
    <tr bgcolor="'.$culoare.'">
    <td>'.$row['id'].'</td>
    <td><a href="" onClick="MM_openBrWindow(\'photos/'.$row['link'].'\',\'\',\'width=640,height=480,valign=center \')">'.$row['link'].' '.$row['obs']. '</a>
    </td>
    <td>'.$row['data'].'</td>';
    //<td><input type="text" name1="nume1" style="background-color: '.$culoare.';" value="'.$row['nume'].'"/></td>
    //<td><input type="text" obs1="obs1" style="background-color: '.$culoare.';" value="'.$row['obs'].'"/></td>';
    echo '<td><input type="text" id="nume-' . $row['id'] . '" name="nume1" style="background-color: ' . $culoare . ';" value="' . htmlspecialchars($row['nume'], ENT_QUOTES, 'UTF-8') . '"/></td>';
    echo '<td><input type="text" id="obs-' . $row['id'] . '" name="obs1" style="background-color: ' . $culoare . ';" value="' . htmlspecialchars($row['obs'], ENT_QUOTES, 'UTF-8') . '"/></td>';
    
        
    
    if($_SESSION['user'] == "root"){

      echo '<td><button type="button" onclick="saveData(' . $row['id'] . ')">Save</button></td>';
      //print '<td><input type="button" name="sterge" value="salvare" ondblClick="MM_openBrWindow(\'gestionarebaza.php?com=stergere_inreg&ID='.$row['id'].'&data='.$row['data'].'&nume='.$_POST['nume1'].'&obs='.$_POST['obs1'].'\',\'\',\'width=500,height=100,valign=center \')" ></td>';
    //print'<td><input type="button" name="sterge" value="salvare" ><>';
    //$cerere1="UPDATE inreg_poze SET sters='nu' where id='".$row['id']."'";
    //mysqli_query($conn,$cerere1);
  
  }
print '
    </tr>';
}
    print '
    <tr>
    <td>
    
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>

';



}
print '
</table>
</center>
</body>
</html>
';
}
?>
