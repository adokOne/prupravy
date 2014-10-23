var pwin;
im = function() {   
    var removeFolder = function(){
        if(foldersTree.getSelectionModel().getSelectedNode()) {
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
                            path:foldersTree.getSelectionModel().getSelectedNode().attributes.id
                        }
                    });
                }
            });
        } else {
            Ext.MessageBox.alert('Ошибка', 'Выберите удаляемую папку!');
        }
    };
    
    var createFolder = function(){
        if(foldersTree.getSelectionModel().getSelectedNode()) {
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
                            path:foldersTree.getSelectionModel().getSelectedNode().attributes.id,
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
        imagesGrid.getView().changeTemplate(tpl);
    }
    
    var imagesView = function(){
        var photo = imagesGrid.getSelectionModel().getSelected();
        var key = imagesStore.indexOf(photo);
        
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
                                key = imagesStore.getTotalCount() - 1;
                            }
                            imgPreviewWin.fireEvent('show');
                        }
                    },'-',{
                        text:'Следущая',
                        handler:function(){
                            if (key < (imagesStore.getTotalCount() - 1)) {
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
                        var data = imagesStore.getAt(key).data;
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
    
    var imagesSave = function () {
        var m = imagesStore.getModifiedRecords();
        if(m.length > 0) {
            var jsonData = new Array();
            for(i=0;i<m.length;i++) {
                jsonData[i] = m[i].data;
            }
            var params = {
                'save':Ext.util.JSON.encode(jsonData)
            }
            Ext.apply(imagesStore.baseParams, params);
            var page = 0;
            if (imagesStore.lastOptions && imagesStore.lastOptions.params)
                page = (imagesStore.lastOptions.params.start / imagesGridBBar.pageSize) + 1;
            imagesGridBBar.changePage(page);
            delete imagesStore.baseParams.save;
            imagesGrid.getTopToolbar().items.get('imagesSave').disable();
        } else {
            Ext.MessageBox.alert('Информация', 'Данные не модифицированы');
        }
    };

    
    var imagesRemove = function () {
        var m = imagesGrid.getSelectionModel().getSelections();
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
                        imagesStore.remove(m[i]);
                    }
                    jsonData = jsonData + '}]';
                    var params = {
                        'remove':jsonData
                    }
                    Ext.apply(imagesStore.baseParams, params);
                    var page = 0;
                    if (imagesStore.lastOptions && imagesStore.lastOptions.params)
                        page = (imagesStore.lastOptions.params.start / imagesGridBBar.pageSize) + 1;
                    imagesGridBBar.changePage(page);
                    delete imagesStore.baseParams.remove;
                }
            });
        }
    };
    
    
    // ToolBars
    var imagesGridTBar = [{
            text: 'Добавить',
            tooltip:'Загрузить фото на сервер',
            iconCls:'add',
            id:'imagesAdd',            
            handler:function(){
                uploadWinImages.show();
            }
        }, {
            text: 'Удалить',
            tooltip:'Удалить виделенные фото',
            iconCls:'remove',
            disabled:true,
            id:'imagesRemove',
            handler:imagesRemove
        }, {
            text:'Сохранить',
            tooltip:'Сохранить изменения',           
            iconCls:'save',
            disabled:true,
            id:'imagesSave',
            handler:imagesSave
        }, '-', {
            text:'Просмотреть',
            tooltip:'Просмотреть в полный размер',
            iconCls:'zoom',
            disabled:true,
            id:'imagesView',
            handler:imagesView
        }, '->', {
            text: 'Вид',
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
    
    
    var foldersTreeTBar = [
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
            id:'imagesAdd',            
            handler:createFolder
        }, {
            tooltip:'Удалить папку',
            iconCls:'remove',
            //disabled:true,
            id:'imagesRemove',
            handler:removeFolder
        }
    ];

    var foldersTree = new Ext.tree.TreePanel({
        animate:false,
        enableDD:false,
        useArrows:true,
        loader:new Ext.tree.TreeLoader({
            dataUrl:'/admin/images/load_tree',
            listeners:{
                'load':function(loader, node){
                    if (imagesStore.baseParams.node) {
                        foldersTree.getSelectionModel().select(foldersTree.getNodeById(imagesStore.baseParams.node));
                        foldersTree.fireEvent('click', imagesStore.baseParams.node);
                    } else {
                        foldersTree.getSelectionModel().select(node);
                        foldersTree.fireEvent('click', node);
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
        tbar:foldersTreeTBar,
        margins:'4 0 4 4',
        listeners:{
            'load':function(node){
                if (node == this.root) {
                    this.expandAll();
                } else {
                    foldersTree.getSelectionModel().select(this.root);
                }
            }
        }        
    });

    var root = new Ext.tree.AsyncTreeNode({
        text:'images',
        draggable:false,
        expanded:true,
        id:'images'        
    });

    foldersTree.setRootNode(root);
   

    Ext.apply(Ext.ux.UploadDialog.Dialog.prototype.i18n, {
        title: 'Загрузка файлов',
        state_col_title: 'Статус',
        state_col_width: 70,
        filename_col_title: 'Имя файла',
        filename_col_width: 230,
        note_col_title: 'Комментарий',
        note_col_width: 150,
        add_btn_text: 'Добавтть',
        add_btn_tip: 'Добавить файл в очередь.',
        remove_btn_text: 'Удалить',
        remove_btn_tip: 'Удалить файл из очереди.',
        reset_btn_text: 'Очистить',
        reset_btn_tip: 'Очистить очередь загрузки.',
        upload_btn_start_text: 'Загрузить',
        upload_btn_stop_text: 'Прервать',
        upload_btn_start_tip: 'Загрузка файлов на сервер',
        upload_btn_stop_tip: 'Остановка загрузки.',
        close_btn_text: 'Закрыть',
        close_btn_tip: 'Закрыть окно загрузки.',
        progress_waiting_text: 'Ожидайте...',
        progress_uploading_text: 'Загрузка: {0} из {1} файлов загружено.',
        error_msgbox_title: 'Ошибка',
        permitted_extensions_join_str: ',',
        err_file_type_not_permitted: 'Загрузка файлов данного типа запрещена.<br />Доступны следующие типы: {1}',
        note_queued_to_upload: 'Пакет загрузки.',
        note_processing: 'Загрузка...',
        note_upload_failed: 'Сервер недоступен либо внутренняя ошибка на стороне сервера',
        note_upload_success: 'Ok.',
        note_upload_error: 'Ошибка загрузки.',
        note_aborted: 'Прервано пользователем.'
    });

    uploadWinImages = new Ext.ux.UploadDialog.Dialog({
        url:'/admin/images/upload_photos',
        reset_on_hide: false,
        allow_close_on_upload: true,
        upload_autostart: false,
        permitted_extensions: ['jpg', 'jpeg', 'png', 'gif']
    });

    foldersTree.on('click', function(node) {
        if(node) {
            imagesStore.baseParams.node = node.attributes.id;
            imagesGrid.setTitle(node.getPath('text').replace(foldersTree.pathSeparator, ''));
            imagesStore.load();
            //imagesGrid.getTopToolbar().items.get('itemsAdd').enable();
            uploadWinImages.setBaseParams('node='+node.attributes.id);
            foldersTree.getSelectionModel().select(node);
        }
    });

    uploadWinImages.on('uploadcomplete', function(){
        imagesStore.load();
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
        
    var imagesStore = new Ext.data.Store({
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
                    imagesGrid.getTopToolbar().items.get('imagesSave').enable();
                } else {
                    imagesGrid.getTopToolbar().items.get('imagesSave').disable();
                }
            }
        }
    });

    var imagesGridBBar = new Ext.PagingToolbar({
        store:imagesStore,
        pageSize:10,
        displayInfo:true,
        displayMsg:'{0} - {1} из {2}',
        emptyMsg:'Пусто...'
    });

    var imagesGrid = new Ext.grid.EditorGridPanel({
        id:'images',
        title:'images',
        region:'center',
        height:250,
        margins:'4 4 4 0',
        layout:'fit',
        split:true,
        ds:imagesStore,
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
        tbar:imagesGridTBar,
        bbar:imagesGridBBar
    });

    imagesGrid.getSelectionModel().on('selectionchange', function(sm) {
        if(sm.getCount() > 0) {
            imagesGrid.getTopToolbar().items.get('imagesRemove').enable();
            imagesGrid.getTopToolbar().items.get('imagesView').enable();
        } else {
            imagesGrid.getTopToolbar().items.get('imagesRemove').disable();
            imagesGrid.getTopToolbar().items.get('imagesView').disable();
        }    
    });
    
    imagesGrid.on('dblclick', function() {
        var m = imagesGrid.getSelectionModel().getSelections();
        if(m.length > 0) {
            var id = m[0].get('id');
            if(im.type=='editor') {    
                var editor = im.currentObject;
                if (Ext.isIE) {
                    var range = editor.doc.selection.createRange();
                    range.select();
                }
                editor.insertAtCursor('<div style="display:inline;margin:5px;padding:0;"><img src="/' + id+ '" align="left" /></div>');
            }

            else if(im.type=='image') {
                Ext.get(im.image).set({
                    src: '/' + id + '?' + Math.random()
                });
                im.croper.loadImage('/' + id);
                Ext.getCmp('editform').form.findField(im.image).setValue('/' + id);
            }

            pwin.hide();
        }    

    });   
    
    return {
        createWindow: function () {     
       
            pwin = Ext.getCmp('im-win');
            if(!pwin) {
                pwin = new Ext.Window({
                    id:'im-win',
                    title:'Менеджер изображений',
                    width:800,
                    height:400,
                    minWidth:300,
                    minHeight:200,
                    layout:'fit',
                    buttonAlign:'right',
                    shim:true,
                    modal:true,
                    maximizable:true,
                    closeAction: 'hide', 
                    items:new Ext.Panel({
                        layout:'border',
                        border:false,
                        items:[foldersTree, imagesGrid]
                    })
                });
            }
            pwin.on('hide', function(){
                im.plugin = false;
            });

            pwin.show();
            Ext.WindowMgr.bringToFront(pwin);
        }
    }

}();

