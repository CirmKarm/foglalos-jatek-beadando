<?php

class Tile 
{
    protected $x;
    protected $y;
    protected $isEnabled;
    
    public function __construct($x, $y) 
    {
        $this->x         = $x;
        $this->y         = $y;
        $this->isEnabled = 1;
    }
    
    public function getX() {return $this->x;}
    public function getY() {return $this->y;}
    public function isEnabled() {return $this->isEnabled;}

    public function unsetEnabled() {$this->isEnabled = 0;}
}
