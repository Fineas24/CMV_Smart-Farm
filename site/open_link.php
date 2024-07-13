<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the link parameter is set
    if (isset($_POST["link"])) {
        $link = $_POST["link"];
        // Use header() to redirect to the link
        header("Location: $link");
        exit();
    } else {
        // Handle error if link parameter is not set
        echo "Error: Link parameter not set.";
    }
} else {
    // Handle error if request method is not POST
    echo "Error: Only POST requests are allowed.";
}
?>
