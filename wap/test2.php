<?php
	require("hawhaw.inc");
	$error = $_REQUEST[error];
	if($error==1) $mot="ERREUR";
  	$myPage = new HAW_deck("SAGEC", HAW_ALIGN_CENTER);
  	$myForm = new HAW_form("authentifie.php",HAW_METHOD_POST);
  	$myText = new HAW_text("SAGEC WAP");
  	$myPage->add_text($myText);
  	$myText = new HAW_text("Identifiez-vous");
  		$myText->set_br(2);
  		$myPage->add_text($myText);
  	$myInput = new HAW_input("login", $mot, "LOGIN");
	$myForm->add_input($myInput);
	$myInput = new HAW_input("pass", $mot, "PASSWORD");
		$myInput->set_type(HAW_INPUT_PASSWORD);
		$myInput->set_br(2);
	$myForm->add_input($myInput);
	
	$mySubmit = new HAW_submit("valider");
	$myForm->add_submit($mySubmit);

  $myPage->add_form($myForm);
  $myPage->create_page();
?>