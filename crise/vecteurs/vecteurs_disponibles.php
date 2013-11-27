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
  * programme: 			vecteur_disponibles.php
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
$backPathToRoot = "../../";

$menu_sup = "<a href='../../samu/samu_main.php'>R�gulation</a> > ";
$menu_sup .= "<a href='../crise_main.php'>Crise</a> > ";
$menu_sup .= "<a href='vecteurs_index.php'>Vecteurs</a> > ";
$menu_sup .= "Vecteurs disponibles";

include_once("vecteurs_top.php");
include_once("vecteurs_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");


$requete="SELECT Vec_Nom,vecteur_type_nom FROM vecteur,vecteur_type WHERE Vec_Engage='o' AND vecteur_type_ID = Vec_Type ORDER BY vecteur_type_nom";
$resultat = ExecRequete($requete,$connexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Superviseur</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body onload="">

<form name="" action= "" method = "post">

<div id="div2">
	
	<fieldset id="field1">
		<legend>Vecteurs Disponibles </legend>
		<p>
			<table>
			<?php while($rub=mysql_fetch_array($resultat)){ ?>
			<tr>
				<td><?php echo $rub['vecteur_type_nom'];?></td>
				<td><?php echo $rub['Vec_Nom'];?></td>
			</tr>
			<?php } ?>
			</table>
		</p>
	</fieldset>
	
	
</div>


</form>
</body>
</html>