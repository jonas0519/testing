(function ($, Drupal) {
  Drupal.behaviors.myModuleName = {
    attach: function (context, settings) {
        
      // Add your Javascript code here.
      $('.result_message', context).css('background', 'yellow');
        
    }
  };
})(jQuery, Drupal);
