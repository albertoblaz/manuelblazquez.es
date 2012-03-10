/* ------------------------------------------------------------------------
 *  File: slides.js
 *  Description: Web Content dividid into several slides with no new server connections, just the first one
 *  Author: tutorialzine - http://tutorialzine.com/2009/11/beautiful-apple-gallery-slideshow/
 *  Modified by: Alberto Blazquez - http://albertoblazquez.net/
 * ------------------------------------------------------------------------ */

$(document).ready(function(){

	/* Script vars */	
	var pos       = 0;
	var totWidth  = 0;
	var positions = new Array();
	var heights   = new Array();

	var $slides   = $('#slides');	
	var $menu     = $('#menu');
	var $links    = $menu.find('a');
	var $menuItem = $menu.find('li.menuItem');

	/* Saving width and height of each slide */
	$slides.find('.slide').each(function(i) {
		positions[i]= totWidth;
		totWidth += $(this).width();
		heights[i] = $(this).height();
				
		if(!$(this).width()) {
			alert("Please, fill in width & height for all your images!");
			return false;
		}
	});
	
	/* Setting the container div's width and height */
	$slides.width(totWidth);
	$slides.height(heights[0]);

	/* On a click */
	$links.click(function(e,keepScroll) {
		$menuItem.removeClass('act');
		$(this).parent().addClass('act');

		pos = $(this).parent().prevAll('.menuItem').length;

		/* Start the sliding animation */
		$slides.stop().animate({marginLeft:-positions[pos]+'px', height:heights[pos]+'px'}, 750);
		e.preventDefault();
		
	});

	/* On page load, mark the first as active */
	$menu.find('li.menuItem:first').addClass('act').siblings();

});