<?php include Kohana::find_file("views","header"); ?>
        <div class="flash">
            <img src="/img/kitchen.png" alt=""/>
        </div>
        
        <div id="content">
            
            <p class="slogan"><?php echo $lang["main_text"] ;?></p>
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