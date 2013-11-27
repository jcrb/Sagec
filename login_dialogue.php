<?php
//===============================================================================================================
// 					AFFICHAGE DU DIALOGUE D'IDENTIFICATION
//===============================================================================================================
// afficher l'entête sagec
session_start();
session_unset();
session_destroy();
session_start();

$backPathToRoot = "./";
require($backPathToRoot."html.php");
entete_sagec_css('', "left", '', $backPathToRoot);
include($backPathToRoot."utilitaires/globals_string_lang.php");
include($backPathToRoot."utilitaires/table.php");
$_REQUEST['langue'] = '';
$the_langue = $_REQUEST['langue'];
switch($the_langue)
{
	case 'Francais':$langue = 'FR';break;
	case 'Deutsch':$langue = 'GE';break;
	case 'English':$langue = 'UK';break;
	default:$langue = 'FR';
}

// enregistrement de la langue
$_SESSION["langue"] = $langue;
//require($backPathToRoot."login/captcha.php");n'est selectionnée

?>

<html>
  <head>
		<link rel="stylesheet" type="text/css" href="../css/entete_gris.css" />
		<link rel="stylesheet" type="text/css" href="../css/menu_gris.css" />
		<link rel="stylesheet" type="text/css" href="./pma.css">
		<link rel="shortcut icon" href="./images/sagec67.ico" />
		<script  type="text/javascript" src="./utilitaires.js"></script>
		<title>Connexion Sagec</title>
	</head>
	
  <body onload="document.getElementById('log').focus()">
  <form name="form1" method="post" action="redirection.php">
	<p>&nbsp;</p>
	<table width="366" border="0" align="center" bgcolor="#CCCCFF">
  	  <tr bordercolor="#9933CC">
    	      <th width="6" rowspan="4" scope="col">&nbsp;</th>
              <th width="341" bordercolor="#9933CC" scope="col"><div align="center"><span class="Style20">
			<?php echo $string_lang['MSG_IDENTIFICATION'][$langue]; ?></span></div></th>
    		<th width="10" rowspan="4" scope="col">&nbsp;</th>
  	   </tr>
           <tr bordercolor="#9933CC">
   		 <th bordercolor="#9933CC" scope="col"><span class="Style21"><img src="images/Ligne%20Horiz%20Bordeau.gif" 
			width="340" height="4"></span></th>
  	   </tr>
  	   <tr>
    		<td>
      <table width="450" border="0" align="center">
        <tr bgcolor="#FF9900">
          <td width="116" bgcolor="#660066"><div align="right"><span class="Style9"><?php echo $string_lang['SESSION_LOGIN'][$langue];?></span></div>
		</td>
          <td width="201" bgcolor="#660066"><input type="text" id="log" name="login" onFocus="_select('log');" onBlur="deselect('log');"></td>
        </tr>
        <tr bgcolor="#FF9900">
          <td nowrap bgcolor="#660066"><div align="right"><span class="Style9"><?php echo $string_lang['SESSION_PASSWORD'][$langue]?></span></div></td>
          <td bgcolor="#660066"><input type="password" id="pass" name="password" onFocus="_select('pass');" onBlur="deselect('pass');"></td>
        </tr>

        <tr bgcolor="#FF9900">
          <td bgcolor="#CCCCFF">&nbsp;</td>
          <td bgcolor="#CCCCFF"><div align="right">
              <input type="submit" name="Submit" value="<?php echo $string_lang['VALIDER'][$langue];?>">
          </div></td>
        </tr>
      </table>
  </tr>
  <tr>
    <td><p align="center" class="Style21"><img src="images/Ligne%20Horiz%20Bordeau.gif" width="340" height="4"></p>
      <p align="left" class="Style22"><?php echo $string_lang['ECHEC_CONNEXION'][$langue];?></p>
    <p align="left" class="Style21">&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <th scope="col"><span class="Style13"><img src="images/Ligne%20Horiz%20Bordeau.gif" width="950" height="4"></span></th>
  </tr>
  <tr>
    <td><div align="center"><span class="Style13"><img src="images/Copyright%20SAGEC.gif" width="217" height="13"></span></div></td>
  </tr>
</table>
<p align="center" class="Style13">&nbsp;</p>
<p align="center" class="Style13">&nbsp;</p>
<p align="left" class="Style13">&nbsp;</p>
<p>&nbsp;</p>
</body>
<html>

