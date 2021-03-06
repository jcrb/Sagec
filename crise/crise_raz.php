<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			crise_main.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";

$titre_principal = "Crise - R�initialisations";
$menu_sup = "<a href='../samu/samu_main.php'>R�gulation</a> > ";
$menu_sup .= "<a href='crise_main.php'>Crise </a> > ";
$menu_sup .= "Outils";

include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

if($_REQUEST['ok']=='R�initialiser')
{
	$message="";
	$ts = time();
	
	if($_REQUEST['blocnote']=='on')
	{
	$d = date("j_m_Y");
	$sauvegarde = "Sagec_sauvegarde/sauvegarde_".$_SESSION[evenement]."_".$ts.".txt";
	$fp = fopen($sauvegarde,"w");
	setlocale(LC_TIME,"french");
	$dateFR = strFTime("%A %d %B %Y");
	fwrite($fp,"Date: ".$dateFR." � ".date("H:i")."\n");
	
	fwrite($fp,"==================================== Sauvegarde du bloc-note ================================="."\n");
	
	fwrite($fp,"LB_ID".","."org_ID".","."LB_Expediteur".","."LB_Date".","."LB_Message".","."LB_visible".","."Localisation_ID".","."IQR"."\n");
	$requete="SELECT livrebord.*
		FROM livrebord
		ORDER BY LB_Date ASC";
	$resultat = ExecRequete($requete,$connexion);
	
	while($rub=mysql_fetch_array($resultat))
	{
		fwrite($fp,$rub[LB_ID].",".$rub[org_ID].",".$rub[LB_Expediteur].",".$rub[LB_Date].",".$rub[LB_Message].",".$rub[LB_visible].",".$rub[localisation].",".$rub[iqr]."\n");
	}
	
	fwrite($fp,"\n");

	fwrite($fp,"======================================== Fin des donn�es ======================================="."\n");
	fclose($fp);
	
	$message = "Main courante sauvegard�e dans ".$sauvegarde;
	
	// Sauvegarde de la table livrebordQR
	$sauvegarde = "Sagec_sauvegarde/sauvegarde_".$_SESSION[evenement]."_".$ts."_iqr.txt";
	$fp = fopen($sauvegarde,"w");
	$requete="SELECT * FROM livrebordQR";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		fwrite($fp,$rub[qr_ID].",".$rub[question_ID].",".$rub[reponse_ID]."\n");
	}
	fclose($fp);
		
	$message .= " et dans ".$sauvegarde;
	
	
	$requete = "TRUNCATE TABLE livrebord";
		$resultat = ExecRequete($requete,$connexion);
		$requete = "TRUNCATE TABLE livrebordQR";
		$resultat = ExecRequete($requete,$connexion);
		print("Livre de bord effac�<br>");
	
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script src="../ajax/ajax.js" type="text/javascript"></script>
	<script src="../ajax/JSON.js" type="text/javascript"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="raz" action= "crise_raz.php" method = "post">

<div id="div2">
	
	<fieldset id="field1">
		<legend>Main courante </legend>
		<tr>
			<td id="tdLeft">
			<input type="checkbox" id="blocnote" name="blocnote"  />
			<label for="blocnote">Effacer la main courante</label>
			</td>
		</tr>
		<br><b></b><?php echo $message ?></b>
	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="R�initialiser" onclick="return confirm('Etes vous s�re de vouloir effacer la main courante ?\n(la main courante sera sauvegard�e)');"/>
</div>


</form>
</body>
</html>
