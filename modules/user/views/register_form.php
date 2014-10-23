<?php include Kohana::find_file('views','header'); ?>
      <form action="/register" data-auto-controller="RegisterController" method="post" >
	       <div class="register_page">
	          <h3><?php echo $lang['registration']?></h3>
	        <ul style="float: left;" class="form_list">

	          <li>
	            <div class="b_left">
	             <label><?php echo $lang['fio']?></label>
	             <input autocomplete="off" name="username"  type="text" class="form-text without_numbers" value=""  required="required" />
	             <div class="b_error"><?php echo $lang['fill_input']?></div><!-- b_error -->
	            </div><!-- b_left -->
	            <div class="b_left">
	             <label><?php echo $lang['nick']?></label>
	             <input autocomplete="off" name="nick" type="text" class="form-text" value="" required="required" />
	             <div class="b_error"><?php echo $lang['fill_input']?></div><!-- b_error -->
	            </div><!-- b_left -->
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
	            <label>E-mail</label>
	            <input autocomplete="off" name="email" type="email" class="form-text wihout_spaces " value="" required="required"/>
	            <div class="b_error"><?php echo $lang['enter_email']?></div><!-- b_error -->
	          </li>
	          <li>
	            <label><?php echo $lang['about']?></label>
	            <textarea name="about"  class="form-textarea"></textarea>
	          </li>
	          <li>
	            <div class="b_left">
	              <label><?php echo $lang['add_avatar']?></label>
	              <div  class="b_photo">
	              	<img src="/upload/" width="100" height="100" />
	              </div><!-- b_photo -->
	            </div><!-- b_left -->
	            <a href="#"  id="btn_upload" class="btn_upload"><?php echo $lang['dropp_avatar']?></a>
	          </li>
	          <li>
	            <input type="hidden" value="" name="image_name" id="image_name" />
	            <input type="hidden" value="<?php echo $token?>" name="token"  />
	            <input type="submit" class="form-submit" value="<?php echo $lang['registration']?>" />
	          </li>
	        </ul>
	        <div class="b_rules"  >
	        	<a class=""><?php echo $lang["rules"]?></a>
<ol class="list" style="display: block; ">
                        	<li>Фото должны быть сделаны Вами. Если фото сделано другим человеком, Вы должны быть уверены в том, что автор не против его публикации. В таком случае укажите имя автора фото или просто уведомьте в комментарии, что Вы не являетесь автором снимка, если авторство установить не удалось. Такие фото могут быть приняты редакторами сайта, но с определенными оговорками.</li>
                        	<li>В случае выявления фактов незаконной публикации либо самовольного присвоения авторства фотографий, все эти снимки будут незамедлительно удалены из базы. Загружать можно: снимки любых летательных аппаратов, снимки с воздуха, аэропорты/аэродромы.</li>
                        	<li>В кадре обязательно должны присутствовать летательный аппарат либо его часть (крыло, двигатель, кабина и т.п.) и/или аэродром - это особенно касается съемки видов с воздуха. Фото, не попавшие ни в одну из указанных категорий, в базу добавляться не будут.</li>
                        	<li>Принимаются фото размером не менее 1000 и не более 1600 пикселей по длинной стороне, в стандартных пропорциях кадра от 3:2 до 4:3. В виде исключения принимаются фото и в нестандартных пропорциях, если это резонно с точки зрения композиции кадра.</li>
                        	<li>Снимки должны быть оригинальными, манипулирование содержимым недопустимо. Грамотная обработка фото приветствуется: Вы можете улучшить/откорректировать цвет, контраст, насыщенность, по-иному скадрировать, убрать пыль и мелкие дефекты, не изменяя содержимого. На сайте введена система предпросмотра фотографий (скрининг), подобно airliners.net или jetphotos.net. Все фото проходят предварительный просмотр редакторами (скринерами) перед добавлением в базу. О результатах Вы будете уведомлены автоматическим сообщением на адрес, указанный при загрузке фото.</li>
                        	<li>Список критериев оценки фото Внимательно заполняйте данные: тип, модификацию, регистрационный и серийный номера. Имеет смысл использовать для этого данные c сайтов, подобных airliners.net.</li>
                        	<li>Имя и E-mail - Ваши идентификаторы. E-mail ни при каких условиях не будет виден нигде в списках фото, поэтому не стоит опасаться попадания адресов к спамерам. Обратная связь с Вами осуществляется через формы, доступные по кнопке "Написать". Имя должно быть написано латиницей.</li>
                        	<li>Старые снимки, фото интересных, редких и значительных событий публикуйте, не задумваясь, в любом качестве. Снимки рядовых самолетов в рядовых обстоятельствах, пожалуйста, тщательно отбирайте, по возможности, избегая похожих кадров. Ответственность за размещение фотографий на сайте несете Вы.</li>
                        	<li>Сайт не претендует на авторские права и не несет ответственности за фото и текстовую информацию. Пользователь в течении недели имеет правно отказаться от загруженных фотографий, и адмиинистрация обязана их удалить с сайта. В случае если фото находятся на сайте больше одной календарной недели, пользователь не может удалить их с сайта, однако права на фото остаются за собственником фото. Пожалуйста, прочитайте этот раздел перед загрузкой фото.</li>
                        </ol>
	        </div>
	        </div><!-- end register_page -->
        </form>
        <div class="cc"></div>
        <div class="b_empty"></div>
<?php include Kohana::find_file('views','footer'); ?>