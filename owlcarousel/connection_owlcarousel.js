$(document).ready(function () {
    $("#carousel1").owlCarousel({

        items: 1, //сколько слайдов показывать 
      //  loop: true, // бесконечная прокрутка 
        nav: true, // стрелочки влево вправо '
        autoplay: true,
        autoplayTimeout: 9000,
        autoplaySpeed: 2500,
        smartSpeed: 2500,
        center: true
    });
});