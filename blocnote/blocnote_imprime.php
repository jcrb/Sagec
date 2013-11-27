<?php
/**
  * blocnote_imprime.php
  *
  */

$backpathToRoot = "../";
$tab = "\t";
include_once($backpathToRoot."dbConnection.php");

$sauvegarde = "sauvegardeBN_".$_SESSION[evenement].".doc";
$fp = fopen("$sauvegarde","w");

$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,iqr,nom,livrebord.org_ID
		FROM livrebord,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		AND LB_visible = 'o'
		ORDER BY LB_Date ";
	$result = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($result))
	{
		print($rep[LB_Message]."<br>");
		fwrite($fp,$rep[LB_ID].$tab.$rep[LB_Date].$tab.$rep[nom].$tab.$rep[LB_Message]."\n");
		
		if($rep[iqr]>0)
		{
			$requete2 = "SELECT LB_Message,LB_Expediteur,LB_Date,nom
					FROM livrebord, livrebordQR,utilisateurs
					WHERE livrebord.LB_ID = livrebordQR.reponse_ID
					AND livrebordQR.question_ID = '$rep[LB_ID]'
					AND LB_Expediteur = ID_utilisateur
					";
			$resultat2 = ExecRequete($requete2,$connexion);
			while($com = mysql_fetch_array($resultat2))
			{
				print("   - ".$com[LB_Message]."<br>");
				fwrite($fp," - ".$com[LB_ID].$tab.$com[LB_Date].$tab.$com[nom].$tab.$com[LB_Message]."\n");
			}
		}
	}
fclose($fp);
?>

<a href="<? echo $sauvegarde;?>">Imprimer la main courante</a>