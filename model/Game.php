<?php

require_once 'Tile.php';
require_once 'Player.php';

class Game 
{
    const MAX_DIM = 50;
    const MIN_DIM = 3;
    
    /** SK = session key */
    const SK_GAME            = "game";
    const SK_CREATION_FAILED = "creation-failed";
    
    /** PK = post key */
    const PK_X             = "x";
    const PK_Y             = "y";
    const PK_PLAYER_1_NAME = "player-1-name";
    const PK_PLAYER_2_NAME = "player-2-name";
    const PK_TILE          = "tile_";
    
    protected $width;
    protected $height;
    /** @var Tile[] */
    protected $tiles;
    /** @var Player[] */
    protected $players;
    protected $stepCount;

    public function __construct() 
    {
        $this->width     = $_POST[self::PK_X];
        $this->height    = $_POST[self::PK_Y];
        $this->stepCount = 0;
        
        $this->tiles = array();
        for ($i = 0; $i < $this->width; $i++) {
            for ($j = 0; $j < $this->height; $j++) {
                $this->tiles[] = new Tile($i, $j);
            }
        }
        
        // A jobb felso sarkot kattinthatatlanra allitja.
        $this->getTileByCoordinates($this->width - 1, 0)->unsetEnabled();
        
        $this->players = array();
        $this->players[] = new Player($_POST[self::PK_PLAYER_1_NAME], 1);
        $this->players[] = new Player($_POST[self::PK_PLAYER_2_NAME], 2);
    }
     
    public static function isPostValidOnCreate()
    {
        $_POST[self::PK_PLAYER_1_NAME] = trim($_POST[self::PK_PLAYER_1_NAME]);
        $_POST[self::PK_PLAYER_2_NAME] = trim($_POST[self::PK_PLAYER_2_NAME]);
        
        $isValid = isset($_POST[self::PK_X]) && $_POST[self::PK_X] >= self::MIN_DIM && $_POST[self::PK_X] <= self::MAX_DIM
            && isset($_POST[self::PK_Y]) && $_POST[self::PK_Y] >= self::MIN_DIM && $_POST[self::PK_Y] <= self::MAX_DIM
            && !empty($_POST[self::PK_PLAYER_1_NAME]) 
            && !empty($_POST[self::PK_PLAYER_2_NAME]);
        
        if (!$isValid) {
            $_SESSION[self::SK_CREATION_FAILED] = 1;
        }
        
        return $isValid;
    }
    
    public function getWidth() {return $this->width;}
    public function getHeight() {return $this->height;}
    public function getStepCount() {return $this->stepCount;}
    public function getPlayers(){return $this->players;}
    
    public function incrementStepCount(){$this->stepCount++;}

    /**
     * @return Tile
     */
    public function getTileByCoordinates($x, $y)
    {
        foreach ($this->tiles as $tile) {
            if ($tile->getX() == $x && $tile->getY() == $y) {
                 return $tile;
            }
        }
    }
    
    public function isTileEnabled($x, $y)
    {
        return $this->getTileByCoordinates($x, $y)->isEnabled();
    }
    
    public function tileClicked($x, $y)
    {
        foreach ($this->tiles as $tile) {
            if ($tile->getX() <= $x && $tile->getY() >= $y) {
                 $tile->unsetEnabled();
            }
        }
        
        $this->incrementStepCount();
    }
    
    public function isEnd()
    {
        foreach ($this->tiles as $tile) {
            if ($tile->isEnabled()) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * @return Player
     */
    public function getCurrentPlayer()
    {
        return $this->stepCount % 2 == 0 ? $this->players[0] : $this->players[1]; 
    }
    
    public function nextRound()
    {
        // Kideritjuk melyik tile lett megkattintva.
        // Vegig kell menni a $_POST valtozon, mivel a kulcs mindig mas.
        $x             = null;
        $y             = null;
        $isTileClicked = false;
        foreach ($_POST as $key => $val) {
            // Megtalaltuk a "tile_" szot a $_POST valtozo kulcsaban. pl.: tile_2_7
            if (strpos($key, self::PK_TILE) !== false) {
                $isTileClicked = true;
                // Szetrobbantjuk a kulcsot az "_" menten.
                $exploded = explode("_", $key);
                $x        = $exploded[1]; 
                $y        = $exploded[2];
            }
        }

        if ($isTileClicked) {
            // X es Y koordinatak alapjan elvegezzuk a kattintast.
            // A biztonsag kedveert leelenorizzuk, hogy meg lett-e mar kattintva.
            if ($this->isTileEnabled($x, $y)) {
                $this->tileClicked($x, $y);
            }
        }
    }
    
    /**
     * A gyoztes nem a getCurrentPlayer hanem a masik, mivel o mar nem tud lepni.
     * @return Player
     */
    public function getWinner()
    {
        return $this->getCurrentPlayer() == $this->players[0] ? $this->players[1] : $this->players[0];
    }

    public static function isExist()
    {
        return isset($_SESSION[self::SK_GAME]);
    }
    
    public static function get()
    {
        return $_SESSION[self::SK_GAME];
    }
    
    public static function save($game)
    {
        $_SESSION[self::SK_GAME] = $game;
    }
}
