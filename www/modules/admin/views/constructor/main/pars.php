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
	            url:'/admin/sources/list_category'
	        }),
	        reader: new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	            id:'id'
	        },["id", "COUNT","TIME","PERIOD"]),
	        remoteSort:true 
	});

	
	
	
	
	
	
		var tarrifsgrid = new Ext.grid.EditorGridPanel({
	   store: tarrifsStore,
	  	id:'tarrifs_grid',
	   selModel:new Ext.grid.RowSelectionModel({singleSelect:false}),
     sm:new Ext.grid.CheckboxSelectionModel(),  
     cm:new Ext.grid.ColumnModel([
	       
     	    { 
              id:'COUNT', 
              header: "Колличетсво", 
              sortable: false, 
              dataIndex: 'COUNT',
              editor: new Ext.form.TextField({
	        		maxLengthText:30,
	           	    allowBlank: false
	       	    })
     	    },{ 
              id:'PERIOD', 
              header: "Переодичность", 
              sortable: false, 
              dataIndex: 'PERIOD',
              editor: new Ext.form.ComboBox({
                store:new Ext.data.JsonStore({
                    id: 'id',
                    fields: ['id', 'text'],
                    data : [
                        {id: '1', text:'Минут'},
                        {id: '2', text:'Часов'},
                        {id: '3', text:'Дней'},
                        {id: '4', text:'Недель'}
                    ]
                }),
                displayField:'text',
                valueField:'id',
                typeAhead: true,
                mode: 'local',
                forceSelection: false,
                triggerAction: 'all',
                selectOnFocus:false
            }),
            renderer:function(val){
                if (val*1 ==1)
                    return '<span style="color:green">Минут</span>';
                else if(val*1 ==2)
                    return '<span style="color:green">Часов</span>';
                else if(val*1 ==3)
                    return '<span style="color:green">Дней</span>';
                else if(val*1 ==4)
                    return '<span style="color:green">Недель</span>';
                    
            }
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
	
	var reset= function(url){
		 Ext.Ajax.request({
                url:url,
                success:function(response) {
                 
				
                },
                params:{
                    'action':"delete"
                }
                        
            });
	}

	
    
    var win = new Ext.Window({
	      layout:'fit',
	      autoWidth: true,
	      modal: true,
	      defaults: { autoScroll:true,height: 100,width:300},

	      closeAction:'hide',
	      items:[{
            title: 'Опции импорта',
            border:false,
            id: 'catlist',
            items: tarrifsgrid
            
        }],
	     

	      buttons: [{
	        text:'Сохранить',
	        handler:function(){
          	itemsSav(tarrifsStore, '/admin/sources/save_option');
          	
          }
	      },{
	        text: 'Закрыть',
	        handler: function(){
	          win.hide();
	        }
	      },{
	        text:'Сбросить',
	        handler:function(){
          	reset('/admin/sources/reset');
          	}
          }]
	 });