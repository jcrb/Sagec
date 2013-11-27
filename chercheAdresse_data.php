<?php
/**
*	chercheAdresse_data.php
*/
?>

	// Create a directions object and register a map and DIV to hold the 
    	// resulting computed directions

    var map;
    var directionsPanel;
   // var gdir;
	 var gdirs = Array();
    var message;
    var from;
    var to;
    
    function distance(from,to){
    	var gdir = new GDirections(map, directionsPanel);
    	var t ;
    	var texte;
    	var mesure; 
    	
    	GEvent.addListener(gdir, "load", onGDirectionsLoad);
    	GEvent.addListener(gdir, "error", handleErrors);
    	
    		var locale = "fr";
    		gdir.clear();
      	gdir.load("from: " + from + " to: " + to,
                { "locale": locale });
    	
    	onGDirectionsLoad = function(){ 
      	// Use this function to access information about the latest load()results.
      	// e.g. var status = gdir.getStatus().code;
      	mesure = gdir.getDistance().meters;
      	var unite_mesure = 'mètres';
      	if(mesure > 1000){
      		mesure = mesure/1000;
      		unite_mesure = 'Km';
      	}
      	t = Math.ceil(gdir.getDuration().seconds/60); 
      	texte = document.getElementById('getStatus').innerText;
			message = texte + ' distance: '+mesure+' '+unite_mesure+' * '+'durée: '+t+' mn<br>';
     		document.getElementById("getStatus").innerHTML = message;
	 	 	//message = 'distance: '+mesure+' '+unite_mesure+' * '+'durée: '+t+' mn';
	 	 	alert(mesure);
	 	 	}
	 	 	
	 	 handleErrors = function()
	 	 {
	   	if (
	   	gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
	     		alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
	   	else if (
	   	gdir.getStatus().code == G_GEO_SERVER_ERROR)
	     		alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
	   
	   	else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
	    		 alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);

			//else if (gdir.getStatus().code == G_UNAVAILABLE_ADDRESS)  <--- Doc bug... this is either not defined, or Doc is wrong
			//     alert("The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.\n Error code: " + gdir.getStatus().code);
	     
	   	else if (gdir.getStatus().code == G_GEO_BAD_KEY)
	    	 alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);

	   	else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
	    	 alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
	    
	   	else alert("An unknown error occurred.");
		}
    }

    function initialize() {
      map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(42.351505,-71.094455), 15);
      directionsPanel = document.getElementById("route");
      
      gdir = new GDirections(map, directionsPanel);
      
      GEvent.addListener(gdir, "load", onGDirectionsLoad);
      GEvent.addListener(gdir, "error", handleErrors);
      setDirections("500 Memorial Drive, Cambridge, MA", "4 Yawkey Way, Boston, MA 02215 (Fenway Park)", "en_US");
    }
    
    function setDirections(fromAddress, toAddress, locale) {
    	//var locale = "fr";
    	gdir.clear();
      gdir.load("from: " + fromAddress + " to: " + toAddress,
                { "locale": locale });
    }
    
    function Smur(fromAdresse)
    {
    	var locale = "fr";
    	var a = Array();
    	var d = Array();
    	a[0]="Wissembourg, france";
    	a[1]="Haguenau, france";
    	a[2]="Saverne, france";
    	a[3]="Strasbourg, france";
    	a[4]="Selestat, france";
    	var to = fromAdresse;
    	//alert(fromAdresse);
    	var m='';
    	message='';
    	//document.getElementById("getStatus").innerHTML= "";
    	for( i= 0;i<5;i++)
    	{
    		//gdirs[i] = new GDirections(map, directionsPanel);
    		//GEvent.addListener(gdirs[i], "load", onGDirectionsLoad);
    		//gdirs[i].load("from: " + a[i] + " to: " + fromAdresse,{ "locale": locale });
    		//gdirs[i].load("from: " + fromAdresse + " to: " + a[i],{ "locale": locale });
    		
    		d[i] = new distance(a[i],to);
    	}
    	//alert(message);
    	//document.getElementById("getStatus").innerHTML= m;
    	for( i= 0;i<5;i++)
    	{
    		alert(d[i].t);
    	}
    }
    
    function onGDirectionsLoad(){ 
      // Use this function to access information about the latest load()results.
      // e.g. var status = gdir.getStatus().code;
      var mesure = gdir.getDistance().meters;
      var unite_mesure = 'mètres';
      if(mesure > 1000){
      	mesure = mesure/1000;
      	unite_mesure = 'Km';
      }
      var t = Math.ceil(gdir.getDuration().seconds/60);
      var texte = document.getElementById('getStatus').innerText;
		message = texte + ' distance: '+mesure+' '+unite_mesure+' * '+'durée: '+t+' mn<br>';
		
     document.getElementById("getStatus").innerHTML = message;
	  //message = 'distance: '+mesure+' '+unite_mesure+' * '+'durée: '+t+' mn';
	}
	
	 function handleErrors(){
	   if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
	     alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
	   else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
	     alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
	   
	   else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
	     alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);

	//   else if (gdir.getStatus().code == G_UNAVAILABLE_ADDRESS)  <--- Doc bug... this is either not defined, or Doc is wrong
	//     alert("The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.\n Error code: " + gdir.getStatus().code);
	     
	   else if (gdir.getStatus().code == G_GEO_BAD_KEY)
	     alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);

	   else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
	     alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
	    
	   else alert("An unknown error occurred.");
	   
	}