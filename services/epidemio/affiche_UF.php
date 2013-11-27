<?php
/**
*	affiche_UF.php
*/
$backpath2root = "../../";
include($backpath2root."dbConnection.php");
$serviceID = $_REQUEST[serviceID];
$requete="SELECT uf_ID,uf_code,uf_nom FROM uf WHERE service_ID = '$serviceID' ORDER BY uf_code";
$resultat = ExecRequete($requete,$connexion);
?>
<table border="1" cellspacing="0">
<tr>
	<td>code UF</td>
	<td>Intitulé</td>
	<td>Lits disponibles</td>
</tr>
<?php
while($rep=mysql_fetch_array($resultat))
{
	?>
	<tr>
		<td><?php echo $rep[uf_code];?> </td>
		<td><?php echo $rep[uf_nom];?> </td>
		<td><input type="text" name="lit_dispo[]" value=""></td>
	</tr>
	<?php
}
?>
</table>
<input type="submit" name="ok" value="valider"/>