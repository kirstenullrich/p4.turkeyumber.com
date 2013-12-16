<div >
	<form action="/entries/p_add" method="POST">

		<label for="title">Title for this check-in</label>
			<input type='text' name="title" required placeholder="ex. Bathroom break"><br>

        <?php if(isset($error) && $error == 'blank'): ?>
            <p class='error'>
                This field is required.<br>
            </p>
        <?php endif; ?>

	<!--	Need PHP if statement for whether this entry is being added in real time or not; if not, display this list

		<label for="state">State</label>
			<select name="state">
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>	-->

		<label for="text">Write something</label>
			<textarea autofocus="autofocus" name="text"></textarea>

		<input type="submit" value="Submit">

	</form>
	<h1>Picture</h1>

    <form method='POST' enctype="multipart/form-data" action='/entries/addimage/'>

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