<?php
//----------------------------------------- SAGEC ---------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
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
//---------------------------------------------------------------------------------
//	programme: 				dispo_main.php
//	date de création: 	12/02/2010
//	auteur:					jcb
//	description:			portail accès au services par les hôpitaux.
//								Remplace le dossier services 
//	version:					1.0
//	maj le:			
//---------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Services - Disponibilités en lits";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

/** Si Priorite_Alerte = 9, ne pas afficher 
  * Sélectionne les services concernés
*/
	$tri = $_REQUEST['tri'];
	$ordre = $_REQUEST['ordre'];
	

	if($_SESSION['auto_org']=='o'){
		$requete="SELECT service.service_ID,service_nom,service_code, lits_dispo,lits_sp,date_maj,type_nom,places_dispo,places_auto
				FROM service,hopital, lits,type_service
				WHERE hopital.org_ID = '$_SESSION[organisation]'
				AND service.Priorite_Alerte <> 9
				AND service.Hop_ID = hopital.Hop_ID
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY ";
	}
	if($_SESSION['auto_org']=='o'){
		$requete="SELECT service.service_ID,service_nom,service_code,lits_dispo,places_dispo,date_maj,type_nom
				FROM service,lits,type_service
				WHERE service.org_ID = '$_SESSION[organisation]'
				AND service.Priorite_Alerte <> 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY ";
		}
	elseif($_SESSION["auto_hopital"]=='o')
		$requete="SELECT service.service_ID, service_nom, service_code, lits_dispo,lits_sp, date_maj, type_nom,places_dispo,places_auto
				FROM service, lits,type_service
				WHERE service.Hop_ID = '$_SESSION[Hop_ID]'
				AND service.Priorite_Alerte <> 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY ";

	elseif($_SESSION["service"]>0)
		$requete = "SELECT service.service_ID,service_nom,service_code,lits_dispo,lits_sp,date_maj,type_nom,places_dispo,places_auto
				FROM service, lits,type_service
				WHERE service.service_ID = $_SESSION[service]
				AND service.Priorite_Alerte <> 9
				AND lits.service_ID = service.service_ID
				AND service.Type_ID = type_service.Type_ID
				ORDER BY 
				";
	/** pour le triage des colonnes */
	switch($tri){
		case 'service':$requete.='service_nom';break;
		case 'type':$requete.='type_nom';break;
		case 'code':$requete.='service_code';break;
		default:$requete.='type_nom';break;
	}
	
	$requete.=' '.$ordre;
	
	$resultat = ExecRequete($requete,$connexion);
	
	if($ordre == 'ASC')$ordre = 'DESC';else $ordre = 'ASC';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des Lits</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom[0]').focus()">

<form name="Lits_disponibles" action= "lits_dispo_enregistre.php" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Services à mettre à jour</legend>
		<p>
			<table width="50%">
				<tr>
					<th><a href="lits_dispo.php?tri=code&ordre=<?php echo $ordre;?>">Code</th>
					<th><a href="lits_dispo.php?tri=service&ordre=<?php echo $ordre;?>">Service</th>
					<th>Lits/places disponibles</th>
					<th>Mise à jour</th>
				</tr>
				<?php
				$n = 1;$i=0;
				while($rep=mysql_fetch_array($resultat))
				{
					print("<tr>");
						print("<td>");
							print("[<a href=\"affiche_UF.php?serviceID=$rep[service_ID]\">".$rep[service_code]."</a>] ".$i->service_nom);
						print("</td>");
						print("<td>");
							print($rep[service_nom]);
						print("</td>");
						// lits disponibles
						print("<td>");
							print("<input type=\"hidden\" name=\"services[]\" value=\"$rep[service_ID]\">");
							print("<input type=\"text\" id=\"nom[$i]\" name=\"litsd[]\" value=\"\" size=\"3\" tabindex=\"$n\" onFocus=\"_select('nom[$i]');\" onBlur=\"deselect('nom[$i]');\">");
							print(" / <input type=\"text\" name=\"placessd[]\" value=\"\" size=\"3\" tabindex=\"$n\">");
							$n++;$i++;
						print("</td>");
						// date de mise à jour
							if($rep[date_maj] < 1)
								$d = "indéterminé";
							else
								$d = date("j/m/Y H:i",$rep[date_maj]);
							print("<td>");
								print("<div align=\"right\"> $d </div>");
							print("</td>");
					print("<tr>");
				}
				?>
			</table>
		</p>
		
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
?>

</form>
</body>
</html>