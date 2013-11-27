<?php
/**
//----------------------------------------- SAGEC -------------------------------
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
//----------------------------------------- SAGEC --------------------------------
/**
//	programme: 				ppi_structures_actives.php
//	date de création: 	14/08/2008
//	@author:					jcb
//	description:
//	@version:				1.0
//	maj le:					14/08/2008
//--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
$backPathToRoot = "../";
require($backPathToRoot."pma_connect.php");
require($backPathToRoot."pma_connexion.php");
require $backPathToRoot.'utilitaires/requete.php';
include_once($backPathToRoot."login/init_security.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>
<header>
	<script>
		function alerte_supprimer(no,id,back,param)
		{
			if(confirm("Voulez-vous vraiment supprimer cet enregistrement ?"))
			{
				location.replace("ts_ppi_supprime.php?enregistrement_ID=" + no + "&back="+ back +"&param="+param+"&id="+id);
		//"&back=../intervenant_saisie.php&personne="
			}
		}
	</script>
</header>
<?php
$id = $_REQUEST['id'];
$nom = $_REQUEST['nom'];

print("<p>$nom <a href=\"ppi_ajouter_structure.php?id=$id\">Ajouter une structure</a></p>");

$requete = "SELECT * 
				FROM ppi_structures_actives,temp_structure
				WHERE ppi_ID = '$id'
				AND ppi_structures_actives.ts_ID = temp_structure.ts_ID
				ORDER BY ts_type
				";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>$rub[ts_ID]</td>");
		print("<td>".Security::db2str($rub[ts_nom])."</td>");
		print("<td><a href=\"../pma/structure_temp.php?ts_IDField=$rub[ts_ID]\"> voir</a></td>");
		print("<td><input type=\"button\" name=\"submit\" value=\"Supprimer\" onclick=\"alerte_supprimer($rub[ts_ID],'','ppi_structures_actives.php?id=$id','');\"></td>");
		  
	print("</tr>");
}
print("</table>");
?>