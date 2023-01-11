<?php
    // uitgevoerde code is MW-05
    session_start();
    if(!isset($_SESSION["user"])){
        header('location: index.php');

    } else {
    // database connectie
    require_once 'db_connectie.php';

    $db = maakVerbinding();

    $melding = '';

    // passagier toevoegen
    if(isset($_POST['submit'])){
        // ingevoerde gegevens
        $naam =                   $_POST['naam'];
        $passagiernummer =        $_POST['passagiersnummer'];
        $geslacht =               $_POST['geslacht'];
        $vluchtnummer =           $_POST['vluchtnr'];
        $balie =                  $_POST['balie'];
        $stoel =                  $_POST['stoel'];

        require 'functies.php';
        $naam =                   strip($naam);
        $passagiernummer =        strip($passagiernummer);
        $geslacht =               strip($geslacht);
        $vluchtnummer =           strip($vluchtnummer);
        $balie =                  strip($balie);
        $stoel =                  strip($stoel);
        
        //query voor maximale aantal passagiers
        $queryplaats = "select max_aantal from vlucht where vluchtnummer = :vluchtnummer";

        $stmtplaats= $db->prepare($queryplaats);
        $stmtplaats->execute([':vluchtnummer' => $vluchtnummer]);

        $querybezetting = "select count(*) as passagiers from passagier where vluchtnummer = :vluchtnummer";        

        $stmtbezetting= $db->prepare($querybezetting);
        $stmtbezetting->execute([':vluchtnummer' => $vluchtnummer]);

        $aantalplaatsen = $stmtbezetting->fetch();
        $resultaatplaats = $stmtplaats->fetch();

        if($aantalplaatsen['passagiers'] + 1 > $resultaatplaats['max_aantal']){
            $melding = "Het maximale aantal plaatsen voor vlucht ".$vluchtnummer." is overschreden";

        }else{

        //query om de passagier in te voeren in de database
        $query = "insert into passagier
        values ( :passagiernummer , :naam , :vluchtnummer , :geslacht , :balie , :stoel , null )";
        
        $stmt = $db->prepare($query);
        $stmt->execute([':passagiernummer' => $passagiernummer, ':naam' => $naam, ':vluchtnummer' => $vluchtnummer, 
        ':geslacht' => $geslacht, ':balie' => $balie, ':stoel' => $stoel]);
        
        // succes
        $melding = 'gegevens succesvol doorgevoerd';
        }
        // logt gebruiker uit
        if(isset($_POST['uitloggen'])){
            require_once 'functies.php';
            uitloggen();
        }
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
            <nav class="navigatie">
                <ul>
                    <li><a   href="mainmenuMW.php">Home</a></li>
                    <li><a   href="checkinMW.php">Passagier inchecken</a></li>
                    <li><a   class="active" href="ToevoegenMW.php">Passagier toevoegen</a></li>
                    <li><a   href="vluchttoevoegen.php">Vlucht toevoegen</a></li>
                </ul>
            </nav>
        <main>
            <form action="toevoegenMW.php" method="post"> 
            <div class="formulier">
                <label>naam</label>
                    <input type="text"  name="naam" required>
                <label>passagiersnummer</label>
                    <input type ="number" name ="passagiersnummer" required>
                <label>geslacht</label>
                    <select name="geslacht">
                        <option>M</option>
                        <option>V</option>
                        <option>X</option>
                    </select>
                <label>vluchtnummer</label>
                    <input type="text" id="vluchtnr" name="vluchtnr" required>
                <label>balienummer</label>
                    <input type = "number" name="balie" required>
                <label>stoel</label>
                    <input type="text" name="stoel" required>
                <br>
            </div>
            <div class="checkin">
                <input type="submit" name="submit"> 
            </div>
            </form>
            <br> <br> <br>
            <?php echo $melding ?>
            <br> <br> <br>
            <form action="toevoegenMW.php" method="post"> 
            <div class="checkin">
            <input type="submit" name="uitloggen" value="uitloggen">
            </div>
        </form>
        </main>
    </body>
</html>