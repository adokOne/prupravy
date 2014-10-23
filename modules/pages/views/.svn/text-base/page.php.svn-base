<?php 
if($pg_seo_name=='footer') {
	echo $page->pg_text;
}
 
else {
	include Kohana::find_file('views','header'); 
	echo '<div class="wrap">
			<div class="b_news_open">
				<h1>'. $page->pg_title.'</h1>
				<p>'.$page->pg_text.'</p>
					<script>				
					$("a.message_box").click(function(){
						showLoader("<p><center>Ожидайте...</center></p>");
						  $.ajax({
							  type: "post",
							  url: "/pages/message_box",
							  data:"id="+$(this).attr("id"),
							  dataType: "json",
								 success: function(response){
									 setLoaderHTML(response.html)
								  }
							  
						 });
					});</script>
			</div> <!-- b_news_open -->';
	include Kohana::find_file('views','baner');
	echo '<div class="clear"></div>
		  </div><!-- end wrap -->';
		include Kohana::find_file('views','footer'); 
}
?>