/*--blog-event-top-right--*/

$(document).ready(function() {

    var hide = true;
    $(".smart_toggle_btn").click(function(e) {
        $(this).next('.smart_collapse').toggleClass('smart_collapse_show');
        e.stopPropagation();
    });

    $('body').on("click", function() {
        if ($(this).closest('.smart_collapse').length === 0) {
            $(".smart_collapse").removeClass('smart_collapse_show');
        }
    });

});

// comment_collapse
$(document).ready(function() {

    $(".comment_toggle_btn").click(function(e) {
        $(this).parent('.nav').next('.comment_collapse').toggleClass('comment_collapse_show');
        e.stopPropagation();
    });

    $('body').on("click", function() {
        if ($(this).closest('.comment_collapse').length === 0) {
            $(".comment_collapse").removeClass('comment_collapse_show');
        }
    });

    $(".comment_collapse .card.card-body ").on('click', function(e) {
        e.stopPropagation();
    });


});

// share
// share_collapse
$(document).ready(function() {

    $(".share_toggle_btn").click(function(e) {
        $(this).next('.share_collapse').toggleClass('share_collapse_show');
        e.stopPropagation();
    });

    $('body').on("click", function() {
        if ($(this).closest('.share_collapse').length === 0) {
            $(".share_collapse").removeClass('share_collapse_show');
        }
    });

    $(".share_collapse .card.card-body ").on('click', function(e) {
        e.stopPropagation();
    });


});

// $('.comment_collapse').css('height', $('.comments__box ').height());


// $('.live_preveiw_wrapper').css('width', $('.d_wrapper').height());