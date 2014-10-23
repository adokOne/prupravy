<script type="text/javascript">
    
module_images = function() {   
    var removeFolder = function(){
        if(categoriesTree.getSelectionModel().getSelectedNode()) {
            Ext.MessageBox.confirm('Інформація', 'Вы действительно хотите удалить эту папку?' , function(btn) {
                if (btn == 'yes') {
                    Ext.Ajax.request({
                        url:'/admin/images/remove_folder',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Ошибка', json.msg);
                            }
                            root.reload();
                        },
                        params:{
                            path:categoriesTree.getSelectionModel().getSelectedNode().attributes.id
                        }
                    });
                }
            });
        } else {
            Ext.MessageBox.alert('Ошибка', 'Выберите удаляемую папку!');
        }
    };
    
    var createFolder = function(){
        if(categoriesTree.getSelectionModel().getSelectedNode()) {
            Ext.Msg.prompt('Новая папка', 'Укажите имя новой папки:', function(btn, text){
                if (btn == 'ok') {
                    Ext.Ajax.request({
                        url:'/admin/images/add_folder',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Ошибка', json.msg);
                            }
                            root.reload();
                        },
                        params:{
                            path:categoriesTree.getSelectionModel().getSelectedNode().attributes.id,
                            name:text
                        }
                    });
                }
            });
        } else {
            Ext.MessageBox.alert('Ошибка', 'Укажите родительскую категорию!');
        }
    }

    var changeView = function(item, checked) {
        var tpl;        
        if (checked) {
            if (item.id == 'short-view')
                tpl = tileIcons;
            else
                tpl = null;
        }
        galleryGrid.getView().changeTemplate(tpl);
    }
    
    var galleryView = function(){
        var photo = galleryGrid.getSelectionModel().getSelected();
        var key = galleryStore.indexOf(photo);
        
            var imgPreviewWin = new Ext.Window({
                modal:true,
                maximizable:true,
                title:photo.get('name'),
                width:700,
                height:490,
                autoHeight:false,
                autoScroll:true,
                html:'',
                tbar: new Ext.Toolbar({
                    items: [{
                        text:'Предыдущая',
                        handler:function(){
                            if (key > 0) {
                                key--;
                            } else {
                                key = galleryStore.getTotalCount() - 1;
                            }
                            imgPreviewWin.fireEvent('show');
                        }
                    },'-',{
                        text:'Следущая',
                        handler:function(){
                            if (key < (galleryStore.getTotalCount() - 1)) {
                                key++;
                            } else {
                                key = 0;
                            }
                            imgPreviewWin.fireEvent('show');
                        }
                    }]
                }), 
                listeners:{
                    show:function(){
                        var data = galleryStore.getAt(key).data;
                        var top = (this.body.getHeight() - data.height)/2;
                        var left = (this.body.getWidth() - data.width)/2;
                        top = (top > 0) ? top : 0;
                        left = (left > 0) ? left : 0;

                        this.setTitle(data.name + '.' + data.ext);

                        this.body.dom.innerHTML = '<img src="/'+data.id+'" alt="" />';
                        this.body.first().setStyle({
                            'margin-top':top+'px',
                            'margin-left':left+'px'
                        });
                    },
                    resize:function(){
                        this.fireEvent('show');
                    }
                }
            });
            imgPreviewWin.show();
    }
    
    var gallerySave = function () {
        var m = galleryStore.getModifiedRecords();
        if(m.length > 0) {
            var jsonData = new Array();
            for(i=0;i<m.length;i++) {
                jsonData[i] = m[i].data;
            }
            var params = {
                'save':Ext.util.JSON.encode(jsonData)
            }
            Ext.apply(galleryStore.baseParams, params);
            var page = 0;
            if (galleryStore.lastOptions && galleryStore.lastOptions.params)
                page = (galleryStore.lastOptions.params.start / galleryGridBBar.pageSize) + 1;
            galleryGridBBar.changePage(page);
            delete galleryStore.baseParams.save;
            galleryGrid.getTopToolbar().items.get('gallerySave').disable();
        } else {
            Ext.MessageBox.alert('Информация', 'Данные не модифицированы');
        }
    };

    
    var galleryRemove = function () {
        var m = galleryGrid.getSelectionModel().getSelections();
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
                        galleryStore.remove(m[i]);
                    }
                    jsonData = jsonData + '}]';
                    var params = {
                        'remove':jsonData
                    }
                    Ext.apply(galleryStore.baseParams, params);
                    var page = 0;
                    if (galleryStore.lastOptions && galleryStore.lastOptions.params)
                        page = (galleryStore.lastOptions.params.start / galleryGridBBar.pageSize) + 1;
                    galleryGridBBar.changePage(page);
                    delete galleryStore.baseParams.remove;
                }
            });
        }
    };
    
    
    // ToolBars
    var galleryGridTBar = [{
            text: 'Добавить',
            tooltip:'Загрузить фото на сервер',
            iconCls:'add',
            id:'galleryAdd',            
            handler:function(){
                uploadWinGallery.show();
            }
        }, {
            text: 'Удалить',
            tooltip:'Удалить виделенные фото',
            iconCls:'remove',
            disabled:true,
            id:'galleryRemove',
            handler:galleryRemove
        }, {
            text:'Сохранить',
            tooltip:'Сохранить изменения',           
            iconCls:'save',
            disabled:true,
            id:'gallerySave',
            handler:gallerySave
        }, '-', {
            text:'Просмотреть',
            tooltip:'Просмотреть в полный размер',
            iconCls:'zoom',
            disabled:true,
            id:'galleryView',
            handler:galleryView
        }, '->', {
            text: 'Вид',
            iconCls:'bogus',
            menu: [{
                    id: 'detail-view',
                    group: 'view',
                    checkHandler: changeView,
                    checked: false,
                    text: 'Детальный'
                }, '-', {
                    id: 'short-view',
                    group: 'view',
                    checkHandler: changeView,
                    checked: true,
                    text: 'Короткий'
                }]
    }];
    
    
    var categoriesTreeTBar = [
        {
            tooltip:'Обновить список',
            iconCls:'refresh',
            handler:function() {
                root.reload();
            }
        },{
            tooltip:'Создать папку',
            iconCls:'add',
            //disabled:true,
            id:'galleryAdd',            
            handler:createFolder
        }, {
            tooltip:'Удалить папку',
            iconCls:'remove',
            //disabled:true,
            id:'galleryRemove',
            handler:removeFolder
        }
    ];

    var categoriesTree = new Ext.tree.TreePanel({
        animate:false,
        enableDD:false,
        useArrows:true,
        loader:new Ext.tree.TreeLoader({
            dataUrl:'/admin/images/load_tree',
            listeners:{
                'load':function(loader, node){
                    if (galleryStore.baseParams.node) {
                        categoriesTree.getSelectionModel().select(categoriesTree.getNodeById(galleryStore.baseParams.node));
                        categoriesTree.fireEvent('click', galleryStore.baseParams.node);
                    } else {
                        categoriesTree.getSelectionModel().select(node);
                        categoriesTree.fireEvent('click', node);
                    }
                }
            }
        }),
        containerScroll:true,
        rootVisible:true,
        pathSeparator:' &raquo; ',
        region:'west',
        width:200,
        minWidth:150,
        maxWidth:350,
        split:true,
        title:'Папки',
        autoScroll:true,
        tbar:categoriesTreeTBar,
        margins:'4 0 4 4',
        listeners:{
            'load':function(node){
                if (node == this.root) {
                    this.expandAll();
                } else {
                    categoriesTree.getSelectionModel().select(this.root);
                }
            }
        }        
    });

    var root = new Ext.tree.AsyncTreeNode({
        text:'images',
        draggable:false,
        expanded:true,
        id:'images',
        children:<?php echo $tree_category ?>,
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
            galleryStore.baseParams.node = node.attributes.id;
            galleryGrid.setTitle(node.getPath('text').replace(categoriesTree.pathSeparator, ''));
            galleryStore.load();
            //galleryGrid.getTopToolbar().items.get('itemsAdd').enable();
        }
    });
   
    uploadWinGallery = new Ext.ux.UploadDialog.Dialog({
        url:'/admin/images/upload_photos',
        reset_on_hide: false,
        allow_close_on_upload: true,
        upload_autostart: false,
        permitted_extensions: ['jpg', 'jpeg', 'png', 'gif']
    });

    uploadWinGallery.on('uploadcomplete', function(){
        galleryStore.load();
    });    
    
    var tileIcons = new Ext.Template(
        '<div class="x-grid3-row ux-explorerview-item ux-explorerview-thumb-item">'+
        '<div class="thumb-wrap" id="{id}">'+
        '<div class="thumb"><img src="/{id}" class="thumb-img"></div>'+
        '<span>{name}.{ext}</span>'+
        '</div>'+
        '</div>'
    );

    var photoRecord = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'name', type: 'string'},
        {name: 'ext', type: 'string'},
        {name: 'size', type: 'int'},
        {name: 'id', type: 'string'},
        {name: 'width', type: 'int'},
        {name: 'height', type: 'int'}
    ]);
        
    var galleryStore = new Ext.data.Store({
        autoLoad:false,
        proxy: new Ext.data.HttpProxy({
            method:'post',
            url:'/admin/images/list_photos'
        }),
        reader:new Ext.data.JsonReader({
            id:'id',
            root:'items',
            totalProperty:'total',
            successProperty:'success'
        }, photoRecord),
        remoteSort:false,
        listeners:{
            'update': function(){
                if (this.getModifiedRecords().length > 0){
                    galleryGrid.getTopToolbar().items.get('gallerySave').enable();
                } else {
                    galleryGrid.getTopToolbar().items.get('gallerySave').disable();
                }
            }
        }
    });

    var galleryGridBBar = new Ext.PagingToolbar({
        store:galleryStore,
        pageSize:10,
        displayInfo:true,
        displayMsg:'{0} - {1} из {2}',
        emptyMsg:'Пусто...'
    });

    var galleryGrid = new Ext.grid.EditorGridPanel({
        id:'images',
        region:'center',
        height:250,
        margins:'0 0 0 0',
        layout:'fit',
        split:true,
        ds:galleryStore,
        enableHdMenu:false,
        sm:new Ext.grid.CheckboxSelectionModel(),
        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
            id:'name',
            header:'Имя',
            width:100,
            sortable:true,
            dataIndex:'name',
            editor:new Ext.form.TextField({
                allowBlank:false
            })
        },{
            id:'ext',
            header:'ext',
            align:'center',
            width:60,
            sortable:true,
            dataIndex:'ext'
        },{
            header:'Ширина',
            align:'center',
            width:100,
            sortable:true,
            dataIndex:'width'
        },{
            header:'Высота',
            align:'center',
            width:100,
            sortable:true,
            dataIndex:'height'
        },{
            id:'size',
            header:'Размер',
            align:'center',
            width:100,
            sortable:true,
            dataIndex:'size'
        }
        ]),
        viewConfig: {
            rowTemplate:tileIcons
        },
        autoExpandColumn:'name',
        tbar:galleryGridTBar,
        bbar:galleryGridBBar
    });

    galleryGrid.getSelectionModel().on('selectionchange', function(sm) {
        if(sm.getCount() > 0) {
            galleryGrid.getTopToolbar().items.get('galleryRemove').enable();
            galleryGrid.getTopToolbar().items.get('galleryView').enable();
        } else {
            galleryGrid.getTopToolbar().items.get('galleryRemove').disable();
            galleryGrid.getTopToolbar().items.get('galleryView').disable();
        }    
    });
    
    galleryStore.loadData(<?php echo $list_photos ?>);
  
    return {
        init: function() {
            return new Ext.Panel({
                layout:'border',
                border:false,
                items:[categoriesTree, galleryGrid]
            });
        }
    };
}();

var mainTabPanel = Ext.getCmp('dashboard_mainTabPanelID');
mainTabPanel.items.each(function(item){mainTabPanel.remove(item);}, mainTabPanel.items);

mainTabPanel.add({
    title: 'Фотографии',
    layout:'fit',
    iconCls:'ico_moderation',
    items:[module_images.init()]
});

mainTabPanel.setActiveTab(0);

</script>