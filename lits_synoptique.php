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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		vecteur_engage.php							//
//	date de création: 	31/08/2003								//
//	auteur:			jcb									//
//	description:		synoptique des moyens disponibles et engagés				//
//	version:		1.0									//
//	maj le:			31/08/2003								//
//													//
//---------------------------------------------------------------------------------------------------------
// 
// connection à la base PMA pour extraire les données nécessaires
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);


require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
//include("menu_sagec.php");
include("utilitairesHTML.php");
require 'utilitaires/globals_string_lang.php';
require ("menu_gestion_lits.php");

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
?>
	<script type="text/javascript"> 
		function redirige(formulaire)   
		{     
			if (formulaire.destination.selectedIndex != 0)       
				location.href = formulaire.destination.options[formulaire.destination.selectedIndex].value;   
		} 
	</script>
</head>
<?php

//MenuLits($langue);
$titre = $string_lang['SYNOPTIQUE'][$langue];
menu_lits($langue,strToUpper($titre));

if($langue == 'GE')$mot="de";
$mot = $string_lang['LANGUE'][$langue];
setlocale(LC_TIME,$mot);

$dateFR = strFTime("%A %d %B %Y");
$heure = date("H:i");
$mot = $string_lang['LITS_DISPO'][$langue]." ".$string_lang['PAR'][$langue]." ".$string_lang['SPECIALITE'][$langue];
//$mot="Lits disponibles par spécialité";
$mot2 = $string_lang['A'][$langue];
$legende = $mot." ".$dateFR." ".$mot2." ".$heure;

print("<br>");
print("<TABLE width=\"75%\"><TR><TD>");
print("<fieldset>");
print("<LEGEND class=\"time_v\"> $legende </LEGEND>");
print("<P CLASS=\"time2\">");
//print("<legend><H2>$mot ".$dateFR." ".$mot2." ".$heure."</H2></legend>");
//print("$mot ".$dateFR." ".$mot2." ".$heure);
print("</P>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
/*
$requete="SELECT lits_dispo,lits.service_ID,service.Type_ID,service_nom
			FROM lits,service 
			WHERE lits_dispo > 0
			AND lits.service_ID = service.service_ID
			ORDER BY service.Type_ID
			";*/
$requete="SELECT lits_dispo,lits.service_ID,service.Type_ID,service_nom
			FROM lits,service 
			WHERE lits.service_ID = service.service_ID
			ORDER BY service.Type_ID
			";
$resultat = ExecRequete($requete,$connexion);
$max = 0;
while($g = LigneSuivante($resultat))
{
	$i=$g->Type_ID;
	$moyen[$i]= $moyen[$i] + $g->lits_dispo;
	if($i>$max)$max = $i;
}

// Affichage des résultats sur 3 colonnes. Chaque ligne correspond à une spécialité.
//	La colonne 1: 	Lien vers le programme Lits_Service.php. Affiche la liste des services
//					correspondant à la spécialité. On passe dans l'adresse le type de
//					service en l'associant à la variable type_s. Attention, ce nom ne doit
//					pas être modifié car il est attendu par Lits_Service.
//	La colonne 2:	Nom de la spécialité
//	La colonne 3:	Nombre total de lits disponibles dans cette spécialité
TblDebut(0,"50%","","","");
for($i=1;$i<=$max;$i++)
{
	TblDebutLigne();
		$mot = $string_lang['VOIR'][$langue];
		TblCellule("<div align=\"center\"><a href=\"lits_service.php?type_s=$i\"><B>$mot</B></a>");
		$mot = $string_lang[ChercheTypeService($i,$connexion)][$langue];
		TblCellule($mot);
		TblCellule($moyen[$i]);
	TblFinLigne();
}
TblFin();
print("</fieldset>");
print("</TD></TR></TABLE>");
print("</html>");
?>
