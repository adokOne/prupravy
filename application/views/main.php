<?php include Kohana::find_file("views","header"); ?>
        <div style="z-index: 3500;position: relative;"  class="flash">


<object style="display: block;margin: 0 auto;margin-top: -30px;" width="750" height="500">
<embed src="/swf/drawing.swf" width="750" height="500" wmode="transparent"></embed>
<param name="wmode" value="opaque" /> 
</object> 
</div>
        
        <div style="z-index: 4000; "id="content">
            
            <p style="z-index: 5000;" class="slogan"><?php echo $lang["main_text"] ;?></p>
                <p class="explain">
                    <?php echo $lang["main_explain"]?> 
                </p>
                
            <div class="advantage">
                <h3><?php echo $lang["advantage"]?></h3>
                    
                    <ul>
                        <?php foreach($lang["main_desc"] as $h=>$v):?>
                            <li><strong><?php echo $h?></strong><br>
                                <?php echo $v?>
                            </li>
                        <?php endforeach;?>
                    </ul>
            
            </div>
        </div><!--content-->
        
        <div id="footer">
            <img src="/img/vegetables.png" alt=""/>
        </div><!--footеr-->
<?php include Kohana::find_file("views","footer"); ?>

