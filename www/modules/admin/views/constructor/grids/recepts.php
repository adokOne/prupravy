        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
            header:"ID",
            dataIndex:'id',
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
        },  {
            header:'Состав',
            dataIndex:'consist',
            width:200,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        },
                {
            header:'Способ приготовления',
            dataIndex:'prepare',
            width:200,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        }
           
        ]),

