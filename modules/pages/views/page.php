<html lang="en">
        <?php include Kohana::find_file("views","header");?>
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=481004451954775";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <body>
        <?php include Kohana::find_file("views","header_menu");?>

      <div class="main-bg">
        <div class="main" >
         
          <section id="content">
            <div class="container_24">
              <div class="wrapper">
                <article class="grid_17 suffix_1" >
                  <div class="page8-box1">
                    <?php $src = file_exists(DOCROOT."upload/pages/b_".$page->id.".jpg") ? "/pages/news/b_".$page->id.".jpg" : "/upload/problems/0/pic_320.jpg";?>
                  <h3 style="font-family: Verdana sans-serif;margin-bottom: 20px;"><?php echo $page->title?></h3>
                  <p>
                    <?php echo $page->text?>
                  </p>
                  </div>
                </article>
                <aside class="grid_6">
                	<div class="wrapper">
                		<h2 class="ident-bot-24" style="text-align: center;">
                			<?php echo Kohana::lang("main.in_social")?>
                		</h2>
                		<div class="vkontakte">
							<script type="text/javascript" src="//vk.com/js/api/openapi.js?87"></script>

							<!-- VK Widget -->
							<div id="vk_groups"></div>
							<script type="text/javascript">
							VK.Widgets.Group("vk_groups", {mode: 0, width: "230", height: "290"}, 20003922);
							</script>
                		</div>
                		<div class="facebook" style="margin-top: 50;">
                			<div class="fb-like-box" data-href="http://www.facebook.com/platform" data-width="230" data-height="290" data-show-faces="true" data-stream="false" data-border-color="white" data-header="true"></div>
                		</div>
                	</div>
                </aside>
              </div>
            </div>
          </section> 
        </div>
      </div>

        <?php include Kohana::find_file("views","footer");?>
         

    </body>
</html>