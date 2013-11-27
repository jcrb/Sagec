<?php
/**
*	affiche_UF.php
*/
$backpath2root = "../";
include($backpath2root."dbConnection.php");
include_once("top.php");
include_once("menu.php");

$serviceID = $_REQUEST[serviceID];
$requete="SELECT uf_ID,uf_code,uf_nom FROM uf WHERE service_ID = '$serviceID' ORDER BY uf_code";
$resultat = ExecRequete($requete,$connexion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Liste des UF</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="">
<form name="" action= "" method = "post">

<div id="div2">

<table border="1" cellspacing="0">
<tr>
	<td>code UF</td>
	<td>Intitulé</td>
	<td>Lits disponibles</td>
</tr>
<?php
while($rep=mysql_fetch_array($resultat))
{
	?>
	<tr>
		<td><?php echo $rep[uf_code];?> </td>
		<td><?php echo $rep[uf_nom];?> </td>
		<td><input type="text" name="lit_dispo[]" value=""></td>
	</tr>
	<?php
}
?>
</table>
<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>

</form>
</body>
</html>