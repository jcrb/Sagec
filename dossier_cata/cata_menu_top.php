<?php
/**
*	cata_menu_top.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$back = $_SESSION['back'];
if(empty($back))
	$back = "../login2.php";
?>
<!--  menu sup  -->
<div id=menu_sup>
	<ul id="dossier_menu_sup">
		<li><a href="dossier_cata_nouveau.php">Nouveau</a></li>
		<li><a href="dossier_cata_liste_entete.php">Liste</a></li>
		<li><a href="dossier_cata_imprime.php">Imprime</a></li>
		<li><a href="dossier_cata_synoptique.php">Synoptique</a></li>
		<li><a href="dossier_cata_destinations.php">Destinations</a></li>
		<li><a href="dossier_cata_listing.php">Listing</a></li>
		<li><a href="<?php echo $back;?>">Menu principal</a></li>
	</ul>
</div>
