<?php
// uitgevoerde code is MW-01
    session_start();
    if(!isset($_SESSION["user"])){
        header('location: index.php');

    } else {
        // maakt database connectie
        require_once 'db_connectie.php';

        $db = maakVerbinding();

        $uitkomst = '';

        // inchecken begint
        if(isset($_POST['submit'])){

            // tijd van nu opnemen
            
            $datum = date_create('now');
            $resultaat = $datum->format('Y-m-d H:i:s');

            // ingevulden gegevens
            $aantalbagage = $_POST['bagage'];
            $passagiernummer = $_POST['passagiernummer'];
            $vluchtnummer = $_POST['vluchtnr'];
            $gewicht = $_POST['gewicht'];

            // SQL injectie verkomen
            require 'functies.php';
            $passagiernummer = strip($passagiernummer);
            $vluchtnummer = strip($vluchtnummer);
            $bagage = strip($aantalbagage);
            $gewicht = strip($gewicht);
            
            //checks voor query's
            $querymaxgewicht = "select max_gewicht_pp from vlucht where vluchtnummer = :vluchtnummer";

            $stmtmaxgewicht= $db->prepare($querymaxgewicht);
            $stmtmaxgewicht->execute([':vluchtnummer' => $vluchtnummer]);

            $querytotaalgewicht = "select sum(gewicht) as gewicht from BagageObject 
            where passagiernummer in (select passagiernummer from Passagier where vluchtnummer = :vluchtnummer)";

            $stmttotaalgewicht= $db->prepare($querytotaalgewicht);
            $stmttotaalgewicht->execute([':vluchtnummer' => $vluchtnummer]);

            $resultaatmaxgewicht = $stmtmaxgewicht->fetch();
            $resultaattotaalgewicht = $stmttotaalgewicht->fetch();


            // checkt of maximale gewicht is overschreden
            if(($resultaattotaalgewicht['gewicht'] + ($gewicht*$aantalbagage)) > $resultaatmaxgewicht['max_gewicht_pp'] && 
            !is_null(!$resultaattotaalgewicht['gewicht'])){
                $uitkomst = "maximale gewicht overschreden";
            }else{

             try{
                //query voor de tijdstip
                $querypassagier = "update passagier
                set inchecktijdstip = :inchecktijdstip 
                where passagiernummer = :passagiernummer  and vluchtnummer = :vluchtnummer";

                //query voor de bagage
                $querybagage = 'insert into bagageObject
                values ( :passagiernummer , :objectvolgnummer  , :gewicht)';

                $stmtpassagier = $db->prepare($querypassagier);
                $stmtpassagier->execute([':inchecktijdstip' => $resultaat, ':passagiernummer' => $passagiernummer, 
                ':vluchtnummer' => $vluchtnummer]);
                    
                // tussenstap voor objectvolgnummer
                    $queryobjectvolgnummer = 'select max(objectvolgnummer) from bagageObject where passagiernummer = :passagiernummer';
                    $stmt = $db->prepare($queryobjectvolgnummer);
                    $stmt->execute([':passagiernummer' => $passagiernummer]);
                    $resultaatobjectvolgnummer = $stmt->fetch();

                    for($i = 0; $i < $aantalbagage; $i++){
                    if($resultaatobjectvolgnummer[0] != 0){
                    $objectvolgnummer = $resultaatobjectvolgnummer[0] + 1;
                    } else{
                        $objectvolgnummer = 0;
                    }
                    $stmtbagage = $db->prepare($querybagage);
                    $stmtbagage->execute([':passagiernummer' => $passagiernummer,':objectvolgnummer' => $objectvolgnummer, ':gewicht' => $gewicht ]);
                    }
                                    
                // succes
                $uitkomst = 'gegevens succesvol doorgevoerd';
            } catch(PDOException $fault){
                // SQL error
                $uitkomst = "Fout probeer opnieuw!";
            }
            }
        }
        // logt gebruiker uit
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
            <label>balienummer</label>
                <input type = "number" name="balie" required>
            <br>
        </div>
        <div class="checkin">
            <input type="submit" name="submit">
        </div>
        </form>
        <br> <br> <br>
            <?php echo $uitkomst ?>
            <br> <br> <br>
            <form action="checkinMW.php" method="post"> 
            <div class="checkin">
            <input type="submit" name="uitloggen" value="uitloggen">
            </div>
        </form>
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