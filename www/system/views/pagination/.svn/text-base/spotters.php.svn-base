<?php 
	$current_page  =  URI::instance()->argument();
	
	$previous_page = $current_page-1;
	
	$next_page     = $current_page+1;
	#var_dump($current_page);die;
	?>


 <div class="b_pages">
	<a href="<?php if ($current_page > 1) echo "/".$segm."/".$previous_page.'?'.$_SERVER['QUERY_STRING'];  ?>" class="b_back <?php if ($current_page < 2) echo "deactive";  ?> "><?php echo Kohana::lang('pagination.prev')?></a>
 	<ul class="list">
	<?php if ($current_page >= $total_pages - 3 and ($current_page-4)>1): ?>
		
		<li><a href="/<?php echo $segm?>/1"<?php echo '?'.$_SERVER['QUERY_STRING']?>>1</a></li>
		<?php echo '<li>...</li>' ?>
	<?php endif; ?>
	<?php for ($i = $current_page - 3, $stop = $current_page + 3; $i < $stop; ++$i): ?>

		<?php if ($i < 1 OR $i > $total_pages) continue ?>
		
		<?php if ($current_page == $i): ?>
			<li class="active"><a href="#"><?php echo $i ?></a></li>
		<?php elseif (!$current_page and $i == 1):?>
			<li class="active"><a href="#"><?php echo $i ?></a></li>
		<?php else: ?>
			<li><a href="/<?php echo $segm?>/<?php echo $i.'?'.$_SERVER['QUERY_STRING'] ?>"><?php echo $i ?></a></li>
		<?php endif ?>
	<?php endfor ?>
	<?php if($total_pages>3):?>
	<?php if ($current_page <= $total_pages - 3): ?>
		<?php if ($current_page != $total_pages - 3) echo '<li>...</li>' ?>
		<li><a href="/<?php echo $segm?>/<?php echo $total_pages ?>"><?php echo $total_pages ?></a></li>
	<?php endif;endif; ?>
	</ul>
	<a href="<?php if ($current_page < $total_pages) echo "/".$segm."/".$next_page.'?'.$_SERVER['QUERY_STRING'];  ?>" class="b_forwords <?php if ($current_page == $total_pages) echo "deactive";  ?>"><?php  echo Kohana::lang('pagination.next')?></a>
</div>

