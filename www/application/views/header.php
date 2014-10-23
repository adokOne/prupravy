<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo Router::$site_title?></title>
<meta name="description" content="<?php echo Router::$site_description ?>">
<meta name="keywords" content="<?php echo Router::$site_description ?>">


<!--[if IE]>
  <script src='/js/pie/PIE.js'></script>
<![endif]-->
<?php echo stylesheet::render();?>
<?php echo javascript::render();?>

</head>
<?php #echo url::current();die;?>
<body>
    <div id="wrapper">
        <div id="header">
            <div class="logo">
                <a href="/"><img src="/img/logo.png" alt=""/></a>
                <?php foreach(Kohana::config("locale.languages") as $key => $lang_arr):?>
                <a  href="<?php echo $key == Kohana::config("multi_lang.default") ? ( Router::$current_language == $key ? "#" : "/".(url::current() == "main/index" ? "" : url::current())  ) : "/".$key."/".(url::current() == "main/index" ? "" : url::current()) ?>" class="lang <?php echo $lang_arr != end(array_reverse(Kohana::config("locale.languages"))) ? "right": ""; ?>  <?php echo Router::$current_language == $key ? "active" : ""?>"><?php echo $lang_arr[1] ?></a>
                <?php endforeach;?>
            </div>
            
            <ul class="nav_menu">
                <li><a class="<?php echo url::current() == "main/index" ? "active" : ""?>" href="/<?php echo Router::$current_language == Kohana::config("multi_lang.default") ? "" : Router::$current_language."/" ;?>"><?php echo $lang["menu"][0]?></a></li>
                <li><a class="<?php echo url::current() == "collection" ? "active" : ""?>" href="/<?php echo Router::$current_language == Kohana::config("multi_lang.default") ? "" : Router::$current_language."/" ;?>collection"><?php echo $lang["menu"][1]?></a></li>
                <li><a class="<?php echo url::current() == "recipes" ? "active" : ""?>" href="/<?php echo Router::$current_language == Kohana::config("multi_lang.default") ? "" : Router::$current_language."/" ;?>recipes"><?php echo $lang["menu"][2]?></a></li>
            </ul>
            
            <ul class="nav_menu2 right">
                <li><a class="<?php echo url::current() == "partners" ? "active" : ""?>" href="/<?php echo Router::$current_language == Kohana::config("multi_lang.default") ? "" : Router::$current_language."/" ;?>partners"><?php echo $lang["menu"][3]?></a></li>
                <li><a class="<?php echo url::current() == "contacts" ? "active" : ""?>" href="/<?php echo Router::$current_language == Kohana::config("multi_lang.default") ? "" : Router::$current_language."/" ;?>contacts"><?php echo $lang["menu"][4]?></a></li>
            </ul>
            
        </div><!--header-->