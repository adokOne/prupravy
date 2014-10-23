<?php include Kohana::find_file("views","header"); ?>
        <div id="content">
            <div class="recipes left">
                <?php foreach($collection as $recept):?>
                    <div class="meal left">
                        <img src="/upload/recepies/<?php echo $recept->id?>/rec_small.jpg" alt="<?php echo $recept->name()?>"/>
                            <h5><?php echo $recept->name()?></h5>
                            <p><?php echo text::limit_chars($recept->consist(),80,"...")?></p>
                            <a href="/main/get_recept_desc/<?php echo $recept->id?>" class="more"><?php echo $lang["more"]?></a>
                    </div>
                <?php endforeach;?>               
            </div>
                    
            <div class="side right">
                <img src="/img/onion.png" alt=""/>
            </div>
            <div class="clear"></div>

        </div><!--content-->
        
        <div id="recipes_footer">
            <img src="/img/chicken.png" alt=""/>
        </div><!--collection_footer-->
<?php include Kohana::find_file("views","footer"); ?>