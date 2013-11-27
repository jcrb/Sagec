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
  * programme: 			moyens.php
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
$back = $_REQUEST['back'];
$titre_principal = "Moyens disponibles";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$requete = "SELECT vecteur_type_ID, vecteur_type_nom 
				FROM vecteur_type,vecteur 
				WHERE vecteur.Vec_Type = vecteur_type_ID 
				AND Vec_Engage='o'";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat)){
	$moyen[$rub['vecteur_type_ID']] = $rub['vecteur_type_nom'];
}

$parc = Array(Array());
$requete = "SELECT Vec_Nom,Vec_Type FROM vecteur WHERE Vec_Engage='o' ORDER BY Vec_Type";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat)){
	$objet[] = $rub['Vec_Type'];
	$parc[$rub['Vec_Type']][]=$rub['Vec_Nom'];
}
// nb max de lignes du tableau $parc 
$nb_lignes = max(array_count_values($objet));


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

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo 'Moyens Engagés'?> </legend>
		<p>
			<table>
				<tr><th style="width:5%" ><?php echo'';?>
					<?php foreach($moyen as $key => $value){?>
					<th style="width:10%" align="center"><?php echo $value;?></th>
					<?php } ?>
				</tr>
				
				<?php 
					for($i = 0;$i<$nb_lignes;$i++){?>
						<tr><td align="center"><?php echo $i+1;?></td>
						<?php foreach($moyen as $key=> $values){?>
							<td align="left"><?php echo $parc[$key][$i];?></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table>
		</p>
	</fieldset>
	
</div>

<?php
?>

</form>
</body>
</html>