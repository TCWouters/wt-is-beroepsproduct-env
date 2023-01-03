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
                    <li><a  class="active" href="ToevoegenMW.php">Passagier toevoegen</a></li>
                    <li><a  href="vluchttoevoegen.php">Vlucht toevoegen</a></li>
                </ul>
            </nav>
        <main>
            <form action="mainmenuMW.php" method="post"> 
            <div class="formulier">
                <label>naam</label>
                    <input type="text"  name="naam" required>
                <label>vluchtnummer</label>
                    <input type="text" id="vluchtnr" name="vluchtnr" required>
                <label>eindbestemming</label>
                    <input type="text" id="eindbestemming" name="eindbestemming" required>
                <label>aantal bagage</label>
                    <input type="number" id="bagage" name="bagage" required>
                <label>bagage gewicht totaal</label>
                    <input type="number" id="bagage_gewicht" name="bagage" required>
                <label>balienummer</label>
                    <input type = "number" name="balie" required>
                <label>passagiersnummer</label>
                    <input type ="number" name ="passagiersnummer" required>
                <label>stoel</label>
                    <input type="text" name="stoel" required>
                <br>
            </div>
            <div class="checkin">
                <button formnovalidate="formnovalidate">Terug</button>
                <input type="submit"> 
            </div>
            </form>
        </main>
    </body>
</html>