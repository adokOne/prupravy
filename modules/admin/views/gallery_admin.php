<script type="text/javascript">
module_gallery = function() {   
    
    var mapPanel = new Ext.Panel({
        region:'east',
        width:500,
        minWidth:150,
        maxWidth:650,
        margins:'0 0 0 0',
        layout:'fit',
        border:false,
        split:true,
        html:'<div id="nadoloni"></div>',
        listeners:{
            'render': function(){
                setTimeout(function() {
                    swfobject.embedSWF("/swf/MM_Construct.swf?"+Math.random(), "nadoloni", "100%", "100%", "9.0.0", "/swf/expressInstall.swf",
                    {bgcolor:"#FFFFFF"});
                }, 1000);
            }
        }
    });    


    var itemRecord = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'district', type: 'string'},
        {name: 'city', type: 'string'},
        {name: 'street', type: 'street'},
        {name: 'building', type: 'string'},
        {name: 'latitude', type: 'float'},
        {name: 'longitude', type: 'float'}
    ]);
   
    var itemsStore = new Ext.data.Store({
        autoLoad:false,
        proxy:new Ext.data.HttpProxy({
            url:'/admin/gallery/list_items'
        }),
        reader:new Ext.data.JsonReader({
            root:'items',
            totalProperty:'total',
            id:'id'
        }, itemRecord),
        remoteSort:true
    });

    var photoRecord = Ext.data.Record.create([<?php echo $sub_grid_record ?>]);

    var galleryStore = new Ext.data.Store({
        autoLoad:false,
        proxy: new Ext.data.HttpProxy({
            method:'post',
            url:'/admin/gallery/sub_list_items'
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

    function renderSearch(val){
        var res = val+'';
        if (itemsStore.baseParams['search']) {
            var searches = itemsStore.baseParams['search'].split(' ');
            eval('mask = new RegExp(/('+searches.join('|')+')/ig);');
            res = res.replace(new RegExp(mask), '<span style="background-color:yellow;color:red;">$1</span>');
        }
        return res;
    }    

    var itemsGridBBar = new Ext.PagingToolbar({
        store:itemsStore,
        pageSize:25,
        displayInfo:true,
        displayMsg:'{0} - {1} из {2}',
        emptyMsg:'Пусто...'
    });
        
    var itemsGrid = new Ext.grid.GridPanel({
        region:'center',
        margins:'0 0 0 0',
        layout:'fit',
        border:false,
        ds:itemsStore,
        clicksToEdit:2,
        viewConfig: {
            forceFit: true
        },
        split: true,
        enableHdMenu:false,
        selModel:new Ext.grid.RowSelectionModel({singleSelect:false}),
        sm:new Ext.grid.CheckboxSelectionModel(),
        

        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
                {
            header:'Город',
            dataIndex:'city',
            width:80,
            sortable:true,
            renderer:renderSearch
        }, {
            header:'Район',
            dataIndex:'district',
            width:80,
            sortable:true,
            renderer:renderSearch
        }, {
            header:'Улица',
            dataIndex:'street',
            width:120,
            sortable:true,
            renderer:renderSearch
        }, {
            header:'Дом',
            dataIndex:'building',
            width:60,
            sortable:true,
            align:'center',
            renderer:renderSearch
        }]),
        plugins:[new Ext.ux.grid.Search({
                position:'bottom',
                width: 180,
                autoFocus:true,
                listeners:{
                    'search':function(){
                        itemsStore.reload();
                    }                
                }
        })],
        bbar:itemsGridBBar
    });

    
    itemsGrid.getSelectionModel().on('selectionchange', function(sm) {
        if(sm.getCount() > 0) {
            if(sm.getCount() == 1) {
                galleryGrid.getTopToolbar().items.get('galleryAdd').enable();

                var row = sm.getSelections();
                var lat = row[0].get('latitude');
                var lon = row[0].get('longitude');
                var title = row[0].get('street') + ' ' + row[0].get('building');
                var category = 36;
                
                var id = sm.getSelected().get('id');
                uploadWinGallery.base_params.node = id;
                galleryStore.baseParams.node = id;
                galleryStore.load();
                if ((lat != 0)&&(lon != 0)) {
                    var nadoloni = document.getElementById('nadoloni');
                    if (nadoloni.getAttribute('type') == 'application/x-shockwave-flash') {
                        nadoloni.clearAll();
                        nadoloni.putMarker(lat, lon, category, title);
                        nadoloni.moveTo(lat, lon);
                    }
                }
            } else {
                galleryGrid.getTopToolbar().items.get('galleryAdd').disable();
                galleryStore.removeAll();
            }
        } else {
            galleryGrid.getTopToolbar().items.get('galleryAdd').disable();
            galleryStore.removeAll();
        }
    });

    itemsStore.loadData(<?php echo $list_items ?>);
    
    
    // Images
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
                width:425,
                height:325,
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

                        this.setTitle(data.title_ru);

                        this.body.dom.innerHTML = '<img src="/<?php echo $folder."/'+data.ad_id+'/".$prefix ?>_'+data.id+'.jpg" alt="" />';
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
            disabled:true,
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

    uploadWinGallery = new Ext.ux.UploadDialog.Dialog({
        url:'/admin/gallery/upload_photos',
        //url:'/upload',
        base_params: {
            type: 'gallery',
            node: galleryStore.baseParams.node
        },
        reset_on_hide:true,
        allow_close_on_upload:true,
        upload_autostart:false,
        permitted_extensions: ['jpg', 'jpeg', 'png', 'gif']
    });

    uploadWinGallery.on('uploadcomplete', function(){
        galleryStore.load();
    });    
    
    var tileIcons = new Ext.Template(
        '<div class="x-grid3-row ux-explorerview-item ux-explorerview-thumb-item">'+
        '<div class="thumb-wrap" id="{id}">'+
        '<div class="thumb"><img src="/<?php echo $folder.'/{ad_id}/'.$prefix ?>_{id}.jpg" class="thumb-img"></div>'+
        '<span>{title_ru}</span>'+
        '</div>'+
        '</div>'
    );

    var galleryGridBBar = new Ext.PagingToolbar({
        store:galleryStore,
        pageSize:10,
        displayInfo:true,
        displayMsg:'{0} - {1} из {2}',
        emptyMsg:'Пусто...'
    });

    var galleryGrid = new Ext.grid.EditorGridPanel({
        id:'images',
        region:'south',
        height:250,
        margins:'0 0 0 0',
        layout:'fit',
        split:true,
        ds:galleryStore,
        enableHdMenu:false,
        autoExpandColumn:'name',
        sm:new Ext.grid.CheckboxSelectionModel(),
        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
            id:'name',
            header:'Название',
            width:250,
            sortable:true,
            dataIndex:'name',
            editor:new Ext.form.TextField({
                allowBlank:false
            })
        }
        ]),
        viewConfig: {
            rowTemplate:tileIcons
        },
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
   
    <?php //include "$dir/main/tree.php" ?>
    
    return {
        init: function() {
            return new Ext.Panel({
                border:false,
                layout:'border',
                items:[/*categoriesTree,*/ new Ext.Panel({
                    region:"center",
                    margins:'0 0 0 0',
                    layout:'border',
                    border:false,
                    items:[itemsGrid, mapPanel, galleryGrid]
                    })
                ]
            });
                    
            return new Ext.Panel({
                region:"center",
                margins:'0 0 0 0',
                layout:'border',
                border:false,
                items:[itemsGrid,galleryGrid]
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
    items:[module_gallery.init()]
});

mainTabPanel.setActiveTab(0);

</script>