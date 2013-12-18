<div>

    <?php foreach($trips as $trip): ?>

    <article>

        <h1><?=$trip->title?></h1>

        <p><?=$trip['desc']?></p>

        <p>Posted by <?=$user->first_name?> <?=$user->last_name?></p>

        <time datetime="<?=Time::display($trip['created'],'Y-m-d G:i')?>"  >
            <?=Time::display($trip['created'])?>
        </time>

    </article>

    <?php endforeach; ?>

</div>