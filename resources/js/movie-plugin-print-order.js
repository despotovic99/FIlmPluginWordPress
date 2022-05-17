const $ = jQuery;

$('.print-button').on('click',(e) => {
    e.preventDefault();

    console.log(e.target)
    console.log($(this))
    // console.log(e.target.data('url-print'))
});



