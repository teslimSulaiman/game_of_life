<?php
session_start();
require_once ("include/board.php");

?>
<link rel="stylesheet" type="text/css" href="css/customStyle.css">
<?php 
 $gosperGliderGun = array(
      array(1, 25),  array(2, 25),  array(2, 23), array(3,21),
      array(3,22),  array(4, 21), 
      array(4, 22), array(5, 21), array(5, 22),
      array(6, 23), array(6,25), array(7,25),
      array(3,36), array(4,36), array(3,35), 
      array(4,35), array(5,1), array(5,2),
      array(6,1),array(6,2), array(3,13),
       array(3,14),
      array(4,12), array(5,11), array(6,11),
      array(7,11), array(8,12), array(9,13),
      array(9,14), array(8,16),array(7,17),
      array(6,17), array(5,17),array(4,16),
      array(6,15),array(6,18) );
if (isset($_POST['submit'])) {
	$input = $_POST['gameInput'];
	if($input == "random"){
		$board = new Board(38,38,"random");
	}else if($input = "gosperGliderGun"){
		$board = new Board(38,38,"gun", $gosperGliderGun);
	}

	?>
	<div align="center" margin-top="40px" id="board">
		<?php 
    echo $board->generateBoard(); 
    $board->moveToNextStage();
    ?>
		<div id="iterationNumber" align="center">1</div>
	</div>
	
<?php 
$_SESSION['board'] = $board;
$_SESSION['counter'] = 1;	
}
?>
	<p align="center" ><a  href="index.php">Play Another game</a></p>

	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Custom JavaScript -->
    <script src="js/callNextState.js"></script>