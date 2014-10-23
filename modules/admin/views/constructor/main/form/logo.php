        {
						xtype: 'textfield',
						hidden: true, 
		                name:'has_logo',
		                id:'has_logo',
				        value: 1
        },{
        xtype:'fieldset',
        title: 'Фото',
        collapsible: true,
        hideBorders:true,
        autoHeight:true,
        anchor:'95%',
        style: {
            border: '1px solid #AAA',
            padding: '4px',
            margin: 0
        },
        items:[{
            xtype:'panel',
            id:'logopanel',
            bodyStyle:'padding:4px;margin:4px 0px;text-align:center;border:1px solid #99BBE8;',
            html:'<img id="logo" src="'+Ext.BLANK_IMAGE_URL+'" />',
            baseCls:'x-plain',
            anchor:'100%',
            tbar:['->', {
                xtype: 'fileuploadfield',
                buttonOnly: true,
                name: 'logo',
                buttonText: '',
                buttonCfg: {
                    iconCls: 'add'
                }, listeners: {
                    'fileselected': function(fb, v){
                        editForm.form.findField('has_logo').setValue(1);
                        itemSave();
                    }
                }
            },/*{
                text:'',
                iconCls:'remove',
                handler:function(){
                    Ext.get('logo').set({src:Ext.BLANK_IMAGE_URL});
                    editForm.form.findField('has_logo').setValue(0);
                    itemSave();
                }
            }*/]
        }]
            
        }
