
	<?php remove_action('wp_head','wp_generator'); ?>

	<footer>
		<div>
			<p>Dise&ntilde;ado por <a href="http://albertoblazquez.net" />Alberto Blazquez</a>, 2011</p>

			<ul>
			<li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li>

			<?php if(get_option('sa_twitter_user')!=""){ ?>
			<li><a href="https://twitter.com/<?php echo get_option('sa_twitter_user'); ?>" class="twitter" title="Twitter"><img src="<?php bloginfo('template_directory'); ?>/images/favicon/ico_twitter.png" alt="Twitter" /></a></li>
			<?php }?>

			<?php if(get_option('sa_facebook_link')!=""){ ?>
			<li><a href="<?php echo get_option('sa_facebook_link'); ?>" class="twitter" title="Facebook"><img src="<?php bloginfo('template_directory'); ?>/images/favicon/ico_facebook.png" alt="Facebook" /></a></li>
			<?php }?>

			<?php if(get_option('sa_flickr_link')!=""){ ?>
			<li><a href="<?php echo get_option('sa_flickr_link'); ?>" class="twitter" title="Flickr"><img src="<?php bloginfo('template_directory'); ?>/images/favicon/ico_flickr.png" alt="Flickr" /></a></li>
			<?php }?>

			<li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS" class="rss"><img src="<?php bloginfo('template_directory'); ?>/images/favicon/ico_rss.png" alt="Subcribe to Our RSS Feed" /></a></li>
			</ul>

		<div class="clear"></div>
		<div>
	</footer>	

</article>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.form.js"></script>

<!-- Launch FancyBox SlideShow -->
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

<!-- Google +1 Button -->
<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
</script>

<!-- AJAX call at Contact -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#contact').ajaxForm(function(data) {
			if (data==1) {
				$('#success').fadeIn("slow");
				$('#bademail').fadeOut("slow");
				$('#badserver').fadeOut("slow");
				$('#contact').resetForm();
			} else if (data==2) {
				$('#badserver').fadeIn("slow");
			} else if (data==3) {
				$('#bademail').fadeIn("slow");
			}
		});
	});
</script>

<?php if (get_option('sa_analytics') <> "") { 
		echo stripslashes(stripslashes(get_option('sa_analytics'))); 
} ?>


<?php wp_footer(); ?>

</body>
</html>


