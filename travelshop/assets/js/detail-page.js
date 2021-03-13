

// Sample Code interactice deckplan
$('.content-block-detail-booking').on('click', '.booking-btn', function(e){

    // collapse all rows
    $(this).closest('.content-block-detail-booking').find('.deck-map').each(function(){
        $(this).fadeOut('fast');
    });

    $(this).closest('.content-block-detail-booking').find('.booking-btn').each(function(){
        $(this).html('Jetzt buchen');
    });

    // open the selected deck-map
    if($(this).closest('.booking-row').find('.deck-map').css('display') == 'none'){
        $(this).closest('.booking-row').find('.deck-map').fadeIn('slow');
        $(this).data('disabled', true);
        $(this).html('Kabine wählen');
        e.preventDefault();
    }

    // link is disabled, abort default behaivor

    console.log($(this).data('disabled'));
    if($(this).data('disabled')){
        console.log('prevent me');
        e.preventDefault();
    }

});

$('.content-block-detail-booking').on('click', '.cab-off', function(){


    $(this).closest('.booking-row').find('.cab-off').each(function(){
        $(this).removeClass('active');
        $(this).css('fill', '');
    });

    var lbl = 'Kabine ' + $(this).attr('cab') + ' buchen ';
    $(this).closest('.booking-row').find('.booking-btn').html(lbl);
    $(this).closest('.booking-row').find('.booking-btn').data('disabled', false);
    $(this).addClass('active');
    $(this).css('fill', 'blue');
});


$('.content-block-detail-booking').on({
    mouseenter: function () {
        $(this).css('fill', 'blue');
    },
    mouseleave: function () {
        if($(this).hasClass('active') === false){
            $(this).css('fill', '');
        }
    }
}, ".cab-off"); //pass the element as an argument to .on