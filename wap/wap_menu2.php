<?php
// wap_menu2.php
require("hawhaw.inc");
$myPage = new HAW_deck("Menu1", HAW_ALIGN_CENTER);
	$myText = new HAW_text("MENU 2");
	$myText->set_br(2);
	$myPage->add_text($myText);
	$myLink = new HAW_link("envoyer message","wap_message.php");
	$myPage->add_link($myLink);
	$myLink = new HAW_link("menu 1","menu1.php");
	$myPage->add_link($myLink);
$myPage->create_page();
?>