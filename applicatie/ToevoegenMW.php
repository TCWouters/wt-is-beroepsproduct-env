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
                <label>voorletters</label>
                <input type="text"  name="voorlet" pattern="[A-Za-z]" required>
                <label>achternaam</label>
                <input type="text"  name="achternaam" pattern="[A-Za-z]" required>
                <label>E-mail</label>
                <input type="email"  name="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                <label>vlucht nummer</label>
                <input type="text" id="vluchtnr" name="vluchtnr" required>
                <label>eind bestemming</label>
                <input type="text" id="eindbestemming" name="eindbestemming" pattern="[A-Za-z]" required>
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
                <button formnovalidate="formnovalidate">Terug</button>
                <input type="submit"> 
            </div>
            </form>
        </main>
    </body>
</html>