<?php

require_once('config.php');
include("connect.php");
if(!isset($_GET['actiune'])) $_GET['actiune'] = '';

switch($_GET['actiune'])
{
case '':
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #66CCFF;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .login-box h5 {
            color: #121087;
            margin-bottom: 20px;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-box input[type="submit"] {
            background-color: #121087;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .login-box input[type="submit"]:hover {
            background-color: #0e0b6c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h5><b>Login:</b></h5>
            <form action="index.php?actiune=validare" method="POST">
                <div>Username: <input type="text" name="user"></div>
                <div>Password: <input type="password" name="parola"></div>
                <div><input type="submit" value="Login"></div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
break;

case 'validare':

$_SESSION['user'] = $_POST['user'];

if(($_POST['user'] == '') || ($_POST['parola'] == ''))
{
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #66CCFF;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .error-box a {
            color: #121087;
            text-decoration: none;
        }
        .error-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-box">
            <p>Completeaza casutele.</p>
            <p>Apasati <a href="index.php">aici</a> pentru a va intoarce la pagina precedenta.</p>
        </div>
    </div>
</body>
</html>

<?php
}
else
{
//$cerereSQL = "SELECT * FROM `Admin` WHERE User='".htmlentities($_POST['user'])."' AND Parola='".md5($_POST['parola'])."'";
$cerereSQL = "SELECT * FROM `Admin` WHERE User='".htmlentities($_POST['user'])."' AND Parola='".htmlentities($_POST['parola'])."'";
$rezultat = mysqli_query($conn,$cerereSQL);
//print $cerereSQL;
//print "bb";

if(mysqli_num_rows($rezultat) == 1)
{
  while($rand = mysqli_fetch_array($rezultat))
  {
    $_SESSION['logat'] = 'Da';
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=HTML/index.html">';
  }
}
else
{
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #66CCFF;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .error-box a {
            color: #121087;
            text-decoration: none;
        }
        .error-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-box">
            <p>Date incorecte.</p>
            <p>Apasati <a href="index.php">aici</a> pentru a va intoarce la pagina precedenta.</p>
        </div>
    </div>
</body>
</html>

<?php
}
}
break;
}
?>
