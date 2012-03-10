<?php
/* Auxiliary File called by the main file (page.php) just for taking the values from the theme panel and put an extra page with contact forms and data */
?>

<div id="colLeft">
	<?php echo stripslashes(stripslashes(get_option('sa_contact_text')))?>

	<p id="success" class="successmsg" style="display:none;">Your email has been sent! Thank you!</p>
	<p id="bademail" class="errormsg" style="display:none;">Please enter your name, a message and a valid email address.</p>
	<p id="badserver" class="errormsg" style="display:none;">Your email failed. Try again later.</p>

	<form id="contact" action="<?php bloginfo('template_url'); ?>/sendmail.php" method="post">
	<div>
		<div>
			<label for="name">Name </label>
			<input type="text" id="nameinput" name="name" value="">
		</div>
		<div id="div_input_center">
			<label for="email">Email </label>
			<input type="text" id="emailinput" name="email" value="">
		</div>
		<div>
			<label for="subject">Subject (optional)</label>
			<input type="text" id="subjectinput" name="subject" value="">
		</div>
		</div>
	<div id="message">
			<label for="comment">Message </label>
			<textarea id="commentinput" name="comment"></textarea><br>
			<input type="submit" id="submitinput" name="submit" class="submit" value="Send Message">
			<input type="hidden" id="receiver" name="receiver" value="<?php echo strhex(get_option('sa_contact_email'));?>" >
	</div>
	</form>
</div>

<div id="colRight">
	<?php echo stripslashes(stripslashes(get_option('sa_contact_lateral')))?>
</div>