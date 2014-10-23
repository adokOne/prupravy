<?php include Kohana::find_file('views','header'); ?>
<div class="cabinet_page">
<?php include Kohana::find_file('views','_left_menu'); ?>
<?php $type =  URI::instance()->argument() == false ? "user_id" :  "user_id" ;#var_dump($type);die;?>
       <div class="right_side">
		<ul data-auto-controller="UserMessagesController" class="post_list">
			<?php foreach($messages as $message):?>
            <li data-id="<?php echo $message->id?>">
            	<a href="#" title="<?php echo ORM::factory("user",$message->$type)->name?>" >
            	<?php $src = img::_get("/upload/avatars/".$message->$type,20);?>
            		<img src="<?php echo $src?>"  />
            	</a>
            	<a class="message" href="#">
              		<h2 style="padding-right: 10px;"><?php echo ucfirst(text::limit_chars($message->theme,30,"..."))?></h2>
              		<?php echo ucfirst(text::limit_chars($message->text,20,"...")) ?>
              	</a>
              	
              <div class="message_controls">
              <?php if(!URI::instance()->argument() == "output"):?>
	              <a class="answer" style="margin-left: 20px;" href="#"><?php echo $lang["answer"] ?></a>
	              <a class="delete" style="margin-left: 20px;" href="#"><?php echo $lang["delete"] ?></a>
	              <?php /*<a class="spam" style="margin-left: 20px;" href="#"><?php echo $lang["spam"] ?></a>*/ ?>
	          <?php else:?>
	          	<a class="delete" style="margin-left: 20px;" href="#"><?php echo $lang["delete"] ?></a>
	          <?php endif;?>
              </div>
              <?php /*<span class="message_type ">
              </span>*/?>
              <div class="b_date"><?php echo date::rusdate2("j M Y H:i",strtotime($message->date))?></div><!-- b_date -->
            </li>
            <?php endforeach;?>
          </ul>
       		<div class="cc"></div>
	   </div>
	   <div class="cc"></div>
</div>
<div class="cc"></div>
<?php echo $pagination->render();?>
<div class="b_empty"></div>
<?php include Kohana::find_file('views','footer'); ?>