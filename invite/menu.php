<?php
/**
*	menu.php
*/
session_start();
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$requete = "SELECT ppi_nom,ppi_ID FROM ppi WHERE ppi_partage = 'o'";
$resultat = ExecRequete($requete,$connexion);

?>

<div id="div1" class="noprint">
	<ul id="menu">
		<li id="intertitre"><a href="index.php">Home</a></li>
		<li id="intertitre"><a href="../docs/manuel.pdf">Aide</a></li>
		
		<li><a href="../blocnote/blocnote_lire.php?back=../invite/index.php">Main courante</a></li>
		<?php
			while($rep = mysql_fetch_array($resultat))
			{
				?><li>
					<a href="../ppi/ppi_dow/ppi_dow.php?id=<?php echo $rep['ppi_ID'].'&nom='.$rep['ppi_nom']?>" target="_blank">
					<?php echo Security::db2str($rep['ppi_nom']);?>
					</a></li>
				<?php
				$evenement = Security::db2str($rep['ppi_nom']);
			}
		?>
		<li><a href="../dossier_cata/dossier_cata_main.php?back=<?php echo $backPathToRoot;?>invite/index.php">victimes</a></li>
		
		<?php // ne concerne que les hôpitaux 
			if($_SESSION[Hop_ID] > 0){ ?>
				<li><a href="../plan_blanc/fiche_hopital.php?hopID=<?php echo $_SESSION[Hop_ID];?>">Lits disponibles</a></li>
		<?php } ?>
		<li><a href="cartographie.php">Cartographie statique</a></li>
		<li><a href="synthese.php">Synthese</a></li>
		<li><a href="annuaire_invite.php">Annuaire</a></li>
		<li><a href="../login2.php">Menu principal</a></li>
	</ul>
</div>





