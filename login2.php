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
//	programme: 		login2.php		
//	date de création: 	09/09/2003
//	auteur:			jcb										
//	description:		Page de login pour un utilisateur	
//  s'inspire de:		identification d'un membre leboeuf pp 122
//	version:		1.3
//	maj le:			03/09/2005																	 //
//
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();
$backPathToRoot = "./";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// identification d'un membre
require($backPathToRoot."dbConnection.php");
include("utilitaires/globals_string_lang.php");
include("utilitaires/table.php");
require("controle_acces.php");
require $backPathToRoot."autorisations/droits.php";
require($backPathToRoot."login/init_security.php");

//require($backPathToRoot."login/captcha.php");
require($backPathToRoot."html.php");

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/entete_gris.css" />
		<link rel="stylesheet" type="text/css" href="css/menu_gris.css" />
		<link rel="stylesheet" type="text/css" href="./pma.css">
		<link rel="shortcut icon" href="./images/sagec67.ico" />
		<title>Accueil</title>
	</head>
	<body>
<?php

//print_r($_SESSION);

if($_SESSION["member_id"])
{	
	// si la variable langue est déjà définie, on la récupère
	$langue = $_SESSION["langue"];
	// langue par défaut si aucunne n'est selectionnée
	if (!isset($langue)) $langue = 'FR';
	// enregistrement de la langue
	$_SESSION["langue"] = $langue;
	
	$requete = "SELECT organisme_type_ID FROM organisme WHERE org_ID = '$_SESSION[organisation]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	$org_type = $rub['organisme_type_ID'];
	
	// afficher l'entête sagec
	$utilisateur_nom = $_SESSION["membre_prenom"]." ".$_SESSION["membre_nom"];
	$mot = "<b>".$_SESSION['utilisateur_nom']."</b> ".$utilisateur_nom.", ".$string_lang['ENREGISTREMENT'][$langue] .$_SESSION[member_id];
	entete_sagec_css($mot,"left", '', $backPathToRoot);

	// afficher les liens en fonction du profil
	echo "<ul class='navbar navbar_big'>";
	
	// Accès à la page de la main courante
	if (est_autorise("MCS_LECTURE")||est_autorise("MCS_ECRITURE")||est_autorise("MCS_MODIFICATION"))
	{ //<= je part du principe que les personnes qui avait déjà accès à la main courante du samu n'utilisent pas ce lien
		//$mot = $string_lang['BLOCNOTE'][$langue];//"Main courante SAMU 67";
		//echo "<li><a href='blocnote/blocnote_lire.php?back=../login2.php'>$mot</a></li>";
	}
	
/**
  *	Invité
  */
	if(est_autorise("INVITE"))
		echo "<li><a href='invite/index.php'>".$string_lang['INVITES'][$langue]."</a></li>";
/**
  *	Autorisation Sagec: accès à Old Sagec
  */	
	if($_SESSION["auto_sagec"])
	{
		$mot = $string_lang['SAGEC67'][$langue];
		echo "<li><a href='sagec67.php'>$mot</a></li>";
	}
/**
  *	Hôpital et services hospitaliers
  */
	if(($_SESSION["auto_hopital"]||$_SESSION["auto_org"]||$_SESSION["auto_service"]) && $_SESSION["autorisation"] > 0)
	{
		$mot = $string_lang['GERER_HOPITAL'][$langue];
		//echo "<a href = \"hopital_start.php\"><H1>$mot</H1></a><br>";
		echo "<li><a href='services/service_frameset.php'>$mot</a></li>";
		echo "<li><a href='dispo/lits_comment.php'>Disponibilité en lits et places</a></li>";
	}
/**
  *	Cellule de crise
  */
	if($_SESSION["auto_ccrise"])
	{
		$mot="CELLULE DE CRISE HUS";
		echo "<li><a href='crisehus/cc_main.php'>$mot</a></li>";
	}
/**
  *	Ambulanciers privés, protection civile, associations de secourisme, SDIS
  */	
	if($_SESSION["auto_apa"])
	{
		/**
		  *	SDIS
		  */
		if($_SESSION['organisation']==3)
			echo "<li><a href='sdis/sdis_main.php'>Accès SDIS</a></li>";
		/**
		  *	SIDPC
		  */
		else if($_SESSION['organisation']==4)
			echo "<li><a href='sidpc/sidpc_frameset.php'>Accès Protection Civile</a></li>";
		/**
		  *	Associations
		  */
		else if($org_type == 5)
		{
			echo "<li><a href='asso/asso_main.php'>Accès Association de Secourisme</a></li>";
		/**
		  *	Transport
		  */
			$mot="Accéder à la section victime / transport";
			echo "<li><a href='apa/apa_frameset.php'>$mot</a></li>";
			echo "<li><a href='apa/apa_main.php'>Accès Transport Sanitaire & Associations</a></li>";
		}
	}
/**
  *	ARS
  */
	if($_SESSION["auto_arh"])
	{
		$mot="Données base ARH 67";
		echo "<li><a href='arh/arh_frameset.php'>$mot</a></li>";
	}
		if (est_autorise("AUTO_ARS"))
	{
		echo "<li><a href='ars/ars_main.php'>Portail ARS</a><br></li>";
	}
/**
  *	Victimes (obsolète)
  */
	if($_SESSION["auto_victime"])
	{
		//$mot="OTAN";
		//echo "<li><a href='otan/otan_frameset.php'>$mot</a></li>";
	}
/**
  *	Médecin de garde
  */
	if($_SESSION["auto_mg"])
	{
		$mot="Accès médecin de garde - MSP";
		echo "<li><a href='medecin/medecin_frameset.php'>$mot</a></li>";
	}
/**
  *	PDS
  */
	if($_SESSION["auto_pds"])
	{
		$mot="Régulation - PDS";
		echo "<li><a href='pds/pds_frameset.php'>$mot</a></li>";
	}
/**
  *	Leitstelle
  */
	if($_SESSION["auto_leitstelle"]=="o")
	{
		$mot = $string_lang['SAMU'][$langue];
		echo "<li><a href='hopital/hopital_frameset.php'>$mot</a></li>";
	}
/**
  *	Centres de grands brûlés
  */
	if(est_autorise("AUTO_CGB"))
	{
		$mot = $string_lang['CENTRE_DE_BRULES'][$langue];
		echo "<li><a href='brules/brule_frameset.php'>$mot</a></li>";
	}
	
	if (est_autorise("AUTO_SYNOPTIQUE")){
		$mot = $string_lang['SYNOPTIQUE_LITS_DISPO'][$langue];
		echo "<li><a href='synoptique/synoptique_frame.php'>$mot</a></li>";
	}
	
/**
  *	Page personnelle
  */
	if($_SESSION[personnelID])
	{
		$mot = $string_lang['PERSO'][$langue];$mot="Perso";
		echo "<li><a href='intervenant_saisie.php?personnelID=$_SESSION[personnelID]&auto=1&back=login2.php'>$mot</a><br></li>";
	}
/**
  *	Création d'étiquettes
  */	
	if (est_autorise("AUTO_ETIQUETTES"))
	{
		echo "<li><a href='serveur/serveur_main.php'>Création d'identifiants victimes</a><br></li>";
	}
/**
  *	DSA
  */
	if (est_autorise("AUTO_DSA"))
	{
		echo "<li><a href='dsa/dsa_nouveau.php'>Signaler un DSA</a><br></li>";
	}

/**
  * Accès au COD
  *
  */
if (est_autorise("AUTO_COD"))
	{
		echo "<li><a href='crise_cod/cc_main.php'>Centre Opérationnel Départemental</a><br></li>";
	}
	
/**
  * Accès Biotox
  *
  */
  if (est_autorise("BIOTOX_LIRE"))
	{
		echo "<li><a href='biotox/biotox_main.php'>Biotox</a><br></li>";
	}
	
/**
  *	Mot de passe
  */
	$mot = $string_lang['CHANGER_MOTDEPASSE'][$langue];
	echo "<li><a href='new_password.php?back=login2.php'>$mot</a><br></li>";

  	
/**
  *	Quitter
  */
	$mot = $string_lang['QUIT_SESSION'][$langue];
	echo "<li><a href='logout.php'>$mot</a></li>";
	
	echo "</ul>";
}
else
{
	echo "L'accès direct à acette page n'est pas autorisé<br>";
	?><a href="login_dialogue.php"">Continuer</a><?php
}
?>
 <!--<?php print_r($_SESSION);?>-->

</body>

</html>

