<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		secteurs_synoptique.php
//	date de création: 	08/10/2003
//	auteur:			jcb
//	description:		Affiche les disponibilités par secteur	
//					en ambulances privées
//	version:			1.2
//	maj le:			30/01/2005
//
//---------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("moyens_commune_menu.php");
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require 'utilitaires/globals_string_lang.php';

print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
?>
<SCRIPT language = JavaScript>
function SetBorder(Objet,Color)
{
    Objet.style.backgroundColor=Color;  
}

</SCRIPT>
<?php
print("</HEAD>");
$langue = "FR";
print("<FORM name =\"Lits\"  ACTION=\"vecteurs_synoptique.php\" >");
MenuCommunes($langue);
$mot = "Disponibilités en transport sanitaire";
Print("<H3>$mot</H3>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete = "SELECT secteur_apa_nom FROM secteur_apa WHERE '1'";
$resultat = ExecRequete($requete,$connexion); 
while($rub=mysql_fetch_array($resultat))
{
	$secteur[] = $rub[0];
}
@mysql_free_result($resultat);
// Récupère le secteur actif, i.e. celui por lequel 'voir' a été cliqué
$gr = $_GET['rg'];
// il y a 2 tables emboitées l'une dans l'autre
// table externe
TblDebut(0,"100%");
	TblDebutLigne();
		print("<TD>");
// table interne
TblDebut(0,"50%");
	TblDebutLigne();
		TblCellule("<B>&nbsp;</B>");
		TblCellule("<B>Secteur</B>");
		TblCellule("<B>Véhicules disponibles</B>");
	TblFinLigne();
	$_style = "gold";
	for($i = 0; $i < 9; $i++)
	{
		if($_style=="gold")$_style="goldenrod";
		else $_style="gold";
		print("<TR bgcolor=\"$_style\" OnMouseOver=javascript:SetBorder(this,'lightsteelblue'); OnMouseOut=javascript:SetBorder(this,'$_style'); >");
			TblCellule($i+1);
			TblCellule("<B>$secteur[$i]</B>");
			$mot = est_secteur_disponible($connexion,$i+1);
			if($mot > 0)
				TblCellule("<div align=\"center\"><B>$mot</B>");
			else
				TblCellule("<div align=\"center\">$mot");
			$rg = $i + 1;
			TblCellule("<A HREF = \"secteurs_synoptique.php?rg=$rg\">Voir</A>");
		TblFinLigne();
	}
TblFin();// table interne
print("</TD>");
print("<TD ID=\"1\">");
	if($gr > 0)
	{
		$liste = apa_du_secteur($connexion,$gr);
	}
print("</TD>");
TblFinLigne();
TblFin();
print("</FORM>");
print("</HTML>");
?>
