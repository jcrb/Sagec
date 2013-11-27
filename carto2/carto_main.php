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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		carto_main.php							//
//	date de création: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		affiche un choix d'options		//
//	version:		1.0									//
//	maj le:			15/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//print("<IMG SRC = \"carto_base.php\">");
if($_GET["dpt"])
{
	$objet = $_REQUEST['objet'];
	$zoom = $_REQUEST['zoom'];
	
	switch($objet)
	{
		case samu:$titre="SAMU départementaux";break;
		case samu_smur: $titre = "SAMU et SMUR départementaux ".$zoom;break;
		case psm1: $titre = "PSM 1";break;
		case psm2: $titre = "PSM 2";break;
		case caisson: $titre = "Caissons hyperbares";break;
		case polyT: $titre = "Polytraumatisés";break;
		case helico: $titre = "Hélicoptères sanitaires";break;
		case rea_adulte: $titre = "Services de réanimation adultes";break;
		case rea_ped: $titre = "Services de réanimation pédiatriques";break;
		case morgue: $titre = "Morgues";break;
		case sau: $titre = "Services d'urgence";break;
	}
	//print($titre."<br>");
	$depart=implode("|", $_GET["dpt"]);
	$action = "<DIV ALIGN=\"center\"><IMG SRC = \"carto_base.php?objet=$objet&depart2=$depart&titre=$titre&zoom=$zoom)";
	if($_GET['isocercle'])
		$action.="&ville=$_GET[id_ville]&rayon=$_GET[rayon]";
	$action .="\"></div>";
	print($action);
}
//include "carto_base.php";
//header("Location:test.php?objet=$_GET[objet]&depart2=$depart");

//print("SAMU et SMUR");
/*
for($i=0;$i<count($_GET['dpt']);$i++)
{
	print("departement ".$_GET['dpt'][$i]."<br>");
}
 print $depart;
$liste2=explode("|", $depart);
for($i=0;$i<count($liste2);$i++)
{
	print("departement ".$liste2[$i]."<br>");
}
*/
?>
