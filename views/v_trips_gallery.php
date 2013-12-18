<div class="contentwrap clearfix">
        <div id="dash">
        <div id="top">
            <h1><?=$title;?></h1>
            <a href="../../dashboard/<?=$trip_id;?>">Back</a>
        </div>
    </div>


        <?php foreach($gallery as $picture): ?>

            <div id="entry_list">
                <div class="img">
                    <img src="/../slir/w580-h580/uploads/entries/<?=$picture['img'];?>"/>
                </div>
                <p>
                    <?=$picture['caption']?>                
                </p>

            </div>
        <?php endforeach; ?>



</div>