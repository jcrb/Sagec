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
// C'est la configuration par défaut de php.ini
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// identification d'un membre
require("pma_connect.php");
include("utilitaires/globals_string_lang.php");
include("utilitaires/table.php");
require("controle_acces.php");
//
// Désactiver le rapport d'erreurs
//error_reporting(0);
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/entete_gris.css" />
		<link rel="stylesheet" type="text/css" href="../css/menu_gris.css" />
		<link rel="stylesheet" type="text/css" href="./pma.css">
		<title>Document sans nom</title>
	</head>
	<body>
<?php
// si la variable langue est déjà définie, on la récupère
$langue = $_SESSION["langue"];
//$langue = 'FR';
if($_POST['francais'])$langue = 'FR';
if($_POST['allemand'])$langue = 'GE';
if($_POST['anglais'])$langue = 'UK';

// enregistrement de la langue
$_SESSION["langue"] = $langue;


if($_POST['login'] && $_POST['password'])
{
	$_SESSION['utilisateur_nom'] = autorise($_POST['login'], $_POST['password']);
	
}


if($_SESSION["member_id"])
{
	// afficher l'entête sagec
	$utilisateur_nom = $_SESSION["membre_prenom"]." ".$_SESSION["membre_nom"];
	$mot = "<b>".$_SESSION['utilisateur_nom']."</b> ".$utilisateur_nom.", ".$string_lang['ENREGISTREMENT'][$langue] .$_SESSION[member_id];
	entete_sagec_css($mot,"left", '', $backPathToRoot);
	
	// afficher les liens en fonction du profil
	echo "<ul class='navbar navbar_big'>";
	if($_SESSION["auto_sagec"])
	{
		$mot = $string_lang['SAGEC67'][$langue];
		echo "<li><a href='sagec67.php'>$mot</a></li>";
	}
	
	print("<table width=\"100%\" border=\"1\" bordercolor=\"#660066\">");
  	print("<tr>");
    	print("<td width=\"21%\"><div align=\"center\"><img src=\"images/Logo_SAGEC3.gif\" width=\"156\"
			height=\"79\"></div></td>");
    	print("<td width=\"79%\">");
		print("<b>".$_SESSION['utilisateur_nom']."</b> ".$utilisateur->nom.", ".$string_lang['ENREGISTREMENT'][$langue] .$_SESSION[member_id]);
		print("</td>");
  	print("</tr>");
	print("</table>");

	if($_SESSION["auto_sagec"])
	{
		$mot = $string_lang['SAGEC67'][$langue];
		//echo "<a href = \"sagec67.php\"><P class=\"Style22\">$mot</P></a>";
		echo "<li><a href='sagec67.php'>$mot</a></li>";
		$mot = $string_lang['CENTRE_DE_BRULES'][$langue];
	}
	if(($_SESSION["auto_hopital"]||$_SESSION["auto_org"]||$_SESSION["auto_service"]) && $_SESSION["autorisation"] > 0)
	{
		$mot = $string_lang['GERER_HOPITAL'][$langue];
		//echo "<a href = \"hopital_start.php\"><H1>$mot</H1></a><br>";
		echo "<a href = \"services/service_frameset.php\"><P class=\"Style22\">$mot</P></a>";
		//echo "<a href = \"crisehus/crisehus_frameset.php\"><P class=\"Style22\">CRISE HUS</P></a>";
	}
	if($_SESSION["auto_ccrise"])
	{
		$mot="CELLULE DE CRISE HUS";
		echo "<a href = \"crisehus/crisehus_frameset.php\"><P class=\"Style22\">$mot</P></a>";
	}
	if($_SESSION["auto_apa"])
	{
		if($_SESSION['organisation']==3)
			echo "<a href = \"sdis/sdis_frameset.php\"><P class=\"Style22\">Accès SDIS</P></a>";
		else if($_SESSION['organisation']==4)
			echo "<a href = \"sidpc/sidpc_frameset.php\"><P class=\"Style22\">Accès Protection Civile</P></a>";
		else
		{
			$mot="Accéder à la section transport";
			//echo "<a href = \"apa_menu.php\"><P class=\"Style22\">$mot</P></a>";
			echo "<a href = \"apa/apa_frameset.php\"><P class=\"Style22\">$mot</P></a>";
		}
	}
	if($_SESSION["auto_arh"])
	{
		$mot="Données base ARH 67";
		echo "<a href = \"arh/arh_frameset.php\"><P class=\"Style22\">$mot</P></a>";
	}
	if($_SESSION["auto_mg"])
	{
		$mot="Accès médecin de garde - MSP";
		echo "<a href = \"medecin/medecin_frameset.php\"><P class=\"Style22\">$mot</P></a>";
	}
	if($_SESSION["auto_pds"])
	{
		$mot="Régulation - PDS";
		echo "<a href = \"pds/pds_frameset.php\"><P class=\"Style22\">$mot</P></a>";
	}
	//if($_SESSION["auto_brule"])
	//{
		$mot = $string_lang['CENTRE_DE_BRULES'][$langue];
		echo "<a href = \"brules/brule_frameset.php\"><P class=\"Style22\">$mot</P></a>";
	//}
	
	//print("<hr>");// barre horizontale
	//$mot = $string_lang['ENREGISTREMENT'][$langue].$_SESSION["member_id"];
	//echo $mot.$_SESSION["member_id"]."<br>";
	//print("<hr>");// barre horizontale
	$mot = $string_lang['SYNOPTIQUE_LITS_DISPO'][$langue];
	echo "<a href = \"synoptique/synoptique_frame.php\"><P class=\"Style22\">$mot</P></a>";

	$mot = $string_lang['CHANGER_MOTDEPASSE'][$langue];
	echo "<a href = \"new_password.php?back=login2.php\">$mot</a><br>";

	$mot = $string_lang['QUIT_SESSION'][$langue];
	echo "<a href = \"logout.php\"><P class=\"Style22\">$mot</P></a>";
}
else
{
	if(isset($userid))
	{
		//en cas de tentative et d'échec d'une ouverture de session avec authentification
		$mot = $string_lang['MSG_SITE_ACCESSIBLE'][$langue];
		echo $mot;
	}
	else
	{
		// l'utilisateur n'a pas encor essayé d'ouvrir une session ou l'a fermée
		//$mot = $string_lang['MSG_IDENTIFICATION'][$langue];
		//echo $mot;
	}
//===============================================================================================================
// 					AFFICHAGE DU DIALOGUE D'IDENTIFICATION
//===============================================================================================================
	print("<html>");
	print("<head>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("<title>Document sans nom</title>");
?>
<script>
function newMessage(message)
{
	adresse = "alerte/message_0.php";
	fenContact=window.open(adresse,"contacts","width=700,height=300,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
</script>
<?
	print("</head>");
	$message = true;
	if($message)
		print("<body onload=newMessage(0);>");
	else
		print("<body>");
?>


<table width="100%" border="1" bordercolor="#660066">
  <!--DWLayoutTable-->
  <tr>
    <td width="21%"><div align="center"><img src="images/Logo_SAGEC3.gif" width="156" height="79"></div></td>
    <td width="79%">&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="366" border="0" align="center" bgcolor="#CCCCFF">
  <tr bordercolor="#9933CC">
    <th width="6" rowspan="4" scope="col">&nbsp;</th>
    <th width="341" bordercolor="#9933CC" scope="col"><div align="center"><span class="Style20"><?php echo $string_lang['MSG_IDENTIFICATION'][$langue]; ?></span></div></th>
    <th width="10" rowspan="4" scope="col">&nbsp;</th>
  </tr>
  <tr bordercolor="#9933CC">
    <th bordercolor="#9933CC" scope="col"><span class="Style21"><img src="images/Ligne%20Horiz%20Bordeau.gif" width="340" height="4"></span></th>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="login2.php">
      <table width="450" border="0" align="center">
        <tr bgcolor="#FF9900">
          <td width="116" bgcolor="#660066"><div align="right"><span class="Style9"><?php echo $string_lang['SESSION_LOGIN'][$langue];?></span></div></td>
          <td width="201" bgcolor="#660066"><input type="text" name="login"></td>
        </tr>
        <tr bgcolor="#FF9900">
          <td nowrap bgcolor="#660066"><div align="right"><span class="Style9"><?php echo $string_lang['SESSION_PASSWORD'][$langue]?></span></div></td>
          <td bgcolor="#660066"><input type="password" name="password"></td>
        </tr>
        <tr bgcolor="#FF9900">
          <td bgcolor="#CCCCFF">&nbsp;</td>
          <td bgcolor="#CCCCFF"><div align="right">
              <input type="submit" name="Submit" value="<?php echo $string_lang['VALIDER'][$langue];?>">
          </div></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td><p align="center" class="Style21"><img src="images/Ligne%20Horiz%20Bordeau.gif" width="340" height="4"></p>
      <p align="left" class="Style22"><?php echo $string_lang['ECHEC_CONNEXION'][$langue];?></p>
    <p align="left" class="Style21">&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <th scope="col"><span class="Style13"><img src="images/Ligne%20Horiz%20Bordeau.gif" width="950" height="4"></span></th>
  </tr>
  <tr>
    <td><div align="center"><span class="Style13"><img src="images/Copyright%20SAGEC.gif" width="217" height="13"></span></div></td>
  </tr>
</table>
<p align="center" class="Style13">&nbsp;</p>
<p align="center" class="Style13">&nbsp;</p>
<p align="left" class="Style13">&nbsp;</p>
<p>&nbsp;</p>
</body>
<?php
	print("</html>");
}
?>
