import $ from "jquery";

$(document).ready(function () {
    /* Aumentar tamaño de la fuente */
    $('#a_more').click(function () {
        let curSize = parseInt($('html').css('font-size')) + 2;
        if (curSize <= 28)
            $('html').css('font-size', curSize + 'px');
    });

    /* Disminuir tamaño de la fuente */
    $('#a_less').click(function () {
        let curSize = parseInt($('html').css('font-size')) - 2;
        if (curSize >= 10)
            $('html').css('font-size', curSize + 'px');
    });

    /* Reiniciar tamaño de la fuente */
    $('#a_normal').click(function () {
        $('html').css('font-size', '16px'); // Asigna el tamaño de fuente inicial que desees aquí
    });

    /* Alto contraste */
    $('#high_contrast').click(function () {
        if ($('html').hasClass('altoContraste')) {
            $('html').removeClass('altoContraste');
            $(".navbar-default").removeClass("navbar-inverse");
        } else {
            $('html').addClass('altoContraste');
            $(".navbar-default").addClass("navbar-inverse");
        }
    });
});
