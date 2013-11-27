<?php
/**
*	menu.php
*/
$back = $_SESSION['back'];
?>

<div id="div1">
	<ul id="menu">
		<li id="intertitre">Menu principal</li>
		
		<li><a href="synthese_main.php?back=<?php echo $back;?>">Evènement</a></li>
		<li><a href="cartographie.php?back=<?php echo $back;?>"">Cartographie</a></li>
		<li><a href="organisation.php?back=<?php echo $back;?>"">Organisation</a></li>
		<li><a href="moyens.php?back=<?php echo $back;?>">Moyens</a></li>
		<li><a href="victimes.php?back=<?php echo $back;?>">Victimes</a></li>
		<li><a href="<?php echo $_SESSION['back'];?>">Retour</a></li>
	</ul>
</div>





