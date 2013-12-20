<div class="contentwrap clearfix">

    <div id="dash">
        <div id="top">
            <h1>Your Starred Trips</h1>
        </div>
    </div>
    <?php if (!empty($starred)): ?>

        <?php foreach($starred as $trip): ?>

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

                    <aside class="star"><a href="/trips/unstar/<?=$trip['trip_id']?>">Unstar</a></aside>

                

                <?php endif; ?>


              </article>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p >You haven't starred any trips.</p>

    <?php endif; ?>


<br>
</div>
