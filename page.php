
<?php get_header(); ?>

	<div id="content">
		<div id="slides">
		<?php
			$args = array(
				'post_type' => 'page',
				'orderby'   => 'menu_order',
				'order'     => 'asc'
			);
			query_posts($args);

			if (have_posts()) { 
				while (have_posts()) : the_post(); ?>
					<section class="slide">
						<?php the_content(); ?>
					</section>
				<?php endwhile; ?>
					<section class="slide">
						<?php include('pagecontact.php'); ?>
					</section>
			<?php } else { ?>
				<p>Sorry, but you are looking for something that isn't here.</p>
			<?php } wp_reset_query(); ?>
		</div>
	</div>
	
<?php get_footer(); ?>