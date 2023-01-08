<?php
    // codes die worden uitgevoerd hier: GB-02, MW-02

    // database connectie
    require_once 'db_connectie.php';

    $db = maakVerbinding();
    
    $fout = '';
    // vlucht wordt uitgevoerd
    if(isset($_GET['vluchtnummer'])){
        // wordt gecheckt of vluchtnummer niet leeg is
        if($_GET['vluchtnummer'] == "" && isset($_GET['submit'])){
            $where = '1=1';
            $fout = 'geen nummer ingevoerd';
        }
        // wordt gecheckt of vluchtnummer een nummer is
        if(is_numeric($_GET['vluchtnummer'])){
            $where = $_GET['vluchtnummer'];
        }
        else{
            $fout = 'geen nummer ingevoerd';
        }
    } else{
        $where = '1=1';
    }
    
    // query wordt uitgevoerd
    $query = 'select * from vlucht where vluchtnummer = :vluchtnummer';

    $stmt = $db->prepare($query);
    $stmt->execute([":vluchtnummer" => $where]);


    //tabel wordt aangemaakt
    $table = '<table class = "passagiersgegevens">';
    $table = $table . '<tr><th>vluchtnummer</th>
    <th>bestemming</th>
    <th>gatecode</th>
    <th>max aantal</th>
    <th>max gewicht pp</th>
    <th>max totaalgewicht</th>
    <th>vertrektijd</th>
    <th>maatschappijcode</th></tr>';

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
  <td>$max_aantal</td><td>$max_aantal</td>
  <td>$max_gewicht_pp</td><td>$max_totaalgewicht</td>
  <td>$vertrektijd</td><td>$maatschappijcode</td></tr>";
}

    $table = $table . "</table>";
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
            <div class="knop">
                <a href="index.php"> 
                    terug
                </a>
            </div>
        </nav>
        <main>
            <form action="vluchten.php" method="get">
            <input type="number" name="vluchtnummer" placeholder="Zoek vluchtnummer">
            <button type="hidden" name="submit">Zoek</button>
            <br> <br>
            <?php echo($table) ?>
            </form>
        </main>
    </body>
</html>