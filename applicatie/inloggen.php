<?php
// uitgevoerde code is OG-03
// database connectie
require_once 'db_connectie.php';

$db = maakVerbinding();
// variabelen die nodig zijn
$username = '';
$password = '';
$hash = '';

// standaard melding
$melding = 'De inlog gegevens zijn onjuist.';

// wachtwoord toevoeging
$salt = 'dfghbgtfvghbnjhbvdsde325rt678ikjhgfr';

if(isset($_POST['inloggen'])){
    if(!empty($_POST['gebruikersnaam'])){
        $username = $_POST['gebruikersnaam'];

        // SQL injectie verkomen
        require_once 'tagremover.php';
        $username = strip($username);
    }
    if(!empty($_POST['wachtwoord'])){
        $password = $_POST['wachtwoord'];

        // SQL injectie verkomen
        require_once 'tagremover.php';
        $password = strip($password);
        // toevoeging voor de wachtwoord
        $password = $password . $salt;
        // wachtwoord wordt gehasht
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
    // query om medewerker te vinden
    $query = "select uid from Medewerkers where password = :password and naam = :username";

    $stmt = $db->prepare($query);
    $stmt->execute([':password' => $hash, ':username' => $username]);

    // zorgen dat de gegevens kloppen
    $output=$stmt->fetchAll();

    $hashed_password=$output;

    foreach($hashed_password as $check){    
    var_dump(password_verify($hash, $hashed_password));
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
        </main>
    </body>
</html>