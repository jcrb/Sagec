<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		cle_importe_execute.php
//	date de création: 	16/05/2005
//	auteur:			jcb
//	description:		ajoute une clé publique au trousseau
//	version:			1.0
//	maj le:			16/05/2005
//
//--------------------------------------------------------------------------------
/**
 * Documents the class following
 * @package Sagec
 * @author JCB
 */
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//
require('../gnugpg/gnuPG_class.inc');
//
$fichier= $_FILES['fichier']['name'];
$taille= $_FILES['fichier']['size'];
$tmp= $_FILES['fichier']['tmp_name'];
$type= $_FILES['fichier']['type'];
$erreur= $_FILES['fichier']['error'];
/*
echo"Nom originel => $fichier <br />";
echo"Taille => $taille <br />";
echo"Adresse temporaire sur le serveur => $tmp <br />";
echo"Type de fichier => $type <br />";
echo"Code erreur => $erreur. <br />";
*/
/*
*/
//$nom_destination = '725.txt';
//move_uploaded_file($tmp, $nom_destination);
if($erreur==0)
{
	//$gpg = new gnuPG('/usr/bin/gpg', '/var/www/html/sagec3/veille_sanitaire');// SAGEC
	$gpg = new gnuPG('/home1/gnupg/bin/gpg', '/home1/apache/.gnupg');
	$fp=@fopen($tmp,"r");
	$KeyBlock = fread ($fp, filesize ($tmp));
	fclose($fp);
	$k = $gpg->Import($KeyBlock);
	if($k == false){
		include("cle_menue.php");
		print("<br>");
		echo"Echec de l'importation d'une clé publique: ".$gpg->error."<br>";
	}
	else
		header("Location: cle_disponible.php");
}
else
{
	include("cle_menue.php");
	print("<br>");
	echo"Echec de l'importation d'une clé publique:<br>";
	if($err == UPLOAD_ERR_INI_SIZE)
  		echo"Le fichier est plus gros que le max autorisé par PHP";
	elseif($err == UPLOAD_ERR_FORM_SIZE)
		echo"Le fichier est plus gros qu'indiqué dans le formulaire";
	elseif($err == UPLOAD_ERR_PARTIAL)
  		echo"Le fichier n'a été que partiellement téléchargé";
	elseif($err == UPLOAD_ERR_NO_FILE)
  		echo"Aucun fichier n'a été téléchargé.";
}
?>
