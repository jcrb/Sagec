<?php
/**
*	menu.php
*/
require $backPathToRoot."autorisations/droits.php";
?>

<div id="div1">
	<ul id="menu">
		<li id="intertitre">Menu principal</li>
		
		<li><a href="regulation/carto_base.php">Régulation</a></li>
		<li><a href="../blocnote/blocnote_lire.php?back=../samu/samu_main.php">Main courante</a></li>
		<li><a href="../crise/crise_main.php">Crise</a></li>
		<?php if(est_autorise("INVITE")){?>
			<li><a href="../invite/index.php">Invités</a></li>
		<?php } ?>
		<?php if(est_autorise("AUTO_ROR")){?>
			<li><a href="../ror/ror_main.php">ROR</a></li>
		<?php } ?>
		<?php if(est_autorise("AUTO_MANIF")){?>
			<li><a href="../manifestation/manif_main.php">Manifestations</a></li>
		<?php } ?>
		<li><a href="procedures.php">Procédures</a></li>
		<li><a href="">Surveillance</a></li>
		<?php if(est_autorise("AUTO_ADMINISTRATION")){?>
			<li><a href="../administration/admin_main.php"><span style="color:red;">Administration</span></a></li><?php } ?>
		<?php if(est_autorise("OLD_SAGEC")){?>	
			<li><a href="../sagec67.php"><span style="color:red;">Old Sagec</span></a></li><?php } ?>
			
		<?php if(est_autorise("BIOTOX_LIRE")||est_autorise("BIOTOX_ECRIRE")){?>	
			<li><a href="../biotox/biotox_main.php"><span style="color:red;">Biotox</span></a></li><?php } ?>
			
		<li><a href="../secretariat/index.php">Secretariat</a></li>
		<li><a href="messagerie/messages.php">SAMU 67</a></li>
		<li><a href="urgences_internes/main_615.php">615</a></li>
		<li><a href="../logout.php">Quitter</a></li>
		
	</ul>
</div>





