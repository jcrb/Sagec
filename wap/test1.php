<?php

// HAWHAW example for (quite a stupid) password authentication
// Norbert Huffschmid
// 1.5.2004

require("../../HawHaw/hawhaw.inc");

if (!isset($_REQUEST['submit']))
{
  // pass 1

  $AuthPage = new HAW_deck("Authenticate", HAW_ALIGN_CENTER);
  $AuthPage->use_simulator();

  $myForm = new HAW_form($_SERVER['PHP_SELF']); 

  $text = new HAW_text("Entrez quelques chiffres:"); 
  $theID = new HAW_input("id", "", "Login",  "*N");
  $theID->set_size(4);
  $theID->set_maxlength(4);

  $thePW = new HAW_input("pw", "", "Password", "*N");
  $thePW->set_size(4);
  $thePW->set_maxlength(4);
  $thePW->set_type(HAW_INPUT_PASSWORD);

  $theSubmission = new HAW_submit("Valider", "submit");

  $myForm->add_text($text);
  $myForm->add_input($theID);
  $myForm->add_input($thePW);
  $myForm->add_submit($theSubmission);

  $AuthPage->add_form($myForm);

  $AuthPage->create_page();
}
else
{
  // form was filled and submitted - pass 2

 $WelcomePage = new HAW_deck("", HAW_ALIGN_CENTER);
 $WelcomePage->use_simulator();

  $text1 = new HAW_text("Hello " . $_REQUEST['id'], HAW_TEXTFORMAT_BIG); 
  $text2 = new HAW_text("Votre mot de passe expire dans 3 jours!", HAW_TEXTFORMAT_SMALL); 

  $WelcomePage->add_text($text1);
  $WelcomePage->add_text($text2);

  $WelcomePage->create_page();
}

?>
