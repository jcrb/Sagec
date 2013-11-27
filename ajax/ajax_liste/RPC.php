<?php
/**
  *	RPC.php
  */
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");

  // Is there a posted query string?
	if(isset($_POST['queryString'])) 
	{
		$queryString = $_POST['queryString'];
		// Is the string length greater than 0?
		if(strlen($queryString) >0) 
		{
			$requete = "SELECT ville_nom,ville_ID FROM ville WHERE ville_nom LIKE '$queryString%' LIMIT 10";
        	$resultat = ExecRequete($requete,$connexion);
        	while($rep=mysql_fetch_array($resultat))
        	{
        		echo '<li onClick="fill(\''.$rep['ville_nom'].'\',\''.$rep['ville_ID'].'\');">'.addslashes($rep['ville_nom']).'</li>';
        	}
		}
		else 
		{
            echo 'ERROR: There was a problem with the query.';
      }
	} 
	else 
	{
    echo 'There should be no direct access to this script!';
	}
?>
