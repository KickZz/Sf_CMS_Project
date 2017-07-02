$(function() {
    // Affichage du sous menu en douceur
    $('ul.nav li.dropdown').hover(function() {
        $(this).find('> .dropdown-menu').fadeIn(200);
        $(this).addClass('open');
    }, function() {
        $(this).find('> .dropdown-menu').fadeOut(200);
        $(this).removeClass('open');
    });

    $('.lienMenuFront').on('click', function () {
        if ($(this).hasClass('fa fa-chevron-circle-right')){
            $(this).removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
        }
        else{
            $(this).removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
        }
    });
});