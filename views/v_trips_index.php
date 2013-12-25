<div class="contentwrap clearfix">

    <div id="dash">
        <div id="top">
            <h1>Everybody's Trips</h1>
        </div>
    </div><!--end dash -->


    <?php if (!empty($trips)): ?>

        <?php foreach($trips as $trip): ?>

        <div class="entry_list">

            <article >
                <a href="http://p4.turkeyumber.com/trips/dashboard/<?=$trip['trip_id']?>">
                <div class="cover">
                    <?php if(($trip['coverimg']) == "fpo.jpg"): ?>
                        <img class="cover" height="100" width="100" src="/../uploads/avatars/fpo.jpg" alt="Trip cover image not set"/>
                    <?php else: ?>
                       <img class="cover" height="100" width="100" src="/../uploads/avatars/<?=$trip['coverimg'];?>" alt="Trip cover image"/>
                    <?php endif; ?>
                    <?php if($trip['trip_user_id'] == $user->user_id): ?>
                        <p>
                            <a href="trips/coverimage/<?=$trip['trip_id']?>">Set cover image</a>
                        </p>
                    <?php endif; ?>     
                </div>
                </a>

                <a href="http://p4.turkeyumber.com/trips/dashboard/<?=$trip['trip_id']?>"><h1><?=$trip['title']?></h1></a>

                <h2>
                    <?=Time::display($trip['created'])?>
                </h2>
                <p>
                    <?=$trip['description']?>
                </p>

                <p class="posted">
                    Posted by <?=$trip['first_name']?> <?=$trip['last_name']?>
                </p>


                <!--STAR/UNSTAR -->

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

                <!--END STAR/UNSTAR -->



              </article>
              
            </div> <!--end entry_list -->


        <?php endforeach; ?>

    <?php else: ?>

        <p ></p>

    <?php endif; ?>

</div> <!--end contentwrap -->
