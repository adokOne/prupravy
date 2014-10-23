    <?php $lang = Kohana::lang("cabinet");?>
    
       <div class="left_side">
         <h3><?php echo $lang['cabinet']?></h3>
         <ul class="cabinet_menu" >
           <li <?php echo URI::instance()->method(false) == "profile" ? "class='active'" :  "" ?> > <a href="/user/profile"><?php echo $lang["profile"]?></a></li>
           <li <?php echo URI::instance()->method(false) == "messages" ? "class='active'" :  "" ?> > <a href="/user/messages"><?php echo $lang["message"]; if($new_m > 0) echo " (".$new_m.")"?> </a>
           <?php if(URI::instance()->method(false) == "messages" ) :  ?>
			  <ul class="sub_menu">
                <li <?php echo URI::instance()->argument() == false ? "class='active'" :  "" ?> ><a href="/user/messages"><?php echo $lang["input"]?></a></li>
                <li <?php echo URI::instance()->argument() == "output" ? "class='active'" :  "" ?> ><a href="/user/messages/output"><?php echo $lang["output"]?></a></li>
              </ul>
           <?php endif;?>
           </li>
           <li <?php echo URI::instance()->method(false) == "friends" ? "class='active'" :  "" ?> > <a href="/user/friends"><?php echo $lang["friends"] ?></a></li>
           <li <?php echo URI::instance()->method(false) == "posts" ? "class='active'" :  "" ?> > <a href="#"><?php echo $lang["photos"] ?></a></li>
         </ul>
       </div><!-- left_side -->