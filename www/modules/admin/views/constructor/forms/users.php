,{
    xtype:'fieldset',
    title: 'Загальна інформація',
    collapsible: true,
    hideBorders:true,
    autoHeight:true,
    anchor:'95%',
    style: {
        border: '1px solid #AAA',
        padding: '4px',
        margin: 0
    },
    items :[{
        layout:'column',
        border:false,
        baseCls:'x-plain',
        defaults:{
            border:false,
            baseCls:'x-plain',
            layout:'form'
        },
        anchor:'97%',
        items:[{
            columnWidth:0.5,
            items:[{
                xtype:'textfield',
                fieldLabel:'ПІБ',
                name:'name',
                anchor:'95%',
                allowBlank:false
            },{
                xtype:'textfield',
                fieldLabel:'Логін',
                name:'username',
                anchor:'95%',
                allowBlank:true
            }]
        },{
            columnWidth:0.5,
            items:[{
                xtype:'textfield',
                fieldLabel:'E-Mail',
                name:'email',
                anchor:'100%',
                allowBlank:false
            },{
                xtype:'textfield',
                fieldLabel:'Телефон',
                name:'phone',
                anchor:'100%',
                allowBlank:true
            }]
        }]
    }]
},{
    xtype:'fieldset',
    title: 'Зміна пароля',
    collapsible: true,
    hideBorders:true,
    autoHeight:true,
    anchor:'95%',
    style: {
        border: '1px solid #AAA',
        padding: '4px',
        margin: 0
    },
    items :[{
        layout:'column',
        border:false,
        baseCls:'x-plain',
        defaults:{
            border:false,
            baseCls:'x-plain',
            layout:'form'
        },
        anchor:'97%',
        items:[{
            columnWidth:0.5,
            items:[{
                xtype:'textfield',
                fieldLabel:'Пароль',
                inputType: 'password',
                name:'password1',
                anchor:'95%',
                allowBlank:true
            }]
        }, {
            columnWidth:0.5,
            items:[{
                xtype:'textfield',
                fieldLabel:'Підтвердження',
                inputType: 'password',
                name:'password2',
                anchor:'100%',
                allowBlank:true
            }]
        }]
    }]
},{
    xtype:'fieldset',
    title: 'Про себе',
    collapsible: true,
    hideBorders:true,
    autoHeight:true,
    anchor:'95%',
    style: {
        border: '1px solid #AAA',
        padding: '4px',
        margin: 0
    },
    items :[{
        layout:'column',
        border:false,
        baseCls:'x-plain',
        defaults:{
            border:false,
            baseCls:'x-plain',
            layout:'form'
        },
        anchor:'97%',
        items:[ {
            columnWidth:1,
            items:[{
                xtype:'textarea',
                inputType: 'text',
                name:'about',
                anchor:'100%',
                allowBlank:true
            }]
        }]
    }]
}