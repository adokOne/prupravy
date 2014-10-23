<div id="fancybox-wrap">
<div id="fancybox-outer">

<div id="fancybox-content" class="shadow">
		<div id="info"  >
				<h5><?php echo $product->name();?></h5>
					<p class="strong"><?php echo $product->desc();?></p> 
				
					<p><?php echo $lang["consist"]?>: <?php echo $product->consist();?></p>

					<p class="strong"><?php echo $lang["gmo"]?><br>
					<?php echo $lang["vaga"]?>: <?php echo $product->weight." ".$lang["g"];?>  (+-9%)</p>
		</div>
</div>
<a id="fancybox-close" style="display: inline;"></a>
</div>
</div>
