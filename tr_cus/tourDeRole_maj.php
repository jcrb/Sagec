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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		tourDeRole_maj.php
//	date de création: 	6/10/2004
//	auteur:			jcb
//	description:		Met à jour la table gérant l'ordre du tour de rôle
//	version:			1.0
//	maj le:			6/10/2004
//
//---------------------------------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaire_tr.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// ajoute une ligne pour un véhicule supplémentaire
if($_GET[ajoute])
{
	$nb_op = mysql_query ( "SELECT COUNT(*) FROM apa_tour");
	$nb_lines = mysql_fetch_row($nb_op);
	$nb_lines = $nb_lines[0];
	mysql_free_result($nb_op);
	$requete="UPDATE apa_tour SET ordre = ordre + 1";
	$resultat = ExecRequete($requete,$connexion);
	$requete="INSERT INTO apa_tour VALUES('0','0')";
	$resultat = ExecRequete($requete,$connexion);
}
else
// enregistre les modifications
{
	//efface toutes les donnée de la table
	$date = getDateCourante();
	$periode = getPeriodeCourante();
	$requete="DELETE FROM garde_cus WHERE date='$date' AND periode='$periode'";//
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>");
	//enregistrement du nouveau tour
	$p=$_GET['ID_assu'];
	$n=count($p);
	// on supprime les valeurs nulles
	$j = 0;
	for($i=0;$i<$n;$i++)
	{
		if($p[$i] != 0)
		{
			$q[$j] = $p[$i];
			$j++;
		}
	}
	$n=count($q);
	for($i=0;$i<$n;$i++)
	{
		$ordre = $n-$i-1;
		$requete="INSERT INTO garde_cus VALUES('$date','$q[$i]',$ordre,'$periode')";
		$resultat = ExecRequete($requete,$connexion);
		//print($requete."<br>");
	}
	maj_tabGarde($connexion);
	$date = date("Y-m-j H:i:s");
	$requete="INSERT INTO apa_tour_modifications VALUES('','$date','$_SESSION[member_id]','$q[0]','$q[1]','$q[2]','$q[3]','$q[4]')";
	$resultat = ExecRequete($requete,$connexion);
}
// enregistre les modifications

header("Location:tourDeRole_modifie.php");
?>
