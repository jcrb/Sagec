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
  * programme: 			victimes.php
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
$titre_principal = "Victimes";
include_once("top.php");
include_once("menu.php");
//include_once($backPathToRoot."/dossier_cata/cata_menu_top.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$evenement = $_SESSION['evenement'];


/**
  *	organisation des tris
  */
$ordre = 'asc';
$tri = $_REQUEST['tri'];
if($tri==NULL)$tri = 'no_ordre';
$ordre = $_REQUEST['ordre'];
if($ordre==NULL)$ordre = 'asc';
switch($tri){
	case 'no_ordre':if($ordre=='asc')$ordre_no='desc';else $ordre_no='asc';break;
	case 'gravite':if($ordre=='asc')$ordre_gravite='desc';else $ordre_gravite='asc';break;
	case 'nom':if($ordre=='asc')$ordre_nom='desc';else $ordre_nom='asc';break;
	case 'sexe':if($ordre=='asc')$ordre_sexe='desc';else $ordre_sexe='asc';break;
	case 'Hop_ID':if($ordre=='asc')$ordre_hop='desc';else $ordre_hop='asc';break;
	case 'no':if($ordre=='asc')$ordre_no='desc';else $ordre_no='asc';break;
}
/** ------------ */

/**
  *	mise en page
  */
$nombre = 10;  // on va afficher 25 résultats par page.
// nb enregistrements dans la table
$requete = "SELECT COUNT(no_ordre)as total FROM victime";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
$total= $rub['total']; 
$nb_page = ceil($total/$nombre);

if(!empty($_REQUEST['limite1'])) $limite1 = $_REQUEST['limite1'];else $limite1 = 1;
if(!empty($_REQUEST['limite2'])) $limite2 = $_REQUEST['limite2'];else $limite2 = $nombre;

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
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<link rel="stylesheet" href="../dossier_cata/div.css" type="text/css" media="all" />
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">
<div id = "div2">
		<fieldset id="field2">
		<table id="jj">
			<tr>
				<th><a href="victimes.php?tri=victime_ID&ordre=<? echo $ordre_no;?>" class="entete">n°</a></th>
				<th><a href="victimes.php?tri=no_ordre&ordre=<? echo $ordre_no;?>" class="entete">identifiant</a></th>
				<th><a href="victimes.php?tri=nom&ordre=<? echo $ordre_nom;?>" class="entete">nom</a></th>
				<th>prénom</th>
				<th><a href="victimes.php?tri=sexe&ordre=<? echo $ordre_sexe;?>" class="entete">sexe</a></th>
				<th>age</th>
				<th><a href="victimes.php?tri=gravite&ordre=<? echo $ordre_gravite;?>" class="entete">gravité</a></th>
				<th>localisation</th>
				<th><a href="victimes.php?tri=Hop_ID&ordre=<? echo $ordre_hop;?>" class="entete">Hôpital</a></th>
				<th>service</th>
				<th>vecteur</th>
			</tr>
			<?php $i=0;while($rub = mysql_fetch_array($victime)){?>
			<tr>
				<td class="td_left"><?php echo $rub['victime_ID'];?></td>
				<td><?php echo $rub['no_ordre'];?></a></td>
				<td><?php echo $rub['nom'];?></td>
				<td><?php echo $rub['prenom'];?></td>
				<td><?php if($rub['sexe']==1)echo 'H';else if($rub['sexe']==2) echo'F';?></td>
				<td><?php if($rub['age1']>0)echo $rub['age1'];?></td>
				<td class="td_left" bgcolor="<?php echo $rub['gravite_couleur'];?>"><?php echo $rub['gravite_nom'];?></td>
				<td><?php echo $rub['ts_nom'];?></td>
				<td><?php echo $rub['Hop_nom'];?></td>
				<td><?php echo $rub['service_nom'];?></td>
				<td><?php echo $rub['Vec_nom'];?></td>
			</tr>
			<?php }
			$limitesuivante = $limite + $nombre;
			$limiteprecedente = $limite - $nombre; 
			?>
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
<?php
?>

</form>
</body>
</html>