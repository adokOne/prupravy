
<?php include Kohana::find_file("views","header"); ?>
		<div id="content">
			<div class="contacts">
				<div class="map left">
					<iframe width="316" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.ua/maps?q=%D0%A3%D0%BA%D1%80%D0%B0%D1%97%D0%BD%D0%B0,+%D0%BC.%D0%9A%D0%B8%D1%97%D0%B2,+%D0%B2%D1%83%D0%BB.%D0%A1%D1%82%D0%B0%D1%80%D0%BE%D1%81%D1%96%D0%BB%D1%8C%D1%81%D1%8C%D0%BA%D0%B0,+1%D0%95&amp;ie=UTF8&amp;hl=uk&amp;hq=&amp;hnear=%D0%A1%D1%82%D0%B0%D1%80%D0%BE%D1%81%D1%96%D0%BB%D1%8C%D1%81%D1%8C%D0%BA%D0%B0+%D0%B2%D1%83%D0%BB.,+1,+%D0%9A%D0%B8%D1%97%D0%B2,+%D0%BC%D1%96%D1%81%D1%82%D0%BE+%D0%9A%D0%B8%D1%97%D0%B2&amp;ll=50.473109,30.589907&amp;spn=0.019502,0.049524&amp;t=m&amp;z=14&amp;output=embed"></iframe>
				</div>
				
				<div class="address left">
					<img src="/img/plant.png" alt=""/>
						
					<div class="maker">
						<h6><?php echo $lang["made_for"]?></h6>
						<?php echo $lang["made_for_text"]?>
					</div>
					
					<div class="distributor">
						<h6><?php echo $lang["distrib"]?></h6>
						<?php echo $lang["distrib_text"]?>
					</div>
				</div>
			</div>
				<div class="clear"></div>
		</div><!--content-->
		
		<div id="partners_footer">
			
		</div><!--footеr-->
<?php include Kohana::find_file("views","footer"); ?>