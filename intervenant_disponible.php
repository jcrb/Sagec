<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
/**
 * 	intervenant_disponible.php
 *		Liste les personnels disponibles par catégorie
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("dbConnection.php");
require("date.php");
require("intervenants_menu.php");
menu_intervenants($_SESSION['langue']);

$rep = array();

$requete = "SELECT Pers_ID,Pers_Nom,Pers_Prenom,heure_arrive, heure_depart,perso_cat_nom
				FROM personnel,perso_cat
				WHERE arrive = 'o'
				AND personnel.perso_cat_ID = perso_cat.perso_cat_ID
				ORDER BY personnel.perso_cat_ID, Pers_Nom";
		$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$rep[$rub[perso_cat_nom]][] = $rub[Pers_Nom];
}
$i = 1;
foreach ($rep as $cat => $nom)
{
	echo $cat."  ";
	foreach($nom as $n)
	{
		echo $n.", ";
	}
	echo "<br>";
}
?>