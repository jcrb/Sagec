<?php
if($_GET["dwn"])
{/*
	// ob_clean();// Vide le buffer (v >= 4.2)
	// Dialogue de téléchargement
	header("content-type: application/octet-stream");
	// seulement pour application/octet-stream !
	header("Content-Disposition: attachment; filename=".$_GET["dwn"]);
	// Ouvrir avec MSWord
	// header("content-type: application/msword");
	// Ouvrir avec MSExcel
	// header("content-type: application/vnd.ms-excel");
	// Ouvrir en Text
	// header("content-type: text/plain");
	// voir aussi http://dev.nexen.net/scripts/details.php?scripts=354
	flush();// Envoie le buffer
	readfile($_GET["dwn"]);// Envoie le fichier
*/
	$type = "text/plain";
 	header("Content-disposition: attachment; filename=$_GET[dwn]");
 	header("Content-Type: application/force-download");
 	header("Content-Transfer-Encoding: $type\n"); // Surtout ne pas enlever le \n
 	header("Content-Length: ".filesize($_GET['dwn']));
 	header("Pragma: no-cache");
 	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, public");
 	header("Expires: 0");
 	readfile($_GET['dwn']);
}
else
{
print("<A HREF = \"download2.php?dwn=archive1.txt\">Test</A><BR>");
}
?>
