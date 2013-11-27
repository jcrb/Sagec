<?php
/**
  *	archives_lire.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require_once $backPathToRoot."autorisations/droits.php";
include($backPathToRoot."login/init_security.php");
include_once("top.php");
include_once("menu.php");

$ordre_auteur = 'asc';
$ordre_date = 'asc';
$tri = 'tri_date';

	// WHERE LBS_visible = 'o'
	$requete = "SELECT livrebord_service.* , nom, prenom
					FROM livrebord_service, utilisateurs 
					WHERE utilisateurs.ID_utilisateur = LBS_expediteur
					";

	if($_REQUEST[tri]=='tri_date'){
		$requete .= " ORDER BY LBS_date ";
		if($_REQUEST[ordre_date]=='desc')$ordre_date='asc';else $ordre_date='desc';
		$requete .= $ordre_date;
	}
	else if($_REQUEST[tri]=='tri_auteur'){
		$requete .= " ORDER BY LBS_expediteur ";
		if($_REQUEST[ordre_auteur]=='asc')$ordre_auteur='desc';else $ordre_auteur='asc';
		$requete .= $ordre_auteur;
	}
	else{
		$requete .= " ORDER BY LBS_date DESC";
	}
	$result = ExecRequete($requete,$connexion);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<meta http-equiv="refresh" content="30">
	<title>Liste des messages</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body>
	<form name="blocnote" method="post" action="archives_lire.php">
	<table>
	
		<tr>
			<th width="10"><a href="archives_lire.php?tri=tri_date&ordre_date=<? echo $ordre_date;?>">Date</a></th>
			<th><a href="archives_lire.php?tri=tri_auteur&ordre_auteur=<? echo $ordre_auteur;?>">Expediteur</th>
			<th>Message</th>
			<th>[S]</th>
		</tr>
		
	<?php while($rep = mysql_fetch_array($result)) { 
		switch($rep['LBS_irq']){
			case 1: $color = '#EDF7F2';break;
			case 2: $color = '#FFBD4F';break;
			case 3: $color = '#98DB9C';break;
			default: $color='#EDF7F2';
		}
	?>
		<tr bgcolor="<?echo $color;?>">
			<td id="tdLeft"><?php echo $rep['LBS_date']; ?></td>
			<td id="tdLeft"><?php echo $rep['nom'].' '.$rep['prenom']; ?></td>
			<td id="tdLeft" width="75%"><?php echo Security::db2str($rep['LBS_message']); ?></td>
			<?php 
				if($rep['LBS_expediteur'] == $_SESSION['member_id']){ ?>
				<!-- <td><a href="bloc_note.php?messageID=<? echo $rep['LBS_ID'];?>">[M]</a></td> -->
				<td><a href="message_delete.php?messageID=<? echo $rep['LBS_ID'];?>" onclick="return confirm('Voulez-vous d�truire d�finitivement ce message ?');">[S]</a></td>
			<?php } else {?>
			<td>&nbsp;</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</table>
	</form>
</body>
</html>