<?php include Kohana::find_file('views','header'); ?>
<div class="cabinet_page">
<?php include Kohana::find_file('views','_left_menu'); ?>
       <div class="right_side">
		<ul data-auto-controller="UserFriendsController" class="friends_list">
		
			<?php foreach($user->user_friends as $friend):?>
			
            <li class="friend" data-id="<?php echo $friend->get_user()->id?>">
            	<h5><?php echo $friend->get_user()->name ?></h5>
            	<img src="<?php echo img::_get("/upload/avatars/".$friend->get_user()->id,230)?>" class="left"/>
           		<ul class="user_data" >
           		<li class="item" ><span class="desc" ><?php echo $lang["reg_date"]; ?>: </span><span><?php echo date::rusdate2("j M Y",strtotime($friend->get_user()->created_at)) ?></span></li>
           		<li class="item" ><span class="desc" >Рейтинг: </span></li>
           		<li class="item" ><span class="desc" ><?php echo $lang["last_login"]?>: </span><span><?php echo date::rusdate2("j M Y H:i",$friend->get_user()->last_login) ?></span></li>
           		
           		<li class="item" ><span class="desc" ><?php echo $lang["user_activity"]?>: </span><span><?php echo $friend->get_user()->posts_count?></span></li>
           		<li class="c_last">
           			<a href="#" class="answer"><?php echo $lang["send_mes"]?></a> 
           			<a href="#" class="send_message"><?php echo $lang["view_new"]?></a> 
           			<a href="#" style="border:none;" class="delete"><?php echo $lang["del_friend"]?></a>
           		</li>
           		</ul>
           		<div class="cc"></div>
            </li>
            <?php endforeach;?>
          </ul>
       		<div class="cc"></div>
	   </div>
	   <div class="cc"></div>
</div>
<div class="cc"></div>
<?php # echo $pagination->render();?>
<div class="b_empty"></div>
<?php include Kohana::find_file('views','footer'); ?>