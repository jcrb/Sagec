      /**
       * A distance widget that will display a circle that can be resized and will
       * provide the radius in km.
       *
       * @param {google.maps.Map} map The map to attach to.
       *
       * @constructor
       */
      function DistanceWidget(map) {
        this.set('map', map);
        this.set('position', map.getCenter());

        var marker = new google.maps.Marker({
          draggable: true,
          title: 'Move me!'
        });

        // Bind the marker map property to the DistanceWidget map property
        marker.bindTo('map', this);

        // Bind the marker position property to the DistanceWidget position
        // property
        marker.bindTo('position', this);

        // Create a new radius widget
        var radiusWidget = new RadiusWidget();

        // Bind the radiusWidget map to the DistanceWidget map
        radiusWidget.bindTo('map', this);

        // Bind the radiusWidget center to the DistanceWidget position
        radiusWidget.bindTo('center', this, 'position');
      }
      DistanceWidget.prototype = new google.maps.MVCObject();


      /**
       * A radius widget that add a circle to a map and centers on a marker.
       *
       * @constructor
       */
       function RadiusWidget() {
         var circle = new google.maps.Circle({
           strokeWeight: 2
         });

         // Set the distance property value, default to 50km.
         this.set('distance', 50);

         // Bind the RadiusWidget bounds property to the circle bounds property.
         this.bindTo('bounds', circle);

         // Bind the circle center to the RadiusWidget center property
         circle.bindTo('center', this);

         // Bind the circle map to the RadiusWidget map
         circle.bindTo('map', this);

         // Bind the circle radius property to the RadiusWidget radius property
         circle.bindTo('radius', this);
       }
       RadiusWidget.prototype = new google.maps.MVCObject();


       /**
        * Update the radius when the distance has changed.
        */
       RadiusWidget.prototype.distance_changed = function() {
         this.set('radius', this.get('distance') * 1000);
       };


      function init() {
        var mapDiv = document.getElementById('map-canvas');
        var map = new google.maps.Map(mapDiv, {
          center: new google.maps.LatLng(37.790234970864, -122.39031314844),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
          });
        var distanceWidget = new DistanceWidget(map);
        alert('test');
      }

