    var categoriesTreeTBar = [{
        tooltip:'Перегрузить дерево',
        iconCls:'refresh',
        handler:function() {
            root.reload();
        }
    },'-',{
        tooltip:'Развернуть дерево',
        iconCls:'expand-all',
        handler:function () {
            root.expandChildNodes(true);
        }
    },{
        tooltip:'Свернуть дерево',
        iconCls:'collapse-all',
        handler:function () {
            root.collapseChildNodes(true);
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
