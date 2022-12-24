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
                <li><a  href="ToevoegenMW.php">Passagier toevoegen</a></li>
                <li><a  class="active" href="vluchttoevoegen.php">Vlucht toevoegen</a></li>
                </ul>
            </div>
        </nav>
    <main>
        <form action="mainmenuMW.php" method="post"> 
        <div class="formulier">
            <label>vluchtnummer</label>
            <input type="text" id="vluchtnr" name="vluchtnr" required>
            <label>vlucht maatschapij</label>
            <input type="text" id="maatschapij" name="maatschapij" required>
            <label>eind bestemming</label>
            <input type="text" id="eindbestemming" name="eindbestemming" required>
            <label>vliegtuig</label>
            <input type="text" id="vliegtuig" name="vliegtuig" required>
            <label>gate</label>
            <input type="text" id="gate" name="gate" pattern="[0-9]" required>
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