<?php

require_once ("cell.php"); 

class Board 
{
	private $randomizedBoard = "random";
	function __construct($width, $height, $type, $inputCells = false)  {
    $this->width = $width;
    $this->height = $height; 
    $this->type = $type;
	$this->cells = $this->populateCells($this->type, $inputCells);
			
	}

	public function populateCells($boardType, $inputCells = false ) {
	$cells = array();
	if($boardType == $this->randomizedBoard)
	{
		$cells = $this->populateRandomCells();
	}
	else
	{
		$cells = $this->populatePredeterminedCells($inputCells);
	}

	return $cells;
    }

    public function moveToNextStage(){

    	for ($x = 0; $x < $this->height; $x++) {
    	   		
 	     for ($y = 0; $y < $this->width; $y++) {
 	     	$cell = $this->cells[$x][$y];
 	     	$validNeighbours = $this->getNeighbours($cell);
 	     	$population = $this->getPopulation($validNeighbours);
 	     	$nextValue = $this->getNextStateOfCell($population, $cell);
 	     	$cell->nextState = $nextValue;
 	     	}
 	     }

 	     $this->updateCurrentState();
    }

    public function getNextStateOfCell($population, $cell){
    	if ($cell->currentState == 1 && $population < 2) { 
        		return  0;
      	} else if ($cell->currentState ==1 &&  $population > 3) {
        		return  0;
    	}else if ($cell->currentState ==0 && $population == 3) {
        		return  1;
        }
    	else return $cell->currentState;

    }

    public function updateCurrentState(){
    	for ($x = 0; $x < $this->height; $x++) {
    	   		
 	     for ($y = 0; $y < $this->width; $y++) {
 	     	$cell = $this->cells[$x][$y];
 	     	$cell->updateStatus();
 	     	}
 	     }
    }

    public function getPopulation($neighbours){
    	$population = 0;
    	foreach ($neighbours as $locationCordinate ) {  
    		$cell = $this->cells[$locationCordinate[0]][$locationCordinate[1]];
    		$population += $cell->currentState;
    	}
    	return $population;
    }

    public function getNeighbours($cell){
    	$directions = array(
      array(-1, 1),  array(0, 1),  array(1, 1), 
      array(-1, 0),                array(1, 0), 
      array(-1, -1), array(0, -1), array(1, -1) 
    );
    	$neighbours = array();
    	foreach ($directions as $key ) {
    		$neighbor = array($cell->x + $key[0], $cell->y + $key[1]);
    		if($this->isCellValidNeighbor($neighbor))
    		{
    			$neighbours[] = $neighbor;
    		}
    	}

    	return $neighbours;

    }


    public function isCellValidNeighbor($cellLocation)
    {
    	if($cellLocation[0] >= $this->width || $cellLocation[1] >= $this->height )
    	 return false;
    	if($cellLocation[0] < 0 || $cellLocation[1] < 0 ) return false;
    	return true;
    }

    public function populatePredeterminedCells($inputCells){
    	$stateValues = array();
    	$stateValues = $this->populateCellsWithZeros();
    	$lifeValues = $this->setStateOfCellsToLife($stateValues, $inputCells);
    	return $this->addCells($lifeValues);
    }

    public function addCells($lifeValues){
    	$cells = array();
    	for ($x = 0; $x < $this->height; $x++) {
    	   		$cellsLevel = array();
 	     for ($y = 0; $y < $this->width; $y++) {
 	     		$cellState = $lifeValues[$x][$y];
 	     	
 	     	$cell =  new Cell($x,$y, $cellState );
 	     	$cellsLevel[] = $cell;

    	 }
    	    $cells[] = $cellsLevel;
    	}
    	return $cells;

    }

    public function setStateOfCellsToLife($values,$inputCells){

    	foreach ($inputCells as $key ) {
    		
    		$values[$key[0]][$key[1]] = 1;
    		
    	}
    	return $values;

    }

    public function populateCellsWithZeros(){
    	$stateValues = array();
    	for($x =0; $x < $this->height; $x++){
    		for($y =0; $y < $this->width; $y++){

    			$stateValues[$x][$y] = 0;
    		}
    	}
    	return $stateValues;
    }

    public function populateRandomCells()
    {
    		$cells = array();
    	for ($x = 0; $x < $this->height; $x++) {
    	   		$cellsLevel = array();
 	     for ($y = 0; $y < $this->width; $y++) {
 	     	$cellState = rand(0,1);
 	     	$cell =  new Cell($x,$y, $cellState );
 	     	$cellsLevel[] = $cell;

    	 }
    	    $cells[] = $cellsLevel;
    	}
    	return $cells;
 
    }
    
    public function generateBoard(){
    	$output = '<table >';
    	for ($x = 0; $x < $this->height; $x++) {
    		$output .=  "<tr>";
    	   		
 	     	for ($y = 0; $y < $this->width; $y++) {
 	     		$cell = $this->cells[$x][$y];
 	     		 if($cell->isAlive()){
		  			
          			$output .=  '<td class="alive"></td>';
          		}else {
          			$output .=  '<td class="dead"></td>';
          		}
          	}
          	$output .=  '</tr>';
 	     }
 	     $output .=  '</table>';
         return $output;
    }
    
}