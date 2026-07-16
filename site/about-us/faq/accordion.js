"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelectorAll(".accordion-item");

    items.forEach((item) => {
        const header = item.querySelector(".accordion-header");
        const content = item.querySelector(".accordion-content");

        if (item.classList.contains("active")) {
            content.style.transition = "none";
            content.style.height = content.scrollHeight + "px";

            content.offsetHeight;

            content.style.transition = "";
        } else {
            content.style.height = "0px";
        }

        header.addEventListener("click", () => {
            if (item.classList.contains("active")) {
                content.style.height = content.scrollHeight + "px";

                requestAnimationFrame(() => {
                    content.style.height = "0px";
                });

                item.classList.remove("active");
            } else {
                item.classList.add("active");
                content.style.height = content.scrollHeight + "px";
            }
        });
    });
});
