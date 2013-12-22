<div class="contentwrap clearfix">
    <div id="dash">
        <div id="top">
            <h1><?=$title;?></h1>
        </div>
    </div>

    <a href="../../dashboard/<?=$trip_id;?>">Back</a>

    <?php foreach($gallery as $picture): ?>
        <div class="entry_list">
            <div class="img">
                <img src="/../uploads/entries/<?=$picture['img'];?>" alt="pictures associated with the entry titled <?=$title;?>"/>
                <br>
            </div>
        </div>
    <?php endforeach; ?>

</div>