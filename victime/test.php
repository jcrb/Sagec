<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require $backPathToRoot.'utilitaires/dbConnection.php';
require $backPathToRoot.'utilitaires/liste.php';
include_once $backPathToRoot.'utilitairesHTML.php';
?>
<head>
    <script src="test.js" type="text/javascript"></script>
    <script src="../ajax/ajax.js" type="text/javascript"></script>
    <script src="../ajax/JSON.js" type="text/javascript"></script>
</head>

<body>
<form>
<?php

print("<table>");
	print("<tr>");
		print("<td>Hôpital</td>");
		print("<td>");
			select_hopital_visible($connexion,$item_select,$langue,$onChange="recupService(this.value)");
		print("</td>");
		print("<td>Service</td>");
		print("<td>");
			print("<select name='serviceID' id='serviceID' onChange='recupUF(this.value)'>");
    		print("<option selected='selected' >Sélectionner un service</option>");
  			print("</select>");
  		print("</td>");
  		
  		print("<td> UF </td>");
		print("<td>");
			print("<select name='ufID' id='ufID' >");
    		print("<option selected='selected' >Sélectionner une UF</option>");
  			print("</select>");
  		print("</td>");
	print("</tr>");
print("</table>");
?>
</form>
</body>