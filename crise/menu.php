<?php
/**
*	menu.php
*/
$backPathToRoot = "../";
require $backPathToRoot."autorisations/droits.php";
?>

<div id="div1">
	<ul id="menu">
		<li id="intertitre">Menu principal</li>
		
		<li><a href="../blocnote/blocnote_lire.php?back=../crise/crise_main.php">Main courante</a></li>
		<li><a href="plans_secours.php">Plans de secours</a></li>
		<li><a href="superviseur/superviseur_main.php">Superviseur</a></li>
		
		<!-- <li><a href="../dossier_cata/dossier_cata_main.php?back=../crise/crise_main.php">Victimes</a></li> -->
		<li><a href="../dossier_cata/dossier_cata_nouveau.php?back=../crise/crise_main.php">Victimes</a></li>
		
		<li><a href="crise_hopitaux.php">Hôpitaux</a></li>
		<li><a href="vecteurs/vecteurs_index.php">Vecteurs</a></li>
		<li><a href="lits.php">Lits</a></li>
		<li><a href="../brules/brule_frameset.php">Grands brûlés</a></li>
		
		<?php if(est_autorise("RAZ")||est_autorise("BIOTOX_ECRIRE")){?>	
			<li><a href="crise_raz.php"><span style="color:red;">ADMINISTRER</span></a></li>
		<?php } ?>
		
		<li><a href="../samu/samu_main.php">Menu principal</a></li>
	</ul>
</div>





