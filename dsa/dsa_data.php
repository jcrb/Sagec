/**
*	dsa_data.php
*/

var latlng = new google.maps.LatLng(48.585, 7.736);
var map;
var infoWindow = new google.maps.InfoWindow();
var pt;
var marker;
var markersArray = [];
var geocoder = new google.maps.Geocoder();


function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
} 

function initialize()
{
	var myOptions = {
      zoom: 10,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
    
    marker = new google.maps.Marker({
        position: latlng, 
        map: map,
        title:"Hello World!",
        draggable: true
    });
    
    google.maps.event.addListener(marker, 'drag', function()
    {
    	//updateMarkerStatus('Dragging...');
    	updateMarkerPosition(marker.get_position());

    	//infoWindow.setContent("<p>Position:</p>"+pt.lat()+"<br>"+pt.lng());
    	//infoWindow.open(map,marker);
  	 });
  	 
  	 google.maps.event.addListener(marker,'click',function()
    	{
    		map.setZoom(10);
    		var pt = marker.getPosition();
    		infoWindow.setContent("<p>Position:</p>"+pt.lat()+"<br>"+pt.lng());
    		infoWindow.open(map,marker);
    		// To add the marker to the map, call setMap();
			//marker.setMap(map);
    	}
    );  
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
