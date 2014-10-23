<html lang="en">
        <?php include Kohana::find_file("views","header");?>
    <body>
        <?php include Kohana::find_file("views","header_menu");?>

      <div class="main-bg">
        <div class="main" >
         
          <section id="content">
            <div class="container_24">
              <div class="wrapper">
                <article class="" >
                 
                  <div class="wrapper ident-bot-17">
                    <h2 class="ident-bot-3" style="font-family: Verdana sans-serif;margin-bottom: 20px;"><?php echo Kohana::lang('main.news');?></h2>
                    
                  
                   <?php foreach($news as $n):?>
                    <div class="wrapper">
                      <?php $src = file_exists(DOCROOT."upload/news/b_".$n->id.".jpg") ? "/upload/news/b_".$n->id.".jpg" : "/upload/problems/0/pic_320.jpg";?>
                      <img src="<?php echo $src ?>" alt="<?php echo $n->title?>" style ="float: left;padding: 10px;"/>
                      <p class="ident-bot-5">
                        <strong class="strong1">
                          <?php echo $n->title?>
                        </strong>
                      </p>
                      <p class="ident-bot-1">
                        <?php echo text::limit_chars($n->anons,400,"...")?>
                      </p>
                      <a href="/news/<?php echo $n->seo_name?>" class="button">
                        <?php echo Kohana::lang("main.read_more");?>
                      </a>
                    </div>
                   <?php endforeach;?>
                  </div>
                 
                </article>
              </div>
            </div>
          </section> 
        </div>
      </div>

        <?php include Kohana::find_file("views","footer");?>
         

    </body>
</html>