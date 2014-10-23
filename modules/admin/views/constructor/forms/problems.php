,{
            xtype:'fieldset',
            title: 'Дані про проблему',
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
                xtype:'textarea',
                height:500,
                anchor:'100%',
                fieldLabel:'Опис',
                name:'description'
            }]
        }/*,{
            xtype:'fieldset',
            title: 'Адреса',
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
                        xtype:'combo',
                        anchor:'95%',
                        fieldLabel:'Місто',
                        name:'city_id',
                        hiddenName:'city_id',
                        store: citiesStore,
                        displayField:'name',
                        valueField:'id',
                        typeAhead: true,
                        mode: 'local',
                        forceSelection: true,
                        triggerAction: 'all',
                        selectOnFocus:true,
                        listeners: {
                                select:
                                function(e,a) {

                                            districtsStore.removeAll();
                                            streetsStore.removeAll();
                                            districtsStore.reload({params: {city_id:a.data.id}});
                                            }
                                }
                    },{
                        xtype:'combo',
                        anchor:'95%',
                        fieldLabel:'Район',
                        name:'district_id',
                        hiddenName:'district_id',
                        store: districtsStore,
                        displayField:'name',
                        valueField:'id',
                        typeAhead: true,
                        mode: 'local',
                        forceSelection: true,
                        triggerAction: 'all',
                        selectOnFocus:true,
                        listeners: {
                                select:
                                function(e,a) {
                                            streetsStore.removeAll();
                                            streetsStore.reload({params: {district_id:a.data.id}});

                                            }
                                }
                    },{
                        xtype:'combo',
                        anchor:'95%',
                        fieldLabel:'Вулиця',
                        name:'street_id',
                        hiddenName:'street_id',
                        store: streetsStore,
                        displayField:'name',
                        valueField:'id',
                        typeAhead: true,
                        mode: 'local',
                        forceSelection: true,
                        triggerAction: 'all',
                        selectOnFocus:true,
                        listeners: {
                                select:
                                function(e,a) {


                                            }
                                }


                    }
            ]
        }



                                            */