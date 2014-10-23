<?php include Kohana::find_file("views","header"); ?>
<div id="content">
            <div class="collection">
                <ul>
                    <?php foreach($collection as $product):?>
                    <li>
                        <a href="/main/get_product_desc/<?php echo $product->id?>">
                            <img   src="/upload/products/<?php echo $product->id?>/pr_small.jpg" alt="<?php echo $product->name()?>"/>
                            <img src="/upload/products/<?php echo $product->id?>/pr_big.jpg" alt="" class="big"/>
                            <p class="sub"><?php echo $lang["main_text"]?></p>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
                <div class="clear"></div>
            </div>            
        </div><!--content-->
        <div id="collection_footer">
            <img src="/img/kitchen2.png" alt="">
        </div>
<?php include Kohana::find_file("views","footer"); ?>