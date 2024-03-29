<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?php echo $lang['title']; ?></title>
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/ext-all.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/dashboard.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/Spinner.css" media="screen" />

	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/Ext.ux.tree.CheckTreePanel.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/upload-dialog.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/data-view.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/xtheme-gray.css" media="screen" />


	<link rel="stylesheet" type="text/css" href="/extjs/ux/css/Ext.ux.FileUploadField.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/extjs/ux/css/Ext.ux.ImageManager.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/extjs/ux/css/Ext.ux.grid.ExplorerView.css" media="screen" />

    <?php /*          DEBUG !!!!
    <script type="text/javascript" src="/extjs/adapter/ext/ext-base-debug.js"></script>
    	<script type="text/javascript" src="/extjs/ext-all-debug.js"></script>
    */ ?>
    <script type="text/javascript" src="/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="/extjs/ext-all.js"></script>

	<script type="text/javascript" src="/extjs/dashboard.js"></script>

	<script type="text/javascript" src="/extjs/ux/util.js"></script>
	<script type="text/javascript" src="/extjs/ux/arraytree.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.ux.plugins.DataView.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.UploadDialog.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.HtmlEditorImageInsert.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.grid.CheckColumn.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.ux.grid.Search.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.ux.form.DateTime.js"></script>
	<script type="text/javascript" src="/extjs/ux/Ext.ux.tree.CheckTreePanel.js"></script>
	<script type="text/javascript" src="/extjs/ux/Spinner.js"></script>
	<script type="text/javascript" src="/extjs/ux/SpinnerStrategy.js"></script>
	<script type="text/javascript" src="/extjs/ux/fieldpanel.js"></script>
	<script type="text/javascript" src="/extjs/ux/timefield.js"></script>
	<script type="text/javascript" src="/extjs/ux/ipfield.js"></script>
	<script type="text/javascript" src="/extjs/ux/tdgi.borderLayout.js"></script>
	<script type="text/javascript" src="/extjs/ux/RowExpander.js"></script>
	<script type="text/javascript" src="/extjs/ux/TabCloseMenu.js"></script>
	<script type="text/javascript" src="/extjs/im.js"></script>

        <script type="text/javascript" src="/extjs/ux/Ext.ux.ImageCrop.js"></script>
        <script type="text/javascript" src="/extjs/ux/Ext.ux.grid.ExplorerView.js"></script>
        <!--<script type="text/javascript" src="/extjs/ux/Ext.ux.ImageManager.js></script>-->

        <script type="text/javascript" src="/extjs/ux/Ext.ux.FileUploadField.js"></script>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=uk"></script>
		<script type="text/javascript" src="/extjs/ux/lib/jQuery/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="/extjs/ux/lib/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="/extjs/ux/Ext.ux.TinyMCE.min.js"></script>
	        
        </head>
<body>

<div id="loading">
  <div class="loading-indicator">
    <?php echo $lang['wait_msg']; ?><br />
    <img src="/extjs/resources/images/default/progress.gif" alt="<?php echo $lang['wait_msg']; ?>" />
  </div>
</div>

<script type="text/javascript">
	var Gmap;
    var balloon = new google.maps.InfoWindow({
        'size': new google.maps.Size(80,20)
    });
	function G_map_initialize(latitude,longitude,title) {
	  var center = new google.maps.LatLng(latitude,longitude);
	   var myOptions = {
	      zoom: 14,
	      center: center,
	      mapTypeId: google.maps.MapTypeId.HYBRID
	    };
	   
	  Gmap = new google.maps.Map(document.getElementById("google_map"), myOptions);
	  var marker = new google.maps.Marker({ 
		  position: new google.maps.LatLng(latitude,longitude), 
		  map: Gmap,
		  draggable: true,
		  animation: google.maps.Animation.DROP,
		  title:title,
		  position_changed:function(){
			  pos=marker.getPosition();
			  var m = Ext.getCmp('itemsGrid').getSelectionModel().getSelections();
	          if(m.length == 1) {
	              var r = m[0];
	              r.beginEdit();
	              r.set('latitude', pos.lat());
	              r.set('longitude', pos.lng());
	              Ext.getCmp('latitude').setValue(pos.lat());
	              Ext.getCmp('longitude').setValue(pos.lng());
	              r.endEdit();
	          }
			}
		});
	  balloon.content = title;
	  balloon.maxWidth=50;
      balloon.open(Gmap, marker);
	}




        function getCoordinates(lat, lon){
            var m = Ext.getCmp('itemsGrid').getSelectionModel().getSelections();
            if(m.length == 1) {
                var r = m[0];
                var map = document.getElementById('nadoloni');
                if (map.getAttribute('type') == 'application/x-shockwave-flash') {
                    var category = 36;
                    map.clearAll();
                    map.putMarker(lat, lon, category, r.get('street')+' '+r.get('building'));
                }
                r.beginEdit();
                r.set('latitude', lat);
                r.set('longitude', lon);
                Ext.getCmp('latitude').setValue(lat);
                Ext.getCmp('longitude').setValue(lon);
                r.endEdit();
            }
        }
        
	Ext.onReady(function(){
	
		Ext.ux.loaderListener = {
		    'beforeload':function() {
		        Ext.get('loading').show();
		    },
		    'load':function(){
		        Ext.get('loading').hide();
		    },
		    'loadexception':function(response) {
		        Ext.get('loading').hide();
		        Ext.MessageBox.alert('<?php echo $lang['wait_error']; ?>', '<?php echo $lang['wait_error_msg']; ?>');
		    }
		};				
		Ext.get('loading').hide();
		
	    var mainTabPanel = new Ext.TabPanel({
				enableTabScroll:true,
				activeTab: 0,
				region: 'center',
				layoutOnTabChange:true,
				monitorResize:true,
				id: 'dashboard_mainTabPanelID',
				plugins: new Ext.ux.TabCloseMenu(),
				margins: '0 5 5 0',
				defaults: { autoScroll:true },
				items: [{
					title: 'Welcome',
					html: ''
				}]
			});
	
	
	    Ext.BLANK_IMAGE_URL = '/extjs/resources/images/default/s.gif';
        
        <?php
		    foreach($modules_action as $i){ 
			    echo $i; 
		    }
	    ?>
        
        var dashboard_toolbar = new Ext.Toolbar();
            
        dashboard_toolbar.addText("<span style='font-size: 12px'><?php echo $lang['welcome_msg']; ?><\/span>");
	    dashboard_toolbar.addFill();
	    dashboard_toolbar.addText("<span style='font-size: 12px'><?php echo $lang['login_user'] . ": <b>$user->username</b>"; ?><\/span>");
	    dashboard_toolbar.addSeparator();
	    dashboard_toolbar.add({text:'<?php echo $lang['logout']; ?>',iconCls:'ico_logout',scope:this,handler:function () {document.location = '/admin/logout';}});
	    dashboard_toolbar.render('dashboard_container');
		    
	    var dashboard_viewport = new Ext.Viewport({
		    layout:'border',
		    items:[
			    mainTabPanel,
			    {
				    region:'north',
				    contentEl: 'dashboard_container',
				    border:false,
				    margins: '0 5 0 5',
              	    height:25
			    },{
				    region:'west',
				    width:230,
				    minWidth:200,
				    maxWidth:350,
				    margins: "0 0 5 5",
				    layout:"accordion",
				    title: '<?php echo $lang['navigation_panel']; ?>', 
				    split:true,
				    layoutConfig:{ animate:true,titleCollapse: true },
				    defaults: { border:false, autoScroll:true,collapsed:false },
				    items: <?php echo $modules; ?>
			    }
		    ]
	    });

	    mainTabPanel.load({
			url: "/admin/products/",
			params: {
				method: 'get'
			},
 			scripts: true,
 			text: "<?php echo $lang['wait_msg']; ?>"
 		});
	});
</script>
<div id="dashboard_container"></div>

</body>
</html>