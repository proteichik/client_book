$('[name="status"]').click(function (event) {
    event.preventDefault();
    var targetUrl = $(this).attr("href");
    $.ajax({
        url: targetUrl,
        type: 'POST'
    }).done(function () {
        location.reload(true);
    }).fail(function (data) {
        console.log(data);
    });
})