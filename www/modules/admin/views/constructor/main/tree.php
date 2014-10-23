   


    var categoriesTreeTBar = [{
        tooltip:'Перезавантажити дерево',
        iconCls:'refresh',
        handler:function() {
            root.reload();
        }
    },'-',{
        tooltip:'Додати',
        iconCls:'add',
        handler:function () {  
                var node = categoriesTree.getSelectionModel().getSelectedNode();                
                if(node) {
                    edit_category(0, node.id);
                } else {
                    edit_category(0, 0);
                } 
        }
    },{
            tooltip:'Редакугвати категорію',
            iconCls:'option',
            handler:function () {                
                var node = categoriesTree.getSelectionModel().getSelectedNode();                
                if(node) {
                    edit_category(node.id, 0);
                } else {
                    Ext.MessageBox.alert('Ошибка', 'Виберіть категорію');
                }                    
            }
        },{
        tooltip:'Видалити категорію',
        iconCls:'remove',
        handler:function () {  
                var node = categoriesTree.getSelectionModel().getSelectedNode();                
                if(node) {
                    Ext.MessageBox.confirm('УВАГА', 'Видалити категорію зі всіма публікаціями?' , function (btn){
                        if(btn == 'yes') {
                            Ext.get('loading').show();
                            Ext.Ajax.request({
                                url:'/admin/gallery/delete_category',
                                success:function(response){
                                    var json = Ext.util.JSON.decode(response.responseText);
                                    if(!json.success) {
                                        Ext.MessageBox.alert('Ошибка', json.msg);                        
                                    } else {
                                        categoriesTree.root.reload();
                                        
                                    }
                                    Ext.get('loading').hide();
                                },
                                failure:function(){
                                    Ext.get('loading').hide();
                                },
                                params:{
                                    'node_id':node.id
                                }
                            });                                
                        }
                    });                    
                } else {
                     Ext.MessageBox.alert('Ошибка', 'Выберите категорию');
                }                 
        }
    }];
    
     var categoriesTree = new Ext.tree.TreePanel({
        region:'west',
        //title:'Категории',
        width:200,
        minWidth:150,
        maxWidth:350,
        margins:'0 0 0 0',
        layout:'fit',
        border:false,        
        split:true,
        tbar:categoriesTreeTBar,
        
        autoScroll:true,
        animate:false,
        enableDD:<?php echo ($enable_DD) ? 'true' : 'false' ?>,
        loader:new Ext.tree.TreeLoader({
            dataUrl:'<?php echo $url ?>/load_tree',
            listeners:{
                'load':function(loader, node){
                    if (itemsStore.baseParams.node) {
                        categoriesTree.getSelectionModel().select(categoriesTree.getNodeById(itemsStore.baseParams.node));
                    } else {
                        categoriesTree.getSelectionModel().select(node);
                    }
                    root.expandChildNodes(true);
                }
            }
        }),
        containerScroll:true,
        rootVisible:true,
        pathSeparator:' &raquo; ',
        listeners:{        
            'load':function(node){
                node.attributes.children = null;
                if (node == this.root) {
                    this.expandAll();
                } else {
                    categoriesTree.getSelectionModel().select(this.root);
                }
            }
        }        
    });

    var root = new Ext.tree.AsyncTreeNode({
        text:'Корень',
        draggable:false,
        expanded:true,
        id:'0',
        children:<?php echo $tree ?>,
        listeners:{
            'load':function(node){
                if (node){
                    node.attributes.children = null;
                }
            }
        }        
    });

    categoriesTree.setRootNode(root);
      

    categoriesTree.on('click', function(node) {
        if(node) {
            itemsStore.baseParams.node = node.attributes.id;
            itemsGrid.setTitle(node.getPath('text').replace(categoriesTree.pathSeparator, ''));
            itemsStore.load();
        }
    });
    
    <?php if ($enable_DD):?>
    categoriesTree.on('nodedrop', function(dropEvent) {
        var node = dropEvent.tree.getRootNode();
        if (itemsStore.baseParams.node) {
            node = dropEvent.tree.getNodeById(itemsStore.baseParams.node);
        }
        dropEvent.tree.getSelectionModel().select(node);
        setTimeout(function() {
            itemsStore.load();
        }, 250);
    });

    categoriesTree.on('beforenodedrop', function(dropEvent) {
        Ext.Ajax.request({
            url: '<?php echo $url ?>/move',
            params: {
                node:dropEvent.dropNode.id,
                point:dropEvent.point,
                target:dropEvent.target.id
            },
            success:function(response) {
                var json = Ext.util.JSON.decode(response.responseText);
                if(!json.success) {
                    dropEvent.cancel = true;
                    Ext.MessageBox.alert('Ошибка', json.msg);
                }
            }
        });
    });    
    <?php endif ?>
   var readCategoryFields     = new Array('id', 'name',  'parent_id');
   var editCategoryFormReader = new Ext.data.JsonReader({},readCategoryFields);


    var item_Save = function() {
        if (editCategoryForm.form.isValid()) {
            editCategoryForm.form.items.each(function(f){
                f.getValue();
            });
            editCategoryForm.form.submit({
                url:'<?php echo $url ?>/save_category',
                waitMsg: 'Ожидайте...',
                failure:function(form, action) {
                    console.log(action);
                    Ext.MessageBox.alert('Ошибка', action.result.msg);
                },
                success:function(form, action) {
                    if(action.response.responseText.length > 0){
                        var json = Ext.util.JSON.decode(action.response.responseText);
                        if(json.success){
                            mainTabPanel.getComponent(0).enable();
                            mainTabPanel.setActiveTab(0);
                            mainTabPanel.getComponent(1).disable();                        
        
                            categoriesTree.root.reload();
                            return;
                        } else {
                            Ext.MessageBox.alert('Ошибка', json.msg);                                            
                            return;
                        }
                    }
                    Ext.MessageBox.alert('Ошибка', 'Ошибка сохранения');
                }
            });
        } else {
            Ext.MessageBox.alert('Ошибка', 'Введите необходимый минимум данных');
        }
    };


    var editCategoryForm = new Ext.FormPanel({
        baseCls:'x-plain',
        method:'POST',
        region:'center',
        border:true,
        labelAlign: 'left',
        autoHeight:true,
        style:'padding:7px',
        labelWidth:100,
                tbar:[{
                    text:'Зберігти',
                    iconCls:'save',
                    handler:function() {
                        item_Save();
                    }
                }, {
                    text:'Відмінити',
                    iconCls:'cancel',
                    handler:function() {                        
                        mainTabPanel.getComponent(0).enable();
                        mainTabPanel.setActiveTab(0);
                        mainTabPanel.getComponent(1).remove();                        
                    }
                }],
        reader: editCategoryFormReader,
        fileUpload: true,
        items:[
            {
                xtype:'hidden',
                name:'id'
            },{
                xtype:'hidden',
                name:'parent_id'
            },new Ext.form.TextField({
                fieldLabel:'Назва',
                anchor:'100%',
                allowBlank:false,
                name:'name'
            })

        ]
    });     
    










    var editCategoryPanel = {
        border:false,
        region:'center',
        layout:'border',
        items:[
            {
                region:'center',
                layout:'border',
                border:false,
                height:50,
                items:editCategoryForm
            }
        ]
    };    
    
    
    var submitCategoryForm = function(){        
        if(editCategoryForm.form.isValid()){
            editCategoryForm.form.items.each(function(f){
                f.getValue();
            });
            editCategoryForm.form.submit({
                params: getSendVariables(readCategoryFields, editCategoryForm),
                waitMsg:'Ожидайте...',
                url:'/admin/gallery/save_category',
                failure:function(form, action) {
                    Ext.MessageBox.alert('Ошибка обработки', action.response.statusText);
                }, 
                success:function(form, action) {
                    if(action.response.responseText.length > 0){
                        var json = Ext.util.JSON.decode(action.response.responseText);
                        if(json.success){
                            mainTabPanel.getComponent(0).enable();
                            mainTabPanel.setActiveTab(0);
                            mainTabPanel.getComponent(1).disable();                        
        
                            categoriesTree.root.reload();
                            return;
                        } else {
                            Ext.MessageBox.alert('Ошибка', json.msg);                                            
                            return;
                        }
                    }
                    Ext.MessageBox.alert('Ошибка', 'Ошибка сохранения');
                }
            });
        } else {
            Ext.MessageBox.alert('Ошибка', 'Заполните обязательные поля');
        }
    };
    var edit_category = function (v_id, v_parent_id) {
    mainTabPanel.add({
    title: 'Категорія',
    layout:'fit',
    iconCls:'ico_moderation',
    items:[editCategoryPanel]
});
        mainTabPanel.getComponent(1).enable();
        mainTabPanel.setActiveTab(1);
        mainTabPanel.getComponent(0).disable();

        if(v_id > 0){            
            editCategoryForm.form.load({
                url:'/admin/gallery/edit_category',
                params:{
                    id:v_id
                },
                waitMsg:'Ожидайте...',
                success:function(response) {
                   // loadAfterLoad(readCategoryFields, editCategoryFormReader, false);
                    Ext.get('logo').set({src:'/<?php echo $logo_path ?>'+editCategoryForm.form.findField('id').getValue()+'<?php echo $logo_prefix.$logo_ext ?>?'+Math.random()});
                   
                }
            });
        } else {
               editCategoryForm.form.reset();
               editCategoryForm.form.findField('parent_id').setValue(v_parent_id);

        }
    };    


