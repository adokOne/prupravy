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
		},        {
            header:'Штрих КОД',
            dataIndex:'code',
            width:200,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        },
                {
            header:'Вес',
            dataIndex:'weight',
            width:200,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        },
                {
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
            header:'Описание',
            dataIndex:'descr',
            width:200,
            sortable: true,
            renderer:renderSearch,
            editor:new Ext.form.TextField({
                allowBlank: false
            })
        }
           
        ]),

