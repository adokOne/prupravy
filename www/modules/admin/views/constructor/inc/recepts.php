    var langMenuSel = function(obj){
        langSplitButton.setText(obj.text);    
        langSplitButton.setIconClass(obj.iconCls);    
        var lang = obj.text.toLowerCase();
        
        itemsStore.baseParams.lang = lang;
        
        itemsStore.load();
    };
    
    var langSplitButton = new Ext.SplitButton({
        minWidth:50,
        tooltip:'Язык контента',
           listeners:{
               click:function(){
                   this.showMenu();
               }
           },
           text: 'RU',
           iconCls:'flag_ru',
        menu : {
            id:'lang_menu',
            items: [
            {
                text: 'RU',
                iconCls:'flag_ru',
                handler: langMenuSel                        
            },{
                text: 'UA',
                iconCls:'flag_ua',
                handler: langMenuSel
            }, {
                text: 'EN',
                iconCls:'flag_en',
                handler: langMenuSel                        
            }]
        }                       

    });