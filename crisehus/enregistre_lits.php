<?php
/**
*	enregistre_lits.php
*/
  $backPathToRoot = "../";
  include_once($backPathToRoot"login/init_security.php");

$uf=$_REQUEST[uf];
foreach($uf as $val=>$ID)
	print($val." ".$ID."<br>");
print("<br>");

$lits_t0=$_REQUEST[lits_t0];
foreach($lits_t0 as $val=>$ID)
	print($val." ".$ID."<br>");
print("<br>");

$lits_t1=$_REQUEST[lits_t1];
foreach($lits_t1 as $val=>$ID)
	print($val." ".$ID."<br>");
print("<br>");

$lits_t2=$_REQUEST[lits_t2];
foreach($lits_t2 as $val=>$ID)
	print($val." ".$ID."<br>");
print("<br>");

$lits_t3=$_REQUEST[lits_t3];
foreach($lits_t3 as $val=>$ID)
	print($val." ".$ID."<br>");
print("<br>");

$lits_t4=$_REQUEST[lits_t4];
foreach($lits_t4 as $val=>$ID)
	print($val." ".$ID."<br>");
print("<br>");
?>