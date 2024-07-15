document.addEventListener("DOMContentLoaded", function () {
    var carouselPC = document.getElementById("recommendedStoresCarousel");
    var carouselMobile = document.getElementById(
        "recommendedStoresCarouselMobile"
    );

    var carouselInstancePC = carouselPC
        ? new bootstrap.Carousel(carouselPC, {
              interval: 5000,
              wrap: true,
              keyboard: true,
          })
        : null;

    var carouselInstanceMobile = carouselMobile
        ? new bootstrap.Carousel(carouselMobile, {
              interval: 5000,
              wrap: true,
              keyboard: true,
          })
        : null;

    var dotsPC = document.querySelectorAll(
        ".carousel-custom-indicators .d-none.d-lg-block .dot"
    );
    var dotsMobile = document.querySelectorAll(
        ".carousel-custom-indicators .d-lg-none .dot"
    );

    function updateDots(dots, activeIndex) {
        dots.forEach(function (dot, index) {
            if (index === activeIndex) {
                dot.classList.add("active");
            } else {
                dot.classList.remove("active");
            }
        });
    }

    if (carouselPC) {
        carouselPC.addEventListener("slide.bs.carousel", function (e) {
            updateDots(dotsPC, e.to);
        });
    }

    if (carouselMobile) {
        carouselMobile.addEventListener("slide.bs.carousel", function (e) {
            updateDots(dotsMobile, e.to);
        });
    }

    dotsPC.forEach(function (dot, index) {
        dot.addEventListener("click", function () {
            if (carouselInstancePC) {
                carouselInstancePC.to(index);
            }
        });
    });

    dotsMobile.forEach(function (dot, index) {
        dot.addEventListener("click", function () {
            if (carouselInstanceMobile) {
                carouselInstanceMobile.to(index);
            }
        });
    });
});
