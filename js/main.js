var rootRx = new RegExp("^" + siteroot);
var ajaxRx = new RegExp(/(about|contact)\/$/);
var $grid;
var originalUrl = location.href;

jQuery(document).ready(function()
{
	var menu = jQuery(".site-menu-drawer");

	jQuery(".menu-show").on("click", function(event)
	{
		menu.addClass("toggled");
		event.preventDefault();
		return false;
	});

	jQuery(".menu-hide").on("click", function(event)
	{
		menu.removeClass("toggled");
		event.preventDefault();
		return false;
	});

	jQuery(".menu-item a").on("click", function(e)
	{
		if( ajaxRx.test(this.href) )
		{
			if( typeof history.pushState === "function" ) {
				history.pushState({}, "", this.href);
			}

			loadLinkContent(this.href, null, showModal);

			e.preventDefault();
			return false;
		}
	});

	jQuery(".the-dot").on("click", function(e){
		e.preventDefault();
		return false;
	});

	jQuery(".dot-pagination a").on("click", function(e)
	{
		if( typeof history.pushState === "function" ) {
			history.pushState({}, "", this.href);
		}

		loadLinkContent(this.href, null, replaceContent);

		e.preventDefault();
		return false;
	});

	jQuery(".entry-title a, .notes .hentry .wrapper").on("click", bindLinks);

	jQuery("body").on("click", ".faux-footer", function()
	{
		var entry = jQuery(this).parents(".hentry");
		var content = entry.find(".entry-content");
		entry.removeClass("open");
		content.slideUp();
	});

	jQuery("body.single .carousel").owlCarousel({
		margin: 0,
		nav: false,
		dots: true,
		loop: false,
		items: 1
	});

	jQuery(".search-toggle").on("click", function(){
		var parent = jQuery(this).parent();
		parent.toggleClass("active");

		if( parent.hasClass("active") ) {
			parent.find("input").focus();
		}
	});

	$grid = jQuery("body.notes .site-main");

	$grid.packery({
		itemSelector: ".hentry"
	});

	if( $grid.length ) {
		adjustExcerptHeight( $grid.children() );
	}
});

jQuery(document).keyup(function(e)
{
	if( e.keyCode === 27 ) {
		removeModal();
	}
});

jQuery(window).on("popstate", function(e)
{
	if( ajaxRx.test(location.href) ) {
		return loadLinkContent(location.href, null, showModal);
	} else if( jQuery("body").hasClass("post-type-archive-note") || jQuery("body").hasClass("search") ) {
		loadLinkContent(this.href, null, replaceContent);
	}

	removeModal();
});

jQuery("body").on("click", ".close-modal", removeModal)

function restoreUrl()
{
	if( typeof history.pushState === "function" ) {
		history.pushState({}, "", originalUrl);
	}
}

function removeModal()
{
	jQuery(".site-main .modal").fadeOut(function() {
		jQuery(this).remove();
		jQuery("body").removeClass("overflown");
		restoreUrl();
	});
}

function replaceContent( tree )
{
	var current = jQuery(".site-main");
	var newEntries = tree.find(".site-main").children();

	newEntries.fadeTo(0, 0);

	current.fadeTo(400, 0, function()
	{
		current.empty();
		$grid.packery("destroy");
		current.append(newEntries);
		newEntries.fadeTo(400, 1);
		current.fadeTo(400, 1);

		adjustExcerptHeight(newEntries);

		$grid = jQuery("body.notes .site-main");

		$grid.packery({
			itemSelector: ".hentry"
		});
	});
}

function adjustExcerptHeight( els )
{
	els.each(function()
	{
		var el = jQuery(this);
		var text = el.find(".text")
		var textHeight = text.outerHeight() - 40;
		var textWidth = text.width();
		var headerHeight = el.find(".entry-header").outerHeight() + 54;
		var excerpt = el.find(".entry-excerpt");
		var originalHeight = excerpt.height();
		var height = textHeight - headerHeight;
		var lh = 15;
		var lhDiff = height % lh;

		height = ! lhDiff ? height : height - lhDiff;

		if( height !== originalHeight )
		{
			if( height < lh * 2 ) {
				height = 0;
			} else {
				addEllipsis(excerpt, height, textWidth, lh);
			}
		}

		excerpt.height(height);
	});
}

function addEllipsis( el, h, w, lh )
{
	var dummy = jQuery('<p></p>').css({ visibility: "hidden" });
	var html = el[0].innerHTML.trim();
		html = html.replace(/<p>/, "").replace(/<\/p>/, "");
	var words = html.split(/\s+/);
	var word = "";
	var len = words.length;
	var lines = [""];
	var newLine = false;
	var line = 0;
	var dh = 0;
	var i = 0;

	el.append(dummy);

	for( i; i < len; i++ )
	{
		word = words[i];
		dummy[0].innerHTML += (i === 0) ? word : " " + word;
		dh = dummy[0].getBoundingClientRect().height;
		newLine = false;

		if( dh > lh )
		{
			lines[++line] = "";
			dummy[0].innerHTML = word;
			newLine = true;
		}

		lines[line] += (newLine || i === 0) ? word : " " + word;
	}

	dummy.remove();
	lines = lines.slice(0, h / lh);
	el[0].innerHTML = "<p>" + lines.join(" ").replace(/\s(\w+)$/, "&hellip;") + "</p>";
}

function showModal( tree )
{
	var menu = jQuery(".site-menu-drawer");
	var current = jQuery(".site-main .modal");
	var entry = tree.find(".hentry");
	var name = location.href.match(ajaxRx)[1];

	entry.addClass("open modal " + name).fadeTo(0, 0);
	entry.append('<button class="close-modal top">x</button>');
	entry.append('<button class="close-modal bottom">x</button>');

	if( current.length )
	{
		current.fadeOut(function()
		{
			jQuery(this).remove();
			jQuery(".site-main").append(entry);
			jQuery("body").addClass("overflown");
			resBaldrickTriggers();
			entry.fadeTo(400, 1);
			menu.removeClass("toggled");
		});
	}
	else
	{
		jQuery(".site-main").append(entry);
		jQuery("body").addClass("overflown");
		resBaldrickTriggers();
		entry.append('<div class="site-logo"><a href="/" rel="home">ars</a></div>');
		entry.fadeTo(400, 1);
		menu.removeClass("toggled");
	}	
}

function showNote( entry )
{
	if( entry.data("animating") == true ) {
		return false;
	}

	entry.data("animating", true);

	var cHeight = 0;
	var eHeight = 0;
	var content = entry.find(".entry-content");

	content.css({position: "absolute", top: "-9999999px", height: "auto"});
	eHeight = entry.outerHeight();
	content.css({position: "static", top: ""});
	cHeight = content.outerHeight();
	entry.height(cHeight + eHeight);
	entry.addClass("open");

	jQuery(".hentry").each(function() {
		$grid.packery("unstamp", this);
	});

	$grid.packery("stamp", entry[0]);
	shiftLayout();

	entry.height(eHeight);
	entry.animate({height: (cHeight + eHeight) + "px"}, 400, function(){
		entry.data("animating", false);
	});
}

function hideNote( entry )
{
	if( entry.data("animating") == true ) {
		return false;
	}

	entry.data("animating", true);

	var eHeight = 0;
	var content = entry.find(".entry-content");
	var cHeight = content.outerHeight();
	
	entry.removeClass("open");
	entry.height("");
	eHeight = entry.outerHeight();
	$grid.packery("unstamp", entry[0]);
	shiftLayout();
	entry.height(eHeight + cHeight);
	entry.animate({height: eHeight + "px"}, 325, function(){
		entry.data("animating", false);
	});
}

function toggleContent( entry )
{
	var content = entry.find(".entry-content");

	if( jQuery("body").hasClass("notes") )
	{
		if( entry.hasClass("open") ) {
			hideNote(entry);
		} else {
			showNote(entry);
		}
	}
	else
	{
		if( entry.hasClass("open") )
		{
			entry.removeClass("open");
			content.slideUp();
		}
		else
		{
			entry.addClass("open");
			content.slideDown();
		}
	}
}

function bindLinks( event )
{
	if( event.ctrlKey || event.shiftKey || event.metaKey ) {
		return true;
	}

	var notes = jQuery("body").hasClass("notes");
	var fileExt = new RegExp(/\.[a-z]+$/);
	var original = this.attributes.getNamedItem("href").nodeValue;
	var url = this.href;
	var entry = jQuery(this).parents(".hentry");

	if( entry.hasClass("loading") )
	{
		event.preventDefault();
		return false;
	}

	if( entry.hasClass("loaded") )
	{
		toggleContent(entry);

		event.preventDefault();
		return false;
	}

	if( original !== "#" && rootRx.test(url) && ! fileExt.test(url) )
	{
		var cb = notes ? insertNoteContent : insertContent;

		loadLinkContent(url, entry, cb);

		entry.addClass("loading");

		event.preventDefault();
		return false;
	}

	return true;
}

function loadLinkContent( url, entry, callback )
{
	var params = {url: url, method: "GET", dataType: "html"};

	jQuery.ajax(params).done(function(res)
	{
		var tree = jQuery("<div>").append( jQuery.parseHTML(res) );
		callback(tree, entry);
	});
}

function insertNoteContent( tree, entry )
{
	var content = tree.find(".entry-content").children();
	var container = entry.find(".entry-content");

	container.children().remove();
	container.append(content);

	content.imagesLoaded(function()
	{
		entry.removeClass("loading");
		entry.addClass("loaded");
		entry.addClass("open");

		showNote(entry);
	});
}

function shiftLayout()
{
	$grid.packery("shiftLayout");
}

function insertContent( tree, entry )
{
	var container = entry.find(".entry-content");
	var content = tree.find(".entry-content").children();
	var carousel = tree.find(".entry-header .carousel");

	container.slideUp(0);
	container.children().remove();
	container.append(content);

	content.imagesLoaded(function()
	{
		entry.removeClass("loading");
		entry.addClass("loaded");
		entry.addClass("open");
		container.slideDown();
	});
	
	if( carousel.length )
	{
		carousel.height(0);
		carousel.addClass("offscreen");

		entry.find(".entry-header").append(carousel);

		carousel.owlCarousel({
			margin: 0,
			nav: false,
			dots: true,
			loop: false,
			items: 1
		});

		carousel.fadeOut(0);

		carousel.imagesLoaded(function()
		{
			entry.find(".post-thumbnail").fadeOut(function()
			{
				carousel.removeClass("offscreen");
				carousel.height("");
				carousel.fadeIn();
				jQuery(this).remove();
			});
		});
	}
}