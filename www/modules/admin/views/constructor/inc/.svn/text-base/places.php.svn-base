  var CountryStore = new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/places/country_list'
	        }),
	        reader:new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	        },['id',"name"]),
	        remoteSort:true,

 });
 var CityStore = new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/places/city_list'
	        }),
	        reader:new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	        },['id',"name"]),
	        remoteSort:true,

 });

var AirportStore = new Ext.data.Store({
	  proxy:new Ext.data.HttpProxy({
            url:'/admin/places/airports_list'
        }),
        reader:new Ext.data.JsonReader({
            root:'items',
            totalProperty:'total',
            idProperty:'id',
        },['id',"name"]),
        remoteSort:true
});
AirportStore.load();

 CountryStore.load();
 CityStore.load();
 var AirportFormReader = new Ext.data.JsonReader({},[<?php echo $form_columns ?>]);
 var AirportForm = new Ext.FormPanel({
        id:'AirportForm',
        method:'POST',
        region:'center',
        border:true,
        margins:'0 0 0 0',
        layout:'form',
        border:false,
        
        disabled:false,
        
        labelAlign:'top',
        baseCls:'x-plain',
        autoScroll:true,
        reader:AirportFormReader,
        items: [
        {
            xtype:'hidden',
            name:'id'
        },
        <?php if (file_exists("$dir/forms/$class.php")) { include "$dir/forms/$class.php";} ?>
        ]
  });
 var AirportADD = new Ext.Window({
        shim:false,
        modal:true,
        maximizable:true,
        title:'Добление Аеропорта',
        autoHeight:true,
        width:480,
        closeAction:'hide',
        items:AirportForm,
        buttonAlign:'center',
        buttons:[{
            text:'Сохранить',
            iconCls:'save',
            handler:function(){
            AirportForm.getForm().submit({ 
             url: 'admin/places/save',
             success: function(form, action){
              	 Ext.Msg.alert('Уведомление', 'Добавленно');
              	 AirportADD.hide();
              	 itemsStore.reload();
              },
              failure: function(form, action){
                 Ext.Msg.alert('Уведомление', 'Ошибка');
              }
            
            })
        }}, {
            text:'Закрыть',
            iconCls:'cancel',
            handler:function(){
                AirportADD.hide();
            }
        }]
 });
 