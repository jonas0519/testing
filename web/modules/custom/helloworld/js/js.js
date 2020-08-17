$(document).ready(function() {
    $('#but').click(function() {

        var checkarr = [];
        $("input[type=checkbox]:checked").each(function(index, element) {
            checkarr.push($(element).val());
        });

        if (checkarr.length > 0) {
            $.ajax({
                type: 'post',
                data: { ajax: 1, checked: checkarr },
                dataType: 'json',
                success: function(response) {
                    $('#response').text('response : ' + JSON.stringify(response));
                }
            });
        }

    });
});