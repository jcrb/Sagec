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
  * programme: 			crise_hopitaux.php
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
$menu_sup .= "Hôpitaux actifs";

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
	<script src="../ajax/ajax.js" type="text/javascript"></script>
<script src="../ajax/JSON.js" type="text/javascript"></script>
<script>
	function vide()
	{
	if(objet_hxr.readyState == 4)
	{
		if(objet_hxr.status == 200)
		{
		}
		else
		{
			alert("Erreur serveur: "+objet_hxr.status+" - "+objet_hxr.statusText);
			objet_hxr.abort();
			objet_hxr = null;
		}
	}
	}
	function check(n)
	{
		objet_hxr = createXHR();
		var cases = document.getElementsByTagName('input');
		for(var i=0; i<cases.length; i++)
		{
			if(cases[i].type == 'checkbox' && cases[i].value == n)
			{
				if(cases[i].checked)
				{
					objet_hxr.open("get","hop_visible_enregistre.php?action=insert&value="+n,true);
				}
				else
					objet_hxr.open("get","hop_visible_enregistre.php?action=del&value="+n,true);
				objet_hxr.onreadystatechange = vide;
				objet_hxr.send(null);
			}
		}
	}
</script>
</head>

<body>
<form name="" action= "" method = "post">
<h3>Sélectionner les hôpitaux devant apparaitre dans le dossier victime</h3>
<?php

$requete = "SELECT Hop_nom, Hop_ID from hopital ORDER BY Hop_nom";
$resultat = ExecRequete($requete,$connexion);
$listeID = 1;//NE PAS MODIFIER
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	$requete = "SELECT hop_ID FROM hopital_visible WHERE hop_ID = '$rub[Hop_ID]' AND org_ID='$_SESSION[organisation]' AND liste_ID = '$listeID'";
	$resultat2 = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat2);
	if($rep['hop_ID'])
	{
		$check = "checked";
		$color="yellow";
	}
	else 
	{
		$check="";
		$color="";
	}
	
	?>
		<tr bgcolor='<?php echo $color;?>'>
			<td id="tdLeft">
			<input type="checkbox" name="ch[]" value="<?php echo $rub['Hop_ID'];?>" <?php echo $check;?> id="<?php echo $rub['Hop_ID'];?>" onClick="check(<?php echo $rub[Hop_ID];?>)">
			<label for="<?php echo $rub['Hop_ID'];?>"><?php echo Security::db2str($rub['Hop_nom']);?></label>
			</td>
		</tr>
	<?php
}
print("</table>");
?>

</form>
</body>
</html>