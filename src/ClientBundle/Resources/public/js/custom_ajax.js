$('[name="status"]').click(function (event) {
    runAjax(event, this);
});

$('[name="btn-delete"]').click(function (event) {
    runAjax(event, this);
});

function runAjax(event, target) {
    event.preventDefault();
    var targetUrl = $(target).attr("href");
    $.ajax({
        url: targetUrl,
        type: 'POST'
    }).done(function () {
        location.reload(true);
    }).fail(function (data) {
        console.log(data);
    });
}