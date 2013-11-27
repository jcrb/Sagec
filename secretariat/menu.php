<?php
/**
*	menu.php
*/
$backPathToRoot = "../";
require_once($backPathToRoot."autorisations/droits.php");
?>

<div id="div1">
	<ul id="menu">
		<li id="intertitre"><a href="index.php">Menu principal</a></li>
		<?php if(est_autorise("AUTO_SECRETARIAT")){?>
			<li><a href="intervenant_saisie.php">Nouveau</a></li>
			<li><a href="intervenant_liste.php">Liste des personnels</a></li>
			<li><a href="intervenant_liste.php?actif=o">Liste des personnels actifs</a></li>
			<li><a href="intervenants_badges.php">Badges</a></li>
			<!--<li><a href="intervenant_affectation.php">Affectations</a></li>-->
		<?php }?>
		<li><a href="../blocnote/blocnote_lire.php?back=../secretariat/index.php">Main courante</a></li>
		<li><a href="intervenants_arrive.php">Plan blanc</a></li>
		<li><a href="../samu/samu_main.php">Menu principal</a></li>
	</ul>
</div>





