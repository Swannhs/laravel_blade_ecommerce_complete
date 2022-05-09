

function showResult(str) {

    var url = $('#url').val();
    $.ajax({
        method: 'POST',
        url: url + '/' + 'search',
        data: {search: str},
        success: function (data) {
            $("#livesearch").show();
            $("#livesearch").html(data);
        },
        error: function (data) {
            
        }
    });

}

