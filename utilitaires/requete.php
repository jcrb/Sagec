<?php
// utilitaires/Requete.php
/* Source MySQL et PHP pp 114
 	Paramètres entrants
		$requete string contenant une requête SQL
		$connexion: parametres de la connexion
	Parametres sortants
		$resultat: résultat de la requête
*/
if(!isset($FichierExecRequete))
{
	$FichierExecRequete = 1;
	// exécution d'une requête en SQL
	function ExecRequete($requete,$connexion)
	{
		$resultat = mysql_query($requete,$connexion);
		if($resultat)
			return $resultat;
		else
		{
			echo "<B> Erreur dans l'éxécution de la requête'$requete'.</B><BR>";
			echo("<B>Message de MySql: </B>" .mysql_error($connexion));
			exit();
		}
	}// fin fonction ExecRequete
	
	function LigneSuivante($resultat)
	// récupère une ligne de résultat dans une base de données
	{
		return mysql_fetch_object($resultat);
	}
}// fin de fonction
?>