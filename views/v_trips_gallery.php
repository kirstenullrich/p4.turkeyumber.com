<div class="contentwrap clearfix">
        <div id="dash">
        <div id="top">
            <h1><?=$title;?></h1>
        </div>
    </div>

            <a href="../../dashboard/<?=$trip_id;?>">Back</a>

        <?php foreach($gallery as $picture): ?>

            <div id="entry_list">

                <div class="img">
                    <img src="/../uploads/entries/<?=$picture['img'];?>"/>
                </div>
                <p>
                    <?=$picture['caption']?>                
                </p>

            </div>
        <?php endforeach; ?>



</div>