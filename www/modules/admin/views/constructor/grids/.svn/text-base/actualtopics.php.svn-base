        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
	        {
		         header:"ID",
		         dataIndex:'id',
		         width:40,
	        },{
			    header:'Категория',
			    dataIndex:'type',
			    width:200,
			    sortable: true,
	            renderer:renderSearch
			},
			//{
			//    header:'Название',
			//    dataIndex:'item_id',
			//    width:200,
			//    sortable: true,
		    //   renderer:renderSearch
			//},
			{
			    header:'Название / ID',
			    dataIndex:'item_name',
			    width:200,
			    sortable: true,
		        renderer:renderSearch
			}
			
			,{
	            header:'Активна',
	            dataIndex:'status',
	            width:80,
	            align:'center',
	            sortable:true,
	            editor: new Ext.form.ComboBox({
	                store:new Ext.data.JsonStore({
	                    id: 'id',
	                    fields: ['id', 'text'],
	                    data : [
	                        {id: '1', text:'Да'},
	                        {id: '0', text:'Нет'}
	                    ]
	                }),
	                displayField:'text',
	                valueField:'id',
	                typeAhead: true,
	                mode: 'local',
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false
	            }),            
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
