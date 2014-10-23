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
                  <div class="page8-box1">
                    <?php $src = file_exists(DOCROOT."upload/news/b_".$news->id.".jpg") ? "/upload/news/b_".$news->id.".jpg" : "/upload/problems/0/pic_320.jpg";?>
                    <img src="<?php echo $src?>" alt="<?php echo $news->title?>" style ="float: left;padding: 10px;"/>
                  <h3 style="font-family: Verdana sans-serif;margin-bottom: 20px;"><?php echo $news->title?></h3>
                  <p>
                    <?php echo $news->text?>
                  </p>
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