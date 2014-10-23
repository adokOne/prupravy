<html lang="en">
        <?php include Kohana::find_file("views","header");?>
    <body>
        <?php include Kohana::find_file("views","header_menu");?>

			<div class="main-bg">
				<div class="main" >
				 
					<section id="content">
						<div class="container_24">
							<div class="wrapper">
								<div class="grid_8 suffix_1">
									<h2 class="ident-bot-24"><?php echo Kohana::lang('main.find_us');?></h2>
									<div class="ident-bot-8">
										<iframe width="350" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.ua/maps?f=q&amp;source=s_q&amp;hl=ru&amp;geocode=&amp;q=%D0%92%D0%BE%D0%BB%D0%BE%D0%B4%D0%B8%D0%BC%D0%B8%D1%80%D0%B0+%D0%92%D0%B5%D0%BB%D0%B8%D0%BA%D0%BE%D0%B3%D0%BE,+%D0%9B%D1%8C%D0%B2%D0%BE%D0%B2,+%D0%9B%D1%8C%D0%B2%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C&amp;aq=0&amp;oq=%D0%B2%D0%BE%D0%BB%D0%BE%D0%B4%D0%B8%D0%BC&amp;sll=48.382803,31.17461&amp;sspn=11.07853,27.114258&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%BC%D0%B8%D1%80%D0%B0+%D0%92%D0%B5%D0%BB%D0%B8%D0%BA%D0%BE%D0%B3%D0%BE&amp;ll=49.809964,24.004612&amp;spn=0.016617,0.025749&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
									</div>
									<div>
										<dl class="dl1">
											<dt class="ident-bot-1">
												<strong class="strong1">
													<?php echo Kohana::lang('main.address');?>
												</strong>
											</dt>
											<dd><span>+38 097 779996</span><?php echo Kohana::lang('main.phone');?></dd>
											<dd><span>+38 097 779996</span><?php echo Kohana::lang('main.phone');?></dd>
											<dd><span>+38 097 779996</span><?php echo Kohana::lang('main.fax');?></dd>
											<dd><?php echo Kohana::lang('main.email');?>: 
												<a class="link-1" href="#"><?php echo Kohana::config("core.site_contact_email")?>
													<script type="text/javascript">
													/* <![CDATA[ */
													(function(){try{var s,a,i,j,r,c,l,b=document.getElementsByTagName("script");l=b[b.length-1].previousSibling;a=l.getAttribute('data-cfemail');if(a){s='';r=parseInt(a.substr(0,2),16);for(j=2;a.length-j;j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}s=document.createTextNode(s);l.parentNode.replaceChild(s,l);}}catch(e){}})();
													/* ]]> */
													</script>
												</a>
											</dd>
										</dl>
									</div>
								</div>
								<div class="grid_15">
									<h2 class="ident-bot-24"><?php echo Kohana::lang('main.get_in_touch');?></h2>
									 
									<div id="confirm">
										<form id="form1" data-auto-controller="ContactsController" action="/contacts/send">
											<div class="success" style="display: none;"><div class="success_txt">Contact form submitted!<br><strong class="strong1"> We will be in touch soon.</strong></div></div>
											<fieldset>
												<label class="name">
													<input class="only_cyrylic_with_spaces" autocomplete="off" name="name" type="text" required="required" placeholder="<?php echo Kohana::lang('main.name');?>">
													<?php /*
													<span class="error" style="display: none;">*This is not a valid name.</span> 
													<span class="empty" style="display: none;">*This field is required.</span>
													*/?>
												</label>
												<label class="email">
													<input autocomplete="off" name="email" type="email" required="required" placeholder="<?php echo Kohana::lang('main.email');?>">
													<?php /*
													<span class="error" style="display: none;">*This is not a valid email address.</span>
													<span class="empty" style="display: block;">*This field is required.</span>
													*/?>
												</label>
												<label class="phone">
													<input class="only_numbers" autocomplete="off" name="phone" type="tel" required="required" placeholder="<?php echo Kohana::lang('main.telephone');?>">
													<?php /*
													<span class="error" style="display: none;">*This is not a valid phone number.</span>
													<span class="empty" style="display: block;">*This field is required.</span>
													*/?>
												</label>
												<label class="message">
													<textarea name="text" required="required" placeholder="<?php echo Kohana::lang('main.massage');?>"></textarea>
													<?php /*
													<span class="error" style="display: none;">*The message is too short.</span>
													<span class="empty" style="display: block;">*This field is required.</span>
													*/?>
												</label>
												<div class="clear"></div>
												<div class="btns">
													<a href="#" class="button reset" ><?php echo Kohana::lang('main.clear');?></a>
													<a href="#" class="button submit" >
														<?php echo Kohana::lang('main.send_message');?>
														
													</a>
												</div>
											</fieldset>
										</form>
									</div> 
								</div>
							</div>
						</div>
					</section> 
				</div>
			</div>

        <?php include Kohana::find_file("views","footer");?>
         

    </body>
</html>