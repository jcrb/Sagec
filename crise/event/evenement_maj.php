<?php
/**
  *	evenement_maj.php
  */
   session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
	$backPathToRoot = "../../";
	require $backPathToRoot."dbConnection.php";
	$langue = $_SESSION['langue'];
	require $backPathToRoot.'utilitaires/globals_string_lang.php';
	require $backPathToRoot.'utilitaires/liste.php';
	require $backPathToRoot.'utilitaires/evenement_routines.php';
	include_once("top.php");
	include_once("menu.php");
	
	$ev = $_REQUEST['ev_courant'];
	
  ?>
  	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Nouvel evenement</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
</head>

<body>
<form name="maj" action="evenement_maj_enregistre.php" method="get">
<?php
	$requete = "SELECT * FROM evenement WHERE evenement_ID = '$ev'";
	//$requete = "SELECT * FROM evenement WHERE evenement_actif = 'en cours'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	// on enregistre dans un champ caché la valeur de l'évènement courant précédant
	print("<input type=\"hidden\" name=\"ev_courant\" value=\"$_REQUEST[ev_courant]\">");
	print("<table>");
	print("<TR>");
		print("<TD>Evènement courant</TD>");
		print("<TD><input type=\"text\" name=\"titre\" value=\"$rub[evenement_nom]\" size=\"50\"></TD>");
		print("<TD><input type=\"submit\" name=\"ok\" value=\"Valider\"></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Date de création</TD>");
		$date = date("Y-m-j");
		print("<TD><input type=\"text\" name=\"date1\" value=\"$rub[evenement_date1]\" size=\"10\"></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Heure de création</TD>");
		$heure = date("H:i:s");
		print("<TD><input type=\"text\" name=\"heure1\" value=\"$rub[evenement_heure1]\" size=\"10\"></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Commentaires</TD>");
		print("<TD><TEXTAREA name=\"comment\" value=\"\" cols=\"50\" rows=\"5\">$rub[comment]</textarea></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>N° dossier SAMU</TD>");
		print("<TD><input type=\"text\" name=\"dossier_samu\" value=\"$rub[dossier_samu]\" size=\"10\"></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>N° dossier SDIS</TD>");
		print("<TD><input type=\"text\" name=\"dossier_sdis\" value=\"$rub[dossier_sdis]\" size=\"10\"></TD>");
	print("</TR>");
	
	print("<TR>");
	print("<TD>PPI associé</TD>");
		print("<TD>");
			$null["aucun"]=0;
			genere_select("ppi_id", "ppi","ppi_ID","ppi_nom",$connexion,'',$null,'','',false);
		print("</TD>");
	print("</TR>");
	
	print("<TR>");
		print("<TD>Plan(s) associé(s)</TD>");
		print("<TD>");
			print("<table class=\"sample\" >");
				print("<TR><td>nom du plan</td><td>type</td><td>activé le</td><td>levé le</td></TR>");
				print("<TR><td>PR Erstein</td><td>Plan Rouge</td><td>19-10-2007 13:25</td><td>19-10-2007 18:25</td></TR>");
			print("</table>");
		print("</TD>");
		/*
		print("<TD>");
				$null["aucun"]=0;
			genere_select("plans_id", "plan","plan_ID","plan_nom",$connect,'',$null,'','',true);
	print("</TD>");
	*/
	print("</TR>");

	print("<TR>");
		print("<TD>évènement actif</TD>");
		$c1 = $c2 = 0;
		if($rub['evenement_actif']=='oui')
			$c1='checked';
		else 
			$c2='checked';
		print("<TD><input type=\"radio\" name=\"actif\" value=\"oui\" $c1> oui");
		print("<input type=\"radio\" name=\"actif\" value=\"non\" $c2> non</TD>");
	print("</TR>");
	print("</table>");
	
	print("<table>");
	print("<TR>");
		print("<TD>Date de fin</TD>");
		print("<TD><input type=\"text\" name=\"date2\" value=\"$rub[evenement_date2]\" size=\"10\"></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Heure de fin</TD>");
		print("<TD><input type=\"text\" name=\"heure2\" value=\"$rub[evenement_heure2]\" size=\"10\"></TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Type incident</TD>");
		print("<TD>");
			//categorie($item_select);
			select_generique('incident_type','type_ID','typeID','type_nom',$item_select); // retourne typeID
		print("</TD>");
		print("<TD>Sous Type</TD>");
		print("<TD>");
			//scategorie($item_select);
			select_generique('incident_soustype','stype_ID','stypeID','stype_nom',$item_select); // retourne stypeID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Catégorie</TD>");
		print("<TD>");
			select_generique('incident_categorie','categorie_ID','categorieID','categorie_nom',$item_select); // retourne categorieID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Certitude</TD>");
		print("<TD>");
			select_generique('incident_certitude','certitude_ID','certitudeID','certitude_nom',$item_select); // retourne certitudeID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Gravité</TD>");
		print("<TD>");
			select_generique('incident_gravite','gravite_ID','graviteID','gravite_nom',$item_select); // retourne graviteID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Niveau</TD>");
		print("<TD>");
			select_generique('incident_niveau','niveau_ID','niveauID','niveau_nom',$item_select); // retourne niveauID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Sévérité</TD>");
		print("<TD>");
			select_generique('incident_severite','severite_ID','severiteID','severite_nom',$item_select); // retourne severiteID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Phase</TD>");
		print("<TD>");
			select_generique('incident_phase','phase_ID','phaseID','phase_nom',$item_select); // retourne phaseID
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>Status</TD>");
		print("<TD>");
			select_generique('incident_status','status_ID','statusID','status_nom',$item_select); // retourne statusID
		print("</TD>");
	print("</TR>");

	print("</table>");
?>
</form>
</body>
</html>