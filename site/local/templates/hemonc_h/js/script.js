"use strict";

document.addEventListener("DOMContentLoaded", () => {
    if (window.Swiper) {
        const sharedConfig = {
            spaceBetween: 15,
            speed: 600,
            grabCursor: true,
            watchSlidesProgress: true,
        };

        new Swiper(".doctors-swiper", {
            ...sharedConfig,
            slidesPerView: 1.1,
            navigation: {
                nextEl: ".doctors-next",
                prevEl: ".doctors-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
            },
        });

        new Swiper(".reviews-swiper", {
            ...sharedConfig,
            slidesPerView: 1.1,
            navigation: {
                nextEl: ".reviews-next",
                prevEl: ".reviews-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                },
            },
        });
    }

    ymaps.ready(init);

    function init() {
        const pointCoords = [55.655458, 37.615233];

        const map = new ymaps.Map("map", {
            center: pointCoords,
            zoom: 16,
            controls: [],
        });

        const myPlacemark = new ymaps.Placemark(
            pointCoords,
            {},
            {
                iconLayout: "default#image",
                iconImageHref: "/local/templates/hemonc/images/map-icon.svg",
                iconImageSize: [70, 70],
                iconImageOffset: [-35, -70],
            },
        );

        map.geoObjects.add(myPlacemark);

        let zoomed = false;

        myPlacemark.events.add("click", function () {
            if (!zoomed) {
                map.setCenter(pointCoords, 18, {
                    duration: 400,
                });

                zoomed = true;
            } else {
                map.setCenter(pointCoords, 15, {
                    duration: 400,
                });
                zoomed = false;
            }
        });

        const geoBtn = document.getElementById("geo-btn");
        const geoLinks = document.getElementById("geo-links");

        if (geoBtn && geoLinks) {
            geoBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                geoLinks.style.display = "flex";
            });

            geoLinks.addEventListener("click", function (e) {
                e.stopPropagation();
            });

            document.addEventListener("click", function () {
                geoLinks.style.display = "none";
            });
        }
    }
});
