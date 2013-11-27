<?php
/**
  *	service_synthese.php
  *
  *	le tableau ne s'affiche correctement que si hopital_visible.org_ID = 85
  *	car c'est org 85 qui l'a défini. pose pb pour les invités. Dans cette version
  *	85 est codé en dur dans la requete sql ligne 33. Pas terrible => à revoir
  */
session_start();
/**
  * le programme appelant doit définir $backPathToRoot
  * defaut: $backPathToRoot = "../../"
  */ 
if($backPathToRoot =="")$backPathToRoot="../../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
$listeID = 4;// ne pas changer
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Hopital</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<link href="../formstyle.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<link rel="stylesheet" media="print, embossed" href="../impression.css">
	 <style type="text/css">
    @media print {
      .noprint { display: none; }
      .pe{style="margin-left=30"; }
    }
  </style>

</head>

<div class="pe">
<?php

print("<p><b>SAGEC Plan Blan - Synthèse des disponibilités en lits</b></p>");

// on récupère la liste des hôpitaux actifs
// '$_SESSION[organisation]' est remplacé par 85 (cf supra) 
$requete = "SELECT hopital_visible.Hop_ID,Hop_nom
				FROM hopital_visible,hopital
				WHERE hopital_visible.org_ID = 85
				AND liste_ID = '$listeID'
				AND hopital_visible.Hop_ID = hopital.Hop_ID
				";
$resultat = ExecRequete($requete,$connexion);
while($rep = mysql_fetch_array($resultat))
{
	$hopital[$rep[Hop_ID]] = $rep[Hop_nom];
}

// liste des spécialités actives
$requete = "SELECT * FROM planblanc_specialite WHERE pb_spe_visible ORDER BY pb_spe_ID";
$resultat = ExecRequete($requete,$connexion);
while($rep = mysql_fetch_array($resultat))
{
	$specialite[$rep[pb_spe_ID]] = $rep[pb_spe_nom];
}

/**
*	Pour chaque hopital de la sélection
*	récupère l'enregistrement le plus récent
*/

/* cette requete fonctionne mais pas optimisée
$requete = "SELECT Hop_ID,pb_lits_dispo,pb_date as date
				FROM planblanc_dispo
				HAVING pb_date IN (SELECT MAX(pb_date) FROM planblanc_dispo GROUP BY Hop_ID)
				ORDER BY Hop_ID
				";*/

/** cette requete est bonne */			
$requete = "select t1.Hop_ID, t1.pb_lits_dispo, t1.pb_date as date
				from planblanc_dispo t1
				where t1.pb_date = (select max(t2.pb_date) from planblanc_dispo t2 where t2.Hop_ID=t1.Hop_ID)
				ORDER BY Hop_ID
				";

$resultat = ExecRequete($requete,$connexion);
$lits_specialite = array();
while($rep=mysql_fetch_array($resultat))
{
	/** juste pour le déboggage
	print($rep[Hop_ID]."  ".$rep[date]."<br>");
	print($rep[pb_lits_dispo]."<br>");
	*/
	$lits = unserialize($rep[pb_lits_dispo]);
	foreach ($lits as $key => $value)
	{
		// $rep[Hop_ID] identifiant de l'hopital
		// $key identifiant de la spécialité
		// $value nb de lits disponibles 
		$lits_dispo[$rep[Hop_ID]][$key] = $value;
		// totalise le nombre de lits dans la spécialité 
		$lits_specialite[$key] += $value;
	}
	$maj[$rep[Hop_ID]] = $rep[date];
}

/**
*	Affichage du tableau
*/
print("<table border=\"1\" cellspacing=\"0\">");
print("<tr>");
	print("<td>&nbsp;</td>");
	foreach($specialite as $val)
	{
		print("<td>".$val."</td>");
	}
	print("<td>Mise à jour</td>");
	print("<td class=\"noprint\">Voir</td>");
print("</tr>");

foreach($hopital as $hopID => $hopNom) // cle => valeur 
{
	print("<tr>");
		print("<td>".Security::db2str($hopNom)."</td>");
		foreach($specialite as $specialID => $val)
		{
			if($lits_dispo[$hopID][$specialID]=="")$lits_dispo[$hopID][$specialID]="-";
			print("<td align=\"center\">".$lits_dispo[$hopID][$specialID]."</td>");
		}
		if(!$maj[$hopID])$maj[$hopID]=" - ";
		?>
		<td align="center"><?php echo $maj[$hopID]; ?></td>
		<td align="center" class="noprint"><a href="<?php if($_SESSION[organisation]==85)
			echo $backPathToRoot.'plan_blanc/fiche_hopital.php?hopID='.$hopID;?>">v</a></td>
	</tr>
		<?php
}

print("<td><b>TOTAL</b></td>");

	foreach($specialite as $val => $x)
	{
		print("<td align=\"center\"><b>".$lits_specialite[$val]."</b></td>");
	}
	print("<td>&nbsp;</td><td>&nbsp;</td>");
print("</table>");

?>
<p><input type="button" name="print" value="Imprimer" class="noprint" onclick="window.print();" style="margin-left:50px"></p>
</div>
</html>