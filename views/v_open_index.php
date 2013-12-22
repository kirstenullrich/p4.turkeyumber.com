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

                <a href="dashboard/<?=$trip['trip_id']?>"><h1><?=$trip['title']?></h1></a>

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

                    <?php foreach($stars as $totalstars):?>

                        <?php if ($totalstars['trip_id'] == $trip['trip_id']): ?>

                            <aside class="star"> <?=$totalstars['total']?> stars.</aside>

                        <?php endif; ?>

                    <?php endforeach; ?>


                <?php else: ?>

                    <?php foreach($stars as $totalstars):?>

                        <?php if ($totalstars['trip_id'] == $trip['trip_id']): ?>

                            <aside  class="star"><?=$totalstars['total']?> stars.</aside>

                        <?php endif; ?>

                    <?php endforeach; ?>


                <?php endif; ?>


              </article>
              
            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>
