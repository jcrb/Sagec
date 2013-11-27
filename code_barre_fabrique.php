<?php
// code_barre_fabrique.php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("code_barre.php");
//$code = new debora($_REQUEST['ean']);
//$code->makeImage();
$codeEAN = new debora($_REQUEST['ean'],$_REQUEST['largeur'],$_REQUEST['hauteur']);
$codeEAN->makeImage();
?>
