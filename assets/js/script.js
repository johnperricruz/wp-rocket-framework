$j = jQuery.noConflict();
	
$j(function(){
	console.log('Loading Resources............100%');
	mobileMenu();
	menuClick();
	
	loading();

});
function mobileMenu(){
	var screen = $j(window).width();
	var nav = $j('#bs-navbar-collapse');
	try{
		$j("div#bs-navbar-collapse.desktop .dropdown,div#bs-navbar-collapse.desktop .btn-group").hover(function(){
			var dropdownMenu = $j(this).children(".dropdown-menu");
			dropdownMenu.parent().toggleClass("open");
		});	
		$j(window).resize(function() {
			nav.toggleClass('desktop');
		});		
	}catch(e){
		console.log(e);
	}
}
function menuClick(){
	$j('li.dropdown').click(function(e){
		console.log(e);
		$j(this).removeClass('open');
	});	
}
function loading(){
	$j('.loading').fadeOut();
}