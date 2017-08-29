<?php

// @todo kikommentezni, ha kesz vagyok
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once 'model/Game.php';

session_start();
//session_unset();

//echo "<pre>";
//print_r($_POST);

// A foglalos-index.php oldalrol jottunk, most indul a jatek.
if (isset($_POST["start-btn"])) {
    // Ha nem validak a posztolt adatok, nem tudjuk elinditani a jatekot. Dobjuk vissza a foglalos-index.php-ra a usert.
    if (!Game::isPostValidOnCreate()) {
        header('Location: foglalos-index.php');
        exit();
    }
    
    $game = new Game();
}
// Megnezzuk, hogy a sessionben van-e jatek es onnan toltjuk vissza.
else if (Game::isExist()) {
    $game = Game::get();
    $game->nextRound();
}
// Ha nincs jatek elmentve a sessionben, es nem az foglalos-index.php oldalrol jovunk,
// akkor valami gond lehet. Dobjuk vissza a foglalos-index.php-ra a usert.
else {
    header('Location: foglalos-index.php');
    exit();
}

//echo "<pre>";
//print_r($game);

$gameSetup              = $_SESSION["game-setup"];
$tileBackgroundColorCss = $gameSetup["hatterszin"];

// Visszamentjuk a sessionbe a jatekot.
Game::save($game);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Jatek</title>
        
        <link rel="stylesheet" type="text/css" href="css/foglalos-jatek.css">
        <style>
            #foglalos-jatek .board .row:nth-child(odd) .tile:nth-child(even) input,
            #foglalos-jatek .board .row:nth-child(even) .tile:nth-child(odd) input{
                background-color: <?php echo $tileBackgroundColorCss; ?>;
            }
        </style>
    </head>
    <body id="foglalos-jatek">
        <a class="new-game" href="foglalos-index.php">New Game</a>
        
        <div>szélesség: <?php echo $game->getWidth(); ?> magasság: <?php echo $game->getHeight(); ?></div>
        <div>lépésszám: <?php echo $game->getStepCount(); ?></div>
        
        <div class="players-wrapper">
            <div class="players">
                <?php foreach ($game->getPlayers() as $onePlayer) { 
                    $currentPlayerClass = $onePlayer == $game->getCurrentPlayer() ? "current" : ""; ?>
                    <span class="<?php echo $currentPlayerClass; ?>">Player <?php echo $onePlayer->getIndex() . ": " . $onePlayer->getName(); ?></span>
                <?php } ?>
            </div>
        </div>
     
        <?php if ($game->isEnd()) { ?>
            <div>A játék véget ért. A nyertes: <?php echo $game->getWinner()->getName();  ?></div>
        <?php } ?>
        
        <form action="foglalos-jatek.php" method="post">
            <table class="board">
            <?php for ($y = 0; $y < $game->getHeight(); $y++) { ?>
                <tr class="row">
                 <?php for ($x = 0; $x < $game->getWidth(); $x++) { 
                     $disabled = $game->isTileEnabled($x, $y) ? "" : "disabled"; ?>
                    
                    <td class="tile <?php echo $disabled; ?>">
                        <input name="<?php echo Game::PK_TILE . $x . "_" . $y; ?>" type="submit" value="" <?php echo $disabled; ?> />
                    </td>
                <?php } ?>
                </tr>
           <?php } ?>
           </table>
        </form>
    </body>
</html>

