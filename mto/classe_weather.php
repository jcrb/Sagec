<?php
// classe_weather.php
error_reporting(E_ALL);
//error_reporting(E_NONE);


define("URL_WEATHER", "http://xoap.weather.com/weather/local/");
define("URL_SEARCH", "http://xoap.weather.com/search/search?where=");
define("DEBUG",0);


class Weather {
	var $weatherXml;/** contient le fichier XML avec les infos MTO */
	var $weatherUnits;
	var $weatherCurrent;
	var $weatherForecast;
	var $weatherLocation;
	var $unit;	/** unités de mesure  */
	var $dayf;	/** durée des prévision (0 à 10 )  */
	var $location; /** lieu de la mesure  */ 
	var $partnerId;/** n° de partenaire fournit par Weather.com  */
	var $keyId;	/** clé fournit par Weather.com */
	var $mto;


/**
 *Le constructeur de la classe Weather à son rôle consiste à paramétrer l'identifiant d'enregistrement et
 * la clef fournit par weather.com
 */
function Weather($partnerId, $keyId) {
	$this->partnerId = $partnerId;
	$this->keyId = $keyId;
}
/**
 *Récupère le fichier XML contenant les données
 *@param $location ville dont on veut les ingormations MTO. Par défaut Strasbourg
 *@param $unit unités de mesure. Par défaut système métrique
 *@param $dayf nombre de jours dont on souhaite les prévisions. Max = 10, défaut=1
*/
function getWeather($location='FRXX0095', $unit = 'm', $dayf = -1) {
	$this->location = $location;
	$this->unit = $unit;
	if ($dayf > 10) {	// la valeur maximale de dayf est 10 à si la valeur supérieure a été communiquée, on la place automatiquement sur 10
		$this->dayf = 10;
	} elseif ($dayf < 0) {
		$this->dayf = 0;
	} else {
		$this->dayf = $dayf;
	}

	$options = "?cc=*&prod=xoap&unit=".$this->unit."&dayf=".$this->dayf."&par=".$this->partnerId."&key=".$this->keyId;
	if ($fp = fopen(URL_WEATHER.$this->location.$options, "r")) 
	{
		$this->weatherXml = "";	// le buffer qui reçoit la météo dans le fichier XML
		while ($buffer = fread($fp, 8192)) {
			$this->weatherXml .= $buffer;
		}
		fclose($fp);
	}
}

function afficheWeatherXML()
{
	if(isset($this->weatherXml))
		echo "<pre>".htmlentities($this->weatherXml)."</pre>";
	else
		echo "<pre>Le fichier est vide ou non chargé</pre>";
}

function getWeatherXML()
{
	if(isset($this->weatherXml))
		return $this->weatherXml;
	else
		return 0;
}
} // fin de la classe weather

/**
  *	utilisation de la classe simpleXML
  */
class SimpleWeatherXML {

	/* variables globales */
	var $racine = '';
	var $dirVentDeg;	/** direction du vent en degré */
	var $dirVentTxt;	/** direction du vent en texte: SSE */
	var $vitVentKmh;	/** vitesse du vent en Km/h */
	var $vitVentMps;	/** vitesse du vent en m/s */
	var $rafaleVent;
	var $pressionAt;	/** pression athmosphérique en mbar */
	var $pressionUp;	/** unité de pression */
	var $vitVentUs;	/** unité de vitesse */
	var $pressEvol;	/** évolution de la pression athmosphérique */
	var $humidite;		/** % d'humidite" */
	var $visibilite;	/** visibilité à vue" */
	var $forceUVval;	/** puissance des UV en valeur */
	var $forceUVtxt;	/** puissance des UV en texte */
	var $dewPoint;		/** point de rosée */
	var $phaseLune;	/** phase la lune */
	var $temperature;
	var $couverture;
	var $lastMesure;	/** horaire du dernier relevé */
	var $stationLat;
	var $stationLon;
	var $stationNom;
		
	function SimpleWeatherXML($weather)
	{
		$rep = simplexml_load_string($weather);
		if($rep == FALSE)
		{
			return FALSE;
		}
		else
		{
			$this->racine = $rep;
			$this->parseWeather();
		}
	}
	
	/**
	  *	parse le contenu de $ weather
	  */
	function parseWeather()
	{
		if(sizeof($this->racine->loc->dnam)>0)
		{
		$this->stationNom = $this->racine->loc->dnam;
		$this->stationLat = $this->racine->loc->lat;
		$this->stationLon = $this->racine->loc->lon;
		
		$this->dirVentDeg = $this->racine->cc->wind->d;
		$this->dirVentTxt = $this->racine->cc->wind->t;
		$this->vitVentKmh = $this->racine->cc->wind->s;
		$this->rafaleVent = $this->racine->cc->wind->gust;
		$this->vitVentUs  = $this->racine->head->us;
		$this->vitVentMps = 1000*$this->vitVentKmh/3600.0;
		
		$this->pressionAt = $this->racine->cc->bar->r;
		$this->pressionUp = $this->racine->head->up;
		$evol = $this->racine->cc->bar->d;
		switch($evol){
			case 'rising':$this->pressEvol = "en hausse";break;
			default: $this->pressEvol = $evol;
		}
		
		$this->humidite = $this->racine->cc->hmid;
		$this->visibilite = $this->racine->cc->vis;
		
		$this->forceUVval = $this->racine->cc->uv->i;
		$this->forceUVtxt = $this->racine->cc->uv->t;
		
		$this->dewPoint = $this->racine->cc->dewp;
		
		$this->temperature = $this->racine->cc->tmp;
		
		$this->lastMesure = $this->racine->cc->lsup;
		
		$couvert = $this->racine->cc->t;
		switch($couvert){
			case 'Mostly Cloudy':$this->couverture = 'Nuages épars';break;
			case 'Cloudy':$this->couverture = 'Quelques Nuages';break;
			default: $this->couverture = $couvert; break;
		}
		
		$phase = $this->racine->cc->moon->t;
		switch($phase){
			case 'Waxing Crescent':$this->phaseLune='1er croissant';break;
			default: $this->phaseLune=$phase;break;
		}
	  }
	}
	
	function getTemperature(){return $this->temperature;}
	function getPression(){return $this->pressionAt;}
	function getDewPoint(){return $this->dewPoint;}
	function getVisibilite(){return $this->visibilite;}
	function getUVvaleur(){return $this->forceUVval;}
	function getUVforce(){return $this->forceUVtxt;}
	function getHumidite(){return $this->humidite;}
	function getRaffales(){return $this->rafaleVent;}
	function getStabilite(){return $this->pressEvol;}
	function getUnitePression(){return $this->pressionUp;}
	function getCouverture(){return $this->couverture;}
	function getVitesse(){return $this->vitVentKmh;}
	
	function windChill(){
		$t = $this->temperature;
		$v = $this->vitVentKmh;
		if($t > 10 || $v > 5)
			return $t;
		else 
			return 13.12 + 0.6215*$t + (0.3965*$t - 11.37) * pow($v,0.16);
	}
	/**
	  * 	imprime le contenu de la chaine $weather
	  */
	function getWeather(){
		$this->racine->asXml();
	}

} /** fin de la classe */

class parse {

// variables globales
	var $current_tag = '';
	var $itemcount;
	var $items;
	var $chantitle;
	var $parser; /** parser XML */
	// variable de la profondeur du parcours de l'arbre 
	var $depth = array(); 
	// Etat de la pile de parcours du document XML 
	var $stack = array();
	

	 
function startElement($parser,$name,$attrs)
{
	$this->itemcount++;
	$this->current_tag = $name;
	if(DEBUG) 
	{
		print("Ouverture: ".$this->current_tag);
		if(sizeof($attrs))
		{
			print(" / ");
			 while (list($k, $v) = each($attribs)) {
            	print " <font color=\"#009900\">$k</font>=\"<font color=\"#990000\">$v</font>\"";}
		}
		print("<br>");
	}
	$this->depth[$parser]++;
	array_push($this->stack,$name); 
}

function endElement($parser,$name)
{
	$this->current_tag = $name;
	if(DEBUG) print("on remonte vers: ".$this->current_tag."<br>");
	$this->current_tag = '';
	$this->depth[$parser]--;
	array_pop($this->stack); 
}

function characterData($parser, $data)
{
	switch($this->current_tag)
	{
		case 'UT':print("unité de température ");
			switch($data){
				case 'C':print("en degrés celcius<br>");$this->mto['ut']='°C';break;
				case 'F':print("en degrés farenheit<br>");$this->mto['ut']='°F';break;
			}
			break;
		case 'UP':print("unité de pression ");
			switch($data){
				case 'mb':print("en milibar<br>");$this->mto['up']='mbar';break;
			}
			break;
		case 'US':print("unité de vitesse ");
			switch($data){
				case 'km/h':print("en km/h<br>");$this->mto['us']='km/h';break;
			}
			break;
		case 'UD':print("unité de distance ");
			switch($data){
				case 'km':print("en km<br>");$this->mto['ud']='km';break;
			}
			break;
		case 'UR':print("unité de précipitation ");
			switch($data){
				case 'mm':print("en mm<br>");$this->mto['ur']='mm';break;
			}
			break;
		case 'TM':print("Heure de la demande ".$data."<br>");$this->mto['tm']=$data;break;
		case 'LAT':print("Latitude ".$data."<br>");$this->mto['lat']=$data;break;
		case 'LON':print("Longitude ".$data."<br>");$this->mto['long']=$data;break;
		case 'SUNR':print("Lever du soleil à ".$data."<br>");$this->mto['sunr']=$data;break;
		case 'SUNS':print("Coucher du soleil à ".$data."<br>");$this->mto['suns']=$data;break;
		case 'LSUP':print("Heure de la dernière mesure ".$data."<br>");$this->mto['lsup']=$data;break;
		case 'TMP':print("Température ".$data."<br>");$this->mto['tmp']=$data;break;
		case 'FLIK':print("Point de rosée ".$data."<br>");$this->mto['flik']=$data;break;
		case 'R':
			if($this->stack[$this->depth[$this->parser]-2]=='BAR')
				print("pression athmosphérique ".$data." ".$this->mto['up']."<br>");$this->mto['bar']=$data;break;
		case 'D':
			if($this->stack[$this->depth[$this->parser]-2]=='BAR')
				print("évolution de la pression athmosphérique: ".$data."<br>");$this->mto['evol_bar']=$data;break;
			if($this->stack[$this->depth[$this->parser]-2]=='WIND')
				print("direction du vent: ".$data."<br>");$this->mto['wind_d']=$data;break;
		case 'S':
			if($this->stack[$this->depth[$this->parser]-2]=='WIND')
				print("vitesse du vent: ".$data." ".$this->mto['us']."<br>");$this->mto['wind_s']=$data;break;
		case 'GUST':
			if($this->stack[$this->depth[$this->parser]-2]=='WIND')
				print("GUST: ".$data." ".$this->mto['us']."<br>");$this->mto['gust']=$data;break;
		case 't':
			if($this->stack[$this->depth[$this->parser]-2]=='WIND')
				print("origine du vent: ".$data." ".$this->mto['us']."<br>");$this->mto['wind_t']=$data;break;
		case 'HMID':print("Humidité ".$data." %<br>");$this->mto['hmid']=$data;break;
		case 'VIS':print("Visibilité ".$data." <br>");$this->mto['vis']=$data;break;
			
		default://print("contenu -->".$data."<br>");break;
	}
	$this->current_tag = '';
	if(DEBUG) print("profondeur: ".$this->depth[$this->parser]."<br>");
	//if(DEBUG) print("contenu -->".$data."<br>");
}

function parse($fichier)
{
	/** initialisation du Parser */
	$this->parser = xml_parser_create();
	xml_set_object($this->parser, $this);// très important si on utilise parse dans une classe
	xml_set_element_handler($this->parser,"startElement","endElement");
	xml_set_character_data_handler($this->parser,"characterdata");
	// exécution
	$xmlresult = xml_parse($this->parser, $fichier);
	$xmlerror = xml_error_string(xml_get_error_code($this->parser));
	$xmlcrtline = xml_get_current_line_number($this->parser);
	xml_parser_free($this->parser);
}
}

?>