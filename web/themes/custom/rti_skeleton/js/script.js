jQuery("form input[type=search]").focus(function(event) {
    jQuery("#navbar").addClass("dimmed");
    jQuery("#search-block-form").addClass("sbox");
    jQuery("button").text('Save').button("refresh");

});

jQuery("form input[type=search]").blur(function(event) {
    jQuery("#navbar").removeClass("dimmed");
    jQuery("#search-block-form").removeClass("sbox");
});

function rti_gates_file_manager_ajax_load() {
    jQuery("#ajax-target").load("/fortesting/web/node/get/ajax/11");
}