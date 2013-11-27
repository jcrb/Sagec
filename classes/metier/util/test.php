<?php
require_once 'Date.class.php';

$vRes = Metier_Util_Date::StringDateVersTimestamp("20081022");
$vRes = Metier_Util_Date::StringDateVersTimestamp("2008-10-22");
$vRes = Metier_Util_Date::StringDateVersTimestamp("2009-03-18");

?>