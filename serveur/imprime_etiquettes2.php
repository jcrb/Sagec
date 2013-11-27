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
  * programme: 			imprime_etiquettes2.php
  * date de création: 	12/02/2010
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
include_once("top_main.php");
include_once("menu_main.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$nb = $_REQUEST[nb];
if($nb < 0) $nb = 0;
if($nb > 99999) $nb = 10;

$requete = "SELECT org_nom FROM organisme WHERE org_ID='$_REQUEST[orgByType]'";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);

$organisme = substr('0000'.$_REQUEST['orgByType'],-4,4);
/**
  * a remettre en production
	$organisme = substr('0000'.$_SESSION['organisation'],-4,4);
  */
if($_REQUEST['type']==1)
	$pays = '379';	// France exercice
else
	$pays = '300';
	
$no_depart = $_REQUEST['no']; // fourchette d'impression 
if($no_depart < 0) $no_depart = 1;
$no_final = $no_depart + $nb -1;


/**
  *	get_cle()
  *	calcule la clé du code
  */
function get_cle($code)
{
	for($i=strlen($code)-1;$i >0; $i-=2)
	{
		(int)$a = 3 * (int)$code[$i];
		(int)$b = (int)$code[$i-1];
		$mot = (int)$mot + (int)$a + (int)$b;
	}
	$clef = 0;
	while(($mot+$clef) % 10 != 0)
	{
		$clef++;
	}
	return $clef;
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

<body onload="">

<form name="" action= "" method = "post">


<H2>Emetteur: <?php echo $rep['org_nom'];?></h2>

<p>
	<!--
	<a href="paper_printer.php?pays=<?php echo $pays;?>&deb=<?php echo $no_depart;?>&fin=<?php echo $no_final;?>&org=<?php echo $organisme;?>">impression papier</a>
	-->
</p>
		
<table id="table50">
<?php
for($i=$no_depart; $i<$no_final; $i++)
{
	$code = $pays.$organisme.substr('00000'.$i,-5,5);
	$code .= get_cle($code);
	if($_REQUEST[ferme] != "on")
	{
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $code;?></td>
		<?php
	}
	else
	{
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><IMG SRC="code_barre_fabrique.php?ean=<?php echo $code;?>&largeur=130&hauteur=45"></td>
		</tr>
		<?php
		//print("<IMG SRC=\"code_barre_fabrique.php?ean=$code&largeur=130&hauteur=45\"><br>");
	}
}

?>
</table>
	

</form>
</body>
</html>