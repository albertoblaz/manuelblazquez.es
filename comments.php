<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h2 class="h2comments"><?php comments_number('No Comments', '1 Comment', '% Comments' );?></h2>

	<ul class="commentlist">
	<?php wp_list_comments('callback=mytheme_comment'); ?>
	</ul>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h2 id="commentsForm"><?php comment_form_title( 'Leave a comment', 'Leave a comment to %s' ); ?></h2>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>


<p id="success" class="successmsg" style="display:none;">Your email has been sent! Thank you!</p>
<p id="bademail" class="errormsg" style="display:none;">Please enter your name, a message and a valid email address.</p>
<p id="badserver" class="errormsg" style="display:none;">Your email failed. Try again later.</p>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

<?php else : ?>

	<div>
		<div id="div_input">
			<label for="author">Name </label>
			<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" />
		</div>
		<div id="div_input_center">
			<label for="email">Email </label>
			<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" />
		</div>
		<div id="div_input">
			<label for="website">Website (optional)</label>
			<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
		</div>
	</div>

<?php endif; ?>

	<div id="message">
		<label for="comment" style=" ">Comment </label>
		<textarea id="commentinput" name="comment"></textarea><br>
		<input type="submit" id="submitinput" name="submit" class="submit" value="Send Message">
	</div>

</form>


<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
