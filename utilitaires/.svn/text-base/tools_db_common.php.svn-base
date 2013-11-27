<?php
// tools_db_common.php
// source: leboeuf pp 88

/* Remarque DSN (data source name pp 74): tableau associatif regroupant les infos nécessaires
	à une connexion avec une BD:
	$DSN = array(
		'hostname'=>"localhost",	//adresse du serveut MySql
		'username'=>"JCB",			// nom de l'utilisateur
		'password'=>"marion",		// mot de passe
		'dbname'=>"IOT"				// nom de la base
	);
*/

//=============================================================================================
// db_error_display		Affichage d'un message d'erreur
//						$err_msg
//						$link
//=============================================================================================
function db_error_display($err_msg, $link)
{
	global $lang;
	global $db_string_lang;
	printf($err_msg);
	if($link)
	{
		printf($db_string_lang['ERROR_DB'][$lang]."%d %s"),mysql_errno($link),mysql_error($link));
	}
}
//=============================================================================================
// db_connect		Ouverture d'une connection vers un serveur à partir d'un DSN
//					$DSN
//=============================================================================================
function db_connect($DSN)
{
	global $lang;
	global $db_string_lang;
	$link = mysql_connect($DSN['hostname'],$DSN['username'],$DSN['password']);
	if(!$link)
	{
		db_error_display(sprintf($db_string_lang['ERROR_DB_CONNECT'][$lang],$DSN['hostname'],$DSN['username']),$link);
		exit();
	}
	return $link;
}
//=============================================================================================
// db_select		Ouverture d'une base à partir d'un DSN
//					$DSN
//					$link
//=============================================================================================
function db_select($DSN, $link)
{
	global $lang;
	global $db_string_lang;
	if(!mysql_select_db($DSN['dbname'],$link))
	{
		db_error_display(sprintf($db_string_lang['ERROR_DB_SELECT'][$lang],$DSN['dbname'],$link);
		exit();
	}
}
//=============================================================================================
// db_disconnect	Fermeture d'une connection 
//					$link
//=============================================================================================
function db_disconnect($link)
{
	global $lang;
	global $db_string_lang;
	if(!mysql_close($link))
	{
		db_error_display(sprintf($db_string_lang['ERROR_DB_DISCONNECT'][$lang],$DSN['hostname'],$link);
		exit();
	}
}
//=============================================================================================
// db_query			Execution d'une requête 
//					$link
//					$query
//=============================================================================================
function db_query($link, $query)
{
	global $lang;
	global $db_string_lang;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		db_error_display(sprintf($db_string_lang['ERROR_DB_QUERY'][$lang],$query,$link);
		exit();
	}
	return $resultat;
}
//=============================================================================================
// db_doquery		FONCTION TOUT EN 1 
//					Connexion, sélection, requête et déconnexion
//					$DSN information de connexion
//					$query question
//=============================================================================================
function db_doquery($DSN, $query)
{
	$link = db_connect($DSN);
	db_select($DSN,$link);
	db_query($link,$query);
	db_disconnect($link);
}
?>