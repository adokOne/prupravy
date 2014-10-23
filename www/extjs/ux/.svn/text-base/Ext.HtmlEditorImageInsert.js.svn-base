Ext.namespace('Ext.ux', 'Ext.ux.plugins');
Ext.ux.plugins.HtmlEditorImageInsert = function(config){
	config = config ||
	{};
	Ext.apply(this, config);
	this.init = function(htmlEditor){
		this.editor = htmlEditor;
		this.editor.on('render', onRender, this);
	};
	this.imageInsert = function(){
		im.plugin = true;
		im.type = 'editor';
		im.currentObject = this.editor;
		im.CreateWindow();
	};
	function onRender(){
		if (!Ext.isSafari) {
			this.editor.tb.add('-');
			this.editor.tb.add({
				itemId: 'htmlEditorImage',
				iconCls:'picture',
				cls: 'x-btn-icon x-edit-insertimage',
				enableToggle: false,
				scope: this,
				handler: function(){
					this.imageInsert();
				},
				clickEvent: 'mousedown',
				tooltip: config.buttonTip ||
				{
					title: 'Вставити зображення',
					text: 'Вставити зображення в HTML-Редактор',
					cls: 'x-html-editor-tip',
				},
				tabIndex: -1
			});
		}
	};
};

