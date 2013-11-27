<?php
/**
*	regul_ask.php
*/
$backpath="../";
include($backpath."utilitairesHTML.php");
include($backpath."dbConnection.php");
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="content-type" content=""text/htm; charset=ISO-8859-15" >

    <title>Régulation</title>
	 <link rel="stylesheet" href="div.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" media="screen" href="formstyle.css" />
    <link rel="stylesheet" type="text/css" media="print" href="impression.css" />
   <!--  <link href="regul_map.css" rel="stylesheet" type="text/css" /> -->
</head
<div id="sup">
	<h2><? echo "Sélectionnez une commune";?></h2>
	<div id="sousup">
		<a href="../sagec67.php">Menu principal > </a><a href="index.php">Régulation</a>
	</div>
</div>

<body>
	<form name="Commune" method="get" action="regul_commune.php">

	<fielset>
		<legend>L'adrese est facultative</legend>
	<p>
		<label for="id">Adresse</label>
		<input type="text" name="ad" id="ad" size="30">
	</p>
	<p>
		<label for="">Commune</label>
		<?php select_ville_france($connexion,$_REQUEST['ville_id'],67,$langue,"document.Commune.submit()");?>
	</p>
	</fielset>
	
	<p><a href="../ajax/ajax_liste/liste.php">Test Ajax</a></p>
</form>
<?php
?>
</body>
</html>