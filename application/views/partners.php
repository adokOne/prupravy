<?php include Kohana::find_file("views","header"); ?>
        <div id="content">
            <div class="container left">
                <div class="table_head">
                    <span class="sku"><?php echo $lang["sku"]?></span>  
                    <span class="weight"><?php echo $lang["vaga"]?></span>    
                    <span class="pack"><?php echo $lang["pack"]?></span>  
                    <span class="bar_code"><?php echo $lang["wcode"]?></span> 
                </div>
                    <div class="table">
                        <div class="table_top"></div>
                        <div class="middle">
                            <ul class="list left">
                                <?php foreach($collection as $product):?>
                                    <li><?php echo $product->name() ?></li>
                                 <?php endforeach;?>
                            </ul>
                        
                            <ul class="list2 left">
                                <?php foreach($collection as $product):?>
                                    <li><?php echo $product->weight." ".$lang["g"] ?>.</li>
                                 <?php endforeach;?>
                            </ul>
                            
                            <ul class="list3 left">
                                <li><?php echo $lang["pack_desc"]?></li>
                            </ul>
                            
                            <ul class="list4 left">
                                <?php foreach($collection as $product):?>
                                    <li><?php echo $product->code ?>.</li>
                                 <?php endforeach;?>
                            </ul>
                            <div class="clear"></div>
                        </div><!--middle-->
                    </div><!--table-->
                    <div class="table_bottom"></div>
                <a href="/main/load_price" class="load right"><?php echo $lang["download_price"]?></a>
            </div><!--container-->
            
            <div class="side right">
                <img src="/img/garlic.png" alt=""/>
            </div>
                <div class="clear"></div>
        </div><!--content-->
        
        <div id="partners_footer">
            
        </div><!--footеr-->
<?php include Kohana::find_file("views","footer"); ?>