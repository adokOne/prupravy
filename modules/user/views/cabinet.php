<?php include Kohana::find_file('views','header'); ?>
<div class="cabinet_page">
<?php include Kohana::find_file('views','_left_menu'); ?>
<?php $lang = Kohana::lang("login");?>
       <div class="right_side">
			<form action="/user/password_update" data-auto-controller="UserCabinetController" method="post">
			<ul style="float: left;" class="form_list">
	          <li>
	          <center style="color: #1D7CC9;font: 14px Arial;"><?php echo $lang["pswd_change"]?></center>
	          </li>
	          <li>
	            <div class="b_left">
	             <label><?php echo $lang['password']?></label>
	             <input autocomplete="off" id="password" name="password" type="password" class="form-text wihout_spaces" value=""  required="required" />
	             <div class="b_error"><?php echo $lang['fill_pass']?></div><!-- b_error -->
	            </div><!-- b_left -->
	            <div class="b_left">
	             <label><?php echo $lang['password_conf']?></label>
	             <input autocomplete="off" id="password_confirm" name="password_confirm" type="password" class="form-text wihout_spaces" value=""  required="required" />
	             <div class="b_error"><?php echo $lang['fill_pass_conf']?></div><!-- b_error -->
	            </div><!-- b_left -->
	          </li>
	          <li>
	                      
	           <center>
	           <div class="b_error_block"></div>
	           	<input type="submit" class="form-submit" value="<?php echo $lang['save']?>" />
	           	</center>
	          </li>
			</ul>
			
			</form>
          <form action="/user/update" data-auto-controller="UserCabinetController" method="post" >
	        <ul style="float: left;" class="form_list">
	          <li>
	          <center style="color: #1D7CC9;font: 14px Arial;"><?php echo $lang["user_info"]?></center>
	          </li>
	          <li>
	            <div class="b_left">
	             <label><?php echo $lang['fio']?></label>
	             <input autocomplete="off" name="username" readonly="readonly" type="text" class="form-text without_numbers" value="<?php echo $user->username?>"  required="required" />
	             <div class="b_error"><?php echo $lang['fill_input']?></div><!-- b_error -->
	            </div><!-- b_left -->
	            <div class="b_left">
	             <label><?php echo $lang['nick']?></label>
	             <input autocomplete="off" name="name" type="text" class="form-text" value="<?php echo $user->name?>" required="required" />
	             <div class="b_error"><?php echo $lang['fill_input']?></div><!-- b_error -->
	            </div><!-- b_left -->
	          </li>
	          <li>
	          <div class="b_left">
	            <label>E-mail</label>
	            <input autocomplete="off" name="email" type="email" class="form-text wihout_spaces " value="<?php echo $user->email?>" required="required" readonly="readonly"/>
	            <div class="b_error"><?php echo $lang['enter_email']?></div><!-- b_error -->
	          </div>
	          <div class="b_left">
	            <label><?php echo $lang["phone"]?></label>
	            <input autocomplete="off" name="phone" type="text" class="form-text wihout_spaces " value="<?php echo $user->phone?>"/>
	            
	          </div>
	          </li>

	          <li>
	            <label><?php echo $lang['about']?></label>
	            <textarea name="about"  class="form-textarea"><?php echo $user->about?></textarea>
	          </li>
	          <li>
	            <div class="b_left">
	              <label><?php echo $lang['add_avatar']?></label>
	              <div  class="b_photo">
	              	<?php $src = $user->has_logo ? img::_get("/upload/avatars/".$user->id, 100) : "" ?>
	              	<img src="<?php echo $src ?>" width="100" height="100" class="<?php echo $user->has_logo ? "show" : ""  ?>"/>
	              </div><!-- b_photo -->
	            </div><!-- b_left -->
	            <a href="#"  id="btn_upload" class="btn_upload"><?php echo $lang['dropp_avatar']?></a>
	          </li>
	          <li>
	            <input type="hidden" value="" name="image_name" id="image_name" />
	            <center>
	            <div class="b_error_block"></div>
	            <input type="submit" class="form-submit" value="<?php echo $lang['save']?>" />
	            </center>
	          </li>
	        </ul>
        </form>
       <div class="cc"></div>
</div>
 <div class="cc"></div>
</div>
 <div class="cc"></div>
<div class="b_empty"></div>
<?php include Kohana::find_file('views','footer'); ?>