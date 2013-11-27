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
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			biotox_image.php													   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		Création de cartes
//						ATTENTION: CE PROGRAMME NE DOIT COMPORTER AUCUNE SORTIE D'ECRAN
//						FAIT APPEL A HEADER									 				   //
//	version:			1.0																	   //
//	maj le:				02/02/2004										                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "Biotox - Cartographie";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
//include("biotox_carto.php");

$type_materiel = Security::str2db($_REQUEST['type_materiels']);
$requete="SELECT materiel_nom FROM materiel WHERE materiel_ID = '$type_materiel'";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>
<body>
	<DIV ALIGN="center"><H2>Zone de Défense EST - Coordination Zonale - Cartographie SAMU 67</H2><BR>
	Type de matériel: "<?php echo Security::db2str($rub[0]);?>"<br>
	
<?php
	print("<IMG SRC = \"biotox_carto.php?type_materiel=$type_materiel\">");
	//print("<IMG SRC = \"../../pic.png\">");
?>
	</DIV><BR>

</body>
</html>