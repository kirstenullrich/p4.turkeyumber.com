<div>

    <h1 >Toggle button to follow or unfollow</h1>

    <?php foreach($users as $user): ?>

        <!-- Print this user's name -->
        <p ><?=$user['first_name']?> <?=$user['last_name']?>

            <!-- If there exists a connection with this user, show unfollow link -->
            <?php if(isset($connections[$user['user_id']])): ?>
                <a href='#'>Following</a>

            <!-- Otherwise, show the follow link -->
            <?php else: ?>
                <a href='#'>Not Following</a>
            <?php endif; ?>

        </p>
        <br><br>

    <?php endforeach; ?>

</div>