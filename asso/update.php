<?php
/**
 *		update.php
 */
$backPathToRoot = "../";
require $backPathToRoot."dbConnection.php";

$id  = $_REQUEST['id'];
$check = $_REQUEST['check'];

echo 'ID = '.$id.' ';
echo 'Check = '.$check;

if($id==0){
	$requete = "UPDATE `vecteur` SET Vec_Engage = '$check'";// tout cocher ou tout décocher 
}
else{
	$requete = "UPDATE `vecteur` SET Vec_Engage = '$check' WHERE Vec_ID = '$id'";
}
$resultat = ExecRequete($requete,$connexion);

return "msg = 'ok'";
?>
