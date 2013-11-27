<?php
/**
  *	serveur XML
  *	serveur_rpc.php
  */
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  include('IXR_Library.inc.php');
  
  /**
    *--------------------------------
    *	FONCTIONS SPECIALISEE
    *--------------------------------
    */
    
	function PersonNameLast($args) {
		return 'Rodriguez';
	}

	function PersonNameFirst($args) {
		return 'Jonathan';
	}

  /**
  	 *-----------------------------------
    * MAIN
    *-----------------------------------
    */
  $server = new IXR_Server(array(
    'Person.Name.Last' => 'PersonNameLast',
    'Person.Name.First' => 'PersonNameFirst'
    ));
?>