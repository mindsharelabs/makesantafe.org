
//console.log(mapvars.name);
//console.log(mapvars);
	/*
			var greenIcon = L.icon({
			    iconUrl: '<?php echo get_template_directory_uri(); ?>/img/favicon.png',
				//shadowUrl: 'leaf-shadow.png',
				scrollWheelZoom: false,
				//boxZoom: false,
				//dragging: false,
				//touchZoom: false,
				//doubleClickZoom: false,
				//scrollWheelZoom: false,
			    iconSize:     [32, 32], // size of the icon
			    iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
			    popupAnchor:  [0, -16] // point from which the popup should open relative to the iconAnchor
			    // shadowSize:   [50, 64], // size of the shadow
			    //shadowAnchor: [4, 62],  // the same for the shadow
			});
	*/
		if( mapvars.icon ){
				var iconhtml = '<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-stack-1x fa-inverse">'+mapvars.icon+'</i></span>';
			}else{
				var iconhtml = '<i class="fa fa-map-marker fa-3x"></i>';
			}

		var anagramicon = L.divIcon({
		        // specify a class name that we can refer to in styles, as we
		        // do above.
		        className: 'map-icon',
		        // html here defines what goes in the div created for each marker
		        html: iconhtml,
		        // and the marker width and height
		        iconSize: [32, 32],
		        iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
		        popupAnchor:  [0, -16] // point from which the popup should open relative to the iconAnchor
		    })

			L.mapbox.accessToken = 'pk.eyJ1IjoiYW5hZ3JhbSIsImEiOiJnSWkybFMwIn0.kmqCTZK657a2rnN66XrdQA';

			var geocoder = L.mapbox.geocoder('mapbox.places'),
			map = L.mapbox.map('mapbox', 'anagram.ljl3m22c', {attributionControl: false});





			 if( mapvars.geo || !( mapvars.lat || mapvars.multiple) ){
							geocoder.query(mapvars.address, showMap);
							console.log('geo');
			} else {


				if(mapvars.multiple){

						var geojson = [
									  {
									    "type": "Feature",
									    "geometry": {
									      "type": "Point",
									      "coordinates": [-105.933693,35.5985516]
									    },
									    "properties": {
									      "title": "Academy for the Love of Learning",
									      "description": "133 Seton Village Rd, Santa Fe, NM 87508",
									    }
									  }

									];

								map.setView([35.689244,-105.941257], mapvars.zoom );


					}else{
						var geojson = [
									  {
									    "type": "Feature",
									    "geometry": {
									      "type": "Point",
									      "coordinates": [mapvars.lng,mapvars.lat]
									    },
									    "properties": {
									      "title": mapvars.name,
									      "description": mapvars.address,
									    }
									  },
									];

									map.setView([mapvars.lat, mapvars.lng], mapvars.zoom );
					};


						var locations = L.mapbox.featureLayer()
						    .setGeoJSON(geojson)
						    .addTo(map);



						        // Add each point as a divIcon and bind a popup to it.
						    locations.eachLayer(function(l) {
						        var props = l.feature.properties;
						        var m = L.divIcon({
						           	className: 'map-icon',
							        html: iconhtml,
							        iconSize: [32, 32],
									iconAnchor:   [16, 16],
									popupAnchor:  [0, -16]
						        });

						        l.setIcon(m);
						        l.bindPopup("<center><b>"+props.title+"</b><br>"+props.description+"</center>");
						    });

						    locations.eachLayer(function(m) {
							  m.openPopup();
							});

						    // Optionally show tooltips on hover
/*
						    locations.on('mouseover', function(e) {
						        e.layer.openPopup();
						    });
						    locations.on('mouseout', function(e) {
						        e.layer.closePopup();
						    });
*/

						    // Set map coordinates to capture all markers in view.
						   // map.fitBounds(locations.getBounds());


						    //this will replace all layers
						    //map.featureLayer.setGeoJSON(geojson).addTo(map);


			};

			function showMap(err, data) {
			    // The geocoder can return an area, like a city, or a
			    // point, like an address. Here we handle both cases,
			    // by fitting the map bounds to an area or zooming to a point.
			    if (data.lbounds) {
				    //map.fitBounds(data.lbounds);

			        map.setView([data.latlng[0], data.latlng[1]], mapvars.zoom );
			        var marker = L.mapbox.featureLayer({
					    type: 'Feature',
					    geometry: {
					        type: 'Point',
					        coordinates: [data.latlng[1], data.latlng[0]]
					    },
					    properties: {
					        "title": mapvars.name,
							"description": mapvars.address,
					    }
					}).addTo(map);


			      	marker.eachLayer(function(l) {
				      	 var props = l.feature.properties;
						        var m = L.divIcon({
						           	className: 'map-icon',
							        html: iconhtml,
							        iconSize: [32, 32],
									iconAnchor:   [16, 16],
									popupAnchor:  [0, -16]
						        });

						        l.setIcon(m);
						        l.bindPopup("<center><b>"+props.title+"</b><br>"+props.description+"</center>");
							 // l.openPopup();
							});

			    } else if (data.latlng) {
				     //var marker = L.marker([data.latlng[0], data.latlng[1]], {icon: anagramicon}).bindPopup("<b>"+mapvars.name+"</b><br>"+mapvars.address+"");
			        map.setView([data.latlng[0], data.latlng[1]], mapvars.zoom );
					map.addLayer(new L.Marker([data.latlng[0], data.latlng[1]], {icon: anagramicon}).bindPopup("<b>"+mapvars.name+"</b><br>"+mapvars.address+"") );
/*
			         marker.eachLayer(function(m) {
							  m.openPopup();
							});
*/

			       // var marker = L.marker([], {icon: anagramicon}).addTo(map)
			    }

			}

			function addDirections() {
				// move the attribution control out of the way
				//map.attributionControl.setPosition('bottomleft');

				// create the initial directions object, from which the layer
				// and inputs will pull data.
				var directions = L.mapbox.directions();

				var directionsLayer = L.mapbox.directions.layer(directions)
				    .addTo(map);

				var directionsInputControl = L.mapbox.directions.inputControl('inputs', directions)
				    .addTo(map);

				var directionsErrorsControl = L.mapbox.directions.errorsControl('errors', directions)
				    .addTo(map);

				var directionsRoutesControl = L.mapbox.directions.routesControl('routes', directions)
				    .addTo(map);

				var directionsInstructionsControl = L.mapbox.directions.instructionsControl('instructions', directions)
				    .addTo(map);
			}

			//addDirections();

			//map.dragging.disable();
			map.touchZoom.disable();
			//map.doubleClickZoom.disable();
			map.scrollWheelZoom.disable();
			//map.boxZoom.disable();
			//map.keyboard.disable();
			var layer = L.mapbox.tileLayer('anagram.ldnj6h3n').addTo(map);
