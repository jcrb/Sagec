<body bgcolor="#FFFFFF" text="#000000">
<h2>Bulletin m�t�o METAR</h2>
<p>Cette page affiche le dernier bulletin m�t�o METAR pour une station donn�e.
<p>Les stations METAR sont g�n�ralement localis�es sur tous les grands a�roports et certains petits. Les identifiants de stations sont g�n�ralement des groupes de quetres lettres comman�ant par L pour la france (code OACI). Par exemple l'identifiant de Strasbourg-Entzheim est LFST.
<p>Les informations sont issues de la base de donn�es de la NOAA (voir <i>http://weather.noaa.gov/weather/metar.shtml</i>).
<p>On peut trouver des informations concernant les METAR sur <a href="http://weather.noaa.gov/weather/metar.shtml">http://weather.noaa.gov/weather/metar.shtml</a>.
<p><strong>Entrer l'identifiant de la station:</strong>
<p>
<form action=metar.php mehod=get>
<p>METAR Station ID: <input type="text" name="metar_station" size="4" maxlength="4" value="LFST">
<input type="submit" name="submit" value="Submit">
</form>
<hr noshade>

<?php
	//include "classe_weather.php";
	$metar_station = $_REQUEST['metar_station'];
	if(!isset($metar_station))
		$metar_station = 'LFST'; //Strasbourg par d�faut

 	function connect_error($metar_station) 
	{
		?>
      		<p><span class=navy>D�sol�, soit cet identifiant de station, <strong><? echo strtoupper($metar_station) ?></strong>, n'est 			pas valide, ou la liaison avec la NOAA est interrompue.</span>
    		<?php
    		die();
  	}

 	if(isset($metar_station)) 
	{
  		$file1 = "ftp://tgftp.nws.noaa.gov/data/observations/metar/decoded/" . strtoupper($metar_station) . ".TXT";
		//print($file1.'<br>');	  
  		$file2 = "ftp://tgftp.nws.noaa.gov/data/observations/metar/stations/" . strtoupper($metar_station) . ".TXT";
	// ftp://tgftp.nws.noaa.gov/data/forecasts/taf/stations
		//print($file2.'<br>');
  		if(!$fd1 = @fopen($file1, "rb"))
		{
    			connect_error($metar_station);
  		} 
		else 
		{
    			$decoded = fread($fd1, 9999999);
		printf("<h3>Observation METAR d�cod�e pour <span class=navy>%s</span></h3><pre>%s</pre>", strtoupper($metar_station),htmlentities($decoded));
    			fclose($fd1);
  		}
  		if(!$fd2 = @fopen($file2, "rb"))
		{
    			connect_error($metar_station);
  		} 
		else 
		{
    			$encoded = fread($fd2, 999999);
    			printf("<h3>Message METAR cod� pour <span class=navy>%s</span></h3><pre>%s</pre>", strtoupper($metar_station), htmlentities($encoded));
    			fclose($fd2);
  		} 
  	}
  ?>
  <a href="mto.php">MTO</a>
  </body>
  </html>
