<?php
require dirname(dirname(__FILE__)) .DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PHPUnit\Framework\TestCase;
require_once ("../include/board.php"); 
require_once("HTML5Validate/HTML5Validate.php");
/**
* 
*/
class BoardTest extends TestCase
{
	
	public function testPopulateCells()
	{
		$randomBoard = new Board(5,5,"random");
		$this->assertNotNull(
			$randomBoard->populateCells("random"),
			'cells must be created and null not returned');
	}

	/**
	*	@dataProvider provideCells
	*/
	public function testMoveToNextStage($items, $expected){
		$predeterminedBoard = new Board(5,5,"determined",array(array(1, 2)),(array(1, 3)),
			(array(2, 2)), (array(0, 1)), (array(0, 2)), (array(0, 3)));
		$predeterminedBoard->moveToNextStage();
		$cell = $items;
		
		$this->assertEquals($expected,
			$cell->currentState,
			"current state must be {$expected}");
	}
	public function provideCells(){
		$predeterminedBoard = new Board(5,5,"determined",array(array(1, 2)),(array(1, 3)),
			(array(1, 1)), (array(0, 1)), (array(0, 2)), (array(0, 3)) );
		return [
		[$predeterminedBoard->cells[0][0],0],
		[$predeterminedBoard->cells[0][2],0]
		];
	}
	public function testGetNextStateOfCell(){
		$predeterminedBoard = new Board(5,5,"random");
		$population = 3;
		$cell = new Cell(2,3,0);
		$nextState = $predeterminedBoard->getNextStateOfCell($population, $cell);
		
		$this->assertEquals(1,
			$nextState,
			'next state must be 1');
		
	}

	public function testUpdateCurrentState(){
		$randomBoard = new Board(5,5,"random");
		$cell = $randomBoard->cells[0][0];
		$cell->nextState =1;
		$randomBoard->updateCurrentState();
		$this->assertEquals(1,
			$cell->currentState,
			'current state must be updated to 1');
	}

	public function testGetPopulation(){
		$predeterminedBoard = new Board(5,5,"determined",array(array(1, 2), array(1, 3),array(2, 2), array(3, 2)));
		$neighbours = array(array(1, 2), array(1, 3),array(2, 2));
		$neighboursCount = $predeterminedBoard->getPopulation($neighbours);
		$this->assertEquals(3,
			$neighboursCount,
			'three neighbours are counted');

	}

	public function testGetNeighbours(){
		$predeterminedBoard = new Board(5,5,"determined",array(array(1, 2), array(1, 3),array(2, 2), array(0, 0)));
		$cell = new Cell(0,0,0);
		$validNeighbours = $predeterminedBoard->getNeighbours($cell);
		$validNeighboursCount = count($validNeighbours);
		$this->assertEquals(3,
			$validNeighboursCount,
			'valid neighbours should be three');
	}

	public function testIsCellValidNeighbor(){
		$randomBoard = new Board(5,5,"random");
		$location = array(6, 5);
		$validity = $randomBoard->isCellValidNeighbor($location);
		$this->assertEquals(false,
			$validity,
			'validity is must not be true for the given location');
	}

	public function testPopulatePredeterminedCells(){
		$predeterminedBoard = new Board(5,5,"determined",array(array(1, 2), array(1, 3),array(2, 2), array(0, 0)));
		$cells = $predeterminedBoard->populatePredeterminedCells(array(array(0, 0)));
		$this->assertNotNull(
			$cells,
			'cells must be created and null not returned');

	}

	public function testAddCells(){
		$predeterminedBoard = new Board(3,3,"determined",array());

		$cells = $predeterminedBoard->addCells(array(array(1, 0,1),array(0,1,0),array(1,1,0)));
		$cellsCount = count($cells) * count($cells);
		$this->assertEquals(9,
			$cellsCount,
			'nine  new cells added');

	}
	public function testSetStateOfCellsToLife(){
		$predeterminedBoard = new Board(5,5,"determined",array());
		$input = array(array(1, 2), array(1, 3),array(2, 2), array(0, 0));
		$cells = array();
		$cells = $predeterminedBoard->setStateOfCellsToLife($cells, $input);
		$cellLifeState = $cells[1][2];
		$this->assertEquals(1,
			$cellLifeState,
			'cell must be alive with state value of 1');
	}

	public function testPopulateCellsWithZeros(){
		$predeterminedBoard = new Board(5,5,"determined",array());
		$cells = $predeterminedBoard->populateCellsWithZeros();
		$valuesSum = array_sum($cells);
		$this->assertEquals(0,
			$valuesSum,
			'all cells must have zero as sum of their lifes');	

	}

	public function testPopulateRandomCells(){
		$randomBoard = new Board(5,5,"random");
		$this->assertNotNull(
			$randomBoard->populateRandomCells("random"),
			'cells must be created and null not returned');
	}

	public function testGenerateBoard(){
		$randomBoard = new Board(5,5,"random");
		$validator = new HTML5Validate();
		$result =  $validator->Assert($randomBoard->generateBoard());
		$this->assertTrue($result, $validator->message);
		
	}
}

