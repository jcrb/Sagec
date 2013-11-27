<?php
/**
  *	dsa_carto.php
  *
  *	Affichage de la carte des DSA
  */
  
  $backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
?>
var startZoom = 15;
var normalProj = G_NORMAL_MAP.getProjection();
var centerLatitude = 48.585;
var centerLongitude = 7.736;
var map;
var path = "../";

var baseIcon2134 = new GIcon();
   baseIcon2134.iconSize=new GSize(21,34);
   baseIcon2134.shadowSize=new GSize(25,16);
   baseIcon2134.iconAnchor=new GPoint(8,16);
   baseIcon2134.infoWindowAnchor=new GPoint(11,0);

function init()
{
	if(GBrowserIsCompatible())
	{
		map = new GMap2(document.getElementById("map"));
		setControles();
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location,startZoom);
	}
	affiche_dsa();
}

/**
 * setControles()
 * @access public
 * @return void
 **/
function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	//map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	GEvent.addListener(map, 'mousemove', mouseMove);
}

/**
 * addMarker
 * @access public
 * @return void
 **/
function addMarker(latitude,longitude,description){
	var marker = new GMarker(new GLatLng(latitude,longitude));
	GEvent.addListener(marker,'click',
		function(){
			marker.openInfoWindowHtml(description);
		}
	)
	map.addOverlay(marker);
}

/**
	Crée un marqueur à l'endroit point, avec l'image icon et lui associe un évènement Click
	En cas de click affiche une fenetre avec le contenu html
*/
function createMarker(point,html,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
	return marker;
}

/**
  *	affiche_dsa()
  */
function affiche_dsa()
{
	var latitude;
	var longitude;
	var dsa_ico = new GIcon(baseIcon2134, path +"images/pma_markers/dsa.png", null, "");
	<?php
		$requete = "SELECT * FROM dsa WHERE dsa_lat <> 0";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
		?>
			latitude = "<? echo $rub[dsa_lat]; ?>";
			longitude = "<? echo $rub[dsa_lng]; ?>";
			message = "<? echo Security::db2str($rub[dsa_site]);?>"+"<br>"+
						 "<? echo Security::db2str($rub[dsa_adresse]);?>"+"<br>"+
						 "<? echo Security::db2str($rub[dsa_tel]);?>"+"<br>"+
						 "<? echo Security::db2str($rub[dsa_comment]);?>"
						 ; 
			point = new GLatLng(latitude,longitude);
			//icone = getIcone(type); 
			markerH = createMarker(point,message,dsa_ico);
			map.addOverlay(markerH);
		<?php
		}
	?>
}

function mouseMove()
{
}

window.onload = init;
window.unload = GUnload;