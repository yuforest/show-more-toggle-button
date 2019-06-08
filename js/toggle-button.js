jQuery(function($) {
  $('.show-more-toggle-button').on('click', function() {
    $(this).fadeOut();
    $(this)
      .parent()
      .find('.show-more-area')
      .slideDown();
  });
});
