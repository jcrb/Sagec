<?php
/**
  * dossier_cata_listing.php
  *
  */
  if(empty($backPathToRoot))$backPathToRoot="../";
	require($backPathToRoot."dbConnection.php");
	require($backPathToRoot."login/init_security.php");
	require($backPathToRoot."autorisations/droits.php");
	include_once("cata_menu_top.php");
	
/**
  *	Utilisation de la jointure externe gauche pour récupérer toutes les lignes de la table victime
  *	même si certains items (gravité, hopital, etc.) ne sont pas renseignés
  */

//$evenement = $_SESSION['evenement'];
$requete = "SELECT evenement_ID FROM alerte";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);
$evenement = $rep['evenement_ID'];
  $requete = "SELECT victime.*,service_nom,Hop_nom,gravite_nom,gravite_couleur,ts_nom,Vec_nom
				FROM victime LEFT OUTER JOIN service ON victime.service_ID = service.service_ID
								 LEFT OUTER JOIN hopital ON victime.Hop_ID = hopital.Hop_ID
								 LEFT OUTER JOIN gravite ON victime.gravite = gravite.gravite_ID
								 LEFT OUTER JOIN temp_structure ON victime.localisation_ID = temp_structure.ts_ID
								 LEFT OUTER JOIN vecteur ON victime.vecteur_ID = vecteur.Vec_ID
				WHERE victime.evenement_ID = '$evenement'
				";
				//echo $requete;
	$victime = ExecRequete($requete,$connexion);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>

	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="dossier_victime.css" type="text/css" media="all" />
	
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	
	<link rel="stylesheet" href="../js/css/jquery.dataTables.css" />
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="startDataTables.js"></script>

</head>

<body>
	<form name="dossier" action="" method="get">
	<div id = "" >
		<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
			<tr>
				<!--<th><a href="liste_victime.php?tri=victime_ID&ordre=<?php echo $ordre_id;?>" class="entete">n°</a></th> -->

				<th class="entete" style="width:5px">n°</th>
				<th style="width:30px">Identifiant</th>
				<th style="width:25px">Nom</th>
				<th style="width:20px">Prénom</th>
				<th style="width:5px; text-align:center">Sexe</th>
				<th style="width:5px">Age</th>
				<th style="width:10px">Gravité</th>
				<th style="width:20px">Localisation</th>
				<th style="width:40px">Hôpital</th>
				<th style="width:30px">Service</th>
				<th style="width:30px">Vecteur</th>
				<?php if (est_autorise("SUP_VICTIME")){?>
					<th>S</th>
				<?php } ?>
			</tr>
			</thead>
			<tboby>
			<?php $i=0;while($rub = mysql_fetch_array($victime)){?>
			<tr>
				<td class="td_left"><?php echo $rub['victime_ID'];?></td>
				<td><a href="dossier_cata_saisie.php?identifiant=<? echo $rub['no_ordre'];?>"><?php echo $rub['no_ordre'];?></a></td>
				<td><?php echo $rub['nom'];?></td>
				<td><?php echo Security::db2str($rub['prenom']);?></td>
				<td><?php if($rub['sexe']==1)echo 'H';else if($rub['sexe']==2) echo'F';?></td>
				<td><?php if($rub['age1']>0)echo $rub['age1'];?></td>
				<td class="td_left" bgcolor="<?php echo $rub['gravite_couleur'];?>"><?php echo $rub['gravite_nom'];?></td>
				<td><?php echo $rub['ts_nom'];?></td>
				<td style="width:40px"><?php echo Security::db2str($rub['Hop_nom']);?></td>
				<td><?php echo $rub['service_nom'];?></td>
				<td><?php echo $rub['Vec_nom'];?></td>
				<?php if (est_autorise("SUP_VICTIME")){?>
					<td><a href="dossier_cata_delete.php?id=<?php echo $rub['victime_ID'];?>">sup</a></td>
				<?php } ?>
			</tr>
			<?php } 
			?>
			</tboby>
		</table>
	</div>
</body>
</html>