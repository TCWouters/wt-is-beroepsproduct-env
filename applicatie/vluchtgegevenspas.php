<?php
    // uitgevoerde code is PA-01
    // maakt database connectie
    require_once 'db_connectie.php';

    $db = maakVerbinding();

    $table = '';
    $i = 0;
    $fout = '';
    $passagiersnummer = -1;

    // checkt of passagiernummer is geset
    if(isset($_POST['passagiernummer'])){

        // checkt of de passagiernummer niet leeg is
        if($_POST['passagiernummer'] == "" && isset($_POST['submit'])){
            $where = 'where 0=1';
            $fout = 'geen nummer ingevoerd';
        }

        // checkt of de passagiernummer nummers zijn
        if(is_numeric($_POST['passagiernummer'])){
            $passagiersnummer = $_POST['passagiernummer'];
            }
            else{
                $fout = 'geen nummer';
            }
        } 
     else{
        $where = 'where 0=1';
     }
    
     // query om de passagier te vinden
    $query = "select * from vlucht 
    where vluchtnummer in (select vluchtnummer from passagier where passagiernummer = :passagiernummer )";

    $stmt = $db->prepare($query);
    $stmt->execute([':passagiernummer' => $passagiersnummer]);

    // voor als passagier niet bestaat
    if(isset($_POST['passagiernummer'])){
        $resultaat = $stmt->rowCount();
        if($resultaat == 0){
            $where = 'where 0=1';
            $fout = 'Geen gegevens gevonden';
        }
    }
    // maakt de tabel voor de gegevens
    if($where != 'where 0=1' ){
        $table = '<table class = "passagiersgegevens">';
        $table = $table . '<tr>
        <th><a href="?orderby=asc">vluchtnummer</a></th>
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
    // als de tabel leeg is dan zijn er geen gegevens
    if($i == 0 && $where != 'where 0=1'){
        $table = 'geen gegevens gevonden voor ' . $_POST['passagiernummer'];
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
                <label>Voer hier uw passagiernummer in</label>
                <br>
                <input type="number" name="passagiernummer" placeholder="passagiernummer">
                <button type="submit" name="submit">Zoek</button>
            </form>
            <?php echo $table ?>
            <?php echo $fout ?>
        </main>
    </body> 
</html>