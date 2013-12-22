<div class="contentwrap clearfix">

	<div id="dash">
		<div id="top">
			<h1>Add a Trip</h1>
		<div>
	</div>

	<div class="entry_list">
		<p>Enter a trip name and a brief decription (this is what everyone else sees first).</p>
		<form class="otherform" action="/trips/p_add" method="POST">

			<label>Title of your trip<span class="red">*</span></label>
				<input type='text' name="title" width="600" required placeholder="Ex. From Boston to San Francisco"><br>

			<label>Description</label>
				<textarea autofocus="autofocus" name="description"></textarea><br>
			
			<input type="submit" value="Add Trip">

		</form>

			<?php if(isset($missing)): ?>
				<p class='red error'>
					Title is a required field.
				</p>
			<?php endif; ?>
	</div>
</div>