<script type="text/javascript" src="/js/jquery-1.4.min.js"></script>
<script type="text/javascript">

var mainTabPanel = Ext.getCmp('dashboard_mainTabPanelID');
mainTabPanel.items.each(function(item){mainTabPanel.remove(item);}, mainTabPanel.items);

mainTabPanel.add({
	id: 'districts_panel',
    title: 'Районы городов',
    layout:'fit',
    iconCls:'ico_moderation',
    autoLoad: {url: '/admin/district/panel'}
});

mainTabPanel.setActiveTab(0);

var Marker = null;
var map = null;
var geocoder;

var store;
var districtsGrid;

var polygon = null;
var MarkersArray = [];
var PolygonsArray = [];
var CurrentPolygonIndex = -1;
var coords = [];

var cities = [];
<?php foreach($cities as $k=>$city){ ?>
	cities[<?php echo $city->id ?>]=new google.maps.LatLng(<?php echo $city->latitude ?>,<?php echo $city->longitude ?>);
<?php } ?>


function cleanMarkers(){
	if(MarkersArray){
		for(i=0; i<MarkersArray.length ; i++ )
			MarkersArray[i].setMap(null);
	}
}

function cleanPolygons(){
	if(PolygonsArray){
		for(i=0; i<PolygonsArray.length ; i++ )
			PolygonsArray[i].setMap(null);
	}
	PolygonsArray = [];
}

function selectPolygon(){
	
}

function load_districts(){
	cleanMarkers();
	CurrentPolygonIndex = -1;
	store.setBaseParam('city', $('#city_id').val());
	store.reload({callback: function(){

		if(polygon){
			 polygon.setMap(null);
			 polygon = null;
		}
		if(Marker)
			Marker.setMap(null);
		
		MarkersArray = [];
		map.setCenter(cities[$('#city_id').val()]);
		$('#polyform').html('');
		$('#new_district_center_lon').val('');
		$('#new_district_center_lat').val('');
		$('#new_district_name').val('');
		drawStorePolygons();
		
	}});
	
}

function drawStorePolygons(){
	//draw all regions
	var cnt = store.data.items.length;
	console.log(cnt)
	if(cnt  > 0 ){
		cleanPolygons();
		for(d=0; d<cnt; d++){

			r = store.data.items[d];

			coords = [];
			for(i in r.data.geom ){
				 coords[i] = new google.maps.LatLng(r.data.geom[i][1] , r.data.geom[i][0]);
			}
			
			PolygonsArray[d] = new google.maps.Polygon({
		         paths: coords,
		         strokeColor: "#" + r.data.color,
		         strokeOpacity: 0.7,
		         strokeWeight: 1,
		         fillColor: "#" + r.data.color,
		         fillOpacity: 0.25,
		         title: r.data.name,
		         zoom: r.data.zoom,
		         lat: r.data.latitude,
		         lon: r.data.longitude,
		         district_id: r.data.id,
		         discrict_index: d
		     });

			PolygonsArray[d].setMap(map);
			google.maps.event.addListener(PolygonsArray[d], 'click', selectDistrict );
			
		}
	}
}

function selectDistrict(event){
	
	var i = this.discrict_index;
	
	CurrentPolygonIndex = i;
	console.log(i);
	cleanMarkers();
	MarkersArray = [];
	r = store.data.items[i];

	//coords = [];
	$('#polyform').html('');
	for(i=0; i<r.data.geom.length; i++ ){
		 //coords[i] = new google.maps.LatLng(r.data.geom[i][1] , r.data.geom[i][0]);
		 $('#polyform').append('<div> \
					' + ( (i*1.0)+1 ) + ') Lat: ' + r.data.geom[i][0] + ' \
					Lng: ' + r.data.geom[i][1] + ' \
				</div>');  
		 

		 MarkersArray[i] = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    position: new google.maps.LatLng(r.data.geom[i][1] , r.data.geom[i][0]),
		    title: 'marker_' + ((i*1.0)+1)
		});
		google.maps.event.addListener(MarkersArray[i], 'dragend', markerPositionChanged);
	}

	$('#new_district_name').val( r.data.name );
	$('#new_district_center_lon').val( r.data.longitude );
	$('#new_district_center_lat').val( r.data.latitude );
	$('#new_district_color').val( r.data.color );
	$('#new_district_zoom').val( r.data.zoom );
	$('#city_id').val( r.data.city_id );
	
}

function addMarker(){
	var index = MarkersArray.length;
	
	MarkersArray[index] = new google.maps.Marker({
	    map: map,
	    draggable: true,
	    animation: google.maps.Animation.DROP,
	    position: map.getCenter(),
	    title: 'marker_' + ((index*1.0)+1)
	});
	google.maps.event.addListener(MarkersArray[index], 'dragend', markerPositionChanged);

	if(index == 0){ // add another 2 markers
		MarkersArray[1] = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    position: map.getCenter(),
		    title: 'marker_2'
		});
		google.maps.event.addListener(MarkersArray[1], 'dragend', markerPositionChanged);
		
		MarkersArray[2] = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    position: map.getCenter(),
		    title: 'marker_3'
		});
		google.maps.event.addListener(MarkersArray[2], 'dragend', markerPositionChanged);
		
	}
	
	
	if( MarkersArray.length > 0){
		$('#addMarkerButton').text('Додати маркер');
	}
	buildPolygonFromMarkers();
}

function buildPolygonFromMarkers(){
	
	 $('#polyform').html('');
	 var crd = [];
	 for(i=0; i<MarkersArray.length; i++ ){
		 crd[i] = MarkersArray[i].getPosition();
		 $('#polyform').append('<div id="polygon_point_' + i + '"> \
									 ' + ( (i*1.0)+1 ) + ') Lng: ' + MarkersArray[i].getPosition().lng() + ' \
									Lat: ' + MarkersArray[i].getPosition().lat() + ' \
								</div>');  
	 }

	 if(CurrentPolygonIndex >= 0){ // modify existing polygon
		 PolygonsArray[CurrentPolygonIndex].setOptions({ paths: crd });
		 console.log('selected');
	 }else {
		 console.log('new');
		 if(polygon)
			 polygon.setMap(null);
	
		 polygon = new google.maps.Polygon({
	         paths: crd,
	         strokeColor: "#ff0000",
	         strokeOpacity: 0.7,
	         strokeWeight: 1,
	         fillColor: "#ff0000",
	         fillOpacity: 0.25,
	         title: 'polygon'
	     });
	
		 polygon.setMap(map);
	 }
}

function getPlygonCoordinates(){
	var coordinates = [];
	 for(i=0; i<MarkersArray.length; i++ ){
		 coordinates[i] = [];
		 coordinates[i][0] = MarkersArray[i].getPosition().lng();
		 coordinates[i][1] = MarkersArray[i].getPosition().lat();
		 
	 }
	 return coordinates;
}

function setMapCenter(){
	if( $('#new_district_center_lon').val() == '' ){
		$('#new_district_center_lon').val( map.getCenter().lng() );
	}
	if( $('#new_district_center_lat').val() == '' ){
		$('#new_district_center_lat').val( map.getCenter().lat() );
	}
}

function createDistrict(){
	// check requred data
	var name = $('#new_district_name').val();
	var lng = $('#new_district_center_lon').val();
	var lat = $('#new_district_center_lat').val();
	var color =	$('#new_district_color').val();
	var zoom = $('#new_district_zoom').val();
	var city_id = $('#city_id').val();

	var district_id = '';
	if( CurrentPolygonIndex >= 0 ){
		district_id = PolygonsArray[CurrentPolygonIndex].district_id;
	}

	if( !name || !lng || !lat || !color || !zoom){
		alert ('Заповніть всі поля');
		return;
	}

	if( MarkersArray.length < 3 ){
		alert ('Додайте полігон. Кількість точок має бути більше трьох.');
		return;
	}

	coordinates = getPlygonCoordinates();
	
	$.ajax({
		type: "POST",
		url: "/admin/district/create",
		data: {
			'name': name,
			'lng': lng,
			'lat': lat,
			'color': color,
			'zoom': zoom,
			'city_id': city_id,
			'coordinates': coordinates,
			'district_id': district_id
		},
		dataType: 'json',
		success: function(msg){
			if(msg.status){
				store.reload();
				alert('ok');
				if(MarkersArray){
					for(i=0; i<MarkersArray.length ; i++ )
						MarkersArray[i].setMap(null);
				}
				MarkersArray = [];
				map.setCenter(cities[$('#city_id').val()]);
				$('#polyform').html('');
				$('#new_district_center_lon').val('');
				$('#new_district_center_lat').val('');
				$('#new_district_name').val('');
				
			}else {
				alert(msg.msg)
			}
		},
		error: function(){
			alert('Error occured')
		}
	});

	
}

function init_map(){
	var langt;
	var longt;
	
	if( !langt || !longt ){
		langt = 50.45273256141691;
		longt = 30.514592666625997;
	}
	
	var latlng = new google.maps.LatLng(langt, longt);
	var myOptions = {
	  zoom: 15,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("gmap"), myOptions);

	// render it
	districtsGrid.render('distrlist');

	// trigger the data store load
	store.setBaseParam('city', 1);
	store.load({params:{start:0, limit:50}});
	google.maps.event.addListener(map, 'rightclick', function(event){

		var index = MarkersArray.length;
	
		MarkersArray[index] = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    position: event.latLng,
		    title: 'marker_' + index
		});
		google.maps.event.addListener(MarkersArray[index], 'dragend', markerPositionChanged);
		buildPolygonFromMarkers();
		return false;
	} );
}

var markerPositionChanged = function (event) {
    //var latlng = Marker.getPosition();
    document.getElementById('longitude').value = event.latLng.lng();
    document.getElementById('latitude').value = event.latLng.lat();

    buildPolygonFromMarkers();
}

	store = new Ext.data.JsonStore({
    root: 'items',
    totalProperty: 'totalCount',
    idProperty: 'id',
    remoteSort: true,
    
    successProperty: 'success',
    messageProperty: 'message',  // <-- New "messageProperty" meta-data

    fields: ['id', 'name', 'color','zoom','latitude','longitude' ,'the_geom' ,'geom'],

    // load using script tags for cross domain, if the data in on the same domain as
    // this page, an HttpProxy would be better
    proxy: new Ext.data.HttpProxy({
        url: '<?php echo url::base() ;?>admin/district/get_items',
        api: {
            create : '<?php echo url::base() ;?>admin/district/item_create',
            update: '<?php echo url::base() ;?>admin/district/item_update',
            destroy: '<?php echo url::base() ;?>admin/district/item_destroy'
        }
    }),
    
    writer: new Ext.data.JsonWriter({
        encode: true,
        writeAllFields: false
    }),
    autoSave: true
});


store.setDefaultSort('id', 'desc')

districtsGrid = new Ext.grid.EditorGridPanel({
    height: 300,
    title:'Список районів',
    store: store,
    trackMouseOver:true,
    sm: new Ext.grid.RowSelectionModel({singleSelect: true}),
    loadMask: true,
    //headerCfg: { cls: 'ui-widget-header'},
    // grid columns
    columns:[{
        header: "ID",
        dataIndex: 'id',
        width: 20,
        align: 'right',
        sortable: true
    },{
        header: "Name",
        dataIndex: 'name',
        sortable: true,
        editor: new Ext.form.TextField({
            allowBlank: false
        })
    }],

    // customize view config
    viewConfig: {
        forceFit:true
    },

    // paging bar on the bottom
    bbar:  new Ext.PagingToolbar({
	            pageSize: 50,
	            store: store,
	            displayInfo: true,
	            displayMsg: 'Відображено районів {0} - {1} of {2}',
	            emptyMsg: "Райони відсутні",
	            items: [' ']
	})
    
});

districtsGrid.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	 coords = [];
	 $('#polyform').html('');
	 for(i in r.data.geom ){
		 coords[i] = new google.maps.LatLng(r.data.geom[i][1] , r.data.geom[i][0]);
		 $('#polyform').append('<div> \
				' + ( (i*1.0)+1 ) + ') Lat: ' + r.data.geom[i][0] + ' \
				Lng: ' + r.data.geom[i][1] + ' \
			</div>');  
	 }

	 
	 if(polygon)
		 polygon.setMap(null);

	 polygon = new google.maps.Polygon({
         paths: coords,
         strokeColor: "#" + r.data.color,
         strokeOpacity: 0.7,
         strokeWeight: 1,
         fillColor: "#" + r.data.color,
         fillOpacity: 0.25,
         title: r.data.name,
         zoom: r.data.zoom,
         lat: r.data.latitude,
         lon: r.data.longitude,
         district_id: r.data.id
     });

	 polygon.setMap(map);
	 var latlng = new google.maps.LatLng(r.data.latitude, r.data.longitude);
	 map.setCenter(latlng);
	 map.setZoom(r.data.zoom - 2);
});

setTimeout('init_map();', 1000)
setTimeout('load_districts();', 1000)

</script>