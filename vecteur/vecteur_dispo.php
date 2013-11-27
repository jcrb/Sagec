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
//	programme: 		vecteur_dispo.php
//	date de création: 	18/08/2003
//	auteur:			jcb
//	description:
//	version:			1.1
//	maj le:			22/11/2004
//
//---------------------------------------------------------------------------------------------------------
// synoptique des moyens disponibles
// connection à la base PMA pour extraire les données nécessaires
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION[langue];

require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
include("vecteurs_menu.php");
include("utilitairesHTML.php");
require 'utilitaires/globals_string_lang.php';

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("<meta http-equiv=\"refresh\" content=\"30\">");
?>
<SCRIPT language = JavaScript>
function SetBorder(Objet,Color)
{
    Objet.style.backgroundColor=Color;
}
</SCRIPT>
<?php
print("</HEAD>");

MenuVecteurs($langue);

TblDebut(0,"100%");
print("<TR>");
print("<TD valign=\"top\">");

$mot = $string_lang['LANGUE'][$langue];
setlocale(LC_TIME,$mot);
$dateFR = strFTime("%A %d %B %Y");
$heure = date("H:i");
$mot = $string_lang['MOYENS_DISPONIBLES'][$langue];
$mot2 = $string_lang['A'][$langue];
$legende = $mot." ".$dateFR." ".$mot2." ".$heure;

//------------------------------ Vecteurs disponibles -----------------------------------------------------------
print("<fieldset>");
print("<LEGEND class=\"time_v\"> $legende </LEGEND>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete="SELECT Vec_Type,Vec_Etat FROM vecteur WHERE Vec_Engage <> 'o'";
$resultat = ExecRequete($requete,$connexion);
$max = 0;
while($g = LigneSuivante($resultat))
{
	$i=$g->Vec_Type;
	$moyen[$i]++;
	if($i>$max)$max = $i;
}

TblDebut(0,"50%");
for($i=1;$i<=$max;$i++)
{
	//TblDebutLigne();
	print("<TR id=TD1 	OnMouseOver=javascript:SetBorder(this,'lightsteelblue');OnMouseOut=javascript:SetBorder(this,'white');>");
	$mot = $string_lang['VOIR'][$langue];
	//TblCellule("<a href=\"vecteurs_selection.php?v_type=$i&type_v=0\"><B>$mot</B></a>","","","time_v");
	print("<TD class=\"verda\"><a href=\"vecteurs_selection.php?v_type=$i&type_v=0\"><B>$mot</B></a></TD>");
	print("<TD class=\"time\">"); print(ChercheTypeVecteur($i,$connexion));print("</TD>");
	print("<TD class=\"time\"> $moyen[$i] </TD>");
	TblFinLigne();
}
TblFin();
//------------------------------ Vecteurs engagés -----------------------------------------------------------
print("</fieldset>");
print("</TD>");
print("<TD valign=\"top\">");
	$mot = $string_lang['MOYENS_ENGAGES'][$langue];
	$legende = $mot." ".$dateFR." ".$mot2." ".$heure;
	print("<fieldset>");
	print("<LEGEND class=\"time_v\"> $legende </LEGEND>");
	$requete="SELECT Vec_Type,Vec_Engage
			FROM vecteur
			WHERE Vec_Engage='o'
			";
	$resultat = ExecRequete($requete,$connexion);
	$max = 0;
	while($g = LigneSuivante($resultat))
	{
		$i=$g->Vec_Type;
		$moyend[$i]++;
		if($i>$max)$max = $i;
	}
	TblDebut(0,"50%");
	for($i=1;$i<=$max;$i++)
	{
		print("<TR id=TD2 	OnMouseOver=javascript:SetBorder(this,'lightsteelblue'); 								OnMouseOut=javascript:SetBorder(this,'white');>");
		$mot = $string_lang['VOIR'][$langue];
	print("<TD class=\"time\"><a href=\"vecteurs_selection.php?v_type=$i&engage=1\"><B>$mot</B></a></TD>");
		print("<TD class=\"time\">"); print(ChercheTypeVecteur($i,$connexion));print("</TD>");
		print("<TD class=\"time\"> $moyend[$i] </TD>");
		TblFinLigne();
	}
	TblFin();
	print("</fieldset>");
print("</TD>");
print("</TR>");
TblFin();
print("</html>");
?>
