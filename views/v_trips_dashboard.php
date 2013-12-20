        <div class="contentwrap clearfix">
            <div id="dash">
                <div id="top">
                    <aside class="newentry">New Entry</aside>
                    <aside class="miles">000855</aside>
                    <h1><?=$thistrip['title'];?></h1><br>
                    <h2>Dates</h2>
                </div>
                <div id="map">
                	<?php foreach($dashmap as $mapstate): ?>

                    	<div class="<?=$mapstate['state'];?> state"></div>

                    <?php endforeach; ?>

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



<!-- LIST OF EXISTING ENTRIES -->


    <?php if (!empty($entries)): ?>

        <?php foreach($entries as $entry): ?>

            <div id="entry_list">

            	<article class="existing">

	                <h1><?=$entry['title']?></h1> 
    					<?php if (!empty($comments)): ?>
                            <img id="comments_<?=$entry['entry_id'];?>" class="comments" src="/../images/comments.png"/>
                        <?php endif; ?>

                        <?php if($entry['pic_id'] == '1'): ?>
                            <a id="pic_<?=$entry['entry_id'];?>" href="../gallery/<?=$entry['entry_id'];?>/<?=$trip_id;?>" class="pic"><img src="/../images/pic.png"/></a>
                        <?php endif; ?>

    					<?php if (!empty($entry['text'])): ?>
                            <img id="text_<?=$entry['entry_id'];?>" class="text" src="/../images/text.png"/>
                        <?php endif; ?>

	                <h2>
	                    <?=Time::display($entry['created']);?> | <?=$entry['city'];?>, <?=$entry['state']?>
	                </h2>

	                <div id="textwrap_<?=$entry['entry_id'];?>" class="display-none">
	                	<p><?=$entry['text']?></p>
	            	</div>

		        </article>


		        <script>
					$('#text_<?=$entry['entry_id'];?>').click(function() {
						$('#textwrap_<?=$entry['entry_id'];?>').toggle();
					});

		        </script>



	            <?php if($entry['user_id'] == $user->user_id): ?>

	            	<p class="modify" id="<?=$entry['entry_id']?>">Modify this entry</p>

	           	<?php endif; ?>

	           	   <p class="addcomment">Comment on this entry</p>


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
							<input type='text' name="caption" ><br>
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

	    	<!-- SHOW COMMENTS -->
    	    <?php if (!empty($comments)): ?>

    	    	<aside id="commentswrap_<?=$entry['entry_id'];?>" class="display-none commentlist">
                	<h1>Comments</h1>
                	<?php if($comments[0]['entry_id'] == $entry['entry_id']): ?>
                		<p><?=$comments[0]['content'];?></p>
                	<?php endif; ?>
                </aside>

                <script>
					$('#comments_<?=$entry['entry_id'];?>').click(function() {
						$('#commentswrap_<?=$entry['entry_id'];?>').toggle();
					});
                </script>

            <?php endif; ?>


			<!-- ADD COMMENT -->
				<div class="commentform">
	                <h1>Add a Comment</h1><br><br>

	                <form class="add_entry" action="/trips/addcomment/<?=$entry['entry_id'];?>/<?=$trip_id;?>" method="POST">
						<textarea name="content" required placeholder="Write a comment!"></textarea><br>

				        <?php if(isset($missing)):?>
				            <p class='red error'>
				                Sorry, no blank entries.<br>
				            </p>
				        <?php endif; ?>

				        <input type="submit" value="Submit">
	                </form>
	            </div>


	        	</div><!--end #entry_list-->




        	</div><!--end #entry_list-->



        <?php endforeach; ?>

    <?php endif; ?>

</div>

