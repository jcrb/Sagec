<?php
/*
	hop_checked.php
	*/
	session_start();
	print('hello');
	$id = $_REQUEST['id'];
	
	$fp=fopen("../../fichier.txt", "w"); //ouverture du fichier en mode écriture, création du fichier s'il n'existe pas.
	fwrite($fp,$id); // insert le texte: Un texte dans votre fichier. 
	fclose($fp);
	print($id);
	return true;

?>
