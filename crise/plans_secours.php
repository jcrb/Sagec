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
  * programme: 			plans_secours.php
  * date de création: 	11/2010
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

$titre_principal = "Plans de secours";
$menu_sup = "<a href='../samu/samu_main.php'>Régulation</a> > ";
$menu_sup .= "<a href='crise_main.php'>Crise</a> > ";
$menu_sup .= "Plans";

include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

$requete = "SELECT * FROM ppi";
$resultat = ExecRequete($requete,$connexion);
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

<body>
<form name="" action= "" method = "post">
<table>
	<?php
		$ligne_i=0;
		while($rub=mysql_fetch_array($resultat))
		{
		?>
		<tr <?= ($ligne_i++ % 2 == 1) ? ' class="impaire"' : ' class="paire"' ; ?>>
		<td><?php echo $rub[ppi_ID];?></td>
		<td id="tdLeft"><?php echo Security::db2str($rub[ppi_nom]);?></td>
		<td id="tdLeft"><?php echo Security::db2str($rub[ppi_activite]);?></td>
		<td><?php echo $rub[ppi_date];?></td>
		<td><a href="voir_plans.php?id=<?php echo $rub[ppi_ID];?>&nom=<?php echo $rub[ppi_nom];?>"> voir</a></td>
		</tr>
		<?php } ?>
</table>

</form>
</body>
</html>