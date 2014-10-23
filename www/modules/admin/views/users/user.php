<script type="text/javascript">

    var typesStore = new Ext.data.JsonStore({
        autoLoad:false,
        id: 'id',
        root: 'items',
        fields: ['id', 'text']
    });

    typesStore.loadData({"items":[
            {id:'tenant',text:'Арендатор'},
            {id:'owner',text:'Хозяин'},
            {id:'realtor',text:'Риэлтор'},
            {id:'agency',text:'Агенство'},
    ]});

    var setActiveTabCool = function(objTabPanel, indexTab){
        try{
            objTabPanel.setActiveTab(indexTab);
          } catch(e) {
            objTabPanel.setActiveTab(0);
            objTabPanel.setActiveTab(indexTab);
          }
    }
    
    var loadAfterLoad = function(arrFormVariables, formReader, flagNew){        
        for(var lp1=0; lp1<arrFormVariables.length; lp1++){    
            if(typeof(Ext.getCmp(arrFormVariables[lp1]))!='undefined'){                
                if(!flagNew){
                    eval('var formVal = formReader.jsonData[0].'+arrFormVariables[lp1]);
                } else {
                    var formVal = '';
                }
                Ext.getCmp(arrFormVariables[lp1]).setValue(formVal);
            }
        }
    }
    
    /*******
    Просмотр профиля пользователя
    u_id - идентификатор пользователя
    ********/
    var showProfile = function(u_id) {
        if(u_id > 0){
            bTabPanel.getComponent(1).enable();
            setActiveTabCool(bTabPanel, 1);
            bTabPanel.getComponent(0).disable();
            
            Ext.get('avatarImage').dom.src = '';
            userProfileForm.form.reset();
            userProfileForm.form.load({url:'/admin/user/show_profile',
                params:{
                    id: u_id
                },
                waitMsg:'Загрузка...',
                success:function(res, action){                    
                    loadAfterLoad(new Array(<?php echo $form_reader ?>), userProfileFormReader, false);
                    Ext.get('avatarImage').dom.src = action.result.data.avatar;
                }
            });
        } else {
            return(false);
        }
    };
    
    /**
    Удаление отмеченных елементов GRID
    **/
    var itemsRemove = function(){
        var m = itemsGrid.getSelectionModel().getSelections();
        if(m.length > 0) {
            Ext.MessageBox.confirm('Оповещение', 'Вы уверены что хотите удалить выбранных пользователей?' , function (btn) {
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
                        url:'/admin/user/remove_grid',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Ошибка', 'Ошибка удаления');
                            }
                            itemsStore.reload();
                        },
                        params:{
                            'delete':jsonData
                        }
                    });                    
                }
            });
        } else {
            Ext.MessageBox.alert('Оповещение', 'Не выбран ни один пользователь');
        }
    };
    
    /**
    * Отметить выбранных пользователей как промодерированных    
    */
    var itemsApprove = function(){
        var m = itemsGrid.getSelectionModel().getSelections();
        if(m.length > 0) {
            Ext.MessageBox.confirm('Оповещение', 'Вы уверены что хотите отметить выбранных пользователей как промодерированных?' , function (btn) {
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
                        url:'/admin/user/approve_grid',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Ошибка', 'Ошибка модерации');
                            }
                            itemsStore.reload();
                        },
                        params:{
                            'approve':jsonData
                        }
                    });                    
                }
            });
        } else {
            Ext.MessageBox.alert('Оповещение', 'Не выбран ни один пользователь');
        }
    }
    
    /**
    * Отметить выбранных пользователей как заблокированных    
    */
    var itemsBan = function(){
        var m = itemsGrid.getSelectionModel().getSelections();
        if(m.length > 0) {
            Ext.MessageBox.confirm('Оповещение', 'Вы уверены что хотите заблокировать выбранных пользователей?' , function (btn) {
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
                        url:'/admin/user/ban_grid',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Ошибка', 'Ошибка модерации');
                            }
                            itemsStore.reload();
                        },
                        params:{
                            'ban':jsonData
                        }
                    });                    
                }
            });
        } else {
            Ext.MessageBox.alert('Оповещение', 'Не выбран ни один пользователь');
        }
    }
    
	/**
    GRID
    **/
    var itemsStore = new Ext.data.Store({
        autoLoad:true,
        proxy:new Ext.data.HttpProxy({
            url:'/admin/user/user_list_items'
        }),
        baseParams:{
            'limit':25
        },
        reader:new Ext.data.JsonReader({
            root:'items',
            totalProperty:'total',
            id:'id'
        },['id', 'usertype', 'username', 'phone', 'email', 'agency_name', {name: 'join', mapping: 'date_join'}]),
        remoteSort:true,
        listeners:Ext.ux.loaderListener
    });

    
    var loadAddParam = false;
    
    var itemsGrid = new Ext.grid.EditorGridPanel({	
    	ds:itemsStore,
        border:false,
        margins:'0',
        region:'center',
        split: true,
        enableHdMenu:false,
        trackMouseOver:true,
        clicksToEdit: 2,
        viewConfig: {
            forceFit: true
        },
        /*
       	plugins:[new Ext.ux.grid.Search({
                iconCls:'bogus',                
                disableIndexes:['join', 'activation'], 
                checkIndexes: ['username', 'email'],              
                width: 180,
                autoFocus:true
        })],
        */
        /*
        listeners: {
            celldblclick: function(gr, rIndex, cIndex, e){
                var row = itemsStore.getAt(rIndex);
                showProfile(row.get('id'));
            }
        },
        */
        selModel:new Ext.grid.RowSelectionModel({singleSelect:false}),
        sm:new Ext.grid.CheckboxSelectionModel(),
		cm:new Ext.grid.ColumnModel([
	        new Ext.grid.CheckboxSelectionModel(),
        {
	    header:'Тип',
	    dataIndex:'usertype',
	    width:100,
	    sortable: true,
            renderer:function(val){
                if (!val)
                    return '';
                var res = typesStore.getById(val).data.text;
                return res;
            },
            editor: new Ext.form.ComboBox({
                store: typesStore,
                displayField:'text',
                valueField:'id',
                typeAhead: true,
                mode: 'local',
                forceSelection: true,
                triggerAction: 'all',
                selectOnFocus:true
            })
	},{
	    header:'ФИО',
	    dataIndex:'username',
	    width:100,
	    sortable: true,
            editor:new Ext.form.TextField({
                allowBlank:false
            })
	},{
            header:'Телефон',
            dataIndex:'phone',
            width:150,
            sortable: true,
            editor:new Ext.form.TextField({
                allowBlank:false
            })
        },{
            header:'E-mail',
            dataIndex:'email',
            width:150,
            sortable: true,
            editor:new Ext.form.TextField({
                allowBlank:false
            })
        },{
            header:'Компания',
            dataIndex:'agency_name',
            width:150,
            sortable: true,
            editor:new Ext.form.TextField({
                allowBlank:false
            })
        },{
	    header:'Дата регистрации',
	    dataIndex:'join',
	    width:75,
	    sortable: true
	
	}]),
	    
        tbar:[
        {
            tooltip:'Сохранить отредактированых',
            text:'Сохрань',
            iconCls:'approve',      
            handler:itemsApprove
        }/*, '-', {
            tooltip:'Заблокировать выбранных пользователей',
            text:'Заблокировать',
            iconCls:'disapprove',
            handler:itemsBan
        }*/, '-', {
            tooltip:'Удалить выбранных пользователей',
            text:'Удалить',
            iconCls:'delete',
            handler:itemsRemove
        }, '-', {
            tooltip:'Посмотреть полный профиль пользователя',
            text:'Профиль',
            iconCls:'ico_users',
            handler:function(){
                var m = itemsGrid.getSelectionModel().getSelections();
                if(m.length == 1) {
                    showProfile(m[0].data['id']);
                } else {
                    Ext.MessageBox.alert('Ошибка', 'Выберите только одного пользователя');
                }
            }
        }
        ],
        bbar:new Ext.PagingToolbar({
            store:itemsStore,
            pageSize:25,
            displayInfo:true,
            displayMsg:'{0} - {1} из {2}',
            emptyMsg:'Пусто...',
            width:350
        })  
        
        
	});  

    var userProfileFormReader = new Ext.data.JsonReader({},[<?php echo $form_reader ?>]);
    var userProfileForm = new Ext.FormPanel({
        method:'POST',
        region:'center',
        labelAlign: 'top',
        reader: userProfileFormReader,
        frame:true,
        bodyStyle:'padding:5px 5px 0',
        items: [
            {
                xtype:'hidden',
                name:'id'
            },{
                xtype:'hidden',
                name:'avatar'
            },{
                layout:'column',
                items:[
                    {
                        width:190,
                        layout: 'form',
                        items: [
                            {
                                fieldLabel: 'Аватар',
                                id:'avatarImage',
                                xtype:'box',
                                autoEl: 
                                    {
                                        tag: 'img', 
                                        src: '', 
                                        style: 'border: 1px solid silver'
                                    },
                                height: 181,
                                boxMaxHeight: 181,
                                width: 181,
                                boxMaxWidth: 181
                            }
                        ]
                    },{
                        columnWidth:.5,
                        layout: 'form',
                        defaults: {disabled: true},
                        defaultType: 'textfield',
                        items: [
                            {
                                fieldLabel: 'Логин',
                                name: 'username',
                                anchor:'99%'
                            },{
                                fieldLabel: 'E-mail',
                                name: 'email',
                                vtype:'email',
                                anchor:'99%'
                            },{
                                fieldLabel: 'Имя',
                                name: 'firstname',
                                anchor:'99%'
                            },{
                                fieldLabel: 'Фамилия',
                                name: 'lastname',
                                anchor:'99%'
                            }
                        ]
                    },{
                        columnWidth:.5,
                        layout: 'form',
                        defaults: {disabled: true},
                        defaultType: 'textfield',
                        items: [
                            {
                                fieldLabel: 'Пол',
                                name: 'gender',
                                anchor:'99%'
                            },{
                                fieldLabel: 'Дата рождения',
                                name: 'birthday',
                                anchor:'99%'
                            },{
                                fieldLabel: 'Страна',
                                name: 'country',
                                anchor:'99%'
                            },{
                                fieldLabel: 'Город',
                                name: 'city',
                                anchor:'99%'
                            }
                        ]
                    }
                ]
            },{
                fieldLabel: 'О себе',
                name: 'about',
                xtype: 'textarea',
                height: 100,
                anchor: '99%',
                disabled: true
            }
        ]
    });
        
    var bTabPanel = new Ext.TabPanel({
        id:'main_tab_panel',
        border:false,
        activeTab: 0,
        margins:'4 4 4 0',
        tabPosition:'bottom',
        layoutOnTabChange:true,
        monitorResize:true,
        defaults: { autoScroll:true },
        items:[
            {
                title: 'Список',
                layout:'border',
                border:false,
                id: 'userList',
                items: itemsGrid
            }, 
            {
                title: 'Профиль',
                disabled:true,
                layout:'fit',
                baseCls:'x-plain',
                id: 'userProfile',
                items:[userProfileForm],
                tbar:[
                    {
                        text:'Назад',
                        iconCls:'back',
                        handler:function() {
                            bTabPanel.getComponent(0).enable();
                            bTabPanel.setActiveTab(0);
                            bTabPanel.getComponent(1).disable();
                        }
                    }, '-', {
                        tooltip:'Отметить как промодерировано',
                        text:'Одобрить',
                        iconCls:'approve',      
                        handler:itemsApprove
                    }, '-', {
                        tooltip:'Заблокировать пользователя',
                        text:'Заблокировать',
                        iconCls:'disapprove',
                        handler:itemsBan
                    }, '-', {
                        tooltip:'Удалить пользователя',
                        text:'Удалить',
                        iconCls:'delete',
                        handler:itemsRemove
                    }
                ]
            }
        ]
    });
    
	var mainTabPanel = Ext.getCmp('dashboard_mainTabPanelID');
	mainTabPanel.items.each(function(item){mainTabPanel.remove(item);}, mainTabPanel.items);	
		
	mainTabPanel.add({
		title: 'На модерации',
		layout:'fit',
        iconCls:'ico_moderation',
		items:[bTabPanel]
	});
    		
	mainTabPanel.setActiveTab(0);	
</script>
