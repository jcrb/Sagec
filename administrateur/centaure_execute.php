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
//	programme: 		centaure_execute.php
//	date de création: 	07/05/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier Centaure dans une table
//	version:			1.0
//	maj le:			07/05/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaires_table.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

require("utilitaire_upload.php");
global $smur;
global $sdis;
global $apa;
global $conseil;
global $med;
//$nom_destination = '725.txt';
//move_uploaded_file($tmp, $nom_destination);
print("<br>");

function initialise()
{
	$smur = 0;
	$sdis = 0;
	$apa = 0;
	$conseil = 0;
	$med = 0;
	$date_courante ="";
}
function affiche($date,$primaires,$secondaires,$apa,$smur,$sdis,$med,$conseil)
{
	print("<br>Résumé des données<br>");
	print("<table border=\"1\">");
		print("<tr><td>date</td><td>".$date."</td></tr>");
		print("<tr><td>primaires</td><td>".$primaires."</td></tr>");
		print("<tr><td>secondaires</td><td>".$secondaires."</td></tr>");
		print("<tr><td>ASSU</td><td>".$apa."</td></tr>");
		print("<tr><td>SMUR</td><td>".$smur."</td></tr>");
		print("<tr><td>VSAV</td><td>".$sdis."</td></tr>");
		print("<tr><td>Médecins</td><td>".$med."</td></tr>");
		print("<tr><td>Conseils</td><td>".$conseil."</td></tr>");
	print("</table>");
}
function enregistre($timestamp,$service,$primaires,$secondaires,$apa,$smur,$sdis,$med,$conseil)
{
	//enregistrement dans la table
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	//$service = '1';
	$requete = "SELECT * FROM veille_samu WHERE date='$timestamp' AND service_ID = '$service'";
	//print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	$num_rows = mysql_num_rows($resultat);
	//print($num_rows."<br>");
	if($num_rows == 0)
		$requete="INSERT INTO veille_samu VALUES(
					'',
					'$timestamp',
					'$service',
					'',
					'$primaires',
					'$secondaires',
					'',
					'',
					'$apa',
					'$sdis',
					'$conseil',
					'$med',
					'$_SESSION[member_id]'
					)";
	else
		$requete="UPDATE veille_samu SET
					nb_primaires = '$primaires',
					nb_secondaires = '$secondaires',
					nb_apa = '$apa',
					nb_vsav = '$sdis',
					conseils = '$conseil',
					nb_med = '$med',
					ID_utilisateur = '$_SESSION[member_id]'
					WHERE date='$timestamp' AND service_ID = '$service'";
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
}

if($erreur==0)
{
	//$table = $_POST['table'];
	//$requete = "SHOW COLUMNS FROM $table";
	//$resultat = ExecRequete($requete,$connexion);

	//print("ouverture du fichier<br>");
	$fp=fopen($tmp,"r");
	// vérification du fichier
	$mot = fgets($fp,4096);
	$mot = substr($mot, 0, strlen($mot)-1);// enlève le caractère fin de ligne
	$mot = trim($mot);
	if($mot == 'Réponse SAMU 67') //analyse uniquement les fichiers commençants par
	{
		//initialise();
		$smur = 0;
		$sdis = 0;
		$apa = 0;
		$conseil = 0;
		$med = 0;
		$intervention[1]=0;
		$intervention[2]=0;
		$date_courante ="";
		$service = $_SESSION['service'];
		while(!feof($fp))
		{
			$mot = fgets($fp,4096);
			$mot = substr($mot, 0, strlen($mot)-1);// enlève le caractère fin de ligne
			$mot = trim($mot);
			if(strlen($mot)> 0) // éviter les enregistrements vides
			{
				if($mot=="Primaire") $p = 1;
				else if($mot=="Transfert") $p = 2;
				else if(strpos($mot, '/')!= 0)// c'est une date
				{
					if($date_courante=="")
					{
						$date_courante = $mot;
						$date = $mot;
						print("date courante: ".$date_courante."<br>");
					}
					else
					{
				affiche($date_courante,$intervention[1],$intervention[2],$apa,$smur,$sdis,$med,$conseil);
				enregistre($timestamp,$service,$intervention[1],$intervention[2],$apa,$smur,$sdis,$med,$conseil);
						$smur = 0;
						$sdis = 0;
						$apa = 0;
						$conseil = 0;
						$med = 0;
						$intervention[1]=0;
						$intervention[2]=0;
						$date_courante = $mot;
						$date = $mot;
						print("date courante: ".$date_courante."  date: ".$date."<br>");
					}
					$rub = explode("/",$mot);
					$valid = checkdate($rub[1],$rub[2],$rub[0]);
					if($valid)
					{
						echo "date valide";
						$timestamp = mktime(0,0,0,$rub[1],$rub[2],$rub[0]);
					}
					else{
						echo "date invalide";
						exit(0);
					}
					print("<br>");
				}
				else{
					print("-> ".$mot."<br>");
					$rub = explode("\t",$mot);
					switch($rub[0])
					{
						case 'Ambulance catégorie A':$apa+=$rub[1];break;
						case 'Ambulance de garde':$apa+=$rub[1];break;
						case 'Ambulance privee':$apa+=$rub[1];break;
						case 'Conseil médical':$conseil+=$rub[1];break;
						case 'Maison médicale de l\'Asum':$med+=$rub[1];break;
						case 'Medecin':$med+=$rub[1];break;
						case 'SOS Médecins':$med+=$rub[1];break;
						case 'SMUR autres':$intervention[$p]+=$rub[1];$smur+=$rub[1];break;
						case 'SMUR Strasbourg':$intervention[$p]+=$rub[1];$smur+=$rub[1];break;
						case 'VSAB':$sdis+=$rub[1];break;
					}
				}
			}
		}
	}
	affiche($date_courante,$intervention[1],$intervention[2],$apa,$smur,$sdis,$med,$conseil);
	enregistre($timestamp,$service,$intervention[1],$intervention[2],$apa,$smur,$sdis,$med,$conseil);
	fclose($fp);
}
?>
