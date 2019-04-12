console.log('JS bien chargé');



$('#likes button') .on('click', function () {

    const slug = $('#likes button').first() .data('slug');

    const params = {
        url: 'http://projetperf.local/api/article/likes/' + slug
    };

//lancement de l'appel ajax
    $.ajax(params).done(displayNewLikes);
});


function displayNewLikes(json)
{
    $('#likes span').text(json.cpt);
}