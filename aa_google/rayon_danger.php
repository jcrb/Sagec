<?php
/**
  *  rayon_danger.php
  */
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>MVC is Fun</title>

    <style type="text/css">
      #map-canvas {
        height: 500px;
      }
    </style>

    <script type="text/javascript"
        src="http://www.google.com/jsapi?autoload={'modules':[{name:'maps',version:3,other_params:'sensor=false'}]}">
    </script>
    <script src="map3.js" type="text/javascript"></script>
    <script type="text/javascript">
     
      google.maps.event.addDomListener(window, 'load', init);
    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>