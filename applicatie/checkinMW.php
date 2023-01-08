<?php
// uitgevoerde code is MW-01
// maakt database connectie
require_once 'db_connectie.php';

$db = maakVerbinding();

$succes = '';
// inchecken begint
if(isset($_POST['submit'])){

    // tijd van nu opnemen
    $datum = date_create('now');
    $resultaat = $datum->format('Y-m-d H:i:s');

    // ingevulden gegevens
    $aantalbagage = $_post['bagage'];
    $passagiernummer = $_POST['passagiernummer'];
    $vluchtnummer = $_POST['vluchtnr'];
    $objectvolgnummer = $_POST['objectvolgnummer'];
    $gewicht = $_POST['gewicht'];

    // SQL injectie verkomen
    require 'tagremover.php';
    $passagiernummer = strip($passagiernummer);
    $vluchtnummer = strip($vluchtnummer);
    $objectvolgnummer = strip($objectvolgnummer);
    $gewicht = strip($gewicht);
    
    //query voor de tijdstip
    $querypassagier = "update passagier
    set inchecktijdstip = ':inchecktijdstip' 
    where passagiernummer = :passagiernummer  and vluchtnummer = :vluchtnummer";

    //query voor de bagage
    $querybagage = 'insert into bagageObject
    values ( :passagiernummer , :objectvolgnummer  , :gewicht)';

    $stmtpassagier = $db->prepare($querypassagier);
    $stmtpassagier->execute([':inchecktijdstip' => $resultaat, ':passagiernummer' => $passagiernummer, 
    ':vluchtnummer' => $vluchtnummer]);


    $stmtbagage = $db->prepare($querybagage);
    $stmtbagage->execute([':passagiernummer' => $passagiernummer, ':objectvolgnummer' => $objectvolgnummer, 
    ':gewicht' => $gewicht]);

    // succesvol
    $succes = 'gegevens succesvol doorgevoerd';
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
        <nav class="navigatie">
            <ul>
                <li><a href="mainmenuMW.php">Home</a></li>
                <li><a  class="active" href="checkinMW.php">Passagier inchecken</a></li>
                <li><a  href="ToevoegenMW.php">Passagier toevoegen</a></li>
                <li><a  href="vluchttoevoegen.php">Vlucht toevoegen</a></li>
            </ul>
        </nav>
        
    <main>
        <form action="checkinMW.php" method="post"> 
        <div class="formulier">
            <label>Passagiernummer</label>
                <input type="number" name="passagiernummer" value="<?=$passagiernummer?>" required>
            <label>vluchtnummer</label>
                <input type="text" id="vluchtnr" name="vluchtnr" required>
            <label>aantal bagage</label>
                <input type="number" id="bagage" name="bagage"> 
            <label>bagage gewicht gemiddeld</label>
                <input type="number" name="gewicht">
            <label>objectvolgnummer</label>
                <input type="number" name="objectvolgnummer">
            <label>balienummer</label>
                <input type = "number" name="balie" required>
            <br>
        </div>
        <div class="checkin">
            <input type="submit" name="submit">
        </div>
        </form>
        <br> <br> <br>
            <?php echo $succes ?>
    </main>
        <footer>
            <div class="footer">
                <p>
                    indien gevraagd, voor privacy verklaring ga naar <a href="Privacy.php">deze</a> website
                </p>
            </div>
        </footer>
    </body>
</html>