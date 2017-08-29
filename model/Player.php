<?php

class Player 
{
    protected $name;
    protected $index;
    
    public function __construct($name, $index) 
    {
        $this->name  = $name;
        $this->index = $index;
    }
    
    public function getName() {return $this->name;}
    public function getIndex() {return $this->index;}
}
