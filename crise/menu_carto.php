<?php
/**
*	menu_carto.php
*/
?>

<div id="div1">
	<ul id="menu">
		<li id="intertitre"><a href="crise_main.php">@</a></li>
		<li><a href="../blocnote/blocnote_lire.php?back=../crise/crise_main.php">Main courante</a></li>
		<li><a href="plans_secours.php">Plans de secours</a></li>
		<li><a href="superviseur/superviseur_main.php">Superviseur</a></li>
		<li><a href="../victime/victimes/index.php">Victimes</a></li>
		<li><a href="lits.php">Lits</a></li>
		<li><a href="../samu/samu_main.php">Menu principal</a></li>
		<li id="intertitre">Cartographie</li>
		<li><input type="checkbox" name="mouseTracking" id="mt" onClick="analyseMenu()">Geoloc</li>
		<li><input type="checkbox" name="struct_temp" id="st" onClick="analyseMenu()">Structures PPI</li>
		<li><input type="checkbox" class="mini" name="rdv" id="rdv" onclick="analyseMenu()">Rose des Vents</li>
	</ul>
</div>





