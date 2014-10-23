        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
	         header:"ID",
	         dataIndex:'id',
        },{
		    header:'Название',
		    dataIndex:'page_name',
		    width:200,
		    sortable: true,
	        renderer:renderSearch,
		},{
            header:'Активна',
            dataIndex:'status',
            width:80,
            align:'center',
            sortable:true,
           
            renderer:function(val){
                if (val*1 == 0)
                    return '<span style="color:red">Нет</span>';
                else
                    return '<span style="color:green">Да</span>';
            }
        }]),
        plugins:[new Ext.ux.grid.Search({
                position:'top',
                width: 180,
                autoFocus:true,
                listeners:{
                    'search':function(){
                        itemsStore.reload();
                    }                
                }
        })],
