function importEvents(){
	$.ajax({
	    type: "GET",
	    url: "/events/import",
	    dataType: "json",
	    async : true,
	    success: function(data){
	    	console.log("- - Import complete - -");
	    }
	});
}

$(document).ready(function() {
	var timeline = $('#timeline').timeline();

	$("#screen").overscroll({
		//captureWheel: false,
		showThumbs : false,
		direction:	'horizontal',	//'vertical',
		wheelDirection : 'vertical',
		scrollLeft : -1 * (timeline.data("timeline").getMarginFromMinDateForOverscroll())
	}).on('overscroll:dragend overscroll:driftend', function(event) {
		var scrollLeft = $(this).scrollLeft();
		timeline.data("timeline").load(scrollLeft);
	});
	
	$("#import_events").click(importEvents);
});