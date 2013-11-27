<?php
/**
  *	client XML
  *	client_rpc.php
  *	Specifying a HXP server by URL (port 80 is assumed)
  */
  include('IXR_Library.inc.php');

	$header['usr'] = 'ies';
	$header['pw'] = 'ies';
	$header['lang'] = 'FR';
	
	function teste_serveur()
	{
		global $header;
		/*
		$client = new IXR_Client('http://sagec.no-ip.org/html/html/sagec4/sagec3/hxp/serveur_test.php');
		if (!$client->query('Person.Name.Last',$header)){
			die('Etwas ging falsch '.$client->getErrorCode().' : '.$client->getErrorMessage());
		}
		$reponse = $client->getResponse();
		echo $reponse.'<br>';
		*/
		
		echo 'teste local host<br>';
		print_r($header).'<br>';
		//$client = new IXR_Client('http://localhost/html/sagec3/hxp/serveur_test.php');
		$client = new IXR_Client('http://sagec.no-ip.org/html/html/sagec4/sagec3/hxp/serveur_test.php');
		
		if (!$client->query('Person.Name.Last',$header)){
			die('Something went wrong '.$client->getErrorCode().' : '.$client->getErrorMessage());
		}
		$reponse = $client->getResponse();
		print_r($reponse);
		print('<br>');
	}
	
	teste_serveur();
?>