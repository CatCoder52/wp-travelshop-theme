// ------------------------------------------------
// -- sticky / hide handling sticky booking cta
// -- using content-main
// ------------------------------------------------
if ( $('.sticky-booking-cta').length > 0 ) {
  var scrollPos = $(window).scrollTop(),
      hideTrigger = ( $('.content-main').offset().top + $('.content-main').height() ) - ( $(window).height() * 1.75 );

  if ( scrollPos > hideTrigger ) {
    $('.sticky-booking-cta').hide(300);
  } else {
    $('.sticky-booking-cta').show(300);
  }

  // -- again by scroll
  $(window).scroll(function(e) {
    scrollPos = $(window).scrollTop();
    hideTrigger = ( $('.content-main').offset().top + $('.content-main').height() ) - ( $(window).height() * 1.75 );

    if ( scrollPos > hideTrigger ) {
      $('.sticky-booking-cta').hide(300);
    } else {
      $('.sticky-booking-cta').show(300);
    }
  });
}

// -----------------------------------------------
// -- Tooltips for images
// -----------------------------------------------
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});


// --------------------------------
// --- Gallery
// --------------------------------
if ( $('.detail-gallery-overlay-inner').length > 0 ) {
  var slider = tns({
    container: '.detail-gallery-overlay-inner',
    items: 1,
    mouseDrag: true,
    navContainer: '#detail-gallery-thumbnails',
    navAsThumbnails: true,
    controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
    '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
    '  <polyline points="15 6 9 12 15 18" />\n' +
    '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
    '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
    '  <polyline points="9 6 15 12 9 18" />\n' +
    '</svg>']
  })
}

if ( $('.detail-image-grid-holder').length > 0 ) {
  $('.detail-image-grid-holder img').on('click', function() {
    console.log('open');
    $('#detail-gallery-overlay').addClass('is--show');
    $('body').addClass('modal-open');
  })
  $('.detail-gallery-overlay-close').on('click', function() {
    $('#detail-gallery-overlay').removeClass('is--show');
    $('body').removeClass('modal-open');
  })
}