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
                    <?php $src = file_exists(DOCROOT."upload/problems/".$problem->id."/pic_320.jpg") ? "/upload/problems/".$problem->id."/pic_320.jpg" : "/upload/problems/0/pic_320.jpg";?>
                    <img src="<?php echo $src?>" alt="<?php echo $problem->street->name_ua?>" style ="float: left;padding: 10px;"/>
                  <h3 style="font-family: Verdana sans-serif;margin-bottom: 20px;">
                    <?php echo  $problem->city->name.", ".$problem->district->name." Р-н, ".$problem->street->name_ua." ".$problem->building?>
                  </h3>
                  <h6><?php echo Kohana::lang("main.status")?>
                    <span class="status_<?php echo $problem->status?>" ><?php echo Kohana::lang("main.statuses.".$problem->status)?></span>
                  </h6>
                  <p>
                    <?php echo $problem->description?>
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