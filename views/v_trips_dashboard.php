        <div class="contentwrap clearfix">
            <div id="dash">
                <div id="top">
                    <aside class="newentry">New Entry</aside>
                    <aside class="miles">000855</aside>
                    <h1><?=$thistrip['title'];?></h1><br>
                    <h2>Dates</h2>
                </div>
                <div id="map">
                    <div class="state vt"></div>
                    <div class="state ny"></div>
                    <img src="/../images/map_bg.png" height="330" width="500" alt="US map"/>
                </div>
            </div>



<!-- ADD NEW ENTRY -->
            <article id="add_entry" class="entry">
                <aside class="expand"><img src="images/toggle_on.png"></aside>
                <h1 class="big">New Entry</h1><br><br>

                <form class="add_entry" action="/trips/p_newentry/<?=$trip_id;?>" method="POST">
                    <h1>Title</h1><br>
					<input type='text' name="title" required placeholder="ex. Bathroom break"><br><br>

			        <?php if(isset($error) && $error == 'blank'): ?>
			            <p class='error'>
			                This field is required.<br>
			            </p>
			        <?php endif; ?>
                        <h1>Entry text</h1><br>
                        <textarea name="text"></textarea>

			        <input type="submit" value="Submit">
                </form>
            </article>

	<!--	Need PHP if statement for whether this entry is being added in real time or not; if not, display this list

					<label for="state">State</label>
						<select name="state">
							<option value="AL">Alabama</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
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




<!-- LIST OF EXISTING ENTRIES -->


    <?php if (!empty($entries)): ?>

        <?php foreach($entries as $entry): ?>

            <div id="entry_list">

            	<article class="existing">

	                <aside class="expand"><img src="images/toggle_on.png"></aside>

	                <h1><?=$entry['title']?></h1> 

	                <h2>
	                    <?=Time::display($entry['created']);?> | <?=$entry['city'];?>, <?=$entry['state']?>
	                </h2>


	                <p><?=$entry['text']?></p>


		            <?php if($gallery['0']['the_entry_id'] == $entry['entry_id']): ?>

                		<a href="#" class="link" >Click to view gallery images</a>
							<a rel="gallery" href="../../images/fpo.jpg"></a>
							<a rel="gallery" href="../../uploads/entries/<?=$gallery['0']['img']?>"></a>

		                <div class="display-none">

		                <?php foreach($gallery as $picture): ?>
							<a rel="gallery<?=$entry['entry_id'];?>" href="../../uploads/entries/<?=$picture['img']?>"></a>
						 <?php endforeach; ?>

						</div>

						

		            <?php endif; ?>


		        </article>



	            <?php if($entry['user_id'] == $user->user_id): ?>

	            	<a class="modify" href="#" id="<?=$entry['entry_id']?>">Modify this entry</a>

	           	<?php endif; ?>



            	<div class="mod_entry_wrap" id="<?=$entry['entry_id']?>">
            		<br>

	            	<?php if($entry['user_id'] == $user->user_id): ?>

						<form class="mod_entry" action="/trips/p_modify/<?php echo $entry['entry_id']; ?>/<?=$trip_id;?>" method="POST">
							<h1>Title</h1><br><br>
							<input type='text' name="title" required value='<?php if(isset($entry['title'])) echo $entry['title']?>'><br>
							<textarea name="text"> <?php if(isset($entry['text'])) echo $entry['text']?> </textarea><br>
							<input type="submit" value="Submit">
						</form>


					    <form class="mod_entry" method='POST' enctype="multipart/form-data" action='/trips/addimage/<?php echo $entry['entry_id']; ?>/<?=$trip_id;?>'>
							<h1>Picture</h1><br>
							<input type='file' name='img'><br>
							<input type='submit' value='Add'>
						</form>

							<?php if(isset($error) && $error == 'invalid'):?>
					            <p class='error'>
					                Invalid file type. Please upload a JPG, PNG, or GIF file.<br>
					            </p>
					        <?php endif; ?>

					        <?php if(isset($error) && $error == 'process'):?>
					            <p class="error">
					            There has been a problem processing your image! Please try again.
					            </p>
					        <?php endif;?>

	                <?php endif; ?>

				</div><!--end #modify-->

        	</div><!--end #entry_list-->

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<script>

						    var $gallery = $("a[rel=gallery").colorbox();
							$("a.link").click(function(e){
							    e.preventDefault();
							    $gallery.eq(0).click();
							});

						</script>