<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo $lang['title'] ?></title>
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/ext-all.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/xtheme-gray.css" media="screen" />
	
	
	
	<script type="text/javascript" src="/extjs/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="/extjs/ext-all.js"></script>

	<style type="text/css"> 
		html { background: #E0E0E0 50% 0 no-repeat; }
		body { width: 52em; margin: 200px auto 2em; font-size: 76%; font-family: Arial, sans-serif; color: #333; line-height: 1.5; text-align: center; }
		.copyright { font-size: 0.9em; color: #333; clear:both;}
		.copyright a {color: #333;text-decoration:none;}
		.copyright a:hover {text-decoration:underline;}
		label {line-height:23px;}
		#loginDialogId {height:350px;}
		#login-form .x-plain-body {padding:15px 15px;} 
		#login-logo {background:url(/images/logo.png) no-repeat 60px 5px;width:346px;height:120px;}
	</style>


</head>
<body>

<script type="text/javascript"> 
	<!--
	
		Ext.SSL_SECURE_URL="/extjs/resources/images/default/s.gif";
		Ext.BLANK_IMAGE_URL="/extjs/resources/images/default/s.gif";
	
		Login = function(){
			var dialog,
				form,
				submitUrl = '/admin/login/';
	
			return {
				Init:function(){

					Ext.QuickTips.init();
					
					var logoPanel = new Ext.Panel({
						baseCls: 'x-plain',
						id: 'login-logo',
		        		region: 'center',
					});
			
			
					var submit = function () {
    					form.submit({
							waitMsg:'<?php echo $lang['wait_msg']; ?>',
							reset:true,
							success:Login.Success,
							scope:Login
						});
                    }					
					
					var formPanel = new Ext.form.FormPanel({
		        		baseCls: 'x-plain',
		        		defaults: {width: 200},
		        		defaultType: 'textfield',
		        		frame: false,
		        		height: 84,
		        		id: 'login-form',
		        		items: [{
		            		fieldLabel: '<?php echo $lang['username']; ?>',
		            		name: 'username',
                            listeners : { 
                                'specialkey': function(){
                                    if (Ext.EventObject.getKey() == 13) {
                                        submit();
                                    }
                                }
                            }		            		
		        		},{
		            		fieldLabel: '<?php echo $lang['password']; ?>',
		            		inputType: 'password',
		            		name: 'password',
                            listeners : { 
                                'specialkey': function(){
                                    if (Ext.EventObject.getKey() == 13) {
                                        submit();
                                    }
                                }
                            }		            		
		        		}],
		        			labelWidth:60,
		        			region: 'south',
		        			url: submitUrl
		    			});
		
		   				dialog = new Ext.Window({
		        			buttons: [{
		        				handler: submit,
		        				scope: Login,
		            			text: '<?php echo $lang['login_btn_text']; ?>'
		        			}],
		        			buttonAlign: 'right',
		        			closable: false,
		        			draggable: false,
		        			height: 250,
		        			id: 'login-win',
		        			layout: 'border',
		        			minHeight: 236,
		        			minWidth: 346,
		        			plain: false,
		        			resizable: false,
		        			items: [
		        				logoPanel,
		        				formPanel
		        			],
							title: '<?php echo $lang['title']; ?>',
		        			width: 310
		    			});
			
						form = formPanel.getForm();
				
					    dialog.show();
					},
		
					Success: function(f,a){
						
						if(a && a.result){
							dialog.destroy(true);
							window.location = a.result.path;
						}
					}
				};
			}();
		
		Ext.BasicForm.prototype.afterAction=function(action, success){
			this.activeAction = null;
			var o = action.options;
			if(o.waitMsg){
				Ext.MessageBox.updateProgress(1);
				Ext.MessageBox.hide();
			}
			if(success){
				if(o.reset){
					this.reset();
				}
				Ext.callback(o.success, o.scope, [this, action]);
				this.fireEvent('actioncompleted', this, action);
			}else{
				Ext.callback(o.failure, o.scope, [this, action]);
				this.fireEvent('actionfailed', this, action);
			}
		}
		Ext.onReady(Login.Init, Login, true); 
	//-->
	</script>

<div align="center" id='loginDialogId'></div> 

	<p class="copyright">
		Please login
	</p> 

</body>
</html>