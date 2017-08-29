<?php
require_once 'model/Game.php';

session_start();

$gameSetup = isset($_SESSION["game-setup"]) ? $_SESSION["game-setup"] : null;
// Ha nincsenek a sessionben a jatek beallitasok, akkor a beallitasok.php oldalra visszadobjuk a usert.
if (!$gameSetup) {
    header('Location: beallitasok.php');
    exit();
}

$player_1 = $gameSetup["babu1"];
$player_2 = $gameSetup["babu2"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Index</title>
        
        <link rel="stylesheet" type="text/css" href="css/foglalos-jatek.css">
    </head>
    <body id="foglalos-index">
        <?php if (isset($_SESSION[Game::SK_CREATION_FAILED])) { ?>
            <div class="error-msg"><?php echo "Az X és Y " . Game::MIN_DIM . " és " . Game::MAX_DIM . " között lehet. A player nevek nem lehetnek üresek. "; ?></div>
            <?php
            // Unseteljuk ki a hibauzenetet, miutan megjelent.
            unset($_SESSION[Game::SK_CREATION_FAILED]);
        } ?>
            
        <a href="beallitasok.php">Vissza a beállításokhoz</a>
        
        <div class="instruction-div">Add meg a pálya méretét!</div>
        
        <form action="foglalos-jatek.php" method="post">
            X: <input type="text" name="<?php echo Game::PK_X; ?>" value="10"><br>
            Y: <input type="text" name="<?php echo Game::PK_Y; ?>" value="10"><br>
            
            Player 1: <input readonly type="text" name="<?php echo Game::PK_PLAYER_1_NAME; ?>" value="<?php echo $player_1; ?>"><br />
            Player 2: <input readonly type="text" name="<?php echo Game::PK_PLAYER_2_NAME; ?>" value="<?php echo $player_2; ?>"><br />
            
            <input name="start-btn" type="submit" value="Start">
        </form>
    </body>
</html>

