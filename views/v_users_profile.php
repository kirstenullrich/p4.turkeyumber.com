<div class="contentwrap clearfix">
    
    <h1>Your Profile</h1>
    <p>Full name: <?=$user->first_name?>&nbsp;<?=$user->last_name?><br>
    	Email address:&nbsp;<?=$user->email?></p>

	<?php if ($user->image == 'avatar.jpg'): ?>

		<p>Does this look like you? Upload your own image to personalize your profile.</p>

	<?php else:?>

		<p>Your profile picture:</p>

	<?php endif; ?>

	<img src="/uploads/avatars/<?= $user->image ?>" alt="<?=$user->first_name?>''s profile image' "> <br><br>  

	<h1>Profile Picture</h1>

    <form method='POST' enctype="multipart/form-data" action='/users/p_profile/'>

		<input type='file' name='image'><br>

		<?php if ($user->image == 'avatar.jpg'): ?>

			<input type='submit' value='Set it!'>
		
		<?php else:?>

			<input type='submit' value='Change it!'>

		<?php endif; ?>

	<form>

	<?php if(isset($error)): ?>

		<div class='error'>
			File type not recognized. Please upload a JPG, GIF, or PNG.
		</div>
		<br>

	<?php endif; ?>
	
</div>

