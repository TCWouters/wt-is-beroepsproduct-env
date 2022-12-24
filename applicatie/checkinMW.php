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
        <form action="mainmenuMW.php" method="post"> 
        <div class="formulier">
            <label>vlucht nummer</label>
            <input type="text" id="vluchtnr" name="vluchtnr" required>
            <label>gate</label>
            <input type="text" id="gate" name="gate" pattern="[0-9]" required>
            <label>aantal bagage</label>
            <select id="bagage" name="bagage">
                <option>1</option>
                <option >2</option>
                <option >3</option>
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