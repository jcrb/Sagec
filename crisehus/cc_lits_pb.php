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
  * programme: 			cc_lits_pb.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			Synthese des lits au fur et � mesure que les maj arrivent
  *							Les services apparraissent au fur et a mesure que leur code UF
  *							est saisi.
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Direction G�n�rale - Lits & places";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

/** table des types de service */
$requete = "SELECT Type_ID, type_nom FROM type_service";
$resultat = ExecRequete($requete,$connexion);
$service_type = Array();
while($rep = mysql_fetch_array($resultat)){
	$service_type[$rep['Type_ID']] = $rep['type_nom'];
}

/** nombre de tranches horaires */
$tmax = 10;
$tmax2 = 6;
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
	<?php 
		$requete = "SELECT lits_pb.*,Hop_nom, service_nom, type_ID,service_code
						FROM lits_pb, hopital,service
						WHERE hopital.Hop_ID = lits_pb.structure_ID
						AND service.service_code LIKE lits_pb.unite_ID
						ORDER BY type_ID
						";
		$resultat = ExecRequete($requete,$connexion);
		?><table>
			<tr>
				<th>H�pital</th>
				<th>Service</th>
				<th>Code</th>
				<th>Type</th>
				<th>T0</th>
				<th>30 mn</th>
				<th>60 mn</th>
				<th>6 h</th>
				<th>12 h</th>
				<th>24 h</th>
				<th>C</th>
				<th>I</th>
				<th>A</th>
				<th>M</th>
				<th>Mise � jour</th>
			</tr>
		<?php
		while($rep = mysql_fetch_array($resultat))
		{
			/** total des lits par type de service */
			$places[$rep['type_ID']][0] += $rep['t1'];
			$places[$rep['type_ID']][1] += $rep['t2'];
			$places[$rep['type_ID']][2] += $rep['t3'];
			$places[$rep['type_ID']][3] += $rep['t4'];
			$places[$rep['type_ID']][4] += $rep['t5'];
			$places[$rep['type_ID']][5] += $rep['t6'];
			
			/** total par groupe horaire */
			$total[0] += $rep['t1'];
			$total[1] += $rep['t2'];
			$total[2] += $rep['t3'];
			$total[3] += $rep['t4'];
			$total[4] += $rep['t5'];
			$total[5] += $rep['t6'];
			$total[6] += $rep['cadre'];
			$total[7] += $rep['ide'];
			$total[8] += $rep['ash'];
			$total[9] += $rep['med'];
			
			/** affichage du tableau */
			?>
			<tr>
				<td style="text-align:left"><?php echo $rep['Hop_nom'];?></td>
				<td style="text-align:left"><?php echo $rep['service_nom'];?></td>
				<td style="text-align:left"><?php echo $rep['service_code'];?></td>
				<td style="text-align:left"><?php echo $service_type[$rep['type_ID']];?></td>
				<td><?php echo $rep['t1'];?></td>
				<td><?php echo $rep['t2'];?></td>
				<td><?php echo $rep['t3'];?></td>
				<td><?php echo $rep['t4'];?></td>
				<td><?php echo $rep['t5'];?></td>
				<td><?php echo $rep['t6'];?></td>
				<td><?php echo $rep['cadre'];?></td>
				<td><?php echo $rep['ide'];?></td>
				<td><?php echo $rep['ash'];?></td>
				<td><?php echo $rep['med'];?></td>
				<td><?php echo $rep['date_maj'];?></td>
			</tr>
			<?php
		}
		?>
			<tr>
				<th colspan="4" style="text-align:right"></th>
				<th>T0</th>
				<th>30 mn</th>
				<th>60 mn</th>
				<th>6 h</th>
				<th>12 h</th>
				<th>24 h</th>
				<th>C</th>
				<th>I</th>
				<th>A</th>
				<th>M</th>
			</tr>
			<tr>
				<th colspan="4" style="text-align:right">Total
				<?php for($i=0;$i<$tmax;$i++){?><th><?php echo $total[$i];?></th><?php }
				?>
				</th>
			</tr>
		</table>
		<?php
	?>
	<br>
	<table>
		<tr>
			<th>Specialit�</th>
			<?php for($i=0;$i<$tmax2;$i++){?><th><?php echo 'T'.$i;?></th><?php }?>
		</tr>
		<?php
			for($i=0; $i < sizeof($service_type);$i++){?>
		<tr>
			<td><?php echo Security::db2str($service_type[$i]);?></td>
			<?php for($j=0;$j<$tmax2;$j++){?><td><?php echo $places[$i][$j];?></td><?php }?>
		</tr>
		<?php } ?>
	</table>
</div>

<?php
?>

</form>
</body>
</html>