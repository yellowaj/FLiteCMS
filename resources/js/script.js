(function() {

/* =============================================================================
   index page slider
   ========================================================================== */

$('.carousel').carousel();

// carousel controls
$('.carousel-controls').on('click', function(e) {
	e.preventDefault();
	var dir = $(this).data('slide');
	$('.carousel').carousel(dir);
});


})();