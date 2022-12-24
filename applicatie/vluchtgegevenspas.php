<?php
    require_once 'db_connectie.php';

    $db = maakVerbinding();

    $table = '';
    $i = 0;

    if(isset($_POST['naam'])){
        $username = $_POST['naam'];
        $username = strip_tags($username);
        $username = addslashes($username);
        $username = htmlspecialchars($username);
        $username = htmlentities($username);
        $where = "where naam like '%" .$username. "%'";
    } else{
        $where = 'where 0=1';
    }

    $query = "select * from vlucht 
    where vluchtnummer in 
    (select vluchtnummer from passagier $where)";

    $stmt = $db->prepare($query);
    $stmt->execute();

    if($where != 'where 0=1' ){
        $table = '<table class = "passagiersgegevens">';
        $table = $table . '<tr>
        <th>vluchtnummer</th>
        <th>bestemming</th>
        <th>gatecode</th>
        <th>max aantal</th>
        <th>max gewicht pp</th>
        <th>max totaalgewicht</th>
        <th>vertrektijd</th>
        <th>maatschappijcode</th></tr>';
    }

    while($rij = $stmt->fetch()) {
        $vluchtnummer = $rij['vluchtnummer'];
        $bestemming = $rij['bestemming'];
        $gatecode = $rij['gatecode'];
        $max_aantal = $rij['max_aantal'];
        $max_gewicht_pp = $rij['max_gewicht_pp'];
        $max_totaalgewicht = $rij['max_totaalgewicht'];
        $vertrektijd = $rij['vertrektijd'];
        $maatschappijcode = $rij['maatschappijcode'];

        $table = $table . "<tr><td>$vluchtnummer</td>
        <td>$bestemming</td><td>$gatecode</td>
        <td>$max_aantal</td><td>$max_gewicht_pp</td>
        <td>$max_totaalgewicht</td>
        <td>$vertrektijd</td><td>$maatschappijcode</td></tr>";
        $i++;
    }

    if($i == 0 && $where != 'where 0=1'){
        $table = 'geen gegevens gevonden voor ' . $_POST['naam'];
    }

    if($where != 'where 0=1'){
        $table = $table . "</table>";
    }
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="normalize" href="css/normalize.css">
        <meta charset="utf-8">
        <title>Gelre Airport</title>
    </head>

    <body>
        <header>
            <div class="titel">
                <h1>
                    Gelre Airport
                </h1>
            </div>
        </header>

        <nav>
            <div class="navigatie">
                <ul>
                <li><a  href="mainmenu.php">Home</a></li>
                <li><a class="active" href="vluchtgegevens.php">mijn gegevens</a></li>
                <li><a  href="checkin.php">Check in</a></li>
            </ul>
            </div>
        </nav>

        <main>
            <br><br>
            <form action="vluchtgegevenspas.php" method="post">
                <input type="text" name="naam" placeholder="naam">
                <button type="submit">Zoek</button>
            </form>
            <?php echo $table ?>
        </main>
    </body> 
</html>