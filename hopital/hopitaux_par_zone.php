<?php
/**
*	hopitaux_par_zone.php
*	affiche la liste des hôpitaux d'une zone dérterminée
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
require($backPathToRoot."interrogeBD.php");
require($backPathToRoot."utilitaires/globals_string_lang.php");
$langue = $_SESSION['langue'];
$listeID = 2; // NE PAS MODIFIER
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	<title>Affichage des hôpitaux </title>
	<LINK REL ="stylesheet" TYPE ="text/css" HREF ="hopital2.css">
</head>
<body>
<form name="">

<?php
$zone = 100;

$requete = "SELECT hopital.Hop_ID,Hop_nom,ville_nom 
				FROM hopital,adresse,ville,hopital_visible
				WHERE hopital.adresse_ID = adresse.ad_ID 
				AND adresse.ville_ID = ville.ville_ID 
				AND ville.zone_ID = '$zone'
				AND hopital.Hop_ID = hopital_visible.Hop_ID
				AND hopital_visible.org_ID = '$_SESSION[organisation]'
				AND hopital_visible.liste_ID = '$listeID'
				ORDER BY ville_nom
				";
/**
$requete="SELECT hopital.Hop_ID,hopital.Hop_nom
				FROM hopital,hopital_visible
				WHERE hopital.Hop_ID = hopital_visible.Hop_ID
				AND hopital_visible.org_ID = '$_SESSION[organisation]'
				AND hopital_visible.liste_ID = '$listeID'
				ORDER BY Hop_nom";*/
				
$resultat = ExecRequete($requete,$connexion);
?>
<div>
<table bgcolor="#CCFFFF" id="grille">
	<tr class="toprow">
		<td>&nbsp;</td>
		<td><?php echo $string_lang['MODIFIER'][$langue];?></td>
		<td><?php echo $string_lang['HOPITAL'][$langue];?></td>
		<td><?php echo $string_lang['VILLE'][$langue];?></td>
		<td><?php echo $string_lang['CONTACT'][$langue];?></td>
	</tr>
<?php
$flag = 0; // gestion de l'alternance des lignes 
while($rep=mysql_fetch_array($resultat))
{
	$i++;
	$requete="SELECT * FROM contact WHERE nature_contact_ID = 5 AND identifiant_contact = '$rep[Hop_ID]' AND type_contact_ID =1";
	$resultat2 = ExecRequete($requete,$connexion); 
	if(!$flag) $couleur="ligne_impaire"; else $couleur="ligne_paire";
	?>
	<tr class="<?php echo $couleur ?>">
		<td><?php echo $i; ?></td>
		<td><a href="hop_saisie.php?hopID=<?php echo $rep[Hop_ID];?>"><?php echo $string_lang['MODIFIER'][$langue]; ?></a></td>
		<td><?php echo $rep['Hop_nom']; ?></td>
		<td><?php echo $rep['ville_nom']; ?></td>
		<?php
		while($contact = mysql_fetch_array($resultat2))
		{
			?>
			<td><?php echo $contact['valeur']; ?></td>
			<?php
		}
		?>
	</tr>
	<?php
	$flag = 1 - $flag;
}
?>
</table>
</div>
</form>
</body>
</html>
<?php
?>
