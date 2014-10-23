        cm:new Ext.grid.ColumnModel([
            new Ext.grid.CheckboxSelectionModel(),
        {
	         header:"ID",
	         dataIndex:'id',
	         hidden:true
        },{
				    header:'Дата создания',
				    dataIndex:'date',
				    width:157,
				    maxWidth:157,
				    renderer:Ext.util.Format.dateRenderer('d.m.Y h:i:s')
           
		},{
			    header:'Добавил',
			    dataIndex:'user',
			    width:200,
			    sortable: true,
		        renderer:renderSearch,
		},{
	            header:'Добавлено к',
	            dataIndex:'item_type',
	            width:130,
	            align:'center',
	            sortable:true,          
	            renderer:function(val){
	                if (val== 'photos')
	                    return '<span style="color:green">Фотография</span>';
	                if (val== 'video')
	                    return '<span style="color:green">Видео</span>';
	                if (val== 'news')
	                    return '<span style="color:green">Новость</span>';
	            }
        },{
	            header:'Ссылка на запись',
	            dataIndex:'link',
	            width:170,
	            align:'center',
	            sortable:true,          
	            renderer:function(val,d){
	                link = '<?php echo $_SERVER['HTTP_ORIGIN'];?>'+'/'+ val
	                return '<a href="'+link+'" target = "blank" style="color:red">Запись</span>';
	            }
        },{
            header:'Активно',
            dataIndex:'active',
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
