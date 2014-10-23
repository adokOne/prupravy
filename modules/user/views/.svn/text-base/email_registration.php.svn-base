<?php $lang = Kohana::lang('email'); ?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $lang['title'] ?></title>
  <meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
</head>
<body style="font: 12px/150% Arial;color: white;">
  <table style="width: 484px;margin: 30px auto;background: #053969;border-spacing: 0;border-collapse: collapse; border: none;">
    <tr>
      <td colspan="3"><img src="http://<?php echo Kohana::config('config.site_domain')?>/images/logo_big.jpg" alt="" /></td>
    </tr>
    <tr>
      <td style="width: 35px"></td>
      <td>
        <p style="font-size: 14px;margin: 20px 0;">
         <?php echo $lang['HI'] ?>, <?php echo $user->nick?>.<br />
          <?php echo $lang['thanks_for'] ?><br />
          <a href="http://<?php echo Kohana::config('config.site_domain')?>" style="color: white"><?php echo Kohana::config('config.sitename') ?></a>
        </p>
        <p style="font-size: 14px;margin: 20px 0;">
         <?php echo $lang['create_for_you'] ?>:
        </p>
        <p style="font-size: 14px;background: white; padding: 10px 20px; color: #053969;">
          <strong><?php echo $lang['login'] ?>:</strong> <?php echo $user->username ?><br />
          <strong><?php echo $lang['password'] ?>:</strong> <?php echo $pass ?>
        </p><!-- b_data -->
        <hr style="background: #446b8f; border: none; height: 1px; margin: 20px 0;" />
        <p>
          <?php echo $lang['text'] ?>.
        </p>
        <hr style="background: #446b8f; border: none; height: 1px; margin: 20px 0;" />
        <p style="margin: 20px 0;">
          <?php echo $lang['for_questions'] ?> <a href="#" style="color: white"><?php echo $lang['support'] ?></a>.
        </p>
      </td>
      <td style="width: 35px"></td>
    </tr>
    <tr>
      <td colspan="3" style="background: #42607C url(http://<?php echo Kohana::config('config.site_domain')?>/images/logo_small.jpg) no-repeat 0 0; padding:0 16px 0 116px; width: 484px; height: 93px;">
        Тут список никому не нужных копирайтов и правил использования материалов сайта со всеми втекающими подробностями что с вами будет, если вы им не последуете.
      </td>
    </tr>
  </table>
</body>
</html>