$(document).ready(function() {
    var timeline = $('#timeline').timeline();

    $("#screen").overscroll({
        captureWheel: false,
        showThumbs: false,
        direction: 'horizontal',
        scrollLeft: -1 * (timeline.data("timeline").getMarginFromMinDateForOverscroll())
    }).on('overscroll:dragend overscroll:driftend', function(event){
            var scrollLeft = $(this).scrollLeft();
            timeline.data("timeline").load(scrollLeft);
        });
});