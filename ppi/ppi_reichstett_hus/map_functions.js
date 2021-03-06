var baseIcon = new GIcon();
   baseIcon.iconSize=new GSize(32,32);
   baseIcon.shadowSize=new GSize(56,32);
   baseIcon.iconAnchor=new GPoint(16,32);
   baseIcon.infoWindowAnchor=new GPoint(16,0);
var map;
var normalProj = G_NORMAL_MAP.getProjection();


/** exemple utilisation
<a href="javascript:visibilite('divid');">afficher/masquer</a>
<div id="divid" style="display:none;">contenu</div>
*/

/**
 * cr�er un marker en cliquant
 * @access public
 * @return void
 **/
function markerClick()
{
	GEvent.addListener(map,'click',
		function(overlay,latlng)
		{
			var marker = new GMarker(latlng);
			map.addOverlay(marker);
		}
	)
}

/**
 *
 * @access public
 * @return void
 **/
function addComplexMarker(point,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {
	var tab1 = new GInfoWindowTab("Info", '<div id="tab1" class="bubble">PRM<br>Point de rassemblement des moyens<br>A4 Bretelle de sortie Reichstett</div>');
	var tab2 = new GInfoWindowTab("Moyens", '<div>VSAV Nord<br>ASSU 834<br>ASSU 835<br>AR1 Strasbourg</div>');
	var infoTabs = [tab1,tab2];
	marker.openInfoWindowTabsHtml(infoTabs);

		//var dMapDiv = document.getElementById("detailmap");
		//var detailmap = new GMap2(dMapDiv);
		//detailmap.setCenter(point , 13);

		//var CopyrightDiv = dMapDiv.firstChild.nextSibling;
		//var CopyrightImg = dMapDiv.firstChild.nextSibling.nextSibling;
		//CopyrightDiv.style.display = "none";
		//CopyrightImg.style.display = "none";

	});
	//map.addOverlay(marker);
	return marker;
}

/**
 *
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
	Cr�e un marqueur � l'endroit point, avec l'image icon et lui associe un �v�nement Click
	En cas de click affiche une fen�tre avec le contenu html
*/
function createMarker(point,html,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
	return marker;
}

/**
 *
 * @access public
 * @return void
 **/
function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	//map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
}

/**
*	Cercle:renvoie un objet GPolygon d�crivant un cercle
*	lat: latitude du centre
* 	lng: longitude du centre
* 	rayon: rayon du cercle en km
*	color: couleur du cercle
*	transparence: entre  0 et 1
*/
function cercle(lat,lng,rayon,color,transparence)
{
	var center = new GLatLng(lat,lng);
	var circlepoints = new Array();
	with (Math)
	{
		var rLat = (rayon/6378.8) * (180/PI);
		var rLng = rLat/cos(center.lat() * (PI/180));
		for (var a = 0 ; a < 361 ; a+=10 ) 
		{
			var aRad = a*(PI/180);
			var x = center.lng() + (rLng * cos(aRad));
			var y = center.lat() + (rLat * sin(aRad));
			var point = new GLatLng(parseFloat(y),parseFloat(x));
			circlepoints.push(point);
		}
	}
	var couleur_trait = color;
	var epaisseur_trait = 1;
	var transparence_trait = 0.5;
	var a_circle = new GPolygon(circlepoints, couleur_trait,epaisseur_trait,transparence_trait,color, transparence);
	return a_circle;
}

/**
 *
 * @access public
 * @return void
 **/
function init(){
	if(GBrowserIsCompatible()){
		map = new GMap2(document.getElementById("map"));
		setControles();
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location,startZoom);
		addMarker(centerLatitude,centerLongitude,description);
		// 		oStatusDiv.innerHTML = navigator.appName;
		GEvent.addListener(map, 'mousemove', mouseMove);
	}
}

function mouseMove(mousePt)
{
	if(mouseTracking)
   {
		mouseLatLng = mousePt;
		var zoom = map.getZoom();
		var oStatusDiv = document.getElementById("mouseTrack")	
		var mousePx = normalProj.fromLatLngToPixel(mousePt, zoom);
		oStatusDiv.innerHTML = 'Latitude:   ' + mousePt.y.toFixed(6) + '<br>Longitude: ' + mousePt.x.toFixed(6) ;
		//oStatusDiv.innerHTML += '<br> ';
		//oStatusDiv.innerHTML += 'Mouse Px: ' + mousePx.x + ', ' + mousePx.y;
		//oStatusDiv.innerHTML += '<br>';
		//oStatusDiv.innerHTML += 'Tile: ' + Math.floor(mousePx.x / 256) + ', ' + Math.floor(mousePx.y / 256);
	}
}

window.onload = init;
window.unload = GUnload;