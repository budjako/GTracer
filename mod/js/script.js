$(document).ready(function() {
	$(document).on("click", ".clickable-row", function(e) {
		var ev=e;
		var button = ev.target;
		ev.stopPropagation();
		if($(button).hasClass('ban') || $(button).hasClass('admin') || $(button).hasClass('approve')) {
			ev.stopPropagation();
		}	
		else window.document.location = $(this).data("href");
	});
});
