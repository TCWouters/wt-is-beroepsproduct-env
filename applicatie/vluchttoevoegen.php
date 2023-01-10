<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header('location: index.php');

    } else {
    // uitgevoerde code is MW-04
    // maakt database connectie
    require_once 'db_connectie.php';

    $db = maakVerbinding();

    $succes = '';

    // vlucht aanmaken begint
    if(isset($_POST['submit'])){
        // volgende vluchtnummer vinden en gebruiken 
        $queryvluchtnummer = 'select max(vluchtnummer) from vlucht';
        $stmt = $db->prepare($queryvluchtnummer);
        $stmt->execute();

        $resultaat = $stmt->fetch();
        $vluchtnummer = $resultaat[0] + 1;

        // ingevoerde gegevens
        $bestemming =           $_POST['bestemming'];
        $gatecode =             $_POST['gate'];
        $max_aantal =           $_POST['max_aantal'];
        $max_gewicht_pp =       $_POST['max_gewicht_pp'];
        $max_totaalgewicht =    $_POST['max_totaalgewicht'];
        $maatschappij =         $_POST['maatschappij'];

        $vertrektijd =      $_POST['vertrektijd'];
        $vertrektijd =      strtotime($vertrektijd);
        $vertrektijd =      date("Y/m/d H:i:s", $vertrektijd);

        // query wordt uitgevoerd
        $queryvlucht = 'insert into vlucht 
                        values(:vluchtnummer, :bestemming, :gatecode, :max_aantal, :max_gewicht_pp, :max_totaalgewicht,
                        :vertrektijd, :maatschappij)';
        
        $stmt = $db->prepare($queryvlucht);
        $stmt->execute([':vluchtnummer' => $vluchtnummer, ':bestemming' => $bestemming, ':gatecode' => $gatecode, 
        ':max_aantal' => $max_aantal, ':max_gewicht_pp' => $max_gewicht_pp, ':max_totaalgewicht' => $max_totaalgewicht, 
        ':vertrektijd' => $vertrektijd, ':maatschappij' => $maatschappij]);
        // succes
        $succes = 'gegevens succesvol doorgevoerd';
    }
    if(isset($_POST['uitloggen'])){
        require_once 'functies.php';
        uitloggen();
        }
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
        <nav>
            <div class="navigatie">
                <ul>
                <li><a   href="mainmenuMW.php">Home</a></li>
                <li><a   href="checkinMW.php">Passagier inchecken</a></li>
                <li><a   href="ToevoegenMW.php">Passagier toevoegen</a></li>
                <li><a   class="active" href="vluchttoevoegen.php">Vlucht toevoegen</a></li>
                </ul>
            </div>
        </nav>
    <main>
        <form action="vluchttoevoegen.php" method="post"> 
        <div class="formulier">
            <label>maatschappij code</label>
                <input type="text" id="maatschappij" name="maatschappij" required>
            <label>bestemming</label>
                <input type="text" id="bestemming" name="bestemming" required>
            <label>maximale aantal passagiers</label>
                <input type="text" id="max_aantal" name="max_aantal" required>
            <label>maximale gewicht per passagier</label>
                <input type="number" id="max_gewicht_pp" name="max_gewicht_pp" required>
            <label>maximale totaal gewicht</label>
                <input type="number" id="max_totaalgewicht" name="max_totaalgewicht" required>
            <label>vertrektijd</label>
                <input type="datetime" id="vertrektijd" name="vertrektijd" placeholder='Y-M-D H-M' required>
            <label>gate</label>
                <input type="text" id="gate" name="gate" required>
            <br>
        </div>
        <div class="checkin">
            <input type="submit" name="submit">
        </div>
        </form>
        <br> <br> <br>
            <?php echo $succes ?>
        <br> <br> <br>
        <form action="vluchttoevoegen.php" method="post"> 
        <div class="checkin">
            <input type="submit" name="uitloggen" value="uitloggen">
        </div>
        </form>
        </main>
    </body>
</html>