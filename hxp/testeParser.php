<?php
/**
* testeParser.php
*/
include ('xmlParser.php');

$p = new xmlParser("fichierTest.xml");
$p->parse();
?>