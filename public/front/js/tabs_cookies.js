(function($) {
$(function() {

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	$('ul.catalog-menu').each(function(i) {
		var cookie = readCookie('tabCookie' + i);
		if (cookie) {
			$(this).find('li').removeClass('active').eq(cookie).addClass('active')
				.closest('div.catalog-box__item').find('div.catalog-tab__item ').removeClass('active').eq(cookie).addClass('active');
		}
	});

	$('ul.catalog-menu').on('click', 'li:not(.active)', function() {
		$(this)
			.addClass('active').siblings().removeClass('active')
			.closest('div.catalog-box__item').find('div.catalog-tab__item').removeClass('active').eq($(this).index()).addClass('active');
		var ulIndex = $('ul.catalog-menu').index($(this).parents('ul.catalog-menu'));
		eraseCookie('tabCookie' + ulIndex);
		createCookie('tabCookie' + ulIndex, $(this).index(), 365);
	});

});
})(jQuery);

(function($) {
$(function() {

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	$('div.catalog-menu').each(function(i) {
		var cookie = readCookie('tabCookie' + i);
		if (cookie) {
			$(this).find('div').removeClass('active').eq(cookie).addClass('active')
				.closest('div.content').find('div.catalog-tab__item  ').removeClass('active').eq(cookie).addClass('active');
		}
	});

	$('div.catalog-menu').on('click', 'div:not(.active)', function() {
		$(this)
			.addClass('active').siblings().removeClass('active')
			.closest('div.content').find('div.catalog-tab__item').removeClass('active').eq($(this).index()).addClass('active');
		var ulIndex = $('div.catalog-menu').index($(this).parents('div.catalog-menu'));
		eraseCookie('tabCookie' + ulIndex);
		createCookie('tabCookie' + ulIndex, $(this).index(), 365);
	});

});
})(jQuery);