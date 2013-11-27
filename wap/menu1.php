<?php
// menu1.php
require("hawhaw.inc");
$myPage = new HAW_deck("Menu1", HAW_ALIGN_CENTER);
	$myText = new HAW_text("MENU 1");
	$myText->set_br(2);
	$myPage->add_text($myText);
	$myLink = new HAW_link("Main courante","wap_menu2.php");
	$myPage->add_link($myLink);
	$myLink = new HAW_link("Victime","");
	$myPage->add_link($myLink);
	$myLink = new HAW_link("Quitter","test2.php");
	$myPage->add_link($myLink);
$myPage->create_page();
?>