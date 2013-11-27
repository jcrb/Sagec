<?php
/**
*	donnees_mto.php
*/
$backPathToRoot = "../";
?>
<html>
<head>
	<title>Donn�es m�t�o</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<link href="../../css/formstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="mto" action="mto_enregistre.php" method="post">
	<div id="formtitle">MTO</div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>Donn�es m�t�orologiques</legend>
		<p>
			<label name="dirvent" for="dirvent">Direction du vent</label>
			<input type="text" name="dirvent" id="dirvent" size="5">
			<span class="exemple">de 0� � 365� d�cimaux</span>
		</p>
		<p>
			<label name="temp" for="temp">Temp�rature</label>
			<input type="text" name="temp" id="temp" size="5">
			<span class="exemple">en �Celcius</span>
		</p>
		<p>
			<label name="pa" for="pa">Pression athmosph�rique</label>
			<input type="text" name="pa" id="pa" size="5">
			<span class="exemple">en mmHg</span>
		</p>
		<p>
			<label name="hm" for="hm">Humidit�</label>
			<input type="text" name="hm<img src="../ppi/ppi_dow/nfrn1409_fichiers/eclogo.gif" width="90" height="61" border="0" alt="" id="hm" size="5">
			<span class="exemple">en %</span>
		</p>
	</fieldset>
	</div>
	
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	
</form>
</body>
</html>