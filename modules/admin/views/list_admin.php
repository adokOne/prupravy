<script type="text/javascript">

<?php include "$dir/main/base.php";?>

<?php if ($use_tree) include "$dir/main/tree.php" ?>

    return {
        init: function() {
            return new Ext.Panel({
                border:false,
                layout:'border',
                items:[<?php if ($use_tree):?>categoriesTree,<?php endif ?> itemsGrid<?php if ($use_form):?>, editPanel<?php endif?>]
            });

        }
    };

 }();

var mainTabPanel = Ext.getCmp('dashboard_mainTabPanelID');
mainTabPanel.items.each(function(item){mainTabPanel.remove(item);}, mainTabPanel.items);

mainTabPanel.add({
    title: 'На модерации',
    layout:'fit',
    iconCls:'ico_moderation',
    items:[module_<?php echo $class ?>.init()]
});

mainTabPanel.setActiveTab(0);

</script>
