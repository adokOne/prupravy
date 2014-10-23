  var TypeStore = new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/actualtopics/types_list'
	        }),
	        reader:new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	        },['id',"name"]),
	        remoteSort:true
 });
 var ItemStore = new Ext.data.Store({
		  proxy:new Ext.data.HttpProxy({
	            url:'/admin/actualtopics/item_list'
	        }),
	        reader:new Ext.data.JsonReader({
	            root:'items',
	            totalProperty:'total',
	            idProperty:'id',
	        },['id',"name"]),
	        remoteSort:true
 });

 TypeStore.load();
 ItemStore.load();
 var ActualTopicFormReader = new Ext.data.JsonReader({},[<?php echo $form_columns ?>]);
 var ActualTopicForm = new Ext.FormPanel({
        id:'ActualTopicForm',
        method:'POST',
        region:'center',
        border:true,
        margins:'0 0 0 0',
        layout:'form',
        border:false,
        
        disabled:false,
        
        labelAlign:'top',
        baseCls:'x-plain',
        autoScroll:true,
        reader:ActualTopicFormReader,
        items: [
        {
            xtype:'hidden',
            name:'id'
        },
        <?php if (file_exists("$dir/forms/$class.php")) { include "$dir/forms/$class.php";} ?>
        ]
  });
 var ActualTopicADD = new Ext.Window({
        shim:false,
        modal:true,
        maximizable:true,
        title:'Добление Категории/Темы',
        autoHeight:true,
        width:480,
        closeAction:'hide',
        items:ActualTopicForm,
        buttonAlign:'center',
        buttons:[{
            text:'Сохранить',
            iconCls:'save',
            handler:function(){
            ActualTopicForm.getForm().submit({ 
             url: 'admin/actualtopics/save',
             success: function(form, action){
              	 Ext.Msg.alert('Уведомление', 'Добавленно');
              	 ActualTopicADD.hide();
              	 itemsStore.reload();
              },
              failure: function(form, action){
                 Ext.Msg.alert('Уведомление', 'Ошибка');
              }
            
            })
        }}, {
            text:'Закрыть',
            iconCls:'cancel',
            handler:function(){
                ActualTopicADD.hide();
            }
        }]
 });
 