$(function(){
 
$(document).click(function(ev){
	el = $(ev.target)
	if(el.attr("id") !== "fancybox-wrap" && el.parents("#fancybox-wrap").length == 0)
		$('#fancybox-wrap').remove()
})
 
$(".collection li a").click(function(ev){
	ev.preventDefault();
	$('#fancybox-wrap').remove()
	get_product_info($(this))
})



$(".meal .more").click(function(ev){
	ev.preventDefault();
	get_recept_info($(this))
})


$("#fancybox-close").live("click",function(){
	$(this).parents('#fancybox-wrap').remove()
	return false;
})



});

var get_product_info = function(el){
	$.ajax({
		url:el.attr("href"),
		type:'post',
		dataType:"json",
		success:function(resp){
			if(resp.success){
				el.parent().append(resp.html)
				$('#fancybox-wrap').offset({
					top:(el.offset().top - 245),
					left:(el.offset().left + 25),
				})
			}
		}
	})
}

var get_recept_info = function(el){
	$.ajax({
		url:el.attr("href"),
		type:'post',
		dataType:"json",
		success:function(resp){
			if(resp.success){
				$("#content").append(resp.html)
				$('#fancybox-wrap').offset({
					top:(el.offset().top - 100)
				})
			}
		}
	})
}