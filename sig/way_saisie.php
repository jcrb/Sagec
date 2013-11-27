<?php
/**
*	source: http://normandlamoureux.com/cours/css/index.html#explication
*/
$backPathToRoot = "../"; 
include($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."dbConnection.php");
include_once("way_utilitaires.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Nouvelle zone</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Language" content="fr" />
	<link href="formstyle.css" rel="stylesheet" type="text/css" />
   <style type="text/css" media="screen">@import url(css/normal.css);</style>
    <!--[if IE]><style type="text/css" media="screen">@import url(css/ie.css);</style><![endif]-->
    <!--[if lte IE 6]><style type="text/css" media="screen">@import url(css/ie6.css);</style><![endif]-->
</head>

<body onload="document.getElementById('nom').focus()">
	<div id="en-tete">
 		<ul>
  			<li id="actif"><a href="way_saisie.php"><span>Nouveau</span></a></li>
  			<li><a href="02.php"><span>Liste</span></a></li>
  			<li><a href="03.php"><span>Outils</span></a></li>
  			<li><a href="04.php"><span>En savoir plus</span></a></li>
 		</ul>
 	</div>
 	
	<?php
		$wayID = $_REQUEST['wayID'];print($wayID);
		if($wayID)
		{
			$requete = "SELECT * FROM way WHERE way_ID = '$wayID'";
			$resultat = ExecRequete($requete,$connexion);
			$way = mysql_fetch_array($resultat);
			print("<input type=\"hidden\" name=\"wayID\" value=\"$wayID\">");
		}
	?>
	<form id="catalogue" action="way_enregistre.php" method="get">
	<div id="formtitle">creer un objet</div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>Description de l'objet</legend>
		<p>
			<label for="nom" title="Nom de l'objet">Nom :</label>
			<input type="text" id="nom" name="nom" title="Nom de l'objet" maxlength="50" size="20" value = "<?php echo($way['way_nom'])?>" />
			<span class="exemple">ex : Zone exclusion 1</span>
		</p>
		<p>
			<label for="ferme">ligne fermée :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
		<p>
			<label for="type">Type :</label>
			<select name="type" id="type">
				<option value="0" selected="selected">non défini</option>
				<option value="1" <?php if($way['way_type']==1) echo(' SELECTED')?> >ligne</option>
				<option value="2" <?php if($way['way_type']==2) echo(' SELECTED')?> >polygone</option>
			</select>
		</p>
		
		<p>
			<label for="points">Liste des points :</label>
			<TEXTAREA NAME="points" ROWS="10" COLS="40" id="points">
			<?php
				if($wayID)
				{
					$tab = getNodes($wid);
					print($tab);
				}
				else
					echo 'Texte par défaut...';
			?>
			</TEXTAREA>
			<span class="exemple">saisir les points dans l'ordre LATITUDE,LONGITUDE</span>
		</p>
	</fieldset>
	<br />
	
	<fieldset id="coordonnees">
		<legend>Elements facultatifs</legend>
		<p>
			<label for="trait">Couleur du trait :</label>
			<input type="text" id="trait" name="trait" maxlength="7" size="6" value = "<?php echo($way['way_trait'])?>" />
			<span class="exemple">ex : #000000</span>
		</p>
		<p>
			<label for="fond">Couleur du fond :</label>
			<input type="text" id="fond" name="fond" maxlength="7" size="6" value = "<?php echo($way['way_fond'])?>"/>
			<span class="exemple">ex : #FF0000</span>
		</p>
		<p>
			<label for="transparence">Transparence :</label>
			<input type="text" id="transparence" name="transparence" value = "<?php echo($way['way_transparence'])?>"/>
			<span class="exemple">entre 0 et 100</span>
		</p>
	</fieldset>
	<br />
	<?php
	listeWay();
	?>
	<!--
	<fieldset id="typecat">
		<legend>Commande catalogue</legend>		
		<p><span class="exemple">Sélectionnez le catalogue que vous souhaitez recevoir :</span><br />
			<input type="radio" name="periode" id="ete" value="cat_ete" checked="checked" /> Catalogue printemps/été 2008<br />
			<input type="radio" name="periode" id="hiver" value="cat_hiver" /> Catalogue automne/hiver 2008<br />		
		</p>
	</fieldset>
	-->
	</div>
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="submit" name="BtnSubmit" id="valid" value="Detruire" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>
