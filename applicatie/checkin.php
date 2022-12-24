<?php


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
                <label>voorletters</label>
                <input type="text"  name="voorlet" pattern="[A-Za-z]" required>
                <label>achternaam</label>
                <input type="text"  name="achternaam" pattern="[A-Za-z]" required>
                <label>E-mail</label>
                <input type="email"  name="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                <label>geslacht</label>
                <select id="geslacht" name="geslacht">
                    <option>M</option>
                    <option>V</option>
                </select>
                <label>aantal bagage</label>
                <select id="bagage" name="bagage">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>   
                <label>bagage gewicht totaal</label>
                <select id="bagage_gewicht" name="bagage">
                    <option>10 kg</option>
                    <option>20 kg</option>
                    <option>30 kg</option>
                </select>   
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