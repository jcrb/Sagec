<?php
/**
*	victime_cherche.php
*	Recherche une victime à partir de différents critères
*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$backPathToRoot = "./";
require $backPathToRoot."dbConnection.php";
include($backPathToRoot."login/init_security.php");
include($backPathToRoot."en_tete.php");
entete($member_id,$langue,$backPathToRoot);

$id = Security::esc2Db($_REQUEST['identifiant']);
$nom =  Security::esc2Db(mb_strtoupper($_REQUEST['nom']));
$prenom = Security::esc2Db($_REQUEST['prenom']);
$err = 0;

/**
*	%$id% contient
*	 $id% commence par
*	%$id  se termine par
*/
$requete = "SELECT * FROM victime WHERE ";
if($id)
{
	$requete .= "no_ordre LIKE '%$id%'";
	if($nom)
	{
		$requete .= " AND nom like '%$nom%'";
	}
	if($prenom)
	{
		$requete .= " AND prenom LIKE '%$prenom%'";
	}
}
else if($nom)
{
	$requete .= " nom like '%$nom%'";
	if($prenom)
	{
		$requete .= " AND prenom LIKE '%$prenom%'";
	}
}
else if($prenom)
{
	$requete .= " prenom LIKE '%$prenom%'";
}
else 
{
	print("ERREUR");
	$err = 1;
}
//print($requete."<br>");
print("<p>Résultat de la recherche</p>");
if($err == 0)
{
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
	print("<tr>");
		print("<th bgcolor=\"#FFFF00\">Ordre</th>");
		print("<th bgcolor=\"#FFFF00\">Identifiant</th>");
		print("<th bgcolor=\"#FFFF00\">Nom</th>");
		print("<th bgcolor=\"#FFFF00\">voir</td>");
	print("</tr>");
	while($rep = mysql_fetch_array($resultat))
	{
		print("<tr>");
		print("<td bgcolor=\"#CCFFFF\">".$rep['victime_ID']."</td>");
		print("<td bgcolor=\"#CCFFFF\">".$rep['no_ordre']."</td>");
		print("<td bgcolor=\"#CCFFFF\">".$rep['nom']."</td>");
		print("<td bgcolor=\"#CCFFFF\"><a href=\"./victimes_saisie.php?identifiant=$rep[no_ordre]\">afficher</a></td>");
		print("</tr>");
	}
	print("</table>");
}
else 
{
	print("<p>ERREUR</p>");
}

print("<br><a href=\"victime_modifie.php\"> Autre recherche </a>");

/*
 SELECT *
FROM `victime`
WHERE `no_ordre` LIKE CONVERT( _utf8 '123'
USING latin1 )
COLLATE latin1_swedish_ci
LIMIT 0 , 30 

 SELECT *
FROM `victime`
WHERE `nom` LIKE CONVERT( _utf8 '%qqq%'
USING latin1 )
COLLATE latin1_swedish_ci
LIMIT 0 , 30 
*/
?>