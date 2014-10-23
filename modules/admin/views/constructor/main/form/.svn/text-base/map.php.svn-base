{
            xtype:'panel',
            title:'Карта',
            region:'north',
            collapsed:false,
            animCollapse:false,
            collapsible:true,
            bodyStyle:'padding:0;margin:0;',
            height:400,
            html:'<div id="nadoloni"></div>',
            //baseCls:'x-plain',
            anchor:'100%',
            //tbar:mapPanelTBar,
            listeners:{
                'render': function(){
                    setTimeout(function() {
                        swfobject.embedSWF("/swf/MM_Construct.swf?"+Math.random(), "nadoloni", "100%", "100%", "9.0.0", "/swf/expressInstall.swf",
                        {bgcolor:"#FFFFFF"});
                    }, 1500);
                }
            }
},