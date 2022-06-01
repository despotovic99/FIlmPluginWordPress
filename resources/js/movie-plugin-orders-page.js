const $ = jQuery;

$('.print-button').on('click', (e) => {
    e.preventDefault();

    let button = e.target;
    let url = button.getAttribute('url-print');
    // console.log(url)
    window.location = url;


});

$('.get-order-infromation-button').on('click', (e) => {
    e.preventDefault();

    let button = e.target;
    let url = button.getAttribute('url');

    req = $.ajax({
        'url': url,
        'method': 'get'
    });

    req.done((res,textStatus,jqXHR)=>{

        console.log(res);

    })

    req.fail(function(jqXHR,textStatus,errorThrown){
        alert("Greska: ",textStatus,errorThrown);
    });

});


$('.create-invoice-button').on('click', (e) => {
    e.preventDefault();

    let button = e.target;
    let url = button.getAttribute('url');

    req = $.ajax({
        'url': url,
        'method': 'get'
    });

    req.done((res, textStatus, jqXHR) => {
        alert(res);
    })

    req.fail(function (jqXHR, textStatus, errorThrown) {
        alert("Greska: ", textStatus, errorThrown);
    });

});