<div >
	<form action="/trips/p_modify" method="POST">
<?php echo $entry_info; ?>		

	<label for="title">Title for this check-in</label>
			<input type='text' name="title" required placeholder="ex. Bathroom break"><br>

        <?php if(isset($error) && $error == 'blank'): ?>
            <p class='error'>
                This field is required.<br>
            </p>
        <?php endif; ?>

<!--

		<label for="text">Write something</label>
			<textarea autofocus="autofocus" name="text"></textarea>
-->
		<input type="submit" value="Submit">

	</form>

	<h1>Picture</h1>

    <form method='POST' enctype="multipart/form-data" action='/trips/addimage/'>

		<input type='file' name='image'><br>

		<input type='submit' value='Add'>

        <?php if(isset($error) && $error == 'invalid'): ?>
            <p class='error'>
                Invalid file type. Please upload a JPG, PNG, or GIF file.<br>
            </p>
        <?php endif; ?>

        <?php if(isset($error) && $error == 'process'):?>
            <p class="error">
            There has been a problem processing you image! Please try again.
            </p>
        <?php endif;?>
</div>