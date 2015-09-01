$(window).bind('beforeunload', function() {
  $('.fa-spinner').css('opacity', '1');
});

$(document).ready(function() {
  $('.fa-spinner').css('opacity', '0');
});
