<?php
require_once 'db_connectie.php';

$db = maakVerbinding();
$query = "select * from test";
// $query = "select uid from medewerkers where password = '" .$hash. "' and naam = '" .$username. "'";

$stmt = $db->prepare($query);
$stmt->execute();

$username = '';
$password = '';
$hash = '';

$melding = 'De inlog gegevens zijn onjuist.';
$salt = 'dfghbgtfvghbnjhbvdsde325rt678ikjhgfr';
$hashed = '$2y$10$5NSz6tecv4h4wVWyXi0Pvuu/y.XFvztBRGJdNi347mdo1HQw3HKz2';

if(isset($_POST['inloggen'])){
    if(!empty($_POST['gebruikersnaam'])){
        $username = $_POST['gebruikersnaam'];

        require_once 'tagremover.php';
        $username = strip($username);
    }
    if(!empty($_POST['wachtwoord'])){
        $password = $_POST['wachtwoord'];
        $password = $password . $salt;
        $hash = password_hash($password, PASSWORD_DEFAULT);
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
            <form action="inloggen.php" method="post">           
                <div class="Login">
                  <label><b>gebruikersnaam</b></label> <br>
                  <input type="text" name="gebruikersnaam"  value="<?=$username?>" required>
                    <br>
                  <label><b>wachtwoord</b></label> <br>
                  <input type="password" name="wachtwoord" required>
                  <br>
                  <input type="submit" id="opslaan" name="inloggen" value="inloggen">
                </div>
            </form>
            <?= $hash ?>
        </main>
    </body>
</html>