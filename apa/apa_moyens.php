<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//																										 
//	programme: 			apa_moyens.php																	 	 
//	date de cr�ation: 	09/09/2003																		
//	auteur:				jcb																				
//	description:		Affichage et maj des moyens d'une soci�t� d'ambulance
//														 											
//	version:			1.0																				 
//	maj le:				09/09/2003																		
//	@version $Id: apa.php 44 2008-04-16 06:55:34Z jcb $																									 
//---------------------------------------------------------------------------------------------------------
// commentaire: premier fichier mis � jour avec subversion 1.3.0
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["auto_apa"])
{
	print("<H2>Vous n'�tes pas autoris� � acc�der � cette zone</H2><BR>");
	echo "<a href = \"langue.php\"><H1>Continuer</H1></a><br>";
	exit();
}
$backPathToRoot = "../";
require($backPathToRoot."pma_connexion.php");// param�tres priv�s de connexion
require($backPathToRoot."pma_connect.php");// fonction connexion
require $backPathToRoot."utilitaires/requete.php";
include($backPathToRoot."utilitaires/table.php");

//include("html.php");
//include("apa_entete.php");
$back = $backPathToRoot."apa/apa_moyens.php";
$org_type = $_SESSION["organisation"];
?>
<HTML>
	<HEAD>
		<TITLE>Liste des vecteurs</TITLE>
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
		<script>
		</script>
	</HEAD>
	<form name="APA" action="apa-enregistre.php" method="post">
<?php
/*
*	Barre de menu
*/
//print("<FORM name =\"APA\"  ACTION=\"../vecteur/vecteur_maj.php?back=$back\" METHOD=\"post\">");

TblDebut(0,"25%");
	TblDebutLigne();
		if($_SESSION["autorisation"]==2 || $_SESSION["autorisation"]==10)
		{
			TblCellule("<a href = \"../vecteur_saisie.php?org_type=$org_type&no_liste_org='1'&back=$back\">Ajouter un v�hicule</a><br>");
		}
TblFin();
print("<hr>");// barre horizontale

/*
*	Affichage du tableau
*/
if($_SESSION["member_id"])
{
	/* nom de l'organisme */
	
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$query = "SELECT org_nom FROM organisme WHERE org_ID = '$_SESSION[organisation]'";
	$result = ExecRequete($query,$connect);
	$apa = LigneSuivante($result);
	print("<H2>$apa->org_nom</H2>");
	print("<p>Moyens pouvant �tre mis � la disposition du SAMU</p>");
	TblDebut(0,"100%");
	$_style = "A2";
	TblDebutLigne("$_style");
	TblFinLigne();
	
	/* tableau des moyens et des disponibilit� */
	
	/* --- s�lection du nom, de l'identifiant et de la disponibilit� */
	$query = "SELECT Vec_ID,Vec_Nom, Vec_Etat,lat,lng FROM vecteur WHERE org_ID = '$_SESSION[organisation]' ORDER BY Vec_Nom";
	$result = ExecRequete($query,$connect);
	while($moyen = LigneSuivante($result))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
			
			TblCellule("$moyen->Vec_Nom");
			$check="";
			if($moyen->Vec_Etat == '2')
				$check="CHECKED";
			// les assu sisponibles sont enregistr�es dans le tableau $m[]
			// spource: PHP Cookbook pp 235
			//TblCellule("<INPUT TYPE=\"CHECKBOX\" VALUE=\"$moyen->Vec_Nom\" NAME=\"m[]\"$check>Disponible ");
			print("<td><INPUT TYPE=\"CHECKBOX\" VALUE=\"on\" NAME=\"".$moyen->Vec_ID."\"$check >Disponible </td>");
			TblCellule("<INPUT TYPE=\"text\" NAME=\"lat[]\" VALUE=\"$moyen->lat\">");
			TblCellule("<INPUT TYPE=\"text\" NAME=\"lng[]\" VALUE=\"$moyen->lng\">");
			if($_SESSION['autorisation']==2  || $_SESSION["autorisation"]==10)
			{
				TblCellule("<a href = \"../vecteur_saisie.php?ttvecteur=$moyen->Vec_ID&&org_type=$org_type&&no_liste_org='1'\">Modifier</a>");
				TblCellule("<a href = \"apa_supprime.php?ttvecteur=$moyen->Vec_ID\" onclick=\"return confirm('Etes vous s�re de vouloir supprimer ce vecteur ?');\">Supprimer</a>");
			}
		TblFinLigne();
	}
	TblFin();
	print("<P>");
	print("<INPUT TYPE=\"SUBMIT\" VALUE=\"VALIDER\" NAME=\"ok\" SIZE = \"30\" ");
}
?>
</form>
</HTML>
