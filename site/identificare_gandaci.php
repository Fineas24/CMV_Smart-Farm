<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('config.php');
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['logat']) || $_SESSION['logat'] != 'Da') {
    echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
          Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
          Pentru a va inregistra, vorbiti cu root';
    exit;
}

function get($param, $default = '') {
    return isset($_GET[$param]) ? $_GET[$param] : $default;
}

function post($param, $default = '') {
    return isset($_POST[$param]) ? $_POST[$param] : $default;
}

$user = get('user');
$nume = post('nume');
$obs = post('obs');
$data1 = post('data1', date('Y-m-d'));
$data2 = post('data2', date('Y-m-d'));
$ora1 = post('ora1', '00:00:01');
$ora2 = post('ora2', date('H:i:s'));

// Set the default value for $ip
$ip = '';

// Default shell commands
shell_exec('gpio mode 0 out');
shell_exec('gpio write 0 1');
shell_exec('gpio mode 1 out');
shell_exec('gpio write 1 1');
shell_exec('gpio mode 2 out');
shell_exec('gpio write 2 1');

// HTML and CSS
echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Identificare Gândaci</title>
<link rel="stylesheet" type="text/css" href="HTML/style.css">
<script>
// Function to send AJAX request
function saveData(id) {
    var numeInput = document.getElementById("nume-" + id);
    var obsInput = document.getElementById("obs-" + id);
    var numeValue = numeInput.value;
    var obsValue = obsInput.value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_data.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            document.getElementById("status-" + id).innerHTML = xhr.responseText;
        }
    };
    xhr.send("id=" + id + "&nume=" + encodeURIComponent(numeValue) + "&obs=" + encodeURIComponent(obsValue));
}
</script>
</head>
<body>
<header>
    <h1>Identificare Gândaci</h1>
</header>
<nav>
    <table>
        <tr>
            <td><a href="HTML/index.html">Acasă</a></td>
            <td><a href="pompe.php">Pompe</a></td>
            <td><a href="insecticide.php">Insecticide</a></td>
        </tr>
    </table>
</nav>
<div class="content" id="div_central">
    <form id="searchForm" name="searchForm" method="post" action="">
        <table border="0">
            <tr>
                <td>ID_inreg:</td>
                <td><input type="text" name="id" id="id" /></td>
                <td>Nume:</td>
                <td><input type="text" name="nume" value="' . htmlspecialchars($nume, ENT_QUOTES, 'UTF-8') . '"/></td>
                <td>Obs:</td>
                <td><input type="text" name="obs" value="' . htmlspecialchars($obs, ENT_QUOTES, 'UTF-8') . '"/></td>
            </tr>
            <tr>
                <td>Data 1:</td>
                <td><input type="date" name="data1" id="data1" value="' . $data1 . '"/></td>
                <td>Data 2:</td>
                <td><input type="date" name="data2" id="data2" value="' . $data2 . '"/></td>
            </tr>
            <tr>
                <td>Ora 1:</td>
                <td><input type="time" name="ora1" id="ora1" value="' . $ora1 . '"/></td>
                <td>Ora 2:</td>
                <td><input type="time" name="ora2" id="ora2" value="' . $ora2 . '"/></td>
                <td><input name="cauta" type="submit" value="Cauta" /></td>
                <td><input name="reset" type="reset" value="Reset" /></td>
            </tr>
        </table>
    </form>';

if ($_SESSION['user'] == "admin" || $_SESSION['user'] == "root") {
    $query = "SELECT * FROM inreg_poze WHERE 1";
    if (!empty($_POST['id'])) $query .= " AND id =" . intval($_POST['id']);
    if (!empty($_POST['nume'])) $query .= " AND nume LIKE '%" . mysqli_real_escape_string($conn, $_POST['nume']) . "%'";
    if (!empty($_POST['obs'])) $query .= " AND obs LIKE '%" . mysqli_real_escape_string($conn, $_POST['obs']) . "%'";
    if (!empty($_POST['data1'])) $query .= " AND data >= '" . mysqli_real_escape_string($conn, $_POST['data1']) . " " . mysqli_real_escape_string($conn, $_POST['ora1']) . "'";
    if (!empty($_POST['data2'])) $query .= " AND data <= '" . mysqli_real_escape_string($conn, $_POST['data2']) . " " . mysqli_real_escape_string($conn, $_POST['ora2']) . "'";
    $query .= " ORDER BY data DESC";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    echo '<table border="1">
            <tr>
                <th>Id</th>
                <th>Poza</th>
                <th>Data intrarii</th>
                <th>Nume</th>
                <th>Obs</th>
            </tr>';

    $color = "white";
    while ($row = mysqli_fetch_assoc($result)) {
        $color = ($color == "white") ? "orange" : "white";
        echo '<tr bgcolor="' . $color . '">
                <td>' . $row['id'] . '</td>
                <td><a href="photos/' . $row['link'] . '" target="_blank">' . $row['link'] . ' ' . htmlspecialchars($row['obs'], ENT_QUOTES, 'UTF-8') . '</a></td>
                <td>' . $row['data'] . '</td>
                <td><input type="text" id="nume-' . $row['id'] . '" name="nume1" style="background-color: ' . $color . ';" value="' . htmlspecialchars($row['nume'], ENT_QUOTES, 'UTF-8') . '"/></td>
                <td><input type="text" id="obs-' . $row['id'] . '" name="obs1" style="background-color: ' . $color . ';" value="' . htmlspecialchars($row['obs'], ENT_QUOTES, 'UTF-8') . '"/></td>';
        if ($_SESSION['user'] == "root") {
            echo '<td><button type="button" onclick="saveData(' . $row['id'] . ')">Save</button></td>';
        }
        echo '</tr>';
    }

    echo '</table>';
}
echo '</div>
</body>
</html>';
?>
