$(document).ready(function () {
    $("a.n-photo").fancybox();
    // document.getElementById("phone-clb").addEventListener('keyup', () => {
    //     window.setTimeout(function () {
    //         CheckCallbackForm();
    //     }, 300);
    // }, false);
    // CheckCallbackForm();
});

document.addEventListener('DOMContentLoaded', function () {
    ymaps.ready(init);

    function init() {
        const pointCoords = [55.655458, 37.615233];

        const map = new ymaps.Map("map", {
            center: pointCoords,
            zoom: 16,
            controls: []
        });

        // map.behaviors.disable('scrollZoom');
        // map.behaviors.disable('dblClickZoom');
        // map.behaviors.disable('multiTouch');

        const myPlacemark = new ymaps.Placemark(pointCoords, {}, {
            iconLayout: 'default#image',
            iconImageHref: '/local/templates/hemonc/images/map-icon.svg',
            iconImageSize: [70, 70],
            iconImageOffset: [-35, -70]
        });

        map.geoObjects.add(myPlacemark);

        let zoomed = false;

        myPlacemark.events.add('click', function () {
            if (!zoomed) {
                map.setCenter(pointCoords, 18, {
                    duration: 400
                });

                zoomed = true;
            }else{
                map.setCenter(pointCoords, 15, {
                    duration: 400
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
}, false);