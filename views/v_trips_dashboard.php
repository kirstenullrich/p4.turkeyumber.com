<div class="contentwrap clearfix">

			<!-- TOP DASHBOARD WITH MAP -->

	<div id="dash">

		<div id="top">
			<aside class="miles invisible">XMILES</aside>
			<aside class="newentry">New Entry</aside>
			<h1><?=$thistrip['title'];?></h1><br>
				<?php if(!empty($start[0]['created'])): ?>
					<h2> <?=Time::display($start[0]['created']);?>
					<?php if(!empty($last[0]['created']) && ($last[0]['created'] !== $start[0]['created'])): ?>
					to <?=Time::display($last[0]['created']);?>
					<?php endif; ?>
					</h2>
				<?php endif; ?>
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
		<h1 class="big">New Entry</h1><br><br>
		<form class="add_entry" action="/trips/p_newentry/<?=$trip_id;?>" method="POST">
			<h1>Title</h1><br><br>
			<input type='text' name="title" required placeholder="ex. Bathroom break"><br><br>

				<?php if(isset($error) && $error == 'blank'): ?>
					<p class='error'>
					This field is required.<br>
					</p>
				<?php endif; ?>
                     
			<h1>Entry text</h1><br><br>
			<textarea name="text"></textarea>
			<input type="submit" value="Submit">
		</form>
	</article>



	<!-- LIST OF EXISTING ENTRIES -->

	<?php if (!empty($entries)): ?>

		<?php foreach($entries as $entry): ?>

			<div class="entry_list">

				<article class="existing_<?=$entry['entry_id'];?> existing">


						<?php if($entry['pic_id'] == '1'): ?>
							<a id="pic_<?=$entry['entry_id'];?>" href="../gallery/<?=$entry['entry_id'];?>/<?=$trip_id;?>" class="pic"><img src="/../images/pic.png" alt="icon showing that there are pictures associated with this entry"/></a>
						<?php endif; ?>

						<?php if (!empty($entry['text'])): ?>
							<img id="text_<?=$entry['entry_id'];?>" class="text" src="/../images/text.png" alt="icon showing that there is text associated with this entry"/>
						<?php endif; ?>

					<h1><?=$entry['title']?></h1> 

					<h2>
						<?=Time::display($entry['created']);?> | <?=$entry['city'];?>, <?=$entry['state']?>
					</h2>

					<div id="textwrap_<?=$entry['entry_id'];?>">
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

					<p id="modify_<?=$entry['entry_id'];?>" class=" modify">Modify this entry or add media</p>

				<?php endif; ?>


				<!-- MODIFY FORM-->

				<div class="mod_entry_wrap display-none mod_entry_wrap_<?=$entry['entry_id'];?>">
					<br>

					<?php if($entry['user_id'] == $user->user_id): ?>

					<div class="commentlist">
						<form class="mod_entry" action="/trips/p_modify/<?php echo $entry['entry_id']; ?>/<?=$trip_id;?>" method="POST">
							<h1>Entry</h1><br><br>
							<h2>Title</h2><br><br>
							<input type='text' name="title" required><br>
							<h2>Text</h2><br><br>
							<textarea name="text"> <?php if(isset($entry['text'])) echo $entry['text']?> </textarea>
							<input type="submit" value="Submit">
						</form>


						<form class="mod_entry" method='POST' enctype="multipart/form-data" action='/trips/addimage/<?php echo $entry['entry_id']; ?>/<?=$trip_id;?>'>
							<h1>Picture</h1><br><br>
							<input type='file' name='img'><br><br>
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

				<aside id="commentswrap_<?=$entry['entry_id'];?>" class="commentlist">
					<h1>Comments</h1>

						<?php foreach($comments as $comment): ?>

							<?php if(!empty($comments) && $comment['entry_id'] == $entry['entry_id']): ?>
							<h2>Posted <?=Time::display($comment['created']);?> by <?=$comment['first_name'];?> <?=$comment['last_name'];?></h2>
								<p><?=$comment['content'];?></p>
							<?php endif; ?>

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

			<script>
				$('#modify_<?=$entry['entry_id'];?>').click(function() {
					//console.log('modify clicked');
					$(".mod_entry_wrap_<?=$entry['entry_id'];?>").toggle();
					$(".existing_<?=$entry['entry_id'];?>").toggle();
					return false;
				});
			</script>

		<?php endforeach; ?>

	<?php endif; ?>
	</div><!--end .entry_list-->


