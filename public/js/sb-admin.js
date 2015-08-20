//$(function() {
//
//    $('#side-menu').metisMenu();
//
//});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() 
{
	$(window).bind("load resize", function() 
	{
		topOffset = 50;
		width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
		
		if (width < 768) 
		{
			$('#side-menu').metisMenu();
			$('div.sidebar-nav').addClass('navbar-collapse');
			$('div.navbar-collapse').addClass('collapse');
			topOffset = 100; // 2-row-menu
		} 
		else
			$('div.navbar-collapse').removeClass('collapse');

		height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
		height = height - topOffset;

		if (height < 1) height = 1;
		
		if (height > topOffset)
			$("#page-wrapper").css("min-height", (height) + "px");
	});

	var url = window.location;
	var element = $('ul.nav a').filter(function() 
	{
		return this.href == url || url.href.indexOf(this.href) == 0;
	})
	.addClass('active').parent().parent().addClass('in').parent();
	
	if (element.is('li'))
		element.addClass('active');

	// $('#cssmenu > ul > li:has(ul)').addClass("has-sub");

	// $('#cssmenu > ul > li > a').click(function() 
	// {
	// 	var checkElement = $(this).next();

	// 	$('#cssmenu li').removeClass('active');
	// 	$(this).closest('li').addClass('active');   

	// 	if((checkElement.is('ul')) && (checkElement.is(':visible'))) 
	// 	{
	// 		$(this).closest('li').removeClass('active');
	// 		checkElement.slideUp('normal');
	// 	}

	// 	if((checkElement.is('ul')) && (!checkElement.is(':visible'))) 
	// 	{
	// 		$('#cssmenu ul ul:visible').slideUp('normal');
	// 		checkElement.slideDown('normal');
	// 	}
	// 	return (checkElement.is('ul')) ? false : true;    
	// });

	// $('#cssmenu > ul > li > ul > li > a').click(function() 
	// {
	// 	var checkElement = $(this).next();

	// 	$('#cssmenu li').removeClass('active');
	// 	$(this).closest('li').addClass('active');   

	// 	if((checkElement.is('ul')) && (checkElement.is(':visible'))) 
	// 	{
	// 		$(this).closest('li').removeClass('active');
	// 		checkElement.slideUp('normal');
	// 	}

	// 	if((checkElement.is('ul')) && (!checkElement.is(':visible'))) 
	// 	{
	// 		$('#cssmenu ul li ul li ul:visible').slideUp('normal');
	// 		checkElement.slideDown('normal');
	// 	}		
	// 	return (checkElement.is('ul')) ? false : true;    
	// });
});
