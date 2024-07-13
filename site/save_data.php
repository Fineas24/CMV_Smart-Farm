<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

print '<link rel="stylesheet" type="text/css" href="style.css">';
require_once('config.php');
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID and values from the POST request
    $id = intval($_POST['id']);
    $nume = mysqli_real_escape_string($conn, $_POST['nume']);
    $obs = mysqli_real_escape_string($conn, $_POST['obs']);

    // Update the database
    $query = "UPDATE `inreg_poze` SET nume = '$nume', obs = '$obs' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "Data updated successfully";
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}

$conn->close();
?>
