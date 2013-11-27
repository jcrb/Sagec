<?php
/**
  *	liste des victimes
  *	liste_victime.php
  */
if(empty($backPathToRoot))$backPathToRoot="../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."autorisations/droits.php");

//$evenement = $_SESSION['evenement'];
$requete = "SELECT evenement_ID FROM alerte";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);
$evenement = $rep['evenement_ID'];

/**
  *	organisation des tris
  *	on mémorise dans une variable de session l'ordre des tris
  */
if(!isset($_SESSION[TRI])) $_SESSION[TRI] = 'no_ordre';
if(!isset($_SESSION[ORDRE])) $_SESSION[ORDRE] = 'asc';

$ordre = 'asc';

$tri = $_REQUEST['tri'];
if($tri==NULL)
	$tri = $_SESSION[TRI];
else
	$_SESSION[TRI] = $tri;

$ordre = $_REQUEST['ordre'];
if($ordre==NULL)
	$ordre = $_SESSION[ORDRE];
else
	$_SESSION[ORDRE] = $ordre;

switch($tri){
	case 'no_ordre':if($ordre=='asc')$ordre_no='desc';else $ordre_no='asc';break;
	case 'gravite':if($ordre=='asc')$ordre_gravite='desc';else $ordre_gravite='asc';break;
	case 'nom':if($ordre=='asc')$ordre_nom='desc';else $ordre_nom='asc';break;
	case 'sexe':if($ordre=='asc')$ordre_sexe='desc';else $ordre_sexe='asc';break;
	case 'Hop_ID':if($ordre=='asc')$ordre_hop='desc';else $ordre_hop='asc';break;
	case 'victime_ID':if($ordre=='asc')$ordre_id='desc';else $ordre_id='asc';break;
}
/** ------------ */

/**
  *	mise en page
  */
$nombre = 10;  // on va afficher 10 résultats par page.
// nb enregistrements dans la table
$requete = "SELECT COUNT(no_ordre)as total FROM victime";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
$total= $rub['total']; 
$nb_page = ceil($total/$nombre);

if(!isset($_SESSION['limite1'])) $_SESSION['limite1'] = 1;
if(!isset($_SESSION['limite2'])) $_SESSION['limite2'] = $nombre;

if(!empty($_REQUEST['limite1'])) $limite1 = $_REQUEST['limite1'];else $limite1 = $_SESSION['limite1'];
if(!empty($_REQUEST['limite2'])) $limite2 = $_REQUEST['limite2'];else $limite2 = $_SESSION['limite2'];

if($_REQUEST['btn']==' >> ')
{
	$limite2 = $total;
	$limite1 = $limite2 - $nombre;
	if($limite1 < 1) $limite1 = 1;
	//$page_courante  = $nb_page;
}
else if($_REQUEST['btn']==' > ')
{
	$limite1 += $nombre;
	$limite2 = $limite1 + $nombre -1;
	if($limite2 > $total){
		$limite2 = $total;
		$limite1 = $limite2 - $nombre;
	}
}
else if($_REQUEST['btn']==' < ')
{
	$limite1 -= $nombre;
	if($limite1 < 1)$limite1 = 1;
	$limite2 = $limite1 + $nombre - 1;
	//$page_courante  = $_REQUEST['page_courante'] - 1;
}
else  if($_REQUEST['btn']==' << ')
{
	$limite1 = 1;
	$limite2 = $limite1 + $nombre - 1;
	$page_courante = 1;
}

$_SESSION['limite1'] = $limite1;
$_SESSION['limite2'] = $limite2;

$page_courante  = floor($limite2/$nombre);
/** ------------ */

/**
  *	Utilisation de la jointure externe gauche pour récupérer toutes les lignes de la table victime
  *	même si certains items (gravité, hopital, etc.) ne sont pas renseignés
  */
  $limite = $limite1-1;
  $requete = "SELECT victime.*,service_nom,Hop_nom,gravite_nom,gravite_couleur,ts_nom,Vec_nom
				FROM victime LEFT OUTER JOIN service ON victime.service_ID = service.service_ID
								 LEFT OUTER JOIN hopital ON victime.Hop_ID = hopital.Hop_ID
								 LEFT OUTER JOIN gravite ON victime.gravite = gravite.gravite_ID
								 LEFT OUTER JOIN temp_structure ON victime.localisation_ID = temp_structure.ts_ID
								 LEFT OUTER JOIN vecteur ON victime.vecteur_ID = vecteur.Vec_ID
				WHERE victime.evenement_ID = '$evenement'
				ORDER BY ".$tri." ".$ordre." LIMIT ".$limite.','.$nombre;
				//echo $requete;
$victime = ExecRequete($requete,$connexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<comment> rafraichissement automatique toutes les 30 secondes </comment>
	<meta http-equiv="refresh" content="30">
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="dossier_victime.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	
	<script>
		function setColor()
		{
			var color = new Array("snow","#ff000f","#ffff00","#fffafa","#40e0d0","#a9a9a9","#7fff00","#ff000f","#ffff00","#7fff00","#7fff00");
			n = document.forms.dossier.gravite. options.selectedIndex;
			//alert(n);
			document.getElementById("gravite").style.backgroundColor=color[n];
		}
	</script>
</head>

<body>
	<form name="dossier" action="" method="get">
	
	<input type="hidden" name="limite1" value="<?php echo $limite1;?>">
	<input type="hidden" name="limite2" value="<?php echo $limite2;?>">
	<input type="hidden" name="tri" value="<?php echo $tri;?>">
	<input type="hidden" name="ordre" value="<?php echo $ordre;?>">
	<input type="hidden" name="back" value="<?php echo $back;?>">
	
	<div id = "">
		<fieldset id="">
		<table id="table_hop" >  <!-- width="100%"  style="table-layout:fixed" -->
		<thead>
			<tr>
				<!--<th><a href="liste_victime.php?tri=victime_ID&ordre=<?php echo $ordre_id;?>" class="entete">n°</a></th> -->

				<th class="entete" style="width:5px" onClick="submit();"><a href="dossier_cata_liste_entete.php?tri=victime_ID&ordre=<?php echo $ordre_id;?>" class="entete">n°</a></th>
				<th style="width:30px"><a href="dossier_cata_liste_entete.php?tri=no_ordre&ordre=<?php echo $ordre_no;?>" class="entete">Identifiant</a></th>
				<th style="width:25px"><a href="dossier_cata_liste_entete.php?tri=nom&ordre=<?php echo $ordre_nom;?>" class="entete">Nom</a></th>
				<th style="width:20px">Prénom</th>
				<th style="width:5px; text-align:center"><a href="dossier_cata_liste_entete.php?tri=sexe&ordre=<?php echo $ordre_sexe;?>" class="entete">Sexe</a></th>
				<th style="width:5px">Age</th>
				<th style="width:10px"><a href="dossier_cata_liste_entete.php?tri=gravite&ordre=<?php echo $ordre_gravite;?>" class="entete">Gravité</a></th>
				<th style="width:20px">Localisation</th>
				<th style="width:40px"><a href="dossier_cata_liste_entete.php?tri=Hop_ID&ordre=<?php echo $ordre_hop;?>" class="entete">Hôpital</a></th>
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
				<td><a href="dossier_cata_saisie.php?identifiant=<? echo $rub['no_ordre'];?>&new=false"><?php echo $rub['no_ordre'];?></a></td>
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
			$limitesuivante = $limite + $nombre;
			$limiteprecedente = $limite - $nombre; 
			?>
			</tboby>
		</table>
		<br>
		
		<div align="center">
			<input type="submit" value=" << " name="btn">
			<?php
				if($limite1 > $nombre)
				{
    					echo '<input type="submit" value=" < " name="btn">';
    					echo '<input type="hidden" value="'.$limitesuivante.'" name="limite2">';
    					echo '<input type="hidden" value="'.$page_courante.'" name="page_courante">';                
				}
				else print("&nbsp;");
				print(" ".$page_courante." / ".$nb_page." ");
				if($limite2 < $total)
					{
    					echo '<input type="submit" value=" > " name="btn">';
    					echo '<input type="hidden" value="'.$limitesuivante.'" name="limite2">';
    					echo '<input type="hidden" value="'.$page_courante.'" name="page_courante">';                
				}
				else print("&nbsp;");
				?>
			<input type="submit" value=" >> " name="btn">
		</div>
		
		</fieldset>
	</div>
</form>
</body>
</html>