<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pompe</title>
    <link rel="stylesheet" href="../smartfarm/HTML/style.css">
    
    <style>
    /* Style for buttons */
    .button-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .button-container input[type="submit"] {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s;
        border-radius: 5px;
    }

    .button-container input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

</head>
<body>
    <header>
        <h1>Pompe</h1>
    </header>
    <nav>
        <table>
            <tr>
                <td><a href="HTML/index.html">Acasă</a></td>
                <td><a href="identificare_gandaci.php">Identificare Gândaci</a></td>
                <td><a href="insecticide.php">Insecticide</a></td>
            </tr>
        </table>
    </nav>
    <div class="content">
        <h2>Alege Pompa de Pulverizare</h2>
        <p>Selectați una dintre cele trei pompe disponibile pentru a pulveriza insecticidul.</p>
        <?php
        //session_start(); nu aici

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        require_once('config.php');
        include("connect.php"); 

        if (!isset($_SESSION['logat'])) $_SESSION['logat'] = 'NU';

        if ($_SESSION['logat'] != 'Da') {
            echo 'Pentru a accesa aceasta pagina, trebuie sa va autentificati. <br>
                  Pentru a va autentifica, apasati <a href="index.php">aici</a><br>
                  Pentru a va inregistra, vorbiti cu root';
        } else {
            if ($_SESSION['user'] == "admin" || $_SESSION['user'] == "portar" || $_SESSION['user'] == "root") {
                $cerere2 = "SELECT * FROM setari WHERE `nume`='ip_pico'";
                $resursa2 = mysqli_query($conn, $cerere2);

                if ($resursa2) {
                    $row = mysqli_fetch_array($resursa2);
                    $ip = $row['val'];
                    echo '
                    <form id="form1" name="form1" method="post" action="">
                        <div class="button-container">
                        <input type="submit" name="Pornire" id="1" value="Pornire P1" onClick="MM_openBrWindow(\'http://' . $ip . '/?pompa1=on\',\'\',\'width=500,height=100,valign=center\')">
                        <input type="submit" name="Oprire" id="2" value="Inchidere P1" onClick="MM_openBrWindow(\'http://' . $ip . '/?pompa1=off\',\'\',\'width=500,height=100,valign=center\')">
                        <br><br>
                        <input type="submit" name="Automat" id="3" value="Pornire P2" onClick="MM_openBrWindow(\'http://' . $ip . '/?pompa2=on\',\'\',\'width=500,height=100,valign=center\')">
                        <input type="submit" name="Pauza" id="4" value="Inchidere P2" onClick="MM_openBrWindow(\'http://' . $ip . '/?pompa2=off\',\'\',\'width=500,height=100,valign=center\')">
                        <br><br>
                        <input type="submit" name="Automat" id="5" value="Pornire P3" onClick="MM_openBrWindow(\'http://' . $ip . '/?pompa3=on\',\'\',\'width=500,height=100,valign=center\')">
                        <input type="submit" name="Pauza" id="6" value="Inchidere P3" onClick="MM_openBrWindow(\'http://' . $ip . '/?pompa3=off\',\'\',\'width=500,height=100,valign=center\')">
                        </div>
                    </form>';
                } else {
                    echo '<p>Nu s-a putut prelua adresa IP pentru pompe.</p>';
                }
            } else {
                echo '<p>Nu aveți permisiunea de a accesa această secțiune.</p>';
            }
        }
        ?>
    </div>
    <script>
        function MM_openBrWindow(theURL, winName, features) {
            window.open(theURL, winName, features);
        }
    </script>
</body>
</html>
