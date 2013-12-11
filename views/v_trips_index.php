<div>

    <?php if (!empty($trips)): ?>

        <?php foreach($trips as $trip): ?>

        <article >

            <div>

                <h1><?=$trip['title']?></h1>
<h2><?php echo $tripObj->trip_id;?></h2>
                <p><?=$trip['description']?></p>

                <p>Posted by <?=$trip['first_name']?> <?=$trip['last_name']?></p>

                <time datetime="<?=Time::display($trip['created'],'Y-m-d G:i')?>"  >
                    <?=Time::display($trip['created'])?>
                </time>

                 <a href="trips/dashboard/<?=$trip['trip_id']?>">See details</a>
            </div>

        </article>


            
                <?php if(isset($star[$trip['trip_id']])): ?>

                    <?php foreach($stars as $totalstars):?>

                        <?php if ($totalstars['trip_id'] == $trip['trip_id']): ?>

                            <aside> <?=$totalstars['total']?> stars.</aside>

                        <?php endif; ?>

                    <?php endforeach; ?>

                    <aside><a href="/trips/unstar/<?=$trip['trip_id']?>">Unstar</a></aside>

                <?php else: ?>

                    <?php foreach($stars as $totalstars):?>

                        <?php if ($totalstars['trip_id'] == $trip['trip_id']): ?>

                            <aside ><?=$totalstars['total']?> stars.</aside>

                        <?php endif; ?>

                    <?php endforeach; ?>

                    <aside><a href="/trips/star/<?=$trip['trip_id']?>">Star this</a></aside>

                <?php endif; ?>

              </article>

        <?php endforeach; ?>

    <?php else: ?>

        <p >No favorites.</p>

    <?php endif; ?>


<?php print_r($here['state']);?>
<br>

</div>