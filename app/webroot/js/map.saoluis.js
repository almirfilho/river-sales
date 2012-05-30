
var map, model, icon;

// coordenadas
var maxNorte	= -271494.32442095;
var maxSul		= -293661.06261972;
var maxLeste	= -4914050.11055;
var maxOeste	= -4944089.862659;
var centerLon	= -4930904.4752799;
var centerLat	= -281851.54175174;

var zoomPadrao	= 12;

// layers
var gmap	= new OpenLayers.Layer.Google( "Ruas Google" );
var markers = new OpenLayers.Layer.Markers( "Marcadores" );

// var x = 10;
// var y = 10;

$.fn.initMap = function( settable, model ){
	
	// construindo mapa
    map = new OpenLayers.Map({
        div: $(this).attr('id'),
		restrictedExtent: new OpenLayers.Bounds( maxOeste, maxSul, maxLeste, maxNorte ),
		projection: "EPSG:900913"
    });

	// adicionando layers
	map.addLayer( gmap );
	
	if( model != '' )
		map.addLayer( markers );
	
	// setando centro e zoom padrao do mapa
	map.setCenter( new OpenLayers.LonLat( centerLon, centerLat ), zoomPadrao );
	
	// adicionando controle de posicao do mouse
	map.addControl( new OpenLayers.Control.MousePosition() );
	
	// configurando handler para clicks
	if( settable ){
		
		OpenLayers.Control.Click = OpenLayers.Class( OpenLayers.Control, {
    
	    	defaultHandlerOptions: {
	            'single': true,
	            'double': false,
	            'pixelTolerance': 0,
	            'stopSingle': false,
	            'stopDouble': false
	        },

	        initialize: function( options ){
	
	            this.handlerOptions = OpenLayers.Util.extend(
	                {}, this.defaultHandlerOptions
	            );

	            OpenLayers.Control.prototype.initialize.apply( this, arguments );

	            this.handler = new OpenLayers.Handler.Click(
	                this, {
	                    'click': this.trigger
	                }, this.handlerOptions
	            );
	        }, 

	        trigger: function( event ){
	
	            var lonlat = map.getLonLatFromViewPortPx( event.xy );

	            // alert("You clicked near " + lonlat.lat + " N, " + lonlat.lon + " E");
			
				markers.addMarker( new OpenLayers.Marker( lonlat, icon ) );
				$('#' + model + 'Localizacao').val( lonlat.lon + ',' + lonlat.lat );
	        }

	    });
	
		// adicionando controle de click do mapa
		var click = new OpenLayers.Control.Click();
	    map.addControl( click );
	    click.activate();
	}

	// construindo icone
	if( model != '' ){
		
		icon = new OpenLayers.Icon(

			'http://localhost/rivervendas/sistema/img/sistema.custom/marker_' + model.toLowerCase() + '.png',
			new OpenLayers.Size( 39, 32 ),
			new OpenLayers.Pixel( -16, -36 )
		);
	}
	
	return $(this);
}

$.fn.setMarker = function( location ){
	
	// se houver localizacao setada, colocar marcador
	if( location != "" ){

		location = location.split(',');
		markers.addMarker( new OpenLayers.Marker( new OpenLayers.LonLat( parseFloat( location[0] ), parseFloat( location[1] ) ), icon ) );
	}

	return $(this);
}

$.fn.addMarker = function( location ){
	
	// se houver localizacao setada, colocar marcador
	if( location != "" ){

		location = location.split(',');
		markers.addMarker( new OpenLayers.Marker( new OpenLayers.LonLat( parseFloat( location[0] ), parseFloat( location[1] ) ), icon.clone() ) );
	}

	return $(this);
}

$.fn.setLocation = function( location ){
	
	// se houver localizacao setada, colocar marcador
	if( location != "" ){

		location = location.split(',');
		location[0] = parseFloat( location[0] );
		location[1] = parseFloat( location[1] )
		map.setCenter( new OpenLayers.LonLat( location[0], location[1] ), 15 );
		markers.addMarker( new OpenLayers.Marker( new OpenLayers.LonLat( location[0], location[1] ), icon ) );
	}

	return $(this);
}

$.fn.displayData = function( dataTypes ){

	for( i = 0; i < dataTypes.length; i++ )
		addLayer( dataTypes[ i ] );
	
	map.addControl( new OpenLayers.Control.LayerSwitcher() );
	
	return $(this);
}

$.fn.clickPopup = function(){
	
	// OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi/?url=";
	// 
	// info = new OpenLayers.Control.WMSGetFeatureInfo({
	//         url: 'http://localhost:8080/geoserver/wms', 
	//         title: 'Teste',
	//         queryVisible: true,
	//         eventListeners: {
	//             getfeatureinfo: function( event ){
	// 
	//                 map.addPopup( new OpenLayers.Popup.FramedCloud(
	//                     "chicken", 
	//                     map.getLonLatFromPixel( event.xy ),
	//                     null,
	//                     dumps(event),
	// 				// 'xalala!',
	//                     null,
	//                     true
	//                 ));
	//             },
	// 		nogetfeatureinfo: function( event ){
	// 			alert("nada");
	// 		}
	//         }
	//     });
	
	// map.addControl( info );
    // info.activate();
	// support GetFeatureInfo
		//     map.events.register('click', map, function( event ){
		// 	
		// x = event.xy.x;
		// y = event.xy.y;
		// 
		// map.addPopup( new OpenLayers.Popup.FramedCloud(
		// 	"popupX" + x + "Y" + y, 
		// 	map.getLonLatFromPixel( event.xy ),
		// 	null,
		// 	'xalala!',
		// 	null,
		// 	true
		// ), true);
		//         // document.getElementById('nodelist').innerHTML = "Loading... please wait...";
		//     
		//     	var params = {
		//             REQUEST: "GetFeatureInfo",
		//             EXCEPTIONS: "application/vnd.ogc.se_xml",
		//             BBOX: map.getExtent().toBBOX(),
		//             X: x,
		//             Y: y,
		//             INFO_FORMAT: 'text/html',
		//             // QUERY_LAYERS: map.layers[0].params.LAYERS,
		// 	QUERY_LAYERS: 'rivervendas:vendedores',
		//             FEATURE_COUNT: 50,
		//             Layers: 'rivervendas:vendedores',
		//             Styles: '',
		//             Srs: 'EPSG:900913',
		//             WIDTH: map.size.w,
		//             HEIGHT: map.size.h,
		//             format: 'image/png'
		// };
		// 
		// OpenLayers.loadURL("http://localhost:8080/geoserver/wms", params, this, setHTML, setHTML);
		//         OpenLayers.Event.stop( event );
		//     });

}

function addLayer( dataType ){

	var visible = true;
	
	if( 'visible' in dataType )
		visible = dataType.visible;
	
	map.addLayer( new OpenLayers.Layer.WMS( dataType.name, "http://localhost:8080/geoserver/wms", {
		layers: "rivervendas:" + dataType.layer,
		srs: "EPSG:900913",
		format: 'image/png',
		transparent: true,
	}, {
		isBaseLayer: false,
		displayOutsideMaxExtent: true,
		visibility: visible
	} ) );
}

function dumps(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...<br/>";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"<br/>";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}