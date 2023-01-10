<?php
// uitgevoerde code is OG-03
// database connectie
require_once 'db_connectie.php';

$db = maakVerbinding();
// variabelen die nodig zijn
$username = '';
$password = '';
$hash = '';

// wachtwoord toevoeging
$salt = 'dfghbgtfvghbnjhbvdsde325rt678ikjhgfr';

// standaard melding
$melding = '';


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
    }
    
    // query om medewerker te vinden
    $query = "select password, uid from Medewerkers where naam = :username";

    $stmt = $db->prepare($query);
    $stmt->execute([":username" => $username]);

    // zorgen dat de gegevens kloppen
    $resultaat = $stmt->fetch();
    if($resultaat) { 
        if (password_verify($password, $resultaat["password"])){
            $_SESSION["user"] = $resultaat["uid"];
            session_start();
            header('Location: mainmenuMW.php');
        }else{ 
        $melding = "verkeerde inloggegevens!";
        } 
    }else{
            $melding = 'Oeps! er is iets verkeerd gegaan ';
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
            <?php echo $melding ?>
        </main>
    </body>
</html>