<?php
/**
	utilitaire_cron.php
	source: http://matthieu.developpez.com/execution_periodique/
	ajouteScript()
	@version $Id: utilitaire_cron.php 31 2008-02-12 18:02:26Z jcb $
	@author JCB
*/
$debut = '# [SAGEC67]';
$fin = '# ------------------------';

function ajouteScriptSagec($chpHeure, $chpMinute, $chpJourMois, $chpJourSemaine, $chpMois, $chpCommande, $chpCommentaire)
{
	$oldCrontab = array(); /* pour chaque cellule une ligne du crontab actuel */
	$newCrontab = array(); /* pour chaque cellule une ligne du nouveau crontab */
	$isSection = false; 
	$enregistre = false;/* pour ne pas enregister � chaque fois l'en t�te*/
	$regle_existe = false;
	$maxNb = 0; /* le plus grand num�ro de script trouv� */
	$debut = '# [SAGEC67]';
	$fin = '# ##';
	$regle = $chpMinute.' '.$chpHeure.' '.$chpJourMois.' '. $chpMois.' '.$chpJourSemaine.' '.$chpCommande;
	print("ajoute script <br>");
	print($regle."<br>");
	exec('crontab -l', $oldCrontab); /* on r�cup�re l'ancienne crontab dans $oldCrontab */
	
	foreach($oldCrontab as $index => $ligne) /* copie $oldCrontab dans $newCrontab et ajoute le nouveau script */
	{
		$motsLigne = explode(' ', $ligne);
		
		if ($motsLigne[0] != '#')
		{
			if($ligne == $regle)
				$regle_existe = true;
		}
		if ($motsLigne[0] == '#' && $motsLigne[1] == '[SAGEC67]')
		{
			$isSection = true;
			$enregistre = true;
		}
		elseif ($motsLigne[0] == '#' && $motsLigne[1] == '##')// fin de section sagec
		{
			$isSection = false;
			if(!$regle_existe)
			{
				$id = $maxNb + 1;
				$newCrontab[] = '# '.$id.' : '.$chpCommentaire;
				$newCrontab[] = $regle;
			}
		}
		if($motsLigne[0] == '#' && $isSection == true)
		{
			$maxNb = $motsLigne[1];
		}
		if($enregistre == true) $newCrontab[] = $ligne;
	}
	print($maxNb."<br>");
	if($maxNb == 0) // la section Sagec n'existe pas, on la cr�e avec la 1�re r�gle
	{
		$id = 1;
		//$newCrontab[] = '\n';
		$newCrontab[] = $debut;
		$newCrontab[] = '# 1 : '.$chpCommentaire;
		$newCrontab[] = $regle; 
		$newCrontab[] = $fin;
	}
	$fp = fopen('tmp', 'w'); /* on cr�e le fichier temporaire */
	for($i=0;$i<count($newCrontab);$i++)
	{
		fwrite($fp, $newCrontab[$i]);print($newCrontab[$i]."<br>");
		fwrite($fp, "\n");
	}
	chmod ($fp, 777);
	fclose($fp);
	//exec('crontab -r');
	echo exec('crontab tmp'); /* on le soumet comme crontab */
	return $id;
}
			
	

function retireScript($id)
{
	$oldCrontab = Array(); /* pour chaque cellule une ligne du crontab actuel */
	$newCrontab = Array(); /* pour chaque cellule une ligne du nouveau crontab */
	$isSection = false; 
	$enregistre = false;/* pour ne pas enregister � chaque fois l'en t�te*/
	$regle_existe = false;
	$maxNb = 0; /* le plus grand num�ro de script trouv� */
	$debut = '# [SAGEC67]';
	$fin = '# ##';
	
	exec('crontab -l', $oldCrontab);		/* on r�cup�re l'ancienne crontab dans $oldCrontab */

	foreach($oldCrontab as $ligne)			/* copie $oldCrontab dans $newCrontab sans le script � effacer */
	{
		$motsLigne = explode(' ', $ligne);
		
		if ($motsLigne[0] == '#' && $motsLigne[1] == '[SAGEC67]')
		{
			$isSection = true;
			$enregistre = true;
		}
		
		if ($isSection == true)			/* on est dans la section g�r�e automatiquement */
		{
			if ($motsLigne[0] == '#' && $motsLigne[1] != $id)	/* ce n est pas le script � effacer */
			{
				//$newCrontab[] = $ligne;			/* copie $oldCrontab, ligne apr�s ligne */
				$enregistre = true;
			}
			elseif ($motsLigne[0] == '#' && $motsLigne[1] == $id)
				$enregistre = false;
		}
		if($enregistre == true) 
			$newCrontab[] = $ligne;		/* copie $oldCrontab, ligne apr�s ligne */
	}

	if(!$f = fopen("tmp2", "w")) /* on cr�e le fichier temporaire */
		die("impossible d'ouvrir le fichier");
	for($i=0;$i<count($newCrontab);$i++)
	{
		fwrite($f, $newCrontab[$i]);
		fwrite($f, "\n");
	}
	chmod ($f, 777);
	fclose($f);
	exec('crontab tmp2'); /* on le soumet comme crontab */

	return 	$id;
}

// ajout� par jcb
function affiche_crontable()
{
	$currentCrontab = Array();				/* pour chaque cellule une ligne du crontab actuel */
	exec('crontab -l', $currentCrontab);		/* on r�cup�re l'ancienne crontab dans $oldCrontab */

	foreach($currentCrontab as $ligne)			/* copie $oldCrontab dans $newCrontab sans le script � effacer */
	{
		print($ligne."<br>");
	}
}
?>