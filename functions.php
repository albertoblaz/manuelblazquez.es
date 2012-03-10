<?php

add_filter('login_errors',create_function('$a', "return null;"));

/*******************************
 MENUS SUPPORT
********************************/
if ( function_exists( 'wp_nav_menu' ) ){
	if (function_exists('add_theme_support')) {
		add_theme_support('nav-menus');
		add_action( 'init', 'register_my_menus' );
		function register_my_menus() {
			register_nav_menus(
				array(
					'main-menu' => __( 'Main Menu' )
				)
			);
		}
	}
}

/* CallBack functions for menus in case of earlier than 3.0 Wordpress version or if no menu is set yet*/

function primarymenu(){ ?>
			<div id="mainMenu" class="ddsmoothmenu">
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</div>
<?php }


/*******************************
 THUMBNAIL SUPPORT
********************************/

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 300, 200, true );

/* Get the thumb original image full url */

function get_thumb_urlfull ($postID) {
$image_id = get_post_thumbnail_id($post);  
$image_url = wp_get_attachment_image_src($image_id,'large');  
$image_url = $image_url[0]; 
return $image_url;
}

/*******************************
 EXCERPT LENGTH ADJUST
********************************/

function home_excerpt_length($length) {
	return 30;
}
add_filter('excerpt_length', 'home_excerpt_length');

	
/*******************************
 PAGINATION
********************************
 * Retrieve or display pagination code.
 *
 * The defaults for overwriting are:
 * 'page' - Default is null (int). The current page. This function will
 *      automatically determine the value.
 * 'pages' - Default is null (int). The total number of pages. This function will
 *      automatically determine the value.
 * 'range' - Default is 3 (int). The number of page links to show before and after
 *      the current page.
 * 'gap' - Default is 3 (int). The minimum number of pages before a gap is 
 *      replaced with ellipses (...).
 * 'anchor' - Default is 1 (int). The number of links to always show at begining
 *      and end of pagination
 * 'before' - Default is '<div class="emm-paginate">' (string). The html or text 
 *      to add before the pagination links.
 * 'after' - Default is '</div>' (string). The html or text to add after the
 *      pagination links.
 * 'title' - Default is '__('Pages:')' (string). The text to display before the
 *      pagination links.
 * 'next_page' - Default is '__('&raquo;')' (string). The text to use for the 
 *      next page link.
 * 'previous_page' - Default is '__('&laquo')' (string). The text to use for the 
 *      previous page link.
 * 'echo' - Default is 1 (int). To return the code instead of echo'ing, set this
 *      to 0 (zero).
 *
 * @author Eric Martin <eric@ericmmartin.com>
 * @copyright Copyright (c) 2009, Eric Martin
 * @version 1.0
 *
 * @param array|string $args Optional. Override default arguments.
 * @return string HTML content, if not displaying.
 */
 
function emm_paginate($args = null) {
	$defaults = array(
		'page' => null, 'pages' => null, 
		'range' => 3, 'gap' => 3, 'anchor' => 1,
		'before' => '<div class="emm-paginate">', 'after' => '</div>',
		'title' => __('Pages:'),
		'nextpage' => __('&raquo;'), 'previouspage' => __('&laquo'),
		'echo' => 1
	);

	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);

	if (!$page && !$pages) {
		global $wp_query;

		$page = get_query_var('paged');
		$page = !empty($page) ? intval($page) : 1;

		$posts_per_page = intval(get_query_var('posts_per_page'));
		$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
	}
	
	$output = "";
	if ($pages > 1) {	
		$output .= "$before<span class='emm-title'>$title</span>";
		$ellipsis = "<span class='emm-gap'>...</span>";

		if ($page > 1 && !empty($previouspage)) {
			$output .= "<a href='" . get_pagenum_link($page - 1) . "' class='emm-prev'>$previouspage</a>";
		}
		
		$min_links = $range * 2 + 1;
		$block_min = min($page - $range, $pages - $min_links);
		$block_high = max($page + $range, $min_links);
		$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
		$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

		if ($left_gap && !$right_gap) {
			$output .= sprintf('%s%s%s', 
				emm_paginate_loop(1, $anchor), 
				$ellipsis, 
				emm_paginate_loop($block_min, $pages, $page)
			);
		}
		else if ($left_gap && $right_gap) {
			$output .= sprintf('%s%s%s%s%s', 
				emm_paginate_loop(1, $anchor), 
				$ellipsis, 
				emm_paginate_loop($block_min, $block_high, $page), 
				$ellipsis, 
				emm_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else if ($right_gap && !$left_gap) {
			$output .= sprintf('%s%s%s', 
				emm_paginate_loop(1, $block_high, $page),
				$ellipsis,
				emm_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else {
			$output .= emm_paginate_loop(1, $pages, $page);
		}

		if ($page < $pages && !empty($nextpage)) {
			$output .= "<a href='" . get_pagenum_link($page + 1) . "' class='emm-next'>$nextpage</a>";
		}

		$output .= $after;
	}

	if ($echo) {
		echo $output;
	}

	return $output;
}

/**
 * Helper function for pagination which builds the page links.
 *
 * @access private
 *
 * @author Eric Martin <eric@ericmmartin.com>
 * @copyright Copyright (c) 2009, Eric Martin
 * @version 1.0
 *
 * @param int $start The first link page.
 * @param int $max The last link page.
 * @return int $page Optional, default is 0. The current page.
 */
function emm_paginate_loop($start, $max, $page = 0) {
	$output = "";
	for ($i = $start; $i <= $max; $i++) {
		$output .= ($page === intval($i)) 
			? "<span class='emm-page emm-current'>$i</span>" 
			: "<a href='" . get_pagenum_link($i) . "' class='emm-page'>$i</a>";
	}
	return $output;
}

function post_is_in_descendant_category( $cats, $_post = null )
{
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}


/*******************************
 CUSTOM COMMENTS
********************************/

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
   	<div class="gravatar">
	 <?php echo get_avatar($comment,$size='50',$default='http://www.gravatar.com/avatar/61a58ec1c1fba116f8424035089b7c71?s=32&d=&r=G' ); ?>
	 <div class="gravatar_mask"></div>
	</div>
     <div id="comment-<?php comment_ID(); ?>">
	  <div class="comment-meta commentmetadata clearfix">
	    <?php printf(__('<strong>%s</strong>'), get_comment_author_link()) ?><?php edit_comment_link(__('(Edit)'),'  ','') ?> <span><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
	  </span>
	  </div>
	  
      <div class="text">
		  <?php comment_text() ?>
	  </div>
	  
	  <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php }


/*******************************
  THEME OPTIONS PAGE
********************************/

add_action('admin_menu', 'sa_theme_page');
function sa_theme_page ()
{
	if ( count($_POST) > 0 && isset($_POST['sa_settings']) )
	{
		$options = array ('logo_img', 'logo_alt','contact_email','contact_text','contact_lateral',
				'linkedin_link','twitter_user','facebook_link','lastfm_link','filmaffinity_link','goodreads_link',
				'github_link','picasa_link','flickr_link','500px_link','behance_link','youtube_link','vimeo_link',
				'keywords','description','google_keywords','google_description','analytics');
		
		foreach ( $options as $opt )
		{
			delete_option ( 'sa_'.$opt, $_POST[$opt] );
			add_option ( 'sa_'.$opt, $_POST[$opt] );	
		}			
		 
	}
	add_menu_page(__('Simple Art Options'), __('Simple Art Options'), 'edit_themes', basename(__FILE__), 'sa_settings');
	add_submenu_page(__('Simple Art Options'), __('Simple Art Options'), 'edit_themes', basename(__FILE__), 'sa_settings');
}

function sa_settings()
{?>
<div class="wrap">
	<h2>Simple Art Options Panel</h2>
	
<form method="post" action="">

<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		<input type="hidden" name="sa_settings" value="save" style="display:none;" />
		</p>

	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>General Settings</strong></legend>
	<table class="form-table">
		<!-- General settings -->
		
		<tr valign="top">
			<th scope="row"><label for="logo_img">Change logo (full path to logo image)</label></th>
			<td>
				<input name="logo_img" type="text" id="logo_img" value="<?php echo get_option('sa_logo_img'); ?>" class="regular-text" /><br />
				<em>current logo:</em> <br /> <img src="<?php echo get_option('sa_logo_img'); ?>" alt="<?php echo get_option('sa_logo_alt'); ?>" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="logo_alt">Logo ALT Text</label></th>
			<td>
				<input name="logo_alt" type="text" id="logo_alt" value="<?php echo get_option('sa_logo_alt'); ?>" class="regular-text" />
			</td>
		</tr>
	</table>
	</fieldset>
	
	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Footer Social Links</strong></legend>
	<table class="form-table">
	<tr valign="top">
			<th scope="row"><label for="twitter_user">Twitter Username</label></th>
			<td>
				<input name="twitter_user" type="text" id="twitter_user" value="<?php echo get_option('sa_twitter_user'); ?>" class="regular-text" />
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"><label for="facebook_link">Facebook link</label></th>
			<td>
				<input name="facebook_link" type="text" id="facebook_link" value="<?php echo get_option('sa_facebook_link'); ?>" class="regular-text" />
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"><label for="linkedin_link">LinkedIn link</label></th>
			<td>
				<input name="linkedin_link" type="text" id="linkedin_link" value="<?php echo get_option('sa_linkedin_link'); ?>" class="regular-text" />
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"><label for="lastfm_link">Last.FM link</label></th>
			<td>
				<input name="lastfm_link" type="text" id="lastfm_link" value="<?php echo get_option('sa_lastfm_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="filmaffinity_link">FilmAffinity link</label></th>
			<td>
				<input name="filmaffinity_link" type="text" id="filmaffinity_link" value="<?php echo get_option('sa_filmaffinity_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="goodreads_link">GoodReads link</label></th>
			<td>
				<input name="goodreads_link" type="text" id="goodreads_link" value="<?php echo get_option('sa_goodreads_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="picasa_link">Picasa Web link</label></th>
			<td>
				<input name="picasa_link" type="text" id="picasa_link" value="<?php echo get_option('sa_picasa_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="github_link">GitHub link</label></th>
			<td>
				<input name="github_link" type="text" id="github_link" value="<?php echo get_option('sa_github_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="flickr_link">Flickr link</label></th>
			<td>
				<input name="flickr_link" type="text" id="flickr_link" value="<?php echo get_option('sa_flickr_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="500px_link">500px link</label></th>
			<td>
				<input name="500px_link" type="text" id="500px_link" value="<?php echo get_option('sa_500px_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="github_link">Behance link</label></th>
			<td>
				<input name="behance_link" type="text" id="behance_link" value="<?php echo get_option('sa_behance_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="github_link">Youtube link</label></th>
			<td>
				<input name="youtube_link" type="text" id="youtube_link" value="<?php echo get_option('sa_youtube_link'); ?>" class="regular-text" />
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="github_link">Vimeo link</label></th>
			<td>
				<input name="vimeo_link" type="text" id="vimeo_link" value="<?php echo get_option('sa_vimeo_link'); ?>" class="regular-text" />
			</td>
		</tr>
        </table>
        </fieldset>
	
	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Contact Page Settings</strong></legend>
	<table class="form-table">	
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr valign="top">
			<th scope="row"><label for="contact_text">Contact Page Text</label></th>
			<td>
				<textarea name="contact_text" id="contact_text" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('sa_contact_text')); ?></textarea>
			</td>
		</tr>
	<tr valign="top">
			<th scope="row"><label for="contact_lateral">Contact Lateral Text</label></th>
			<td>
				<textarea name="contact_lateral" id="contact_lateral" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('sa_contact_lateral')); ?></textarea>
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"><label for="contact_email">Email Address for Contact Form</label></th>
			<td>
				<input name="contact_email" type="text" id="contact_email" value="<?php echo get_option('sa_contact_email'); ?>" class="regular-text" />
			</td>
		</tr>
        </table>
     </fieldset>
        
      <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>SEO</strong></legend>
		<table class="form-table">
        <tr>
			<th><label for="keywords">Meta Keywords</label></th>
			<td>
				<textarea name="keywords" id="keywords" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('sa_keywords'); ?></textarea><br />
                <em>Keywords comma separated</em>
			</td>
		</tr>
        <tr>
			<th><label for="description">Meta Description</label></th>
			<td>
				<textarea name="description" id="description" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('sa_description'); ?></textarea>
			</td>
		</tr>
	<tr>
			<th><label for="google_keywords">Google+1 Meta Keywords</label></th>
			<td>
				<textarea name="google_keywords" id="google_keywords" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('sa_google_keywords'); ?></textarea><br />
                		<em>Keywords comma separated</em>
			</td>
		</tr>
	<tr>
			<th><label for="google_description">Google+1 Meta Description</label></th>
			<td>
				<textarea name="google_description" id="google_description" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('sa_google_description'); ?></textarea><br />
			</td>
		</tr>
		<tr>
			<th><label for="ads">Google Analytics code:</label></th>
			<td>
				<textarea name="analytics" id="analytics" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('sa_analytics')); ?></textarea>
			</td>
		</tr>
		
	</table>
	</fieldset>

	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		<input type="hidden" name="sa_settings" value="save" style="display:none;" />
	</p>

	</form>
</div>

<?php }
/*******************************
  CONTACT FORM 
********************************/

 function hexstr($hexstr) {
  $hexstr = str_replace(' ', '', $hexstr);
  $hexstr = str_replace('\x', '', $hexstr);
  $retstr = pack('H*', $hexstr);
  return $retstr;
}

function strhex($string) {
  $hexstr = unpack('H*', $string);
  return array_shift($hexstr);
}
?>