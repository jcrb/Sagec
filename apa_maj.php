<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
/**																										
*	programme: 			apa_maj.php																	 	 
*	date de cr�ation: 	09/09/2003																		
*	auteur:				jcb																				 
*	description:		Enregistre les modification d'�tat des APA
*						et tient � jour le journal des modifications								 											
*	@version $Id$																				 
*	maj le:				22/10/2003																		
*/																										 
//---------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_apa'])header("Location:langue.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$back = $_REQUEST['back']; /* adresse de retour*/
$date_maj = date("Y-m-j H:i:s");

$requete = "SELECT Vec_ID,Vec_Etat FROM vecteur WHERE org_ID = '$_SESSION[organisation]'";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$id = $rub[Vec_ID];
	if(isset($_REQUEST[$id]) && $_REQUEST[$id]=="on")// la case est coch�e 
	{
		if($rub[Vec_Etat] != 2)// la valeur 2 correspond � un vecteur disponible
		{ 
			$requete = "INSERT INTO apa_journal values('','$id','2','$date_maj')"; 
			ExecRequete($requete,$connexion);
		}
		$requete="UPDATE vecteur SET Vec_Etat = '2' WHERE Vec_ID = '$id'";
		ExecRequete($requete,$connexion);
		//print("Request: ".$requete."<br>");
	}
	else // la case n'est pas coch�e ou a �t� d�coch�e 
	{
		if($rub[Vec_Etat] != 1)// la valeur 1 correspond � un vecteur indisponible
		{ 
			$requete = "INSERT INTO apa_journal values('','$id','1','$date_maj')"; 
			ExecRequete($requete,$connexion);
		}
		$requete="UPDATE vecteur SET Vec_Etat = '1' WHERE Vec_ID = '$id'";
		ExecRequete($requete,$connexion);
	}
}
@mysql_free_result($resultat);

/*
// lit l'�tat des v�hicules dans un tableau
$apa = array();
$requete = "SELECT Vec_ID,Vec_Etat FROM vecteur WHERE org_ID = '$_SESSION[organisation]'";
//print($requete."<BR>");
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$apa[$rub[Vec_ID]] = $rub[Vec_Etat];
}
@mysql_free_result($resultat);

$date_maj = date("Y-m-j H:i:s");
// tous les vecteurs d'une m�me organisation sont remis � indisponibles (1)
$requete="UPDATE vecteur SET Vec_Etat = '1',Vec_Maj = '$date_maj' WHERE org_ID = '$_SESSION[organisation]'";
//print($requete."<BR>");
$resultat = ExecRequete($requete,$connexion);
// puis tous ceux qui sont coch�s sont mis � disponible
//print("n = ".count($_POST['m'])."<BR>");
for($i=0;$i<count($_POST['m']);$i++)
{
	$j = $_POST['m'][$i]; 
	$requete="UPDATE vecteur SET Vec_Etat = '3' WHERE Vec_Nom = '$j'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>\n");
}
// lit le nouvel �tat des v�hicules dans un tableau $apa2
$apa2 = array();
$requete = "SELECT Vec_ID,Vec_Etat FROM vecteur WHERE org_ID = '$_SESSION[organisation]'";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$apa2[$rub[Vec_ID]] = $rub[Vec_Etat];
}
// on remet le pointeur en d�but de tableau
reset($apa2);
reset($apa);
// on compare les enregistrements identiques des 2 tableaux pour voir si une
// maj est n�cessaire
//echo $date_maj;
//echo "<BR>";
while($i = each($apa2))
{
	$j = each($apa);
	if( $i["value"] <> $j["value"])
	{
		//echo "mettre � jour enregistrement ";
		//echo $i["key"];
		//echo " avec la valeur ";
		//echo $i["value"];
		$vecteur = $i["key"];
		$etat = $i["value"];
		$requete = "INSERT INTO apa_journal values('','$vecteur','$etat','$date_maj')";
		$resultat = ExecRequete($requete,$connexion);
	}
	else
	{
		//echo $i["key"];
		//echo " pas de mise � jour ";
	}
	//echo "<BR>";
}
*/
header("Location:apa.php");

?>
