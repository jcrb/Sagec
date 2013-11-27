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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		/gis/ville/ville_liste.php						//
//	date de création: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		affiche une liste déroulante avec la liste des villes répertoriées	//
//	version:		1.0									//
//	maj le:			18/08/2003								//
//													//
//---------------------------------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathtoRoot="./../../";
require './../../utilitaires/globals_string_lang.php';
include("./../../utilitairesHTML.php");
require("./../../pma_connect.php");
require("./../../pma_connexion.php");
require($backPathtoRoot."login/init_security.php");

print("<html>");
print("<head>");
print("<title> Liste de villes </title>");
print("<LINK REL=stylesheet HREF=\"./../../pma.css\" TYPE =\"text/css\">");
?>
<SCRIPT>
	function swap(form_name)
	{
		document.ville.submit();
		//document.write(form_name);
	}
</SCRIPT>
<?php
print("</head>");

print("<FORM name=\"ville\" action=\"ville_saisie.php\" method=\"get\" TARGET=\"midle\">");
print("Saisir une ville<BR>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];
select_ville($connexion,$item_select,$langue,"swap(this.form.name)");//retourne $id_ville
print("<BR>");
//print("<A href=\"./../../carto2/carto_frameset.php\" TARGET=\"_TOP\">Menu principal</A>");
print("</FORM>");
print("</html>");
?>
