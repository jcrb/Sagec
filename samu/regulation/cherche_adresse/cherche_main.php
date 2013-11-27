<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			ars_deces.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../../";
include_once("top_cherche.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

$id = $_REQUEST['ville_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Géolocalisation</title>
	<link rel="stylesheet" href="../../div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../../utilitaires.js"></script>

	<style type="text/css">

		.suggestionsBox {
    		position: relative;
    		left: 200px;
    		margin: 10px 0px 0px 0px;
    		width: 200px;
    		background-color: #212427;
    		-moz-border-radius: 7px;
    		-webkit-border-radius: 7px;
    		border: 2px solid #000;
    		color: #fff;
			}

		.suggestionList {
    		margin: 0px;
    		padding: 0px;
			}

		.suggestionList li {
   		 margin: 0px 0px 3px 0px;
   		 padding: 3px;
    		 cursor: pointer;
			}

		.suggestionList li:hover {
    		background-color: #659CD8;
		}
</style>

	<script src="../../../ajax/jquery-1.3.2.js" type="text/javascript"></script>
	
	<script type="text/javascript">

	function lookup(inputString) {
    	if(inputString.length == 0)
    	{
        // Hide the suggestion box.
        $('#suggestions').hide();
    	} 
    	else 
    	{
        $.post("RPC.php", {queryString: ""+inputString+""}, function(data){
            if(data.length >0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
        });
    }
	} // lookup

	function fill(thisValue,this_id) 
	{
		$('#inputString').val(thisValue);
		$('#ville_id').val(this_id);
		$('#suggestions').hide();
	}
	</script>
</head>

<body onload="document.getElementById('nom').focus()">
<!--
<form name="liste"  method="get" action="../../../regulation/regul_commune.php">
-->
<form name="liste"  method="get" action="geoloc_commune.php">

<div id="div2">
	<fieldset id="field1">
		<legend> Géolocalisation rapide</legend>
		<p>
			<label for="nom" title="nom">N° et rue:</label>
			<input type="text" name="nom" id="nom" title="nom" value="" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="ville" title="ville">Saisir le nom d'une ville:</label>
			<input size="30" id="inputString" onkeyup="lookup(this.value);" type="text" onFocus="_select('inputString');" onBlur="deselect('inputString');"/>
			<input type="hidden" name="ville_id" id="ville_id" value="3" />
		</p>
          
    <div class="suggestionsBox" id="suggestions" style="display: none;">
      <img src="upArrow.png" style="position: relative; top: -12px; left: 30px" alt="upArrow" />
      	<div class="suggestionList" id="autoSuggestionsList"></div>
    </div>
    </fieldset>
    
    <input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</div>
</form>
</html>
