<?php
/**
*	feuille_soins3.php
*	 
*/
$patient = $_REQUEST['dossier'];
?>
<html>
<head>
	<title>feuille de soins</title>
	<LINK REL=stylesheet HREF="tr_css.css" TYPE ="text/css">
</head>
<body>

<!-- 
<div class="legende">
	<p>L�gende</p>
</div>

<div class="feuille">
	<img src="graphe.php?value= <?php echo($patient) ?>" alt="Mon graphique"/>
</div>

<div class="medicament">
	<p>m�dicaments</p>
</div>
 -->
 
<table>
	<tr>
		<td HEIGHT = "400" width="100">L�gende</td>
		<td HEIGHT = "400">
			<img src="graphe.php?value= <?php echo($patient) ?>" alt="Mon graphique"/>
		</td>
	</tr>
</table>

</body>
</html>