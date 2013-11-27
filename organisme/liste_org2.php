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
//	programme: 		liste_org2.php
//	date de création: 	7/10/2003
//	auteur:			jcb
//	description:	affichage des organismes
//	version:			1.2
//	maj le:			11/11/2004
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
if(! $_SESSION['auto_sagec'])header("Location:".$backPathToRoot."logout.php");
$langue = $_SESSION['langue'];
require($backPathToRoot."dbConnection.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include($backPathToRoot."utilitairesHTML.php");
include_once($backPathToRoot."login/init_security.php");
include_once("top.php");
include_once("menu.php");

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
			<td><a href="organisme_menu.php">menu</a></td>
		</tr>
	</table>
	<?php
	if($_REQUEST['ok']=='valider')
	{
		$i = 0;
		$organisme_type_ID = $_REQUEST['organisme_type'];
		$requete = "SELECT organisme.*,adresse.*,ville_nom
						FROM organisme, adresse, ville";
						if($organisme_type_ID > 0)
						{
							$requete.= " WHERE organisme_type_ID = '$organisme_type_ID' AND organisme.adresse_ID = adresse.ad_ID
										 AND adresse.ville_ID = ville.ville_ID
							
							";
						}
						else
						{
							$requete.= " WHERE organisme.adresse_ID = adresse.ad_ID
										 AND adresse.ville_ID = ville.ville_ID
							";
						}
						
		$resultat = ExecRequete($requete,$connexion);
		?>
			<table  border="1" cellspacing="0">
			<tr bgcolor="yellow">
				<td>voir</td>
				<td>supprimer</td>
				<td>Organisme</td>
				<td>Ville</td>
				<td>Adresse 1</td>
				<td>Adresse 2</td>
				<td>longitude</td>
				<td>latitude</td>
			</tr>
		<?php
		while($rep=mysql_fetch_array($resultat))
		{
			foreach($rep as $key=>$value){
				if($value =="" || $value =="0")
					$rep[$key]="&nbsp;";
			}
			$i++;
			if($rep[adresse_ID != 0])
			{
			}
			?>
			<tr>
				<td><a href="<?php echo "organisme_saisie.php?orgID=$rep[org_ID]&ok=Envoyer&back=$_REQUEST[organisme_type]&ad=$rep[adresse_ID]" ?>" ><?php echo $i ?></a></td>
				<td><a href="org_supprime.php?orgID=<? echo $rep[org_ID];?>&back=<? echo $_REQUEST[organisme_type];?>" onclick="return confirm('Etes vous sûre de vouloir supprimer cet organisme ?');">Supprimer</a></td>
				<td><?php echo Security::db2str($rep[org_nom]) ?></td>
				<td><?php echo Security::db2str($rep[ville_nom]) ?></td>
				<td><?php echo Security::db2str($rep[ad_zone1]) ?></td>
				<td><?php echo Security::db2str($rep[ad_zone2]) ?></td>
				<td><?php echo $rep[ad_longitude] ?></td>
				<td><?php echo $rep[ad_latitude] ?></td>
				<?php
					// liste des contacts
					$requete2 = "SELECT * FROM contact WHERE nature_contact_ID = 2 AND identifiant_contact = '$rep[org_ID]' ORDER BY type_contact_ID";
					$resultat2 = ExecRequete($requete2,$connexion);
					while($rep2=mysql_fetch_array($resultat2))
					{
						print("<td>$rep2[valeur]</td>");
					}
				?>
				<td><?php echo $rep[tel1] ?></td>
				<td><?php echo $rep[tel2] ?></td>
				<td><?php echo $rep[tel3] ?></td>
				<td><?php echo $rep[fax] ?></td>
				<td><?php echo $rep[mail1] ?></td>
				<td><?php echo $rep[mail2] ?></td>
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
