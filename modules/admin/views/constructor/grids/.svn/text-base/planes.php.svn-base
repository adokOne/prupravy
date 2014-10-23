        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
	         header:"ID",
	         dataIndex:'id',
        },{
		            header:'Производитель',
		            dataIndex:'manufacturer_id',
		            width:200,
		            align:'center',
		            sortable:true,
		            editor: new Ext.form.ComboBox({
	                store:ManufacturersStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false,
	                listeners: {
						select:
						function(e,a) {
									PlaneTypesStore.removeAll();
									PlaneTypesStore.reload({params: {id:a.data.id}});
									}
			            }
	            }),            
		            renderer:function(val){
		              console.log(val)
		            	if(val == undefined)
		            	  return '';
		            	obj = ManufacturersStore.getById(val)
		                return obj.data.name;
		            }
		},{
		            header:'Тип',
		            dataIndex:'plane_type_id',
		            width:200,
		            align:'center',
		            sortable:true,
		            editor: new Ext.form.ComboBox({
	                store:PlaneTypesStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false,
	                listeners: {
						select:
						function(e,a) {
									ModGridStore.removeAll();
									ModGridStore.reload({params: {id:a.data.id}});
									}
			            }
	            }),            
		            renderer:function(val){
		            	if(val == undefined)
		            	  return '';
		            	obj = PlaneTypesStore.getById(val)
		                return obj.data.name;
		            }
		        },{
		            header:'Модификация самолета',
		            dataIndex:'plane_modification_id',
		            width:200,
		            align:'center',
		            sortable:true,
		            editor: new Ext.form.ComboBox({
	                store:ModGridStore,
	                displayField:'name',
	                valueField:'id',
	                typeAhead: true,
	                forceSelection: true,
	                triggerAction: 'all',
	                selectOnFocus:false,
	                
	            }),            
		            renderer:function(val){
		            	if(val == undefined)
		            	  return '';
		            	obj = ModGridStore.getById(val)
		            	console.log(obj)
		                return obj.data.name;
		            }
		        },{
            header: 'Колличество в реестре',
            align: 'center',
            renderer: renderSearch,
            dataIndex: 'plane_count',
            width: 150
        },        {
            header:'Активен',
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
        },{
            header: 'История',
            align: 'center',
            renderer: historyButton,
            dataIndex: 'History',
            width: 250
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
