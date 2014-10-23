	{
        tooltip:'Добавить',
        text:'Добавить',
        iconCls:'add',
        disabled:false,
        id:'itemsAdd',
        handler:function(){
			    	edit_bloger(0);
			    	Ext.ux.TinyMCE.initTinyMCE();
        }
    }, {
        tooltip:'Удалить выделенные',
        text:'Удалить выделенные',
        iconCls:'remove',
        disabled:true,
        id:'itemsRemove',
        handler:itemsRemove
    }, {
        tooltip:'Редактировать',
        text:'Редактировать',
        iconCls:'option',
        disabled:false,
        id:'itemsEdit',
        handler:function(){
		    var m = itemsGrid.getSelectionModel().getSelections();
		    if(m.length == 1) {
		    	edit_bloger(m[0].get('id'));
		    	Ext.ux.TinyMCE.initTinyMCE();
		        
		    } else {
		        Ext.MessageBox.alert('Сообщение', 'Не выбрано ни одного элемента');
		    }            	
        }
    }