<div >
	<p>Add your trip name and a brief decription (this is what everyone else sees first).</p>
	<form action="/trips/p_add" method="POST">

		<label for="title">Title of your trip</label>
			<input type='text' name="title" required placeholder="Trip title"><br>

		<label for="description">Description</label>
			<textarea autofocus="autofocus" name="description"></textarea>
		
		<input type="submit" value="Add Trip">

	</form>

</div>