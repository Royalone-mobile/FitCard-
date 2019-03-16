$(function () {
    "use strict";
    $("#slider").owlCarousel({
        navigation: false, // Show next and prev buttons
        slideSpeed: 600,
        paginationSpeed: 600,
        singleItem: true,
        transitionStyle: "fade",
        autoPlay: 6000
    });
});
