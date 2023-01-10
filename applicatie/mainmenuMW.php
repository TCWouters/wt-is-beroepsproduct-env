<?php
session_start();
    if(!isset($_SESSION["user"])){
        header('location: index.php');
}else{
    if(isset($_POST['uitloggen'])){
        session_unset();
        session_destroy();
        header('location index.php');
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
            <nav class="navigatie">
                <ul>
                    <li><a  class="active" href="mainmenuMW.php">Home</a></li>
                    <li><a  href="checkinMW.php">Passagier inchecken</a></li>
                    <li><a  href="ToevoegenMW.php">Passagier toevoegen</a></li>
                    <li><a  href="vluchttoevoegen.php">Vlucht toevoegen</a></li>
                </ul>
            </nav>
        <main>
            <br><br>
            <form action="mainmenuMW.php" method="post">        
            <input type="submit" name="uitloggen" value="uitloggen">
            </form>
            <br> <br> <br>
            <p>
                Welkom als medewerker bij Gelre Airport, waar wij de beste werk omgeving van onze medewerkers willen geven.
            </p>
        </main>
        <section>
            <h2>
                Regels
            </h2> <br>
        
        <ul>
            <li>
            Niet eten tijdens dienst <br>
            Niks accepteren van passagiers <br>
            Werk kleding moet altijd aan <br>
            Help de klant met een glimlach. Ze betalen immers jouw salaris <br>
            Gebruik vriendelijk taal gebruik
            </li>
        </ul>
        </section>
    </body>
</html>