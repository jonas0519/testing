$(document).ready(function() {
    $('#editable-mode').click(function() {
        $('form input[type="submit"]').prop("disabled", true);
    });
});