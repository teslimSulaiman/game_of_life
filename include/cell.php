<?php

class Cell 
{
	public $currentState;
	public $x;
	public $y;
	public $nextState;
	function __construct($x, $y, $currentState = 0)
	{
		$this->x = $x;
    	$this->y = $y;
    	$this->currentState = $currentState;
    	$this->nextState = $currentState;
    	
	}
	public function updateStatus(){
		$this->currentState = $this->nextState;
	}

	public  function isAlive(){
        if($this->currentState == 0) 
        	return false;
        else return true;
    }

}