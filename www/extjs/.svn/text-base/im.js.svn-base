var pwin;
im = function() {
	
    var formatData = function(data){
        data.shortName = Ext.util.Format.ellipsis(data.name, 15);
        data.sizeString = Ext.util.Format.fileSize(data.size);
        return data;
    };

    var imagesStore = new Ext.data.Store({
        autoLoad:false,
        proxy: new Ext.data.HttpProxy({
            method:'post',
            url:'/admin/im/list_items'
        }),

        listeners:Ext.ux.loaderListener,

        reader: new Ext.data.JsonReader({
            id:'url',
            root:'items',
            totalProperty:'total',
            successProperty:'success'
        }, ['name', {name:'size', type: 'float'},
                    {name:'lastmod', type:'date', dateFormat:'timestamp'},
                    'url', 'width', 'height']
        ),

        baseParams:{
            node:'images',
            limit:25            
        }

    });
    
    var removeFolder = function(){
        if(tree.getSelectionModel().getSelectedNode()) {
            Ext.MessageBox.confirm('Інформація', 'Ви дійсно бажаєте видалити цю папку?' , function(btn) {
                if (btn == 'yes') {
                    Ext.Ajax.request({
                        url:'/admin/im/remove_folder',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Помилка', json.msg);
                            }
                        },
                        params:{
                            path:tree.getSelectionModel().getSelectedNode().attributes.id
                        }

                    });
                    tree.selModel.selNode.parentNode.reload();
                }
            });
        } else {
            Ext.MessageBox.alert('Помилка', 'Будь-ласка виберіть папку!');
        }
    };

    var imagesRemove = function(){
        var selNodes = view.getSelectedNodes();
        if(selNodes.length) {
            Ext.MessageBox.confirm('Інформація', 'Ви дійсно бажаєте видалити виділені зображення?' , function(btn) {
                if (btn == 'yes') {
                    var jsonData = '[{';
                    for(var i = 0, len = selNodes.length; i < len; i++) {
                        var ss = '"'+i+'":"' + selNodes[i].id + '"';
                        if(i==0) {
                            jsonData = jsonData + ss;
                        } else {
                            jsonData = jsonData + ',' + ss;
                        }
                    }
                    jsonData = jsonData + '}]';
                    Ext.Ajax.request({
                        url:'/admin/im/remove_items',
                        success:function(response) {
                            var json = Ext.util.JSON.decode(response.responseText);
                            if(!json.success) {
                                Ext.MessageBox.alert('Помилка', json.msg);
                            } else {
                                imagesStore.load();
                            }
                        },
                        params:{
                            path:tree.getSelectionModel().getSelectedNode().attributes.id,
                            'delete':jsonData
                        }
                    });
                }
            });

        } else {
            Ext.MessageBox.alert('Помилка', 'Будь-ласка оберіть зображення');
        }
    };
    
    var tb = new Ext.Toolbar({

        items:[{
            text: 'Нова папка',
            tooltip:'Створити нову папку на сервері',
            iconCls: 'add',
            handler: function(){
                if(tree.getSelectionModel().getSelectedNode()) {
                    Ext.Msg.prompt('Нова папка', 'Будь-ласка введіть ім`я папки:', function(btn, text){
                        if (btn == 'ok') {
                            Ext.Ajax.request({
                                url:'/admin/im/add_folder',
                                success:function(response) {
                                    var json = Ext.util.JSON.decode(response.responseText);
                                    if(!json.success) {
                                        Ext.MessageBox.alert('Помилка', json.msg);
                                    }
                                },
                                params:{
                                    path:tree.getSelectionModel().getSelectedNode().attributes.id,
                                    name:text
                                }
                            });
                            tree.selModel.selNode.reload();
                        }
                    });
                } else {
                    Ext.MessageBox.alert('Помилка', 'Будь-ласка оберіть батьківську папку!');
                }
            }
        }]
    });
   
    var tree = new Ext.tree.TreePanel({
        animate:false,
        loader:new Ext.tree.TreeLoader({
            dataUrl:'/admin/im/load_tree',
            listeners:Ext.ux.loaderListener
        }),
        pathSeparator:' &raquo; ',
        containerScroll:true,
        rootVisible:true,
        region:'west',
        width:180,
        minWidth:160,
        maxWidth:220,
        split:true,
        title:'Папки',
        lines:false,
        autoScroll:true,
        useArrows: true,
        tbar:tb,
        margins:'4 0 4 4'
    });

    new Ext.tree.TreeSorter(tree, {
        folderSort:true
    });

    var root = new Ext.tree.AsyncTreeNode({
        text:'images',
        draggable:false,
        expanded:true,
        id:'images'
    });
    
    //tree.getSelectionModel().select(root);
    tree.setRootNode(root);
    
    Ext.apply(Ext.ux.UploadDialog.Dialog.prototype.i18n, {
        title: 'Загрузка файлів',
        state_col_title: 'Статус',
        state_col_width: 70,
        filename_col_title: 'І’мя файла',
        filename_col_width: 230,
        note_col_title: 'Коментар',
        note_col_width: 150,
        add_btn_text: 'Додати',
        add_btn_tip: 'Додати файл в чергу.',
        remove_btn_text: 'Видалити',
        remove_btn_tip: 'Видалити файл з черги.',
        reset_btn_text: 'Очистити',
        reset_btn_tip: 'Очистити чергу загрузки.',
        upload_btn_start_text: 'Загрузити',
        upload_btn_stop_text: 'Перервати',
        upload_btn_start_tip: 'Загрузка пакету файлів на сервер',
        upload_btn_stop_tip: 'Зупинака загрузки.',
        close_btn_text: 'Закрити',
        close_btn_tip: 'Закрити вікно загрузки.',
        progress_waiting_text: 'Очікуйте...',
        progress_uploading_text: 'Загрузка: {0} з {1} файлів загружено.',
        error_msgbox_title: 'Помилка',
        permitted_extensions_join_str: ',',
        err_file_type_not_permitted: 'Загрузка файлів даного типу заборонена.<br />Оберіть файл одного з наступних типів: {1}',
        note_queued_to_upload: 'Пакет загрузки.',
        note_processing: 'Загрузка...',
        note_upload_failed: 'Сервер недоступний або внутрішня помилка на стороні сервера',
        note_upload_success: 'Ok.',
        note_upload_error: 'Помилка загрузки.',
        note_aborted: 'Перервано користувачем.'
    });

    upWinIM = new Ext.ux.UploadDialog.Dialog({
        url: '/admin/im/upload',
        reset_on_hide: false,
        allow_close_on_upload: true,
        base_params:{
            node:'images/'
        },
        upload_autostart: false,
        permitted_extensions: ['jpg', 'jpeg', 'png', 'gif']
    });

    upWinIM.on('uploadcomplete', function(){
        imagesStore.load();
    });

    var editor = new Ext.form.TextField({
        allowBlank: false,
        growMin:168,
        growMax:168,
        grow:true,
        selectOnFocus:true
    });

    editor.on('change', function(field, value, oldValue){
        Ext.Ajax.request({
            url:'/admin/im/rename_image',
            success:function(response) {
                var json = Ext.util.JSON.decode(response.responseText);
                if(!json.success) {
                    Ext.MessageBox.alert('Помилка', json.msg);
                }
            },

            params:{
                path:tree.getSelectionModel().getSelectedNode().attributes.id,
                newname:value,
                oldname:oldValue
            }
        });
    });

    var view = new Ext.DataView({
        itemSelector:'div.thumb-wrap',
        style:'overflow:auto',
        multiSelect:true,
        plugins: [
            new Ext.DataView.DragSelector(),
            new Ext.DataView.LabelEditor({dataIndex: 'name'}, editor)
        ],

        store:imagesStore,
        tpl: new Ext.XTemplate(
            '<tpl for=".">',
                '<div class="thumb-wrap" id="{name}">',
                    '<div class="thumb"><img src="/{url}" class="thumb-img"></div>',
                    '<span class="x-editable">{shortName}</span>',
                    '<span>{sizeString}- [{width}x{height}]</span>',
                '</div>',
            '</tpl>'
        ),

        prepareData: function(data){
            return formatData(data);
        }
    });
    
    view.on('dblclick', function(dataView, index, node, e) {
		 if(im.type=='editor') {
       	 
            var editor = im.currentObject;
            if (Ext.isIE) {
                var range = editor.doc.selection.createRange();
                range.select();
            }
            
            var path = tree.getSelectionModel().getSelectedNode().attributes.id || 'images';
            //editor.relayCmd('insertimage', '/' + path + '/' + node.id);
            editor.insertAtCursor('<div style="display:inline;margin:5px;padding:0;"><img src="/' + path + '/' + node.id+ '" align="left" /></div>');
		 }

        if(im.type=='field') {
            var field = im.currentObject;
            console.log(im);
            console.log(tree.getSelectionModel().getSelectedNode());
            var path = tree.getSelectionModel().getSelectedNode().attributes.id || 'images';
            field.fireEvent('change', field, path + '/' + node.id);                    
        }

        pwin.hide();
    }); 
    
    

    var images = new Ext.Panel({
        id:'images',
        title:'images',
        region:'center',
        minWidth: 260,
        margins:'4 4 4 0',
        layout:'fit',
        tbar:[{
            text: 'Загрузка',
            tooltip:'Загрузка файлів на сервер',
            iconCls:'add',
            handler:function(){
                upWinIM.show();
            }
        }, {
            text: 'Видалити',
            tooltip:'Видалити вибрані зображення',
            iconCls:'remove',
            handler:imagesRemove
        }],

        bbar:new Ext.PagingToolbar({
            store:imagesStore,
            pageSize:25,
            displayInfo:true,
            displayMsg:'Зображення: {0} - {1} з {2}',
            emptyMsg:'Пусто...'
        }),

        items: view
    });

    tree.on('click', function(node) {
        if(node) {
            upWinIM.setBaseParams('node='+node.attributes.id);
            imagesStore.baseParams.node=node.attributes.id;
            images.setTitle(node.getPath('text').replace(tree.pathSeparator, ''));
            imagesStore.load();
        }
    });
    
    var treeContextMenu = function (object, e){
        e.stopEvent();
        var ctxMenu = new Ext.menu.Menu({
            id:'copyCtx',
            items:[{
                text:'Видалити',
                iconCls:'remove',
                handler:removeFolder
            }, '-', {
                id:'expand',
                handler:expandAll,
                cls:'expand-all',
                text:'Expand All'
            }, {
                id:'collapse',
                handler:collapseAll,
                cls:'collapse-all',
                text:'Collapse All'
            }, '-',{
                text:'Обновити',
                iconCls:'refresh',
                handler:function() {
                    tree.selModel.selNode.reload();
                }
            }]

        });

        ctxMenu.showAt(e.getXY());

    };

    tree.on('contextmenu', treeContextMenu);

    function collapseAll(){
        setTimeout(function(){
            root.eachChild(function(n){
                n.collapse(false, false);
            });
        }, 10);
    }

    function expandAll(){
        setTimeout(function(){
            root.eachChild(function(n){
                n.expand(false, false);
            });
        }, 10);
    }


    return {
    	
	    CreateWindow: function () {
    	
    	    	
        //pwin = Ext.getCmp('im-win');
        
        
        
        pwin = Ext.getCmp('im-win');
        if(!pwin) {
		pwin = new Ext.Window({
								id:'im-win',
								title:'Менеджер зображень',
								width:600,
								height:500,
								minWidth:300,
								minHeight:200,
								layout:'fit',
								buttonAlign:'right',
								iconCls:'bogus',
								shim:false,
								floating:true,
								autoShow: false,
								modal:true,
								animCollapse:false,
								closeAction: 'hide', 
								constrainHeader:true,
								items:new Ext.Panel({
								            border:false,
								            layout:'border',
								            items:[tree, images]
								        })
				});
		  }
		  pwin.on('hide', function(){ im.plugin = false;  });
	      imagesStore.load();
	      pwin.show();
	      //setTimeout('editWindow.toBack()', 100);
    }
  };

}();

