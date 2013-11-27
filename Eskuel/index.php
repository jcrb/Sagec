<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if($_SESSION["autorisation"]<'10') header("Location:../logout.php");
if (@is_file('config.inc.php')) {
    header('Location: main.php');
}
else {
    header('Location: setup.php');
}
?>