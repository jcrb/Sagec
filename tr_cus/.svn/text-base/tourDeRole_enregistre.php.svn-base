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
//	programme: 		tourDeRole_enregistre.php
//	date de création: 	15/08/2003
//	auteur:			jcb
//	description:		Enregistre le tour de rôle courant et l'historique
//	version:			1.0
//	maj le:			31/08/2003
//
//---------------------------------------------------------------------------------------------------------
//
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
 $nb_op = mysql_query ( "SELECT COUNT(*) FROM apa_tour");
 $nb_lines = mysql_fetch_row($nb_op);
 //$nb_lines = $nb_lines[0];
 mysql_free_result($nb_op);

$requete="UPDATE apa_tour SET ordre = MOD(ordre+1,'$nb_lines[0]')";
$resultat = ExecRequete($requete,$connexion);
$dispo = $_GET[disponible][0];
$date = date("Y-m-j H:i:s");
$requete = "INSERT INTO apa_tour_enregistre VALUES('$date','$_GET[org_id]','$_GET[dossier]','$dispo')";
$resultat = ExecRequete($requete,$connexion);
//print($requete);
// si indisponible, on mémorise le n° du dossier
$d="";
if($dispo =="n")
	$d = $_GET["dossier"];
header("Location:tourDeRole_cus.php?dossier=$d");
?>
