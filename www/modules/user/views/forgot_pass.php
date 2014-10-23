  <?php $lang = Kohana::lang('login');?>
  
  <div class="b_shadow">
  	<form method="post"  action="/user/forgot_pass">
	    <div class="b_popup">
	    <a href="#" id="close" style="position: absolute;right: 5px;top: 5px;"><img src="/images/close.1.png"></a>
	      <h3><?php echo $lang['pass_recovery']?></h3>
	      <ul class="form_list">
	        <li>
	          <label><?php echo $lang['reg_email']?></label>
	          <input type="email" name="email" class="form-text" value="" required="required" />
	        </li>
	        <li>
	          <input type="submit" class="form-submit" value="<?php echo $lang['recover']?>" />
	        </li>
	        <li>
	          <span style="display:none" class="b_errors_block">
	          </span><!-- b_errors_block -->
	        </li>
	      </ul>
	      <div class="cc"></div>
	    </div><!-- b_popup -->
   </form>
  </div><!-- b_shadow -->