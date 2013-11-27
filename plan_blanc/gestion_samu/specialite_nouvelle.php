<?php
/**
*	specialite_nouvelle.php
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
$speID = $_REQUEST[speID];
if($speID)
{
	$requete="SELECT * FROM planblanc_specialite WHERE pb_spe_ID='$speID'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
}
?>
<head>
	<title>Spécialité médicale</title>
	<meta http-equiv="content-type" content="t="text/h; charset=ISO-8859-1" 1>
	<link href="../formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('dechoc').focus()">
	<form id="cat" action="specialite_enregistre.php" method="post">
	<input type="hidden" name="hopID" value ="<?php echo $speID; ?>">
	<div id="formtitle">PLAN BLANC - Specialité <?php if($speID)echo 'Mise à jour';else echo 'nouvelle' ?></div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>Caractétistique</legend>
		<p>
			<label for="nom" title="">intitulé :</label>
			<input type="text" id="" name="nom" size="50" value="<?php echo $rep[pb_spe_nom];?>" title=""/>
		</p>
		<p>
			<label for="short" title="">intitulé court :</label>
			<input type="text" id="" name="short" size="50" value="<?php echo $rep[pb_spe_short];?>" title=""/>
		</p>
		<p>
			<label for="visible" title="">visible :</label>
			<input type="checkbox" id="" name="visible" <?php if($rep[pb_spe_visible])echo 'checked';?> title=""/>
		</p>
		<p>
			<label for="nom" title="">intitulé :</label>
			<input type="text" id="" name="c1" size="50" value="<?php echo $rep[pb_spe_comment0];?>" title=""/>
		</p>
		<p>
			<label for="nom" title="">intitulé :</label>
			<input type="text" id="" name="c2" size="50" value="<?php echo $rep[pb_spe_comment1];?>" title=""/>
		</p>
		<p>
			<label for="nom" title="">intitulé :</label>
			<input type="text" id="" name="c3" size="50" value="<?php echo $rep[pb_spe_comment2];?>" title=""/>
		</p>

	</fieldset>
	<br />

	
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
