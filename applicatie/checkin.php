<!-- werkt nog niet -->
<?php
require_once 'db_connectie.php';

$db = maakVerbinding();

$datum = date_create('now');
$resultaat = $datum->format('Y-m-d H:i:s');

$succes = '';

if(isset($_POST['submit'])){
    $passagiernummer = $_POST['passagiernummer'];
    $vluchtnummer = $_POST['vluchtnummer'];
    $objectvolgnummer = $_POST['objectvolgnummer'];
    $gewicht = $_POST['gewicht'];


    require 'tagremover.php';
    $passagiernummer = strip($passagiernummer);
    $vluchtnummer = strip($vluchtnummer);
    $objectvolgnummer = strip($objectvolgnummer);
    $gewicht = strip($gewicht);
    
    
$querypassagier = "update passagier
set inchecktijdstip = '" .$resultaat. 
"' where passagiernummer = " .$passagiernummer. " and vluchtnummer = " .$vluchtnummer;

$querybagage = 'insert into bagageObject
values (' .$passagiernummer. ',' .$objectvolgnummer. ',' .$gewicht. ')';

$succes = 'gegevens succesvol doorgevoerd';


$stmtpassagier = $db->prepare($querypassagier);
$stmtpassagier->execute();


$stmtbagage = $db->prepare($querybagage);
$stmtbagage->execute();
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
        <main>
            <form action="checkin.php" method="post">    
            <div class="formulier">
                <label>passagiernummer</label>
                <input type="number"  name="passagiernummer" required>
                <label>vluchtnummer</label>
                <input type="text"  name="vluchtnummer"  required>
                <label>objectvolgnummer</label>
                <input type="number"  name="objectvolgnummer" required>
                <label>aantal bagage</label>
                <input type="number" name="bagage">
                </select>   
                <label>bagage gewicht gemiddeld</label>
                <input type="number" name="gewicht">
                <br>
            </div>
            <div class="checkin">
                <input type="submit" name ="submit">
            </div>
            </form>
            <?php echo $succes ?>
            <div class="bagage">
                <img src="images/bagage.jpg" alt="bagage foto">
            </div>
        </main>
    </body>
</html>