
var tree_<?php echo $title ?>_tree = <?php echo $actions; ?>; 

var tree_<?php echo $title ?> = new Ext.ux.tree.ArrayTree({
	id: 'tree_<?php echo $title ?>',
	rootVisible: false,
	border: false,
	defaultTools:false,
	useArrows: true,
	rootConfig:{
		text:'Tree Root',
		visible:false
	},
	style:'padding:10px 10px',
	children:tree_<?php echo $title ?>_tree
   
});


function showSettings(node, e){
	if(node.id){
		mainTabPanel.load({
			url: "/admin/"+node.id,
			params: {
				method: 'post'
			},
 			scripts: true,
 			text: "Загрузка"
 		});
	}
};




tree_<?php echo $title ?>.on("click", showSettings);