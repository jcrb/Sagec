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
  * programme: 			vecteur_ajout_wraper.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			Page de saisie/modification d'un vecteur
  *								 
  * version:				1.0
  * maj le:					20/03/2011
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Association - Ajouter/modifier un vecteur";
include_once("top.php");
include_once("menu.php");
require_once $backPathToRoot.'utilitaires/globals_string_lang.php';
require_once($backPathToRoot."dbConnection.php");
require_once($backPathToRoot."login/init_security.php");

if($_REQUEST['ttvecteur'] > 0){
	$requete = "SELECT * FROM vecteur WHERE Vec_ID = '$_REQUEST[ttvecteur]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
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
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "<?php echo $backPathToRoot.'vecteur/vecteur_enregistre.php?vecteur='.$_REQUEST[ttvecteur];?>" method = "post">
<input type="hidden" name="back" value="<?php echo $backPathToRoot.'asso/vecteur_ajout_wraper.php';?>">

	<?php 
		/** appel � la proc�dure standard de saisie d'un v�hicule */
		include_once($backPathToRoot."vecteur/vecteur_ajout.php");
	?>	
	

<?php
?>

</form>
</body>
</html>