<?php
/**
*	apa_liste_victimes.php
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <title>nouvelle victime</title>
  <LINK REL="stylesheet" HREF="apa.css" TYPE ="text/css">
  <style type="text/css" media="screen">@import url(../sig/css/normal.css);</style>
   <!--[if IE]><style type="text/css" media="screen">@import url(../sig/css/ie.css);</style><![endif]-->
   <!--[if lte IE 6]><style type="text/css" media="screen">@import url(../sig/css/ie6.css);</style><![endif]-->
   <script>
		function controle()
		{
			if(document.forms[0].no_victime.value != "")
			{
					return true;
			}
			else
			{
				alert('il faut obligatoirement un identifiant');
				return false;
			}
		}
		
		function setFocus(chp)
		{
			document.getElementById(chp).focus();
		}
	</script>
</head>

<body bgcolor="#ffffff" onload="setFocus('no_victime')">
	<form name="saisie" action="apa_valide.php" method="get" onsubmit="return controle()">
		
	<div id="en-tete">
 		<ul>
  			<li id="actif"><a href="apa_nouvelle_victime.php"><span>Nouveau</span></a></li>
  			<li><a href="apa_liste_victimes.php"><span>Liste</span></a></li>
  			<li><a href=""><span> ? </span></a></li>
  			<li><a href=""><span> ? </span></a></li>
 		</ul>
 	</div>
 	
 	<div id="etatcivil">
 	<fiedset>
 		<legend>Nouvelle victime</legend>
 		<p>
 			<label for="no_victime">Identifiant (ou code barre):</label>
 			<input type="text" name="no_victime" id="no_victime" value=""/>
 			<input type="submit" value="Valider" name="okBtn"/>
 		</p>
 	</fiedset>
 	</div>
 	</form>
</body>
</html>