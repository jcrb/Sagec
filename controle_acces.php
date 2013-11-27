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
/**
*	programme: 		controle_acces.php
*	date de création: 	09/09/2003
*	@author:			jcb
*	description:		Vérifie si un utikisateur est connu est si oui fixe ses autorisation d'accès
*	s'inspire de:		identification d'un membre leboeuf pp 122
*	@version:			$Id: controle_acces.php 43 2008-03-13 22:41:12Z jcb $
*	maj le:			10/03/2008
*/
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();

/**
* function autorise($login, $password)
* return le prénom + le nom de l'utilisateur ou "" si inconnu
*/
function autorise($login, $password,$connexion)
{
	//require($backPathToRoot."dbConnection.php");
	$password=crypt(trim(htmlspecialchars(addslashes($password))),"azerty");
	
	$requete = "SELECT *
					FROM utilisateurs
					WHERE login ='$login' AND pass='$password'";
	$resultat = ExecRequete($requete,$connexion);
	$utilisateur = "";
	$num_rows = mysql_num_rows($resultat);
	
	if($num_rows==1)
	{
		$utilisateur = LigneSuivante($resultat);
		$utilisateur_nom="";
		// Il s'agit d'un utilisateur répertorié
	
		$_SESSION["mcs"] = $utilisateur->mcs;
		$_SESSION["member_login"] = $login;
		$utilisateur_nom = $utilisateur->prenom." ".$utilisateur->nom;
		$_SESSION["membre_prenom"] = $utilisateur->prenom;
		$_SESSION["membre_nom"] = $utilisateur->nom;
		// on affecte la clé de l'enregistrement à la variable member_id
		$_SESSION["member_id"] = $utilisateur->ID_utilisateur;
		// si l'utilisateur est un administrateur
		$_SESSION["admin_id"] = $utilisateur->admin;
		// autorisations diverses
		$_SESSION["auto_sagec"] = $utilisateur->auto_sagec;
		$_SESSION["auto_org"] = $utilisateur->auto_org;
		$_SESSION["auto_hopital"] = $utilisateur->auto_hopital;
		$_SESSION["auto_service"] = $utilisateur->auto_service;
		$_SESSION["auto_apa"] = $utilisateur->auto_apa;
		$_SESSION["auto_arh"] = $utilisateur->auto_arh;
		$_SESSION["organisation"] = $utilisateur->org_ID;
		$_SESSION["Hop_ID"] = $utilisateur->Hop_ID;
		$_SESSION["auto_mg"] =  $utilisateur->code_gen;
		$_SESSION["auto_pds"] =  $utilisateur->auto_regul_pds;
		$_SESSION["auto_test"] =  $utilisateur->auto_test;
		$_SESSION["auto_ccrise"] =  $utilisateur->auto_ccrise;
		// service auquel appartient l'utilisateur
		$_SESSION["service"] = $utilisateur->service_ID;
		// niveau d'autorisation
		$_SESSION["autorisation"] = $utilisateur->autorisation;
		/**
		*	autorisé à modifier la page hopital.php
		*	0 = non, 1 = uniq l'hopital courant, 9 = tous les hôpitaux
		*/
		$_SESSION["modif_hopital"] = $utilisateur->modif_hopital;
		$_SESSION["auto_ppi"] = $utilisateur->auto_ppi;
		$_SESSION["auto_victime"] = $utilisateur->auto_victime;
		// mise à jour du fichier connexion
		$date_maj = date("Y-m-j H:i:s");
		$ip = getenv("REMOTE_ADDR");
		$requete="INSERT INTO connexion VALUES
		 		('','$_SESSION[member_id]','$date_maj','$ip','$_SESSION[organisation]')";
		$result = ExecRequete($requete,$connexion);
		$query = "SELECT org_nom FROM organisme WHERE org_ID = '$utilisateur->org_ID'";
		$result = ExecRequete($query,$connexion);
		$h = LigneSuivante($result);
		$_SESSION["hopital"] =  $h->org_nom;
		$query = "SELECT evenement_ID FROM alerte";
		$result = ExecRequete($query,$connexion);
		$h = LigneSuivante($result);
		$_SESSION["evenement"] =  $h->evenement_ID;// nom de l'évènement
		$_SESSION["localisation"] = $utilisateur->localisation_ID;
		$_SESSION['auto_leistelle']= $utilisateur->auto_leistelle;
		$requete="SELECT Pers_ID FROM personnel WHERE Pers_Nom ='$utilisateur->nom' AND Pers_Prenom='$utilisateur->prenom'";
		$result = ExecRequete($requete,$connexion);
		$rep = mysql_fetch_array($result);
		$_SESSION[personnelID]=$rep[Pers_ID];
	}
	mysql_close($connexion);
	return $utilisateur_nom;
}
?>
