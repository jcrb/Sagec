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
//
//	programme: 		modifie_table.php
//	date de création: 	12/02/2005
//	auteur:			jcb
//	description:		export de données du serveur vers l'utilisateurs
//	version:			1.0
//	maj le:			12/02/2005
//
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
if(!$_SESSION["autorisation"]>8) header("Location:".$backPathToRoot."logout.php");
$langue = $_SESSION['langue'];
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$table = $_REQUEST['table'];
$pagesize = 30; //nb de lignes par pages 
$page = 1;
//---------------------------------------------------------------
// nombre de lignes et de colonnes de la table:

function show_table($resultat,$table)
{
	$num_rows = mysql_num_rows($resultat); // nb de lignes
	$num_cols = mysql_num_fields($resultat); // nb de colonnes 

	if($num_rows > 1)
	{
		echo "<table border = 1>";
		echo "<tr>";
			for($i=0;$i<$num_cols;$i++)
				echo "<th>",mysql_field_name($resultat,$i),"</th>";
			echo "<th><a href='choix_lire_table.php'>retour</a></th>";
		echo "</tr>";
		$n = 0;
		while($row=mysql_fetch_array($resultat))
		{
			echo "<tr>";
				for($i=0;$i<$num_cols;$i++)
				{
					echo "<td>",$row[$i],"</td>";
				}
				echo "<td>","<a href='modifie_ligne.php?action=modifier&table=$table&ligne=$n'>modifier</a>","</td>";
				echo "<td>","<a href='modifie_ligne.php?action=supprimer&table=$table&ligne=$n'>supprimer</a>","</td>";
				$n++;
			echo "</tr>";
		}
		echo "</table>";
	}
}

$requete = "SELECT * FROM $table ";
$resultat = ExecRequete($requete,$connexion);
show_table($resultat,$table);
?>

