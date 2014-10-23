{
    xtype:'fieldset',
    title: 'Текст звернення',
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
                height: 300,
                xtype:'textarea',
                inputType: 'text',
                name:'text',
                anchor:'100%',
                allowBlank:true
            }]
        }, {
            columnWidth:1,
            items:[{   xtype:'combo',
                anchor:'95%',
                fieldLabel:'Розлянуто?',
                name:'status',
                hiddenName:'status',
                store: new Ext.data.JsonStore({
                    id: 'ids',
                    fields: ['id', 'text'],
                    data : [
                        {id: '1', text:'Так'},
                        {id: '0', text:'Нi'}
                    ]
                }),
                displayField:'text',
                valueField:'id',
                typeAhead: true,
                mode: 'local',
                forceSelection: true,
                triggerAction: 'all',
                selectOnFocus:true,
                allowBlank: 'false',
            }]
        }]
    }]
}


