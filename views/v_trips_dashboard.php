<div class="contentwrap clearfix">

			<!-- TOP DASHBOARD WITH MAP -->

            <div id="dash">

                <div id="top">
                    <aside class="newentry">New Entry</aside>
                    <h1><?=$thistrip['title'];?></h1><br>
                    <h2><?=Time::display($start[0]['created']);?> to <?=Time::display($last[0]['created']);?></h2>
                </div>

                <div id="map">
                	<?php foreach($dashmap as $mapstate): ?>

                    	<div class="<?=$mapstate['state'];?> state"></div>

                    <?php endforeach; ?>

                    <img src="/../images/map_bg.png" height="330" width="500" alt="US map"/>
                </div>

            </div> <!--end dash -->



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
    					<?php if (!empty($comments[0]['entry_id']) && $comments[0]['entry_id'] == $entry['entry_id']): ?>
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


				<!-- SHOW/HIDE ENTRY TEXT -->

		        <script>
					$('#text_<?=$entry['entry_id'];?>').click(function() {
						$('#textwrap_<?=$entry['entry_id'];?>').toggle();
					});

		        </script>



				<!-- MODIFY ENTRY LINK-->

	            <?php if($entry['user_id'] == $user->user_id): ?>

	            	<p class="modify" id="<?=$entry['entry_id']?>">Modify this entry or add media</p>

	           	<?php endif; ?>


				<!-- MODIFY FORM-->

            	<div class="mod_entry_wrap" id="<?=$entry['entry_id']?>">
            		<br>

	            	<?php if($entry['user_id'] == $user->user_id): ?>

	            	<div class="commentlist">
						<form class="mod_entry" action="/trips/p_modify/<?php echo $entry['entry_id']; ?>/<?=$trip_id;?>" method="POST">
							<h1>Title</h1><br><br>
							<input type='text' name="title" required value='<?php if(isset($entry['title'])) echo $entry['title']?>'><br>
							<textarea name="text"> <?php if(isset($entry['text'])) echo $entry['text']?> </textarea><br>
							<input type="submit" value="Submit">
						</form>


					    <form class="mod_entry" method='POST' enctype="multipart/form-data" action='/trips/addimage/<?php echo $entry['entry_id']; ?>/<?=$trip_id;?>'>
							<h1>Picture</h1><br>
							<input type='file' name='img'><br>
							<h2>Caption</h2>
							<input type='text' name="caption" ><br>
							<input type='submit' value='Add'>
						</form>
					</div>
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

    	    	<aside id="commentswrap_<?=$entry['entry_id'];?>" class="commentlist display-none">
                	<h1>Comments</h1>
                	     <?php foreach($comments as $comment): ?>

		                	<?php if($comment['entry_id'] == $entry['entry_id']): ?>
		                	<h2>Posted <?=Time::display($comment['created']);?> by <?=$comment['first_name'];?> <?=$comment['last_name'];?></h2>
		                		<p><?=$comment['content'];?></p>
		                	<?php endif; ?>

                <script>
					$('#comments_<?=$entry['entry_id'];?>').click(function() {
						$('#commentswrap_<?=$entry['entry_id'];?>').toggle();
					});
                </script>

        				<?php endforeach; ?>
                </aside>

	           	   <p class="addcomment" id="addcomment_<?=$entry['entry_id'];?>">Comment on this entry</p>


			<!-- ADD COMMENT LINK-->

			<script>
			$('#addcomment_<?=$entry['entry_id'];?>').click(function() {
				$('#commentform_<?=$entry['entry_id'];?>').toggle();
				return false;
			});
			</script>


			<!-- ADD COMMENT -->
				<div class="commentform" id="commentform_<?=$entry['entry_id'];?>">
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

	     	</div>

        <?php endforeach; ?>

    <?php endif; ?>
    </div><!--end #entry_list-->

</div>

