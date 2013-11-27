 <?php
 // nettoie_commune.php
 // supprime les apostrophes autour des noms de ville et des cartes top 25)
    include_once("../dbConnection.php");

$requete = "SELECT com_nom,top25 FROM commune";
$result = MYSQL_QUERY($requete);
while($rep=mysql_fetch_array($result))
{
	$com = ltrim($rep['com_nom'],'\"');
	$com = rtrim($com,'\"');
	$t25 = ltrim($rep['top25'],'\"');
	$requete = "UPDATE commune SET com_nom = '$com',top25 = '$t25' WHERE com_nom = '$rep[com_nom]'";
	echo $requete."<br>";
	$r = MYSQL_QUERY($requete);
}
    
?>