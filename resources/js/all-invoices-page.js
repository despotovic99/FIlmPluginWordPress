const $ = jQuery;

$('.delete-invoice-btn').on('click', (e) => {
    e.preventDefault();

    let button = e.target;
    let url = button.getAttribute('url');

    req = $.ajax({
        'url': url,
        'method': 'get'
    });

    req.done((res, textStatus, jqXHR) => {

        alert(res);
        location.reload();
    })

    req.fail(function (jqXHR, textStatus, errorThrown) {
        alert("Greska: ", textStatus, errorThrown);
    });


});