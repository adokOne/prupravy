<div id="fancybox-wrap" style="left:23%">
<div id="fancybox-outer">

<div id="fancybox-content">

           <div id="recipe">
                <div class="recipe_cont">
                    <img src="/upload/recepies/<?php echo $recept->id?>/rec_big.jpg" alt="<?php echo $recept->name()?>"/>
                    <h5><?php echo $recept->name()?></h5>
                        <p><?php echo $recept->consist()?></p>
                        <p class="formula strong"><?php echo $lang["prepare"]?></p>
                        <p><?php echo $recept->prepare()?></p>
                        <p class="strong"><?php echo $lang["sma4"]?></p>
                </div>
            </div>
</div>
<a id="fancybox-close" style="display: inline;"></a>
</div>
</div>