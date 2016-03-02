/**
 * Stickymenu for Blogetti theme
 * Author: Guriev Eugen
 */
(function ($) {
	$.fn.StickyMenu = function(options) {
		var me = this,
		pseudo_block = {},
		outer_height = parseInt( me.outerHeight(true) );
		options = $.extend(
			{
				"fixed_class" : "menu_fixed"
			}, 
			options
		);
		$('<div class="pseudoStickyBlock"></div>').insertAfter(me);
		pseudo_block = $('.pseudoStickyBlock');
		pseudo_block.css({
			"position" : "relative",
			"display" : "block"
		});

		/**
		 * Refresh stickymenu
		 * @param  {[type]} scroll_offset offset
		 * @param  {[type]} scroll_level  level.
		 */
		me.refresh = function(scroll_offset, scroll_level) {
			var margin_top = "-" + $(this).outerHeight(true) + "px";
			if (scroll_offset <= scroll_level) {
				$('body').removeClass(options.fixed_class);
				pseudo_block.css({ "height" : 0 });
			} else if (scroll_offset > scroll_level) {
				if ( ! $('body').hasClass(options.fixed_class) ) {
					pseudo_block.css({ "height" : outer_height });
					$('body').addClass(options.fixed_class);
					$(this).css('marginTop', margin_top).animate({'marginTop': 0}, 500);
				}
			}
		};

		/**
		 * Bind refresh to scroll event
		 * @param  {[type]} $obj         jquery object
		 * @param  {[type]} scroll_level integer scroll level [offset.top + outerHeight]
		 */
		me.scroll = function($obj, scroll_level) {
			$(document).on(
				'scroll',
				function(){
					me.refresh($(window).scrollTop(), scroll_level);
				}
			);
		}

		/**
		 * Init my plugin
		 */
		me.init = function() {
			$(this).each(function(){
				var scroll_level = $(this).offset().top + $(this).outerHeight(true);
				me.refresh($(window).scrollTop(), scroll_level);
				me.scroll($(this), scroll_level);
			});
		};

		me.init();
	};
})(jQuery);