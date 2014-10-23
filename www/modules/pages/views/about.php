<html lang="en">
        <?php include Kohana::find_file("views","header");?>
    <body>
        <?php include Kohana::find_file("views","header_menu");?>

      <div class="main-bg">
        <div class="main" >
          <section id="content" data-auto-controller="AboutController">
            <div class="container_24">
              <div class="wrapper ident-bot-14">
                <div class="grid_8">
                  <div class="block-4 block-4-color-1">
                    <p class="block-4-header">
                      <?php $lang= Kohana::lang('main');echo $lang["mission_vision"] ?>
                    </p>
                    <p>
                      Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque penatibus et magnis .
                    </p>
                  </div>
                </div>
                <div class="grid_8">
                  <div class="block-4 block-4-color-2">
                    <p class="block-4-header">
                      <?php $lang= Kohana::lang('main');echo $lang["volunteering"] ?>
                    </p>
                    <p>
                      Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque penatibus et magnis .
                    </p>
                  </div>
                </div>
                <div class="grid_8">
                  <div class="block-4 block-4-color-3">
                    <p class="block-4-header">
                      <?php $lang= Kohana::lang('main');echo $lang["recent_programs"] ?>
                    </p>
                    <p>
                      Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque penatibus et magnis .
                    </p>
                  </div>
                </div>
              </div>
              <div class="wrapper ident-bot-17">
              <div class="grid_14 suffix_1">
              <h2 class="ident-bot-3"><?php echo $lang["PRESIDENT"]?></h2>
              <img class="fl-l ident-top-5 ident-right-1" src="/upload/avatars/<?php echo $president->id?>/pic_227.jpg" alt="">
              <div class="extra-wrap">
                <p class="ident-bot-5">
                  <strong class="strong1">
                    <?php echo $president->name?>
                  </strong>
                </p>
              <div class="block-5 ident-bot-15">
              <?php echo $president->about?>
              </div>
              <figure class="bot1"><img src="/images/bot1.gif" alt=""></figure>
              <div class="clear"></div>
              </div>
              </div>
                <div class="grid_9">
                <h2 class="ident-bot-3"><?php echo $lang["foundation_history"]?></h2>
                <?php foreach($lang["history"] as $year=>$desc):?>
                <div class="wrapper ident-bot-16">
                  <div class="fl-l ident-right-5">
                    <p>
                      <strong class="strong1"><?php echo $year?> - </strong>
                    </p>
                  </div>
                  <div class="extra-wrap">
                    <p>
                      <a class="link-2" href="#">
                        <?php echo $desc?>
                      </a>
                    </p>
                  </div>
                </div>
                <?php endforeach;?>
                </div>
              </div>
              <div class="wrapper">
                <div class="grid_24">
                  <h2><?php echo $lang["MEET_OUR_TEAM"]?></h2>
                  <div class="carousel-cont-1">
                    <div class="carousel">
                      <ul>
                        <?php foreach($members as $member):?>
                        <li>
                        <img class="ident-bot-18" src="/upload/avatars/<?php echo $member->id?>/pic_227.jpg" width="230" height="284" alt="">
                        <p>
                          <strong class="strong1">
                            <a href="#">
                              <?php echo $member->name?>
                            </a>
                          </strong>
                        </p>
                        <p>
                          <?php echo $member->about?>
                        </p>
                        </li>
                      <?php endforeach;?>
                      </ul>
                    </div>
                      <a href="#" class="prev car-button" data-type="prevPage"></a>
                      <a href="#" class="next car-button" data-type="nextPage"></a>
                    <div class="clear"></div>
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