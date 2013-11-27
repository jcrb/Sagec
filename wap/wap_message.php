<?php
// wap_message.php
require("hawhaw.inc");
$myPage = new HAW_deck("message", HAW_ALIGN_CENTER);
	$myForm = new HAW_form("send_message.php",HAW_METHOD_POST);
		$myArea = new HAW_textarea("msg", "Nouveau message ...", "Message", 5, 25);
		$myForm->add_textarea($myArea);
		$mySubmit = new HAW_submit("valider");
		$myForm->add_submit($mySubmit);
	$myPage->add_form($myForm);
	$myLink = new HAW_link("menu 1","menu1.php");
	$myPage->add_link($myLink);
$myPage->create_page();
?>