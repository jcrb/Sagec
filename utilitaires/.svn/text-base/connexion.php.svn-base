<?php
// Connexion.php
// Utilitaire de connexion à un serveur et une base de données
// syntaxe Connexion(nom, mpot_de_passe, base, serveur);
if(!isset($fichierconnexion))
{
	// évite les pb en cas d'inclusion multiple de ce fichier'
	$fichierconnexion = 1;
	//fonction connexion: connexion à MySQL
	function Connexion($pNom,$pMotPasse,$pBase,$pServeur)
	{
		//echo $pNom."*".$pMotPasse."*".$pBase."*".$pServeur;
		// connexion au serveur
		$connexion = mysql_pconnect($pServeur,$pNom,$pMotPasse);
		if(!connexion)
		{
			echo("Désolé, connexion au serveur $pServeur impossible\n");
			exit();
		}
		// connexion à la base
		if(!mysql_select_db($pBase,$connexion))
		{
			echo("Désolé, connexion à la base $pBase impossible\n");
			echo"<B>Message de MySql: </B>".mysql_error($connexion);
			exit();	
		}
		// on renvoie la variable de connexion
		return $connexion;
	}
}
?>