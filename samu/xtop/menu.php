<?php
/**
*	menu.php
*/
$backPathToRoot = "../../";
require_once $backPathToRoot."autorisations/droits.php";
?>

<div id="div1">
	<ul id="menu">
		<li id="intertitre">Menu principal</li>
		<?php if(est_autorise("TOP_ECRITURE")){?>
			<li><a href="">Administrer</a></li>
			<?php } ?>
		<li><a href="xmaj.php">Mettre à jour</a></li>
		<li><a href="">Synoptique</a></li>
		<li><a href="">4</a></li>
		<li><a href="">5</a></li>
		<li><a href="../sagec67.php">Menu principal</a></li>
	</ul>
</div>





