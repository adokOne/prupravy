     var RemoveItems = function (grid,url,store) {
        console.log(grid);
        var m = grid.getSelectionModel().getSelections();
        if(m.length > 0) {
            Ext.MessageBox.confirm('Информация', 'Подтвердите операцию удаления' , function (btn) {
                if(btn == 'yes') {
                    var jsonData = '[{';
                    for(var i = 0, len = m.length; i < len; i++) {
                        var ss = '"'+i+'":"' + m[i].get('id') + '"';
                        if(i==0) {
                            jsonData = jsonData + ss;
                        } else {
                            jsonData = jsonData + ',' + ss;
                        }
                        itemsStore.remove(m[i]);
                    }
                    jsonData = jsonData + '}]';
                    Ext.Ajax.request({
		            	url:url,
		            	params:{
		                	delete: jsonData
		            	},
		            	method:'post',
		            	success:function(response, opts) {
		            		store.reload();
		                	grid.getView().refresh();
		            	}
            		});
                }
            });
        }
     };
	
	
	var ItemsSave = function (store,url) {
        var m = store.getModifiedRecords();
        if(m.length > 0) {
            var jsonData = new Array();
            for(i=0;i<m.length;i++) {
                jsonData[i] = m[i].data;
            }
            Ext.Ajax.request({
            	url:url,
            	params:{
                	save: Ext.util.JSON.encode(jsonData),
            	},
            	method:'post',
            	success:function(response, opts) {
            		store.commitChanges();
                	store.reload();
            }
            });
        } else {
            Ext.MessageBox.alert('Информация', 'Данные не модифицированы');
        }
     }
	
	var itemsRelink = function (grid, url, store, r_for) {
        console.log(grid);
        var m = grid.getSelectionModel().getSelections();
        var relink_to_id = ( r_for == 'mod' )?(document.getElementsByName('relink_to_mod')[0].value):(document.getElementsByName('relink_to_type')[0].value);
        
        if( relink_to_id == "" ){
        	Ext.MessageBox.alert('Предупреждение', 'Выбирите запись со списка, на которую перелинкировать пожалуйста');
        } else{
        	if(m.length == 1) {
	            Ext.MessageBox.confirm('Информация', 'Подтвердите операцию перелинкование' , function (btn) {
	                if(btn == 'yes') {
	                    var jsonData = new Array();
			            for( i = 0; i < m.length; i++ ){
			                jsonData[i] = m[i].data;
			                jsonData[i]['relink_to_id'] = relink_to_id;
			            }
			            Ext.Ajax.request({
			            	url:url,
			            	params:{
			                	relink: Ext.util.JSON.encode(jsonData),
			            	},
			            	method:'post',
			            	success:function(response, opts) {
			            		store.commitChanges();
			                	store.reload();
			            	}
			            });
	                }
	            });
	        } else if(m.length > 1) {
	            Ext.MessageBox.alert('Предупреждение', 'Выбирите только одну запись пожалуйста');
	        } else {
	            Ext.MessageBox.alert('Предупреждение', 'Выбирите запись пожалуйста');
	        }
	    }
    };
    
	var TypeReader  = new Ext.data.JsonReader({},['id','manufacturer_id','name']);
	var ModReader = new Ext.data.JsonReader({},['id','plane_type_id','name','manufacturer_id']);
    
    var TypesGridStore = new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/planes/types_list'
	        }),
	        reader:new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	        },['id',"manufacturer_id", "name"]),
	        remoteSort:true,
	        listeners:{
             	'update': function(){
                	var saveButton = TypesGrid.getTopToolbar().items.get('ItemsSave');
                	if (this.getModifiedRecords().length > 0 && saveButton){
                    	saveButton.enable();
                	} else {
                    	saveButton.disable();
                	}
            	}
        	} 
	}); 
 
    var ModGridStore = new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/planes/mod_list'
	        }),
	        reader:new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	        },['id',"plane_type_id", "name","manufacturer_id"]),
	        remoteSort:true,
	        listeners:{
             	'update': function(){
                	var saveButton = ModGrid.getTopToolbar().items.get('ItemsSave');
                	if (this.getModifiedRecords().length > 0 && saveButton){
                    	saveButton.enable();
                	} else {
                    	saveButton.disable();
                	}
            	}
        	} 
	});
 
 
 ManufacturersStore =  new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/manufacturers/list_items'
	        }),
	        reader:new Ext.data.JsonReader({
		            root:'items',
		            totalProperty:'total',
		            idProperty:'id',
	        	},['id', "name"]),
	       	remoteSort:true,
	       	listeners:{
             	'update': function(){},
             	'select': function(){}
             }
	        });
 
 var PlaneTypesStore =  new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/planes/types_list'
	        }),
	        reader:new Ext.data.JsonReader({
		            root:'items',
		            totalProperty:'total',
		            idProperty:'id',
	        	},['id', "name","plane_type_id"]),
	       	remoteSort:true,
	       	listeners:{
             	'update': function(){},
             	'select': function(){}
             }
	        });
	        
 var ModificationsStore =  new Ext.data.Store({
 	proxy:new Ext.data.HttpProxy({
	            url:'/admin/planes/mod_list_fullname'
	        }),
	        reader:new Ext.data.JsonReader({
		            root:'items',
		            totalProperty:'total',
		            idProperty:'id',
	        	},['id', "name"]),
	       	remoteSort:true,
	       	listeners:{
             	//'update': function(){},
             	//'select': function(){}
             }
  });
  
  var TypesStore =  new Ext.data.Store({
 	proxy:new Ext.data.HttpProxy({
	            url:'/admin/planes/types_list_fullname'
	        }),
	        reader:new Ext.data.JsonReader({
		            root:'items',
		            totalProperty:'total',
		            idProperty:'id',
	        	},['id', "name"]),
	       	remoteSort:true,
	       	listeners:{
             	//'update': function(){},
             	//'select': function(){}
             }
  });

	ModGridStore.load();
	PlaneTypesStore.load();
	ManufacturersStore.load();
	ModificationsStore.load();
	
	var Get_Type = function (){
	  ManufacturersStore.load();
	  TypesGridStore.load();
	  TypesStore.load();
	  EditTypeWin.show();
	}
 
	var Get_Mod = function (){
	  EditModWin.show()
	  ManufacturersStore.load();
	  PlaneTypesStore.load();
	  ModGridStore.load();
	  ModificationsStore.load();
	}
  
     var TypeGridTBar= [{
                        text: 'Добавить',
                        iconCls:'add',
                        handler: function () {
                        	console.log('erfrefre');
         					TypesGridStore.insert(0, new itemRecord());
     					},
                        tooltip:'Добавить',
            	 }, 
            
                 {
                        text: 'Удалить',
                        iconCls: 'remove',
                        tooltip:'Удалить',
                        handler:function(){
                        	RemoveItems(TypesGrid,'/admin/planes/remove_types',TypesGridStore)
                        } 
                        
                 }, 
                 
                 {
                        text: 'Сохранить',
                        iconCls: 'save',
                        id:'ItemsSave',
                        handler: function(){
                        	ItemsSave(TypesGridStore,'/admin/planes/save_types');
                        }
     }]
 
 	var TypeGridTBar_relink= [
     			{
                        text: 'Перелинковать существующую запись',
                        iconCls: 'save',
                        id:'ItemRelink_type',
                        handler: function(){
                        	itemsRelink(TypesGrid,'/admin/planes/relink_types',TypesGridStore, 'type');
                        }
     			},
     			
     			{
	                xtype:'combo',
	                anchor:'95%',
	                width: 250,
	                fieldLabel:'',
	                name:'relink_to_type',
	                hiddenName:'relink_to_type',
	                store: TypesStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                mode: 'local',
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:true,
	                listeners: {
							select:
							function(e,a) {
											
										  }
				            }
	           }
     ]
     
     var ModGridTBar= [{
                        text: 'Добавить',
                        iconCls:'add',
                        handler: function () {
         					ModGridStore.insert(0, new itemRecord());
     					},
                        tooltip:'Добавить',
            	 }, 
            
                 {
                        text: 'Удалить',
                        iconCls: 'remove',
                        tooltip:'Удалить',
                        handler:function(){
                        	RemoveItems(ModGrid,'/admin/planes/remove_mods',ModGridStore)
                        } 
                        
                 }, 
                 
                 {
                        text: 'Сохранить',
                        iconCls: 'save',
                        id:'ItemsSave',
                        handler: function(){
                        	ItemsSave(ModGridStore,'/admin/planes/save_mods');
                        }
     			}

     ]
     
     var ModGridTBar_relink= [
     			{
                        text: 'Перелинковать существующую запись',
                        iconCls: 'save',
                        id:'ItemRelink',
                        handler: function(){
                        	itemsRelink(ModGrid,'/admin/planes/relink_mods',ModGridStore, 'mod');
                        }
     			},
     			
     			{
	                xtype:'combo',
	                anchor:'95%',
	                width: 250,
	                fieldLabel:'',
	                name:'relink_to_mod',
	                hiddenName:'relink_to_mod',
	                store: ModificationsStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                mode: 'local',
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:true,
	                listeners: {
							select:
							function(e,a) {
											
										  }
				            }
	           }
     ]
 
 
/*********************** Grids **********************************/

	var TypesGrid = new Ext.grid.EditorGridPanel({
 			 store:TypesGridStore,
 	   		 id:'TypeGrid',
 	   		 clicksToEdit: 2,
 	   		 height: 450,
 	   		 region:'center',
			 selModel:new Ext.grid.RowSelectionModel({singleSelect:false}),
			 sm:new Ext.grid.CheckboxSelectionModel(),  
			 cm:new Ext.grid.ColumnModel([
   		  		new Ext.grid.CheckboxSelectionModel() ,
   		  		 {
				    header:'ID',
				    dataIndex:'id',
				    hidden:true,
				    hideable:false,
           
				},
				{
		            header:'Производитель',
		            dataIndex:'manufacturer_id',
		            width:200,
		            align:'center',
		            sortable:true,
		            editor: new Ext.form.ComboBox({
	                store:ManufacturersStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false
	            }),            
		            renderer:function(val){
		            	if(val == undefined)
		            	  return '';
		            	obj = ManufacturersStore.getById(val)
		                return obj.data.name;
		            }
		        },
               	{
				    header:'Название',
				    dataIndex:'name',
				    width:150,
				    maxWidth:150,
				    renderer:renderSearch,
			        editor:new Ext.form.TextField({
		                allowBlank: false
		            })
           
				}
	        ]),
 			   reader:TypeReader,
 			   tbar: [TypeGridTBar, TypeGridTBar_relink],
 			   bbar: GridBBar
    });
	var ModGrid = new Ext.grid.EditorGridPanel({
 			 store:ModGridStore,
 	   		 id:'ModGrid',
 	   		 clicksToEdit: 2,
 	   		 height: 450,
 	   		 region:'center',
			 selModel:new Ext.grid.RowSelectionModel({singleSelect:false}),
			 sm:new Ext.grid.CheckboxSelectionModel(),  
			 cm:new Ext.grid.ColumnModel([
   		  		new Ext.grid.CheckboxSelectionModel() ,
   		  		 {
				    header:'ID',
				    dataIndex:'id',
				    hidden:true,
				    hideable:false,
           
				},
				{
		            header:'Производитель',
		            dataIndex:'manufacturer_id',
		            width:200,
		            align:'center',
		            sortable:true,
		            editor: new Ext.form.ComboBox({
	                store:ManufacturersStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false
	            }),            
		            renderer:function(val){
		              console.log(val)
		            	if(val == undefined)
		            	  return '';
		            	obj = ManufacturersStore.getById(val)
		                return obj.data.name;
		            }
		        },{
		            header:'Тип',
		            dataIndex:'plane_type_id',
		            width:200,
		            align:'center',
		            sortable:true,
		            editor: new Ext.form.ComboBox({
	                store:PlaneTypesStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false
	            }),            
		            renderer:function(val){
		            	if(val == undefined)
		            	  return '';
		            	obj = PlaneTypesStore.getById(val)
		            	console.log(obj)
		                return obj.data.name;
		            }
		        },
               	{
				    header:'Название',
				    dataIndex:'name',
				    width:250,
				    maxWidth:250,
				    renderer:renderSearch,
			        editor:new Ext.form.TextField({
		                allowBlank: true,
		                value : '-//Base//-'
		            })
           
				}
	        ]),
 			   reader:ModReader,
 			   tbar: [ModGridTBar, ModGridTBar_relink]
    });
     var GridBBar = new Ext.PagingToolbar({
        store:TypesGridStore,
        pageSize:20,
        hideRefresh: true,
        displayInfo:true,
        listeners: {
			render: function(c){
				c.refresh.hideParent = true;
				c.refresh.hide();
				c.first.hideParent =true;
				c.first.hide();
				c.last.hideParent =true;
				c.last.hide();
			}
		},
        displayMsg:'{0} - {1} из {2}',
        emptyMsg:'Пусто...'
    });
 
/********************************** Window ********************************************/
    var EditTypeWin = new Ext.Window({
        shim:true,
        modal:true,
        maximizable:false,
        title:'Типы самолетов',
        width:720,
        height:450,
        layout:'border',
        autoHeight:false,
        closeAction:'hide',
        bodyStyle:'overflow-y:auto;',
        buttonAlign:'center',
        items:[TypesGrid],
        scripts:true,
        listeners:{
        	'hide':function(){
        	}
        },
        buttons:[
        	{
            text:'Закрыть',
            iconCls:'cancel',
            handler:function(){
                EditTypeWin.hide();
            }
        	}
       ],
        
     });
     
    var EditModWin = new Ext.Window({
        shim:true,
        modal:true,
        maximizable:true,
        title:'Редактирование модификации самолетов',
        width:730,
        height:450,
        autoHeight:false,
        closeAction:'hide',
        bodyStyle:'overflow-y:auto;',
        buttonAlign:'center',
        items:[ModGrid],
        scripts:true,
        listeners:{
        	'hide':function(){
        	}
        },
        buttons:[
        	{
            text:'Закрыть',
            iconCls:'cancel',
            handler:function(){
                EditModWin.hide();
            }
        	}
       ],
        
     });
     
    var HistoryWin = new Ext.Window({
        shim:true,
        modal:true,
        maximizable:true,
        title:'Редактирование истории КОНКРЕТНОГО самолета',
        width:860,
        height:450,
        autoHeight:false,
        closeAction:'hide',
        bodyStyle:'overflow-y:auto;padding:10px 16px;',
        buttonAlign:'center',
        items: [],
        listeners:{
        	'hide':function(){
        	}
        },
        buttons:[
        	{
            text:'Закрыть',
            iconCls:'cancel',
            handler:function(){
                HistoryWin.hide();
            }
        	}
       ],
        
     });

/******************** Grid Button ******************************/

    function historyButton(value, id, r)
    {
 
            var id = Ext.id();
            if (r.data.registered == false)
            {
                createGridButton.defer(1, this, ['Install', id, r]);
                return('<div id="' + id + '"></div>;');
            }else
            {
                createGridButton.defer(1, this, ['ReInstall', id, r]);
                return('<div id="' + id + '"></div>');
            }
 
    }
    function createGridButton(value, id, record) {
        new Ext.Button({
        	
            text:    'Создать историю с данным самолетом ',
            id:record.id,
            iconCls: 'option',
            handler : function(btn, e) {
            	Record = record.id;
                HistoryWin.show();
            }
        }).render(document.body, id);
    }