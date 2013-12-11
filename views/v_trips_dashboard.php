<p>Dashboard</p>

<div>

    <?php if (!empty($entries)): ?>

        <?php foreach($entries as $entry): ?>

        <article >

            <div>

                <h1><?=$entry['title']?></h1>

                <time datetime="<?=Time::display($entry['created'],'Y-m-d G:i')?>"  >
                    <?=Time::display($entry['created'])?>
                </time>

                <p><?=$entry['text']?></p>

            </div>

            <?php if($entry['user_id'] == $user->user_id): ?>


                    <a href="#">Modify this entry</a>

                <?php endif; ?>

        </article>

            
        <?php endforeach; ?>

  

    <?php endif; ?>

</div>