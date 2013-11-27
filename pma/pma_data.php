<?php
/**
*	pma_data.php
*/
?>

var centerLatitude = 48.655806;
var centerLongitude = 7.798040;
var startZoom = 15;
var description = 'Lanxes'
var mouseTracking = 0;
var marker;
var geocoder = null;

function mouseMove(mousePt)
{
	if(mouseTracking)
   {
		mouseLatLng = mousePt;
		var zoom = map.getZoom();
		var oStatusDiv = document.getElementById("mouseTrack")	
		var mousePx = normalProj.fromLatLngToPixel(mousePt, zoom);
		oStatusDiv.innerHTML = 'Latitude:   ' + mousePt.y.toFixed(6) + '<br>Longitude: ' + mousePt.x.toFixed(6) ;
	}
}

/**
*	positionne - positionne la carte si les coordonnées du point sont connues
*/
function positionne()
{
	var lat = document.getElementById("lat").value;
	var lng = document.getElementById("long").value;
	var pt;
	if(lat != 0 && lng != 0)
	{
		pt = new GLatLng(lat, lng);
	}
	else
		pt = new GLatLng(centerLatitude, centerLongitude);
	map.setCenter(pt, startZoom);
	marker = new GMarker(pt);
   map.addOverlay(marker);
}

/**
*	mapClick - Handles the event of a user clicking anywhere on the map
*	Adds a new point to the map and draws either a new line from the last point
*	or a new polygon section depending on the drawing mode.
*/
function mapClick(marker, clickedPoint) 
{
	// pour éviter de déplacer un point par inadvertance
	if(document.getElementById("check").checked == true)
	{
		// on efface la marque précédante
		map.clearOverlays();
		// dessine le nouveau point
		marker = new GMarker(clickedPoint);
   	map.addOverlay(marker);
		// renseigne les coordonnées
		document.getElementById("lat").value = clickedPoint.lat();
		document.getElementById("long").value = clickedPoint.lng();
	}
}

/**
 *
 * @access public
 * @return void
 **/
function init()
{
	if(GBrowserIsCompatible())
	{
		map = new GMap2(document.getElementById("map"),{draggableCursor: 'crosshair', draggingCursor: 'move'});
		//map.setCenter(new GLatLng(centerLatitude, centerLongitude), startZoom);
		positionne();
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.enableDoubleClickZoom();
      keyboardhandler = new GKeyboardHandler(map);
      map.addControl(new GOverviewMapControl(new GSize(100,100)), new GControlPosition(G_ANCHOR_BOTTOM_RIGHT));
		GEvent.addListener(map, 'click', mapClick);
		GEvent.addListener(map, 'mousemove', mouseMove);
      geocoder = new GClientGeocoder();
		//addMarker(centerLatitude,centerLongitude,description);
		// 		oStatusDiv.innerHTML = navigator.appName;
	}
}
window.onload = init;
window.unload = GUnload;