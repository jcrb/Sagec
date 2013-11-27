<?php
/**
*	fiche_hopital.php
*/
session_start();
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");

$hopID = $_REQUEST['hopID'];
if($hopID)
{
	$requete = "SELECT Hop_nom FROM hopital WHERE Hop_ID ='$_SESSION[Hop_ID]'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$hopNom = $rep[Hop_nom];
	
	$requete = "SELECT *
					FROM planblanc_dispo
					WHERE planblanc_dispo.Hop_ID = '$hopID'
					ORDER BY pb_date DESC 
					LIMIT 1 
					";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	{
		//print_r($rep);
		//print($rep[pb_lits_dispo]."<br>");
		$lits_Dispo = unserialize($rep[pb_lits_dispo]);
		$lits_lib = unserialize($rep[pb_lits_liberables]);
		//print_r($lits_Dispo);
		$date = $rep[pb_date];
	}
}

$requete = "SELECT * FROM planblanc_specialite WHERE pb_spe_visible = '1' ORDER BY pb_spe_ID";
$resultat = ExecRequete($requete,$connexion);
while($rep = mysql_fetch_array($resultat))
{
	$special_nom[]=$rep[pb_spe_nom];
	$special_id[]=$rep[pb_spe_ID];
	$special_short[]=$rep[pb_spe_short];
	$special_comment1[] = $rep[pb_spe_comment1];
	$special_comment2[] = $rep[pb_spe_comment2];
	$special_comment0[] = $rep[pb_spe_comment0];
}
$qq=array();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Hopital</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<link href="formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('dechoc').focus()">
	<form id="catalogue" action="fiche_hopital_enregistre.php" method="post">
	<input type="hidden" name="hopID" value ="<?php echo $hopID; ?>">
	<div id="formtitle">PLAN BLANC - Centre Hospitalier <?php echo $hopNom; ?></div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>Etats des lits disponibles</legend>
		<p>
			<label for="nom" title="">Spécialité :</label>
			<label for="nom" title="nb de lits actuellement disponibles">Lits disponibles :</label>
			<label for="nom" title="nb de lits libérables dans les 3 heures">Lits libérables :</label>
		</p>
		
		<?php for($i=0;$i<sizeof($special_id);$i++){?>
			<p>
			<label for="<?php echo $special_short[$i] ?>" title="<?php echo $special_comment0[$i] ?>"><?php echo $special_nom[$i] ?></label>
			<!--
			<input type="text" id="<?php echo $special_short[$i].'1' ?>" name="<?php echo $special_short[$i].'1' ?>" title="<?php echo $special_comment1[$i] ?>"/>
			<input type="text" id="<?php echo $special_short[$i].'2' ?>" name="<?php echo $special_short[$i].'2' ?>" title="<?php echo $special_comment2[$i] ?>"/>
			-->
			<input type="text" id="<?php echo $special_short[$i].'1' ?>" name="dispo[<?php echo $special_id[$i] ?>]" value="<?php echo $lits_Dispo[$special_id[$i]];?>" title="<?php echo $special_comment1[$i] ?>"/>
			<input type="text" id="<?php echo $special_short[$i].'2' ?>" name="liberable[<?php echo $special_id[$i] ?>]" value="<?php echo $lits_lib[$special_id[$i]];?>" title="<?php echo $special_comment2[$i] ?>"/>
		<?php } ?>
		</p>
		

	</fieldset>
	<br />
	
	<fieldset id="coordonnees">
		<legend>Capacité d'accueil</legend>
		<p>
			<label for="nom" title="">&nbsp;</label>
			<label for="nom" title="nb de lits actuellement disponibles">Immédiatement</label>
			<label for="nom" title="nb de lits libérables dans les 3 heures">Déja accueillis</label>
		</p>
		
		<p>
			<label for="ua" title="Nb d'UA acceptables">Urgences Absolues (UA) :</label>
			<input type="text" id="ua1" name="ua1" title="Nb d'Urgences Absolues encore acceptables"/>
			<input type="text" id="ua2" name="ua2" title="Nb d'Urgences absolues déjà admises"/>
		</p>
		<p>
			<label for="ur" title="Nb d'UR acceptables">Urgences Relatives (UR) :</label>
			<input type="text" id="ur1" name="ur1" title="Nb d'Urgences Relatives encore acceptables"/>
			<input type="text" id="ur2" name="ur2" title="Nb d'Urgences Relatives déjà admises"/>
		</p>
		<p>
			<label for="heberg" title="Nb de places d'hébergement">Places d'hébergement :</label>
			<input type="text" id="heberg1" name="heberg1" title="Possibilités d'hébergement encore acceptables"/>
			<input type="text" id="heberg2" name="heberg2" title="Nb de personnes actuellemnt hébergées"/>
		</p>
	</fieldset>
	<br />
	
	<fieldset id="infosupp">
		<legend>Commentaires</legend>
		<p>
			<textarea cols="80" rows="6" name="comment"></textarea>
		</p>
	</fieldset>
	<br />
	
	<p>
		<spam class="exemple">Dernière mise à jour: <?php echo $date;?></spam>
	</p>

	
	</div>
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>
