<?php
require_once ("include/board.php");

session_start();
?>
<link rel="stylesheet" type="text/css" href="css/customStyle.css">

<?php
$board = $_SESSION['board'];
$counter = $_SESSION['counter'];
echo $board->generateBoard(); 
$board->moveToNextStage();
$_SESSION['board'] = $board;
$_SESSION['counter'] = $counter + 1;
?>
<div id="iterationNumber" align="center"><?php echo $counter + 1?> </div>