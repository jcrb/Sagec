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
//
//	programme: 		veille_enregistre.php
//	date de cr?ation: 	2005
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			2005
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$member_id = $_SESSION['member_id'];
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../date.php");
//====================== Corps =======================================
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$date = fDate2unix($_GET['date']);
// vérifie si enregistrement existe déjà
$requete = "SELECT veille_samu_ID FROM veille_samu WHERE date = '$date' AND service_ID = '$_SESSION[service]'";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);
$id = $rub[veille_samu_ID];
if($id == 0)
{
	$requete = "INSERT INTO veille_samu VALUES(
				'',
				'$date',
				'$_SESSION[service]',
				'$_GET[nb_affaires]',
				'$_GET[nb_primaires]',
				'$_GET[nb_secondaires]',
				'$_GET[nb_neonat]',
				'$_GET[nb_tiih]',
				'$_GET[nb_apa]',
				'$_GET[nb_vsav]',
				'$_GET[nb_conseils]',
				'$_GET[nb_med]',
				'$_SESSION[member_id]'
				)";
	//print($requete);
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	$requete = "UPDATE veille_samu SET date = '$date',
				service_ID = '$_SESSION[service]',
				nb_affaires = '$_GET[nb_affaires]',
				nb_primaires = '$_GET[nb_primaires]',
				nb_secondaires ='$_GET[nb_secondaires]',
				nb_neonat = '$_GET[nb_neonat]',
				nb_tiih = '$_GET[nb_tiih]',
				nb_apa = '$_GET[nb_apa]',
				nb_vsav = '$_GET[nb_vsav]',
				conseils = '$_GET[nb_conseils]',
				nb_med = '$_GET[nb_med]',
				ID_utilisateur = '$_SESSION[member_id]'
				WHERE veille_samu_ID = '$id'
	";
	//print($requete);
	$resultat = ExecRequete($requete,$connexion);
}
header("Location: veille.php?enregistrement=$id");
