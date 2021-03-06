<?php
/**
*	hopital_voir_synthese.php
*	tableau croisant h�pitaux et lits
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."date.php");
require($backPathToRoot."utilitaires/globals_string_lang.php");
$listeID = 3; // NE PAS MODIFIER
$nb_specialite_visible = 10;
$liste_typeID = "1','2','4','5','6','7','8','10','21','22";// liste des sp�cilit�s � afficher (voir table type_service)
$typeID = array(1,2,4,5,6,7,8,10,21,22);// idem sous forme de tableau

$mode = $_REQUEST['affichage'];
if($mode == 2)
	$affichage = "LITS_TOT";
else
{
	$affichage = "LITS_DISPO";
	$mode = 1;
}

$date = uDateTime2MySql(time());// maintenant
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<LINK REL ="stylesheet" TYPE ="text/css" HREF ="hopital2.css">
</head>
<body>
<form name="tableau crois�" action="hopital_voir_synthese.php" method="post">
<div id="">
	<table>
		<tr>
			<td><P><?php echo $date; ?></p></td>
			<td>
				<input type="radio" name="affichage" value = "1" id="" onchange = "this.form.submit();" <?php if($mode==1)echo "CHECKED";?> ><?php echo $string_lang['LITS_DISPO'][$langue];?>
				<input type="radio" name="affichage" value = "2" id="" onchange = "this.form.submit();" <?php if($mode==2)echo "CHECKED";?> ><?php echo $string_lang['LITS_AUTO'][$langue];?>
			</td>
			<td><input type="submit" name="maj" value="mise � jour"</td>
		</tr>
	</table>
</div>

<div id = "tableau">
<table border cellspacing="0" bgcolor="#dddddd">
<table id="sample" border cellspacing="0">
	<!-- EN TETE DE LA TABLE -->
	<tr bgcolor="#FF9933">
		<td><?php echo $string_lang['HOPITAL'][$langue];?></td>
		<td><?php echo $string_lang['VILLE'][$langue];?></td>
		<td><?php echo $string_lang['LITS_INSTALLE'][$langue];?></td>
		<td><?php echo $string_lang['LITS_DISPO'][$langue];?></td>
		<?php
		$requete = "SELECT type_nom FROM type_service WHERE Type_ID IN ('$liste_typeID')";
		$resultat = ExecRequete($requete,$connexion);
		while($rep=mysql_fetch_array($resultat))
		{
			?>
			<td><?php echo $string_lang[$rep['type_nom']][$langue]; ?></td>
			<?php
		}
		?>
	</tr>
<?php
/**
*	S�lectionne les h�pitaux d'int�r�t
*	la liste est limit�e aux h�pitaux Allemands ($zone = 100)
*	figurant sur la liste 2
*/
	$zone = 100;
	$requete = "SELECT hopital.Hop_ID,Hop_nom,ville_nom 
				FROM hopital,adresse,ville,hopital_visible
				WHERE hopital.adresse_ID = adresse.ad_ID 
				AND adresse.ville_ID = ville.ville_ID 
				AND hopital.Hop_ID = hopital_visible.Hop_ID
				AND hopital_visible.org_ID = '$_SESSION[organisation]'
				AND hopital_visible.liste_ID = '$listeID'
				ORDER BY ville_nom
				";
	$resultat = ExecRequete($requete,$connexion);
	?>
	
<?php
while($rep=mysql_fetch_array($resultat))
{
	?>
	<tr>
		<td><?php echo $rep['Hop_nom']; ?></td>
		<td><?php echo $rep['ville_nom']; ?></td>
		<?php
			$requete = "SELECT SUM(lits_dispo) AS lits_dispo,SUM(lits_sp)AS lits_totaux
							FROM lits
							WHERE lits.Hop_ID = '$rep[Hop_ID]'
							";
			$resultat2 = ExecRequete($requete,$connexion);
			$lits = mysql_fetch_array($resultat2);
			$total_lits += $lits['lits_totaux'];
			if($lits['lits_dispo']>0) $total_lits_dispo += $lits['lits_dispo'];
			if(!$lits['lits_totaux']) $lits['lits_totaux']="&nbsp";
			if($lits['lits_dispo']<1) $lits['lits_dispo']="&nbsp";
		?>
		<td align=right><?php echo $lits['lits_totaux']; ?></td>
		<td align=right><?php echo $lits['lits_dispo']; ?></td>
		<?php
			$requete = "SELECT SUM(lits_dispo) AS lits_dispo,SUM(lits_sp)AS lits_totaux,type_service.type_nom,type_service.Type_ID
							FROM lits,service,type_service
							WHERE lits.Hop_ID = '$rep[Hop_ID]'
							AND lits.service_ID = service.service_ID
							AND service.Type_ID = type_service.Type_ID
							AND type_service.Type_ID IN ('1','2','4','5','6','7','8','10','21','22')
							GROUP BY service.Type_ID
							ORDER BY service.Type_ID
							";
			$resultat3 = ExecRequete($requete,$connexion);
			
			$lits_specialite_totaux = array_fill(0, $nb_specialite_visible, "&nbsp;");
			$lits_specialite_dispo = array_fill(0, $nb_specialite_visible, "&nbsp;");
			
			while($litssp = mysql_fetch_array($resultat3))
			{
				$lits_specialite_totaux[$litssp['Type_ID']] = $litssp['lits_totaux'];
				$lits_specialite_dispo[$litssp['Type_ID']] = $litssp['lits_dispo'];
			}
			
			for($i = 0; $i < $nb_specialite_visible; $i++)
			{
				$total_lits_special[$i] += $lits_specialite_totaux[$typeID[$i]];
				$total_lits_special_dispo[$i] += $lits_specialite_dispo[$typeID[$i]];
				
				if(!$lits_specialite_totaux[$typeID[$i]]) $lits_specialite_totaux[$typeID[$i]]="&nbsp;";
				if(!$lits_specialite_dispo[$typeID[$i]]) $lits_specialite_dispo[$typeID[$i]]="&nbsp;";
				
				if($affichage == "LITS_DISPO") $print = $lits_specialite_dispo[$typeID[$i]];
				else if($affichage == "LITS_TOT") $print = $lits_specialite_totaux[$typeID[$i]];
				?>
				<!-- <td align=right><?php echo $litssp['type_nom']; ?></td> -->
				<td align=right><?php echo $print; ?></td>
				<!-- <td align=right><?php echo $lits['lits_dispo']; ?></td> -->
				<?php
			}
		?>
	</tr>
	<?php
}
?>
<!-- EN TETE DE LA TABLE -->
	<tr bgcolor="#FF9933">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><?php echo $string_lang['LITS_INSTALLE'][$langue];?></td>
		<td><?php echo $string_lang['LITS_DISPO'][$langue];?></td>
		<?php
		$requete = "SELECT type_nom FROM type_service WHERE Type_ID IN ('$liste_typeID')";
		$resultat = ExecRequete($requete,$connexion);
		while($rep=mysql_fetch_array($resultat))
		{
			?>
			<td><?php echo $string_lang[$rep['type_nom']][$langue]; ?></td>
			<?php
		}
		?>
	</tr>
<!-- Ligne des totaux-->
	<tr bgcolor="#FF9933">
		
		<td>&nbsp;</td>
		<td><b>TOTAL</b></td>
		<td align=right><?php echo $total_lits; ?></td>
		<td align=right><?php echo $total_lits_dispo; ?></td>
		<?php
			for($i = 0; $i < $nb_specialite_visible; $i++)
			{
				if($affichage == "LITS_DISPO") $print = $total_lits_special_dispo[$i];
				else if($affichage == "LITS_TOT") $print = $total_lits_special[$i];
				?>
				<td align=right><?php echo $print ?></td>
				<?php
			}
		?>
	</tr>
</table>
</div>
</form>
</body>
</html>