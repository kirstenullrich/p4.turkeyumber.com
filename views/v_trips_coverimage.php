<div class="contentwrap clearfix">
 
	<div id="dash">
		<div id="top">
			<h1><?=$trips['title']?> Cover Image</h1>
		</div>
	</div>

	<a href="http://p4.turkeyumber.com/trips">Back</a>


	<div class="entry_list">

		<img src="/uploads/avatars/<?=$trips['coverimg'];?>" alt="<?=$trips['coverimg'];?>Choose a cover image!"> <br><br>  

		<h1>Profile Picture</h1><br>
		<p>Please choose a JPG, GIF, or PNG less than 800 x 800 pixels in size.</p>

		<form class="otherform" method='POST' enctype="multipart/form-data" action='/trips/p_coverimage/<?=$trip_id;?>'>

			<input type='file' name='coverimg'><br>

			<?php if (($trips['coverimg']) == "fpo.jpg"): ?>

				<input type='submit' value='Set it!'>
			
			<?php else:?>

				<input type='submit' value='Change it!'>

			<?php endif; ?>

		</form>

		<?php if(isset($error)): ?>

			<div class='error'>
				Please upload a JPG, GIF, or PNG that is less than 800 x 800 pixels.
			</div>
			<br>

		<?php endif; ?>
	</div>
</div>

