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
var map;

/* point central de la carte: par défaut Strasbourg */
var center = new google.maps.LatLng(48.583, 7.750);

/* caractéristiques par défaut de la carte */
var options = {
	zoom: 10,
	center: center,
	draggableCursor: 'crosshair',
	mapTypeId: google.maps.MapTypeId.ROADMAP};

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
	var latlng;
	if(lat != 0 && lng != 0)
	{
		latlng = new google.maps.LatLng(lat,lng);
	}
	else
		latlng = new google.maps.LatLng(centerLatitude, centerLongitude);
		
	marker = new google.maps.Marker({
          position: latlng,
          map:map});
          
	map.setCenter(latlng, startZoom);
  marker.setMap(map);
}

/**
*	mapClick - Handles the event of a user clicking anywhere on the map
*	Adds a new point to the map and draws either a new line from the last point
*	or a new polygon section depending on the drawing mode.
*/
function mapClick(event) 
{
	if(document.getElementById("check").checked == true)
      {
        document.getElementById("lat").value = event.latLng.lat();
        document.getElementById("long").value = event.latLng.lng();
        /* efface le marqueur */
        if(marker){
          marker.setMap(null);
          marker.setPosition(event.latLng);
         }
        /* crée le nouveau marqueur */
        else{
          marker = new google.maps.Marker({
          position: event.latLng,
          map:map});
        }
        marker.setMap(map);
      }
}

/**
 *
 * @access public
 * @return void
 **/
function init()
{
    map = new google.maps.Map(document.getElementById("map"),options);
    positionne();
    google.maps.event.addListener(map,'click',function(event){
      //alert(event.latLng.toString());
      mapClick(event);
      
     });

    /* 
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
	
   */
};
window.onload = init;

