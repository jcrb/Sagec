<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
include($backPathToRoot."dbConnection.php");
include("mto_utilitaires.php");


?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15" />
	<title>weather.com</title>
	<style type="text/css">
	body { background-color: white; color: black; font-family: Sans-Serif; }
	</style>
</head>

<body>
<?php
// utilisation de la classe parse 
//$p = new parse($data);

//listeStation('FRXX');
//GetLastDataStationXX();
printLastData(lePlusProche(48.30261111,7.68308333));
?>
</body>
</html>