<?php
require_once 'db_connectie.php';

$db = maakVerbinding();

$naam = $_post['naam'];
$vluchtnummer = $_post['vluchtnummer'];
$geslacht = $_post['geslacht'];
$objectvolgnummer = $_post['objectvolgnummer'];
$gewicht = $_post['gewicht'];


$passagiersnummer = 'select max(passagiernummer) from passagier';

$passagiersnummer = $passagiersnummer . 1;

$queryPassagier = 'insert into passagier
value('$passagiersnummer ',' $naam ',' $vluchtnummer ',' $geslacht ', null,' ',' date_create('now') ')';

$queryBagage = 'insert into bagageObject
value('$passagiersnummer ',' $objectvolgnummer ',' $gewicht ')';
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
            <form action="mainmenu.php" method="post">    
            <div class="formulier">
                <label>naam</label>
                <input type="text"  name="naam" pattern="[A-Za-z]" required>
                <label>vluchtnummer</label>
                <input type="text"  name="vluchtnummer" pattern="[0-9]" required>
                <label>objectvolgnummer</label>
                <input type="numeric"  name="objectvolgnummer" pattern="[0-9]" required>
                <label>geslacht</label>
                <select id="geslacht" name="geslacht">
                    <option>M</option>
                    <option>V</option>
                    <option>x</option>
                </select>
                <label>aantal bagage</label>
                <input type="number" name="bagage">
                </select>   
                <label>bagage gewicht gemiddeld</label>
                <input type="number" name="gewicht">
                <br>
            </div>
            <div class="checkin">
                <input type="submit">
            </div>
            </form>
        
            <div class="bagage">
                <img src="images/bagage.jpg" alt="bagage foto">
            </div>
        </main>
    </body>
</html>