<div>

    <?php if (!empty($trips)): ?>

        <?php foreach($trips as $trip): ?>

        <article >

            <div>

                <h1><?=$trip['title']?></h1>

                <p><?=$trip['description']?></p>

                <p>Posted by <?=$user->first_name?> <?=$user->last_name?></p>

                <time datetime="<?=Time::display($trip['created'],'Y-m-d G:i')?>"  >
                    <?=Time::display($trip['created'])?>
                </time>

            </div>

        </article>

                <?php if($trip['trip_user_id'] == $user->user_id): ?>


                    <a href="/dashboard/<?=$trip['trip_id']?>">Modify this trip</a>

                <?php endif; ?>

            
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

</div>