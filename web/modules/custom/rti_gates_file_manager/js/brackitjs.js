// JavaScript Document
var brackitjs=brackitjs||{};	

(function ($) {
	brackitjs.cardManager = {

			init : function() {

				this.openEditIcon = $("#openEditIcon");
				this.openEditIcon.click(function(e) {

					e.preventDefault();
					$("#fileUploadWrapper").fadeIn(500);
				});
		}
		
	}
	
})(jQuery);

brackitjs.cardManager.init();
