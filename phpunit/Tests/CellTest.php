<?php
require dirname(dirname(__FILE__)) .DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PHPUnit\Framework\TestCase;
require_once ("../include/cell.php"); 

/**
* 
*/
class CellTest extends TestCase
{
	public function setUp(){
		$this->Cell = new Cell(2,3,1); 
	}

	public function tearDown(){
		unset($this->Cell);
	}
	
	public function testIsCellAlive()
	{
		$this->assertEquals(true,
			$this->Cell->isAlive(),
			'when alive true should be returned');
	}

	public function testUpdateStatus(){
		$this->Cell->nextState = 0;
		$this->Cell->updateStatus();
		$this->assertEquals(0,
			$this->Cell->currentState,
			'when updateStatus is called current status is updated to nextState');

	}
}

