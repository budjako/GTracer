
// drag and drop css
$(function() {
	var consinput=
		"<br>\
		<select class='compare'>\
			<option>Equals</option>\
			<option>Not Equals</option>\
			<option>Less Than</option>\
			<option>Greater Than</option>\
			<option>Less Than or Equal</option>\
			<option>Greater Than or Equal</option>\
			<option>Like</option>\
			<option>Not Like</option>\
		</select>\
		<input type='text' class='value'></input>";

	function handleDropEvent(event, ui){
		if(! $(ui.draggable).hasClass('clone')){					// not a duplicate of a clone
			// $(ui.draggable).css("background", "#ddd");
			// var original=$(ui.draggable).hasClass('original');
			$(ui.draggable).draggable("disable");
			var clone = $(ui.draggable).clone();
			clone.removeClass('original');
			$(ui.draggable).css("background", "#ddd");
			clone.children('.lbl').attr("data-toggle", "dropdown");
			clone.children('.lbl').addClass("dropdown-toggle");
			var label=clone.children('.lbl').text();
			var str=
				"<span class='rem opt'>X</span>\
				<span class='caret opt' data-toggle='dropdown'></span>";
			var mod=$(str);
			str=
				"<ul class='dropdown-menu'>\
					<li class='dropdown-item single'><a>Single Constraint</li>\
					<li class='dropdown-item and'><a>Multiple Constraints (And)</a></li>\
					<li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li>\
				</ul>"
			var options=$(str);
			clone.css('top', 0).css('left', 0).css('clear', 'both').css('z-index', '');
			clone.addClass('clone');
			clone.prepend(mod);
			clone.append(options);
			$(this).append(clone);
			
			if($(ui.draggable).hasClass('draggable')){
				clone.draggable();
			}
		}
		else{													// duplicate of a clone -- sort
			var item=$(ui.draggable).detach();
			item.css('top', 0).css('left', 0).css('clear', 'both');
			$(this).append(item);
		}
	}

	$(".draggable").draggable({
		helper: 'clone',
		revert: true,
		revertDuration: 0,
		drag: function(event, ui) {
			$(this).css('z-index', 5);
		},
		stop: function(event, ui){
			$(this).css('z-index', 2);
		}
	});

	$(".query").droppable({
		drop: handleDropEvent
	});

	$(document).on('click', '.rem', function(){
		if($(this).parent().hasClass('clone')){		// enable original
			var views=$('.view');
			for(var i=0; i<views.length; i++){
				if($(views[i]).text()==$(this).parent().children('.view').text()){
					$(views[i]).parent().draggable("enable");
					$(views[i]).parent().css("background","");
				}
			}
		}
		var secparent=$(this).parent().parent();
		$(this).parent().remove();
		if(secparent.hasClass('clone') && secparent.children('.compare').length==0 && secparent.children('.op').length==0){
			secparent.children('.rem').remove();
			var str=
				"<span class='rem opt'>X</span>\
				<span class='caret opt' data-toggle='dropdown'></span>";
			var mod=$(str);
			str=
				"<ul class='dropdown-menu'>\
					<li class='dropdown-item single'><a>Single Constraint</li>\
					<li class='dropdown-item and'><a>Multiple Constraints (And)</a></li>\
					<li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li>\
				</ul>"
			var options=$(str);
			secparent.prepend(mod);
			secparent.append(options);
		}
	});

	$(document).on('click', '.single', function(){
		var single=$(consinput);
		
		$(this).parent().parent().append(single);
		$(this).parent().parent().css('z-index', '');
		$(this).parent().remove();
		single.siblings(".caret").remove();
	});

	$(document).on('click', '.add-cons', function(){
		var single=$(consinput);
		$(this).parent().parent().append(single);
	});

	$(document).on('click', '.and', function(){
		var secparent = $(this).parent().parent();
		if(secparent.hasClass("clone")){						// remove caret and other attributes and classes
			secparent.children().remove(".caret");
			secparent.children().remove(".dropdown-menu");
			secparent.children('.lbl').removeAttr("data-toggle");
			secparent.children('.lbl').removeClass("dropdown-toggle");
		}
		var mod=$("<span class='rem opt'>X</span><span class='caret opt' data-toggle='dropdown'>");
		var options=$("<ul class='dropdown-menu'><li class='dropdown-item add-cons'><a>Add Constraint</li><li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li></ul>");
		var andop=$("<div class='op resizable'><span class='lbl operator dropdown-toggle' data-toggle='dropdown'>And</span></div>");
		andop.css("display", "table");
		andop.prepend(mod);
		andop.append(options);
		secparent.append(andop);
	});

	$(document).on('click', '.or', function(){
		var secparent = $(this).parent().parent();
		if(secparent.hasClass("clone")){						// remove caret and other attributes and classes
			secparent.children().remove(".caret");
			secparent.children().remove(".caret");
			secparent.children().remove(".dropdown-menu");
			secparent.children('.lbl').removeAttr("data-toggle");
			secparent.children('.lbl').removeClass("dropdown-toggle");
		}

		var mod=$("<span class='rem opt'>X</span><span class='caret opt' data-toggle='dropdown'>");
		var options=$("<ul class='dropdown-menu'><li class='dropdown-item add-cons'><a>Add Constraint</li><li class='dropdown-item and'><a>Multiple Constraints (And)</a></li></ul>");
		var orop=$("<div class='op resizable'><span class='lbl operator dropdown-toggle' data-toggle='dropdown'>Or</span></div>");
		orop.css("display", "table");
		orop.prepend(mod);
		orop.append(options);
		secparent.append(orop);
	});
});

// dropdown js

+function ($) {
	'use strict';

	// DROPDOWN CLASS DEFINITION
	// =========================

	var backdrop = '.dropdown-backdrop'
	var toggle   = '[data-toggle="dropdown"]'
	var Dropdown = function (element) {
		$(element).on('click.bs.dropdown', this.toggle)
	}

	Dropdown.VERSION = '3.3.4'

	Dropdown.prototype.toggle = function (e) {
		var $this = $(this)

		if ($this.is('.disabled, :disabled')) return

		var $parent  = getParent($this)
		var isActive = $parent.hasClass('open')

		clearMenus()

		if (!isActive) {
			if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
				// if mobile we use a backdrop because click events don't delegate
				$('<div class="dropdown-backdrop"/>').insertAfter($(this)).on('click', clearMenus)
			}

			var relatedTarget = { relatedTarget: this }
			$parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

			if (e.isDefaultPrevented()) return

			$this
				.trigger('focus')
				.attr('aria-expanded', 'true')

			$parent
				.toggleClass('open')
				.trigger('shown.bs.dropdown', relatedTarget)
		}

		return false
	}

	Dropdown.prototype.keydown = function (e) {
		if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return

		var $this = $(this)

		e.preventDefault()
		e.stopPropagation()

		if ($this.is('.disabled, :disabled')) return

		var $parent  = getParent($this)
		var isActive = $parent.hasClass('open')

		if ((!isActive && e.which != 27) || (isActive && e.which == 27)) {
			if (e.which == 27) $parent.find(toggle).trigger('focus')
			return $this.trigger('click')
		}

		var desc = ' li:not(.disabled):visible a'
		var $items = $parent.find('[role="menu"]' + desc + ', [role="listbox"]' + desc)

		if (!$items.length) return

		var index = $items.index(e.target)

		if (e.which == 38 && index > 0)                 index--                        // up
		if (e.which == 40 && index < $items.length - 1) index++                        // down
		if (!~index)                                      index = 0

		$items.eq(index).trigger('focus')
	}

	function clearMenus(e) {
		if (e && e.which === 3) return
		$(backdrop).remove()
		$(toggle).each(function () {
			var $this         = $(this)
			var $parent       = getParent($this)
			var relatedTarget = { relatedTarget: this }

			if (!$parent.hasClass('open')) return

			$parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))

			if (e.isDefaultPrevented()) return

			$this.attr('aria-expanded', 'false')
			$parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
		})
	}

	function getParent($this) {
		var selector = $this.attr('data-target')

		if (!selector) {
			selector = $this.attr('href')
			selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
		}

		var $parent = selector && $(selector)

		return $parent && $parent.length ? $parent : $this.parent()
	}


	// DROPDOWN PLUGIN DEFINITION
	// ==========================

	function Plugin(option) {
		return this.each(function () {
			var $this = $(this)
			var data  = $this.data('bs.dropdown')

			if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
			if (typeof option == 'string') data[option].call($this)
		})
	}

	var old = $.fn.dropdown

	$.fn.dropdown             = Plugin
	$.fn.dropdown.Constructor = Dropdown


	// DROPDOWN NO CONFLICT
	// ====================

	$.fn.dropdown.noConflict = function () {
		$.fn.dropdown = old
		return this
	}


	// APPLY TO STANDARD DROPDOWN ELEMENTS
	// ===================================

	$(document)
		.on('click.bs.dropdown.data-api', clearMenus)
		.on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
		.on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
		.on('keydown.bs.dropdown.data-api', toggle, Dropdown.prototype.keydown)
		.on('keydown.bs.dropdown.data-api', '[role="menu"]', Dropdown.prototype.keydown)
		.on('keydown.bs.dropdown.data-api', '[role="listbox"]', Dropdown.prototype.keydown)
		.on('click', '.dropdown', toggle, Dropdown.prototype.toggle)
}(jQuery);