<?php
 //fichier_analyses.php
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$fichier=$_GET['fichier'];

$fichier2 = "/home/jcb/Desktop/Tableau/".$fichier;
//print($fichier2."<br>");
$fp=fopen($fichier2,"r");
$i=0;
print("Op�ration en cours...<br>");

while(!feof($fp))
{
	$mot = fgets($fp,4096);
	$i = explode("\t",$mot);
	$moyen = $i[0];
	$date = strtotime($i[1]);
	$n = $i[2];
	print($moyen."<br>");
	$requete = "";
	//$requete = "INSERT INTO veille_samu (date,service_ID,nb_primaires) VALUES('$date','1','$n')";
	//$requete = "UPDATE veille_samu SET nb_secondaires='$n' WHERE date='$date'";
	/*
	if(($moyen=="Ambulance cat�gorie A") || ($moyen=="Ambulance de garde") || $moyen==("Ambulance privee"))
		$requete = "UPDATE veille_samu SET nb_apa= nb_apa + '$n' WHERE date='$date'";

	else if(($moyen=="Conseil m�dical")||($moyen=="Renseign.m�dical"))
		$requete = "UPDATE veille_samu SET conseils= conseils + '$n' WHERE date='$date'";

	else if(($moyen=="Garde hors secteur")||($moyen=="Maison m�dicale de l'Asum")||($moyen=="Medecin")||($moyen=="SOS M�decins"))
		$requete = "UPDATE veille_samu SET nb_med= nb_med + '$n' WHERE date='$date'";

	else if(($moyen=="SMUR autres")||($moyen=="SMUR Strasbourg"))
		$requete = "UPDATE veille_samu SET nb_smur= nb_smur + '$n' WHERE date='$date'";

	else if($moyen=="VSAB")
		$requete = "UPDATE veille_samu SET nb_vsav= nb_vsav + '$n' WHERE date='$date'";
	*/
	$requete = "UPDATE veille_samu SET nb_primaires= '0'";
	if($requete)
	{
		print($requete."<br>");
		$resultat = ExecRequete($requete,$connexion);
	}
}
print(date("j/m/Y",$date));
?>
