<?php
/**
*	digitaliseur_data.php
*/

?>

var map;
var mode; // 0 ligne, 1 polygone, 2 point, 3 rien
var mode_ligne = 0;
    var mode_polygone = 1;
    var mode_point = 2;
    var mode_null = 3;
 var fileMode;
    var modeTXT = 1;
    var modeKLM = 0;

var kmlFillColor = "7dff0000"; // half-opaque blue fill
var polyShape;
var polygonMode;
var polygonDepth = "20";
var polyPoints = [];
var marker;
var geocoder = null;

var fillColor = "#0000FF"; // blue fill
var lineColor = "#FF0000"; // black line
var opacity = .5;
var lineWeight = 2;

function init()
{
	if (GBrowserIsCompatible()) 
	{
        map = new GMap2(document.getElementById("map"),{draggableCursor: 'crosshair', draggingCursor: 'move'});
        map.setCenter(new GLatLng(48.665556, 7.710556), 13);
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.enableDoubleClickZoom();
        keyboardhandler = new GKeyboardHandler(map);
        map.addControl(new GOverviewMapControl(new GSize(100,100)), new GControlPosition(G_ANCHOR_BOTTOM_RIGHT));
		  GEvent.addListener(map, 'click', mapClick);
        geocoder = new GClientGeocoder();
        mode = mode_ligne;
        fileMode = modeKLM;
        clearMap();
	}
}
/**
*	nettoie la carte courante
*/
function clearMap()
{
	map.clearOverlays();
	polyPoints = [];
	document.getElementById("coords").value ="&lt;-- Click on the map to digitize!";
}

/**
*	mapClick - Handles the event of a user clicking anywhere on the map
*	Adds a new point to the map and draws either a new line from the last point
*  or a new polygon section depending on the drawing mode.
*/
function mapClick(marker, clickedPoint)
{
	//polygonMode = document.getElementById("drawMode_polygon").checked;

	// Push onto polypoints of existing polygon
	polyPoints.push(clickedPoint);
	drawCoordinates();
}

/**
*	drawCoordinates
*/
function drawCoordinates()
{
	//Re-create Polyline/Polygon
	if(mode == mode_polygone)
	{
			// Push onto polypoints of existing polygon
        	polyShape = new GPolygon(polyPoints,lineColor,lineWeight,opacity,fillColor,opacity);
	}
	else if(mode == mode_ligne)
	{
        	polyShape = new GPolyline(polyPoints,lineColor,lineWeight,opacity);
	}
	else if(mode == mode_point)
	{
		//marker = new GMarker(pt);
		//map.addOverlay(marker);
	}
	
	if(mode != mode_null)
	{
      map.clearOverlays();
      // récupère le dernier point de polyPoints pour en faire le marker
      marker = new GMarker(polyPoints[polyPoints.length -1]);
      map.addOverlay(marker);
      map.addOverlay(polyShape);
      logCoordinates();
    }
}

/**
*	logCoordinates - écrit les coordonnées des points contenus dans le tableau polyPoints
*	Cette version utilise le style KML, mais peut être étendue à d'autres modes de sortie
*/
function logCoordinates()
{
	var header="# MON TITRE\n";
	document.getElementById("coords").value =  header;
	
	for (var i = 0; i< polyPoints.length; i++)
	{
		var lat = polyPoints[i].lat();
		var longi = polyPoints[i].lng();
		if(lat && longi)
			document.getElementById("coords").value += longi + ", " + lat + ",0\n";
	}
}

function deleteLastPoint()
{
	// supprime le dernier element du tableau polypoint
	polyPoints.pop();
	drawCoordinates();
}

function fermer()
{
	// ferme la forme
	polyPoints.push(polyPoints[0]);
	drawCoordinates();
}

function showAddress(address) 
{
	if (geocoder)
	{
		geocoder.getLatLng(address,
         function(point) 
         {
           if (!point) 
           {
             alert(address + " non trouvée");
           } 
           else
           {
	     			clearMap();
             	map.setCenter(point, 13);
           }
         }
       );
	}
}

window.onload = init;
window.unload = GUnload;