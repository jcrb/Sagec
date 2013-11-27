<?php
/**
/*	liste_org.php
*/
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//---------------------------------------------------------------------------------------------------------
//	programme: 		liste_org.php
//	date de création: 	7/10/2003
//	auteur:			jcb
//	description:	affichage des organismes
//	version:			1.2
//	maj le:			11/11/2004
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
if(! $_SESSION['auto_sagec'])header("Location:".$backPathToRoot."logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($backPathToRoot."dbConnection.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include($backPathToRoot."utilitairesHTML.php");
include_once($backPathToRoot."login/init_security.php");
include_once("top.php");
include_once("menu.php");

/**
*
*/
function phoneType($type,$typeID)
{
	print("<td>"); 
	$nb = count($type[$typeID],1);
	if($nb >0){
		for($i=0;$i<$nb;$i++){
			print($type[$typeID][$i]."<br>");
		}
	} else print("&nbsp;");
	print("</td>");
}
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Gestion des organismes</title>
	<meta http-equiv="content-type" content="="text/ht; charset=ISO-8859-15" ">
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>

<body>
<form name="organisme" action="" method="get">
<div id="div2">
	<table>
		<tr>
			<td><?php SelectTypeOrganisme($connexion,$organisme->organisme_type_ID,$langue); ?></td>
			<td><input type="submit" name="ok" value="valider"></td>
		</tr>
	</table>
	<?php
	if($_REQUEST['ok']=='valider')
	{
		$i = 0;
		$organisme_type_ID = $_REQUEST['organisme_type'];
		$requete = "SELECT organisme.*
						FROM organisme ";
						if($organisme_type_ID > 0)
						{
							$requete .= "WHERE organisme_type_ID = '$organisme_type_ID' ";
						}
						$requete .= "ORDER BY org_nom";
						
		$resultat = ExecRequete($requete,$connexion);
		?>
			<table  border="1" cellspacing="0">
			<tr bgcolor="yellow">
				<td>voir</td>
				<td>Organisme</td>
				<td>Ville</td>
				<td>Adresse 1</td>
				<td>Adresse 2</td>
				<td>Tel.fixe</td>
				<td>Portable</td>
				<td>Fax</td>
				<td>Courriel</td>
			</tr>
		<?php
		while($rep=mysql_fetch_array($resultat))
		{
			$i++;
			if($rep[adresse_ID] != 0)
			{
				$requete3 = "SELECT ad_zone1,ad_zone2,zip,ville_nom
								FROM adresse,ville
								WHERE ad_ID = $rep[adresse_ID]
								AND adresse.ville_ID = ville.ville_ID
								";
				$resultat3 = ExecRequete($requete3,$connexion);
				$rep3=mysql_fetch_array($resultat3);
				$rep[ville_nom] = $rep3[ville_nom];
				$rep[ad_zone1] = $rep3[ad_zone1];
				$rep[ad_zone2] = $rep3[ad_zone2];
			}
			?>
			<tr>
				<td><a href="<?php echo "organisme_saisie.php?orgID=$rep[org_ID]&ok=Envoyer&back=liste_org.php" ?>" ><?php echo $i ?></a></td>
				<td><?php echo Security::db2str($rep[org_nom]) ?></td>
				<td><?php echo Security::db2str($rep[ville_nom]) ?></td>
				<td><?php echo Security::db2str($rep[ad_zone1]) ?></td>
				<td><?php echo Security::db2str($rep[ad_zone2]) ?></td>
				<?php
					// liste des contacts organisme = 2
					$requete2 = "SELECT * FROM contact WHERE nature_contact_ID = 2 AND identifiant_contact = '$rep[org_ID]' ORDER BY type_contact_ID";
					$resultat2 = ExecRequete($requete2,$connexion);
					$type = array();
					while($rep2=mysql_fetch_array($resultat2))
					{
						$type[$rep2[type_contact_ID]][] = $rep2[valeur];
					}
					// telephone fixe
					phoneType($type,1);
					// telephone portable
					phoneType($type,4);
					// fax 
					phoneType($type,7);
					// mail 
					phoneType($type,5);
				?>
			</tr>
			<?php
		}
		?> </table> <?php
	}
	?>
</div>
</form>
</body>
</html>
