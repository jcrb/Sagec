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
//	programme: 		fichier_en_table_execute.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier dans une table
//	version:		1.1
//	maj le:			23/09/2005 Apostrophes
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require "../classe_dessin.php";
require("utilitaires_table.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$fichier= $_FILES['fichier']['name'];
$taille= $_FILES['fichier']['size'];
$tmp= $_FILES['fichier']['tmp_name'];
$type= $_FILES['fichier']['type'];
$erreur= $_FILES['fichier']['error'];

echo"Nom originel => $fichier <br />";
echo"Taille => $taille <br />";
echo"Adresse temporaire sur le serveur => $tmp <br />";
echo"Type de fichier => $type <br />";
echo"Code erreur => $erreur. <br />";

if ($err = $_FILES['fichier']['error']){
	echo"il y a eu une erreur<br>";
	if($err == UPLOAD_ERR_INI_SIZE)
  		echo"Le fichier est plus gros que le max autorisé par PHP";
	elseif($err == UPLOAD_ERR_FORM_SIZE)
		echo"Le fichier est plus gros qu'indiqué dans le formulaire";
	elseif($err == UPLOAD_ERR_PARTIAL)
  		echo"Le fichier n'a été que partiellement téléchargé";
	elseif($err == UPLOAD_ERR_NO_FILE)
  		echo"Aucun fichier n'a été téléchargé.";
} else echo"fichier correctement téléchargé" ;

//$nom_destination = '725.txt';
//move_uploaded_file($tmp, $nom_destination);
print("<br>");
if($erreur==0)
{
	$table = $_POST['table'];
	$requete = "SHOW COLUMNS FROM $table";
	$resultat = ExecRequete($requete,$connexion);
	$num_rows = mysql_num_rows($resultat);
	print($num_rows."<br>");
	if($_POST['opt']==1){
		print("La table ".$table." va être fusionnée avec les données du fichier ".$fichier);
	}
	else {
		print("La table ".$table." va être effacée et remplacée par les données du fichier ".$fichier);
		$requete = "TRUNCATE TABLE $table";
		$resultat = ExecRequete($requete,$connexion);
	}
	print("<br>");
	$fp=@fopen($tmp,"r");
	while(!feof($fp)){
		$mot = fgets($fp,4096);
		if($mot<1)break;// éviter les enregistrements vides
		$mot = str_replace("'","\'",$mot);//protection des apostrophes
		$rub = explode("\t",$mot);
		$requete = "INSERT INTO $table VALUES(";
		for($i = 0; $i < $num_rows;$i++)
			$requete .= "'".$rub[$i]."',";
		$requete = substr($requete,0,strlen($requete)-1);
		$requete .= ")";
		//print($requete."<br>");
		$resultat = ExecRequete($requete,$connexion);
	}
	fclose($fp);
}
?>
