<div class="contentwrap clearfix">

    <div id="dash">
        <div id="top">
            <h1>Everybody's Trips</h1>
        </div>
    </div>
    <?php if (!empty($trips)): ?>

        <?php foreach($trips as $trip): ?>

            <div id="entry_list">

        <article >

                <a href="trips/dashboard/<?=$trip['trip_id']?>"><h1><?=$trip['title']?></h1></a>

                <h2>
                    <?=Time::display($trip['created'])?>
                </h2>
                
                <p>
                    <?=$trip['description']?>
                </p>

                <p class="posted">
                    Posted by <?=$trip['first_name']?> <?=$trip['last_name']?>
                </p>


                <?php if(isset($star[$trip['trip_id']])): ?>

                    <aside class="starlink"><a href="/trips/unstar/<?=$trip['trip_id']?>"> | Unstar</a></aside>

                    <?php foreach($stars as $totalstars):?>

                        <?php if ($totalstars['trip_id'] == $trip['trip_id']): ?>

                            <aside class="star"> <?=$totalstars['total']?></aside>

                        <?php endif; ?>

                    <?php endforeach; ?>


                <?php else: ?>

                    <aside class="starlink"><a href="/trips/star/<?=$trip['trip_id']?>">Star this</a></aside>

                    <?php foreach($stars as $totalstars):?>

                        <?php if ($totalstars['trip_id'] == $trip['trip_id']): ?>

                            <aside class="star"><?=$totalstars['total']?></aside>

                        <?php endif; ?>

                    <?php endforeach; ?>


                <?php endif; ?>


              </article>
              
            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p >No favorites.</p>

    <?php endif; ?>


<br>
</div>
