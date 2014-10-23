 var itemsSav = function (storeObject, url) {   	
        var m = storeObject.getModifiedRecords();
        if(m.length > 0) {
            jsonData = "[";
            for(i=0;i<m.length;i++) {
                record = m[i];
                jsonData += Ext.util.JSON.encode(record.data) + ",";
            }
            jsonData = jsonData.substring(0,jsonData.length-1) + "]";
            
            Ext.Ajax.request({
                url:url,
                success:function(response) {
                    var json = Ext.util.JSON.decode(response.responseText);
                    if(!json.success) {
                        Ext.MessageBox.alert('Помилка', json.msg);                        
                    } else {
                        storeObject.commitChanges();
                        storeObject.reload();
                    }

                },
                params:{
                    'save':jsonData
                }
                        
            });
        } else {
            Ext.MessageBox.alert('Информация', 'Данные не модифицированы');
        }
    };


    var itemsRemov = function (gridObject, url) {
        var m = gridObject.getSelectionModel().getSelections();    
            
        if(m.length > 0) {
            Ext.MessageBox.confirm('Информация', 'Подтвердите операцию удаления' , function (btn) {
                if(btn == 'yes') {
                    var jsonData = '[{';
                    for(var i = 0, len = m.length; i < len; i++) {
                        var ss = '"'+i+'":"' + m[i].id + '"';
                        if(i==0) {
                            jsonData = jsonData + ss;
                        } else {
                            jsonData = jsonData + ',' + ss;
                        }
                        gridObject.getStore().remove(m[i]);
                    }
                    jsonData = jsonData + '}]';
                    Ext.Ajax.request({
                        url:url,
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Помилка', json.msg);
                            } else {
                                gridObject.getStore().reload();
                            }

                        },
                        params:{
                            'delete':jsonData
                        }
                    });                    
                }
            });
        } else {
            Ext.MessageBox.alert('Информация', 'Введите необходимый минимум данных');
        }
    };  
    
    
    
    
    
    var headerNew=null;
    var headerNew =function (){
     tarrifsStore.load();
    	 win.show();
    };
     var tarrifsStore = new Ext.data.Store({
		  proxy: new Ext.data.HttpProxy({
	            url:'/admin/tariffs/list_category'
	        }),
	        reader: new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	            id:'id'
	        },["id", "name","description"]),
	        remoteSort:true 
	});

	
	
	
	
	
	
		var tarrifsgrid = new Ext.grid.EditorGridPanel({
	   store: tarrifsStore,
	  	id:'tarrifs_grid',
	   selModel:new Ext.grid.RowSelectionModel({singleSelect:false}),
     sm:new Ext.grid.CheckboxSelectionModel(),  
     cm:new Ext.grid.ColumnModel([
   		  new Ext.grid.CheckboxSelectionModel() ,
	        { 
     	        id: 'id',
     	        header: "Id",
     	        width: 20, 
     	        sortable: true,
     	        dataIndex: 'id'
          },{ 
              id:'name', 
              header: "Название", 
              sortable: false, 
              dataIndex: 'name',
              editor: new Ext.form.TextField({
	        		maxLengthText:100,
	           	    allowBlank: false
	       	    })
     	    },
     	    { 
              id:'description', 
              header: "Описание", 
              sortable: false, 
              dataIndex: 'description',
              editor: new Ext.form.TextField({
	        		maxLengthText:100,
	           	    allowBlank: true
	       	    })
     	    }
	    ]),
	   viewConfig: {
         forceFit: true
     },
     
     split: true,
	    ds:tarrifsStore,
	    stripeRows: true,
	    autoWidth: true,
	    autoHeight: true
	});
	
	var Windowc= new Ext.FormPanel({

		  url:'/admin/tariffs/add_option',
		  frame: true,
		  items: [
		      {
		          xtype: 'textfield',
		          id: 'name',
		          fieldLabel: 'Название',
		          allowBlank:false,
		          anchor: '90%'
		      }
		  ],

		  buttons: [
		      {
		        text: 'Отправить',
		        handler: function() {
		        	Windowc.getForm().submit({
		                waitTitle: 'пожалуйста подождите...',
		                waitMsg: 'Опция создается',
		                success: function(){
		                	Window.hide();
    		                }
		            });
		        	tarrifsStore.load();
		        }
		      }
		  ]
		});
	
	var Window = new Ext.Window({
  		modal: true,
  		title:'Название новой опции',
  		width:330,
  		closable: true,
  		closeAction:'hide',
  		 headerPosition: 'top',
  		items: Windowc
  		});
	
    
    var win = new Ext.Window({
	      layout:'fit',
	      autoWidth: true,
	      modal: true,
	      defaults: { autoScroll:true,height: 300,width:700},

	      closeAction:'hide',
	      items:[{
            title: 'Опции тарифов',
            border:false,
            id: 'catlist',
            items: tarrifsgrid
            
        }],
	      
	      tbar: [
		{
		xtype: 'buttongroup', 
		width:200,
		items:[
		      {'text':'Удалить',
		          iconCls:'remove', 
		          handler:function(){
		      	itemsRemov(tarrifsgrid, '/admin/tariffs/remove_options');
		      	
		      	}
		      },
		      {'text':'Добавить',
		        iconCls:'add',
		        handler:function(){
		      		Window.show();
		
		      	},
		      
		      
		      }
		  ]}],

	      buttons: [{
	        text:'Сохранить',
	        handler:function(){
          	itemsSav(tarrifsStore, '/admin/tariffs/save_option');
          	
          }
	      },{
	        text: 'Закрыть',
	        handler: function(){
	          win.hide();
	        }
	      }]
	 });