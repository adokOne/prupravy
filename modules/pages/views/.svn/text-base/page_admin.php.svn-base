<script>


//***************  Create the Data Store  *************
var dataStore = new Ext.data.JsonStore({
    root: 'pages',
    totalProperty: 'totalCount',
    remoteSort: true,
    autoLoad: true,
    fields: [ 'pg_id', 'pg_title', 'pg_date' ],
    url: '/admin/pages/pages_list'
});

dataStore.setDefaultSort('pg_id', 'desc');

var loadEditForm = function(v_id, v_name){		
		var basePanelName = 'edit_panel_' + String(v_id);
		var baseFormName = 'form_panel_' + String(v_id);
		
		var jsonReader = new Ext.data.JsonReader({},['pg_id', 'pg_title', 'pg_text','pg_seo_name']);		
		
		//Проверка существует ли таб панель для даного ID
		var presPanel = false;		
		mainTabPanel.items.each(function(item){
			if(item.getId() == basePanelName){
				mainTabPanel.setActiveTab(item);	
				presPanel = true;
				return;
			}

				
		}, mainTabPanel.items);					
		if(presPanel){
			return;
			
		}	    

		var editPanel = mainTabPanel.add({
			id: basePanelName,
			title: v_name,
			layout:'border',
			closable:true,
			border:false,
	        tbar:[{
	        	tooltip:'Сохранить',
	            text:'Сохранить',
	            iconCls:'save',
	            handler:function() {

	            	var formPanel = Ext.getCmp(baseFormName);
	            	
	            	formPanel.form.findField('pg_text').setValue(Ext.getCmp(basePanelName).findById('pg_text').getValue());	          
	            		            	
		            if (formPanel.form.isValid()) {
		            	formPanel.form.submit({
		                    waitMsg:'Сохранение',
		                    url:'/admin/pages/save',
		                    failure:function(form, action) {
		                        Ext.MessageBox.alert('Результат', action.result.msg);
		                    },
		                    success:function(form, action) {
		                        Ext.MessageBox.alert('Результат', 'Сохранено');
		                        dataStore.reload();
				                mainTabPanel.remove(mainTabPanel.getActiveTab());
				                mainTabPanel.setActiveTab(0);			
		                    }
		                });
		            } else {
		                Ext.MessageBox.alert('Произошло что что странное', 'Произошло что что странное');
		            }
        
	            	
	            	
	            	
	            }
	        }, '-' ,{
	        	tooltip:'Отмена',
	            text:'Отмена',
	            iconCls:'cancel',
	            handler:function() {	            	
	              mainTabPanel.remove(mainTabPanel.getActiveTab());
	              mainTabPanel.setActiveTab(0);			
	            	
	            }
	        }],
	        
	        
			//Форма с базовыми параметрами			
			items:[{
			    region:'north',
			    height: 60,
			    layout:'fit',
			    baseCls:'x-plain',
			    border:true,
			    items:[
			    	{
			            xtype:'hidden',
			            id:'test_id',
			            value:v_id
				   },
				   new Ext.FormPanel({
			    		id:baseFormName,
				        baseCls:'x-plain',
				        autoHeight:true,
				        reader:jsonReader,
				        style:'padding:7px',
				        items: [{
				            layout:'column',
				            border:false,
				            baseCls:'x-plain',
				            defaults:{
				                border:false,
				                baseCls:'x-plain',
				                layout:'form'
				            },
				            items:[
								{
					                columnWidth:'.6',
					                items: [
							           new Ext.form.TextField({
							                fieldLabel:'Название',
							                name:'pg_title',
							                anchor:'95%',
							                allowBlank:false
							            }),
							           new Ext.form.TextField({
							                fieldLabel:'ЧПУ (ENG)',
							                name:'pg_seo_name',
							                anchor:'95%',
							                allowBlank:false
							            })
					                ]
				            	}]
				            		
				            	
				        },{
				            xtype:'hidden',
				            name:'pg_id'
				        },{
				            xtype:'hidden',
				            name:'pg_text'
				        }]

				    })]
			    
			},
			{
			    region:'center',
			    layout:'fit',
			    baseCls:'x-plain',
			    border:true,
			    items:[
						new Ext.TabPanel({
						        deferredRender:false,
						        activeTab:0,
						        border:false,
						        defaults:{
						            layout:'fit'
						        },
						        baseCls:'x-plain',						        
						        items:[{
							            title: 'Добавить',
							            items:[new Ext.form.HtmlEditor({
							                        id:'pg_text',
							                        plugins:new Ext.ux.plugins.HtmlEditorImageInsert(),
							                        anchor:'100%',
							                        allowBlank:true
							            })]
						        	}
						        ]						        
						        
						        
						        
						        
						
						})			    
			    
			    ]
			}
			
			
			
			]	        
		});
		
		
		mainTabPanel.setActiveTab(editPanel);	
		

		if(v_id === 0){//новый страница			
			Ext.getCmp(baseFormName).form.reset();
    		Ext.getCmp(basePanelName).findById('pg_text').setValue('');			
		}	else{
			
			//загрузка данных формы
			Ext.getCmp(baseFormName).form.load({url:'/admin/pages/edit',        
	        	success:function(form, action){      
	        		Ext.getCmp(basePanelName).findById('pg_text').setValue(form.findField('pg_text').getValue());	        		

	        	},
	            params:{
	                id:v_id
	            },
	            waitMsg:'Загрузка'
	        });					

			
			}
					
		

	};




//***************   <Search Field> ****************************
Ext.app.SearchField = Ext.extend(Ext.form.TwinTriggerField, {
    initComponent : function(){
        Ext.app.SearchField.superclass.initComponent.call(this);
        this.on('specialkey', function(f, e){
            if(e.getKey() == e.ENTER){
                this.onTrigger2Click();
            }
        }, this);
    },

    validationEvent:false,
    validateOnBlur:false,
    trigger1Class:'x-form-clear-trigger',
    trigger2Class:'x-form-search-trigger',
    hideTrigger1:true,
    width:180,
    hasSearch : false,
    paramName : 'query',

    onTrigger1Click : function(){
        if(this.hasSearch){
            this.el.dom.value = '';
            var o = {start: 0};
            this.store.baseParams = this.store.baseParams || {};
            this.store.baseParams[this.paramName] = '';
            this.store.reload({params:o});
            this.triggers[0].hide();
            this.hasSearch = false;
        }
    },

    onTrigger2Click : function(){
        var v = this.getRawValue();
        if(v.length < 1){
            this.onTrigger1Click();
            return;
        }
        var o = {start: 0};
        this.store.baseParams = this.store.baseParams || {};
        this.store.baseParams[this.paramName] = v;
        this.store.reload({params:o});
        this.hasSearch = true;
        this.triggers[0].show();
    }
}); // ***********  </SearchField> **********************

//**************    Paging Bar   ********************
var pagingBar = new Ext.PagingToolbar({
    pageSize: 25,
    store: dataStore,
    displayInfo: false,
    displayMsg: 'ddddddw',
    emptyMsg: "wdwwdwdw"

});

sm2 = new Ext.grid.CheckboxSelectionModel({singleSelect : false });



//**************** DeleteAction Handler ********************
var deleteQuestion = function(){
	var selected_item =itemsGrid.getSelectionModel().getSelections();
	if(selected_item.length > 0) {
		Ext.MessageBox.confirm('Сообщение', 'Вы уверенны что хотите удалить выбраные елементы?' , function (btn) {
			if(btn == 'yes') {
				var jsonData = '[{';
				for(var i = 0, len = selected_item.length; i < len; i++) {
					var ss = '"'+i+'":"' + selected_item[i].get('pg_id') + '"';
					if(i===0) {
                        jsonData = jsonData + ss;
                    } else {
                        jsonData = jsonData + ',' + ss;
                    }
                    dataStore.remove(selected_item[i]);
				}
				
				jsonData = jsonData + '}]';
                Ext.Ajax.request({
                    url:'/admin/pages/delete',
                    success:function(response) {
                        var json = Ext.util.JSON.decode(response.responseText);
                        if(!json.success) {
                            Ext.MessageBox.alert('Сообщение', json.msg);
                        } else {
                        	dataStore.reload();
                            //rootDate.reload();
                        }

                    },
                    params:{
                        'delete':jsonData
                    }
                });                    
			}
		});
	} else {
		Ext.MessageBox.alert('Сообщение', 'Не выбрано ни одного элемента');
	}
}
	

//************    Main Grid   ********************
var itemsGrid = new Ext.grid.GridPanel({
    id:'button-grid',
    store: dataStore,
    cm: new Ext.grid.ColumnModel([
        sm2,
        {header: "№", width: 10, sortable: true, dataIndex: 'pg_id'},
        {header: "Название", width: 60, sortable: true, dataIndex: 'pg_title'},
        {header: "Дата", width: 30, sortable: true, dataIndex: 'pg_date'}
    ]),
    sm: sm2,

    viewConfig: { forceFit:true },

    // inline toolbars
    tbar:[{
        text:'Добавить',
        tooltip:'Добавить',
        iconCls:'add',
        handler:function(){
        	loadEditForm(0, 'Добавление');
        	
        }
    }, '-', {
        text:'Редактировать',
        tooltip:'Редактировать',
        iconCls:'option',
        handler:function(){
		    var m = itemsGrid.getSelectionModel().getSelections();
		    if(m.length == 1) {
		    	loadEditForm(m[0].get('pg_id'), m[0].get('pg_title'));
		        
		    } else {
		        Ext.MessageBox.alert('Сообщение', 'Не выбрано ни одного элемента');
		    }            	
        }        
        
    },'-',{
        text:'Удалить',
        tooltip:'Удалить',
        iconCls:'remove',
        handler: deleteQuestion
    }],

 	// paging bar on the bottom
    bbar: [pagingBar,
           'cwwecwecwecw: ', ' ',
           new Ext.app.SearchField({
               store: dataStore,
               width:320
           }) ],
    
    frame: false,
    iconCls:'icon-grid'
});


// ****************  Integration into main container **********************************
var mainTabPanel = Ext.getCmp('dashboard_mainTabPanelID');
mainTabPanel.items.each(function(item){mainTabPanel.remove(item);}, mainTabPanel.items);
mainTabPanel.add({
		title: 'Страницы',
		region:'center',
		layout:'fit',
		iconCls:'ico_page',
		items: itemsGrid
	});

mainTabPanel.setActiveTab(0);

</script>