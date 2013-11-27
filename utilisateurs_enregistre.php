<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2004 (Jean-Claude Bartier).
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
//	programme: 		utilisateurs_enregistre.php
//	date de création: 	03/01/2004
//	auteur:			jcb
//	description:		Enregistre un utilisateur dans la base de données
//	version:			1.0
//	maj le:			28/02/2004
//
//---------------------------------------------------------------------------------------------//
//Liste des vecteurs
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(!$_SESSION['auto_sagec'] && $_SESSION[autorisation]==10)header("Location:logout.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_POST['apa']=="on")$_POST['apa']="o";
if($_POST['sagec']=="on")$_POST['sagec']="o";
if($_POST['hop']=="on")$_POST['hop']="o";
// si $utilisateur existe, il s'agit d'une maj
$utilisateur = $_POST['utilisateur'];
// $code_gen est une variable générale dont la valeur ou le sens dépend de la valeur d'une autre variable
// par ex, si auto_mg est vraie => $code_gen correspond au med_ID de la table mg67
$code_gen = 0;
if($_POST['auto_mg']) $code_gen = $_POST['med_id'];
//
if($_POST['utilisateur'])
{
	$requete=	"UPDATE utilisateurs SET
				nom = '$_POST[nom]',
				prenom = '$_POST[prenom]',
				login = '$_POST[login]',
				email = '$_POST[mail]',
				org_ID = '$_POST[orgID]',
				autorisation = '$_POST[auto]',
				service_ID = '$_POST[the_service]',
				auto_apa = '$_POST[apa]',
				auto_sagec = '$_POST[sagec]',
				auto_org = '$_POST[org]',
				auto_hopital = '$_POST[hop]',
				auto_service = '$_POST[service]',
				auto_arh = '$_POST[arh]',
				Hop_ID = '$_POST[ID_hopital]',
				auto_mg = '$_POST[auto_mg]',
				code_gen = '$code_gen',
				auto_regul_pds = '$_POST[auto_pds]',
				auto_test = '$_POST[auto_test]',
				auto_ccrise = '$_POST[ccrise]',
				modif_hopital = '$_POST[modif_hopital]',
				auto_ppi = '$_POST[auto_ppi]',
				auto_victime = '$_POST[auto_victime]',
				auto_leistelle = '$_POST[auto_leistelle]'
				WHERE ID_utilisateur = '$_POST[utilisateur]'";
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	//$login=crypt(trim(htmlspecialchars(addslashes($_POST['login']))),"azerty");
	$login=$_POST['login'];
	$pass=crypt(trim(htmlspecialchars(addslashes($_POST['pass']))),"azerty");
	$requete = "INSERT INTO utilisateurs VALUES (
				'',
				'$_POST[nom]',
				'$_POST[prenom]',
				'$login',
				'$pass',
				'',
				'$_POST[mail]',
				'',
				'',
				'$_POST[orgID]',
				'$_POST[sagec]',
				'$_POST[org]',
				'$_POST[hop]',
				'$_POST[service]',
				'$_POST[apa]',
				'$_POST[arh]',
				'$_POST[auto]',
				'$_POST[the_service]',
				'$_POST[ID_hopital]',
				'$_POST[auto_mg]',
				'$code_gen',
				'$_POST[auto_pds]',
				'$_POST[auto_test]',
				'$_POST[ccrise]',
				'$_POST[modif_hopital]',
				'$_POST[auto_ppi]',
				'$_POST[auto_victime]',
				'$_POST[auto_leistelle]'
				)";
	$resultat = ExecRequete($requete,$connexion);
	$utilisateur = mysql_insert_id();
}
//print($requete);
header("Location: utilisateurs_ajout.php?utilisateur=$utilisateur");

?>
