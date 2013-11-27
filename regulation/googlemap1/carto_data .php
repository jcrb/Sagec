<?php
/**
*	carto_data.php
*/
?>

var startZoom = 15;
var normalProj = G_NORMAL_MAP.getProjection();

/**
 *
 * @access public
 * @return void
 **/
 
function mouseMove()
{
}

function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	//map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	GEvent.addListener(map, 'mousemove', mouseMove);
}

function init()
{
	if(GBrowserIsCompatible())
	{
		var centerLatitude = 48.669544;
		var centerLongitude =  7.707370;
		map = new GMap2(document.getElementById("map"));
		setControles();
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location,startZoom);
		addMarker(centerLatitude,centerLongitude,description);
		// 		oStatusDiv.innerHTML = navigator.appName;
	}
}

window.onload = init;
window.unload = GUnload;