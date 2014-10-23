        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
	        {
		         header:"ID",
		         dataIndex:'id',
	        },{
			    header:'Страна',
			    dataIndex:'county_name',
			    width:200,
			    sortable: true,
	            renderer:renderSearch
			},{
			    header:'Город',
			    dataIndex:'city_name',
			    width:200,
			    sortable: true,
		        renderer:renderSearch
			},{
			    header:'Название',
			    dataIndex:'name_0',
			    width:200,
			    sortable: true,
		        renderer:renderSearch
			},{
			    header:'IATA',
			    dataIndex:'IATA',
			    width:100,
			    sortable: true,
		        renderer:renderSearch,
			},{
			    header:'ICAO',
			    dataIndex:'ICAO',
			    width:100,
			    sortable: true,
		        renderer:renderSearch,
			},{
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
