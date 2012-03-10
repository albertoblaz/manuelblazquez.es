<?php
get_header();
?>

		<!-- Begin #colLeft -->
		<div id="colLeft">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="postItem">
				<h1><?php the_title(); ?></h1> 

				<div class="meta"><?php the_time('M j, Y') ?></div>

				<?php the_content(__('read more')); ?> 				

				<div class="postTags"><?php the_tags(); ?></div>
							
							<div id="shareLinks">
								<span id="icons">
									<a href="http://twitter.com/home/?status=<?php the_title(); ?> de Manuel Blazquez: <?php the_permalink(); ?>" title="Tweet this!">
									<!--<img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" alt="Tweet this!" />-->&#8226; Twitter</a>			
									<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;amp;t=<?php the_title(); ?>" title="Share on Facebook.">
									<!--<img src="<?php bloginfo('template_directory'); ?>/images/facebook.png" alt="Share on Facebook" id="sharethis-last" />-->&#8226; Facebook</a>
								</span>
							</div>
	
			        <?php comments_template(); ?>
			</div>
		<?php endwhile; else: ?>
			<p>Sorry, but you are looking for something that isn't here.</p>
		<?php endif; ?>
		
		</div>
		<!-- End #colLeft -->

<?php get_footer(); ?>
