<?php
    // uitgevoerde code is PA-02, PA-03
    // maakt database connectie
    require_once 'db_connectie.php';

    $db = maakVerbinding();

    $uitkomst = '';

    // in checken start
    if(isset($_POST['submit'])){
        // tijd van nu opnemen
        $datum = date_create('now');
        $resultaat = $datum->format('Y-m-d H:i:s');

        // variabelen die zijn ingevuld
        $aantalbagage = $_POST['bagage'];
        $passagiernummer = $_POST['passagiernummer'];
        $vluchtnummer = $_POST['vluchtnummer'];
        $gewicht = $_POST['gewicht'];

        // SQL injectie verkomen
        require 'tagremover.php';
        $aantalbagage = strip($aantalbagage);
        $passagiernummer = strip($passagiernummer);
        $vluchtnummer = strip($vluchtnummer);
        $gewicht = strip($gewicht);
        
        // query voor de tijdstip
        $querypassagier = "update passagier
        set inchecktijdstip = :resultaat where passagiernummer = :passagiernummer and vluchtnummer = :vluchtnummer";

        // query voor de bagage invoegen
        $querybagage = 'insert into bagageObject
        values (:passagiernummer, :objectvolgnummer, :gewicht)';

        try{
            $stmtpassagier = $db->prepare($querypassagier);
            $stmtpassagier->execute([':resultaat' => $resultaat, ':passagiernummer' => $passagiernummer, ':vluchtnummer' => $vluchtnummer]);

            for($i = 0; $i < $aantalbagage; $i++){
                $stmtbagage = $db->prepare($querybagage);
                $stmtbagage->execute([':passagiernummer' => $passagiernummer,':objectvolgnummer' => $i, ':gewicht' => $gewicht ]);
            }
            // succes
            $uitkomst = 'gegevens succesvol doorgevoerd';
        } catch(PDOException $fault){
            // SQL error
            $uitkomst = "Er staat al een aanmelding voor deze gebruiker";
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
            <br> <br>
            <?php echo $uitkomst ?>
            <div class="bagage">
                <img src="images/bagage.jpg" alt="bagage foto">
            </div>
        </main>
    </body>
</html>