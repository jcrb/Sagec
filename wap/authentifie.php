<?php
// authentifie.php
$backPathToRoot = "../";
require($backPathToRoot."controle_acces.php");
include_once($backPathToRoot."login/init_security.php");
$login = Security::esc2Db($_REQUEST[login]);
$pass = Security::esc2Db($_REQUEST[pass]);
if($login && $pass)
{	
		$utilisateur_nom = autorise($login,$pass);
		if(!$utilisateur_nom)header("Location: test2.php?error=1");
		else header("Location: menu1.php");
	
}
else
	header("Location: test2.php?error=1");
?>