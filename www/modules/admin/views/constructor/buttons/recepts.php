    {
        tooltip:'Добавить',
        iconCls:'add',
        disabled:false,
        id:'itemsAdd',
        handler:function(){
            itemsAdd()
        }
    }, {
        tooltip:'Удалить выделенные',
        iconCls:'remove',
        disabled:true,
        id:'itemsRemove',
        handler:itemsRemove
    }, {
        tooltip:'Сохранить изменения',
        iconCls:'save',
        disabled:true,
        id:'itemsSave',        
        handler:itemsSave
    },langSplitButton