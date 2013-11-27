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
//	programme: 		modifie_ligne.php
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
include_once($backPathToRoot."dbConnection.php");

$action = $_REQUEST[action];
$table = $_REQUEST[table];
$ligne = $_REQUEST[ligne];

/**
*	Modifie une ligne
*/
if(isset($_REQUEST[btn]))
{
	$ligne = $_REQUEST[ligne];
	$table = $_REQUEST[table];
	$requete = "SELECT * FROM $table LIMIT $ligne,1";
	$resultat = ExecRequete($requete,$connexion);
	$num_cols = mysql_num_fields($resultat);
	$rep = mysql_fetch_array($resultat);
	
	if($_REQUEST[btn]=="modifier")
	{
		$requete = "UPDATE $table SET ";
		for($i=0;$i<$num_cols;$i++)
		{
			$name = mysql_field_name($resultat,$i);
			if (array_key_exists($name, $_REQUEST)) 
			{
    			echo "L'élément ".$name." existe dans le tableau et vaut: ".$_REQUEST[$name]."<br>";
    			$tab[] = $name." = '".$_REQUEST[$name]."'";
    			$where[] = $name." = '".$rep[$name]."'";
			}
		}
		$requete .= implode(", ",$tab)." WHERE ".implode(" AND ",$where)." LIMIT 1";
		print($requete);
		$resultat = ExecRequete($requete,$connexion);
	}
	
	else if($_REQUEST[btn]=="supprimer")
	{
		$requete = "DELETE $table WHERE ";
		for($i=0;$i<$num_cols;$i++)
		{
			$name = mysql_field_name($resultat,$i);
			{
    			echo "L'élément ".$name." existe dans le tableau et vaut: ".$_REQUEST[$name]."<br>";
    			$where[] = $table.".".$name." = '".$rep[$name]."'";
			}
		}
		$requete .= implode(" AND ",$where)." LIMIT 1";
		print($requete);
		//DELETE FROM `apa_assu` WHERE `apa_assu`.`org_ID` = 64 AND `apa_assu`.`secteur_apa_ID` = 6 LIMIT 1
		$resultat = ExecRequete($requete,$connexion);
	}
}

?>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<form name="modifie_ligne" action="" method="get">

<?php

	$requete = "SELECT * FROM $table LIMIT $ligne,1";
	$resultat = ExecRequete($requete,$connexion);
	$num_cols = mysql_num_fields($resultat); // nb de colonnes 
	if(!$num_cols)
	{
		echo "La table ".$table." est vide ";
		echo "<a href='modifie_table.php?table=$table'>  retour</a>";
	}
	else 
	{
		echo "<input type='hidden' name='ligne' value='$ligne'>";
		echo "<input type='hidden' name='table' value='$table'>";
		echo "<input type='hidden' name='num_col' value='$num_cols'>";

		$row=mysql_fetch_array($resultat);
		echo "<table border = 1>";
		for($i=0;$i<$num_cols;$i++)
		{
			echo "<tr>";
				$name = mysql_field_name($resultat,$i);
				echo "<td>",$name,"</td>";
				echo "<td>";
					echo "<input type='texte' name='$name' value='$row[$i]'>";
				echo "</td>";
				echo "</tr>";
		}
		echo "</table>";
		if($action=="modifier")
			echo "<input type='submit' name='btn' value='modifier'>";
		else if($action=="supprimer")
			echo "<input type='submit' name='btn' value='supprimer'>";

		echo "<a href='modifie_table.php?table=$table'>  retour</a>";
	}
?>
</form>
</body>