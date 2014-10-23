        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
            dataIndex:'id',
            hidden:true
        },
        {
            header:'Название',
            dataIndex:'name',
            width:200,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        },        {
            header:'Заголовок',
            dataIndex:'title',
            width:250,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        },
                {
            header:'Описание',
            dataIndex:'desc',
            width:250,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        },
                {
            header:'Ключевые слова',
            dataIndex:'keyw',
            width:250,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        }
           
        ]),

