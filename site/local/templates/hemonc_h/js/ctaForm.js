"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const sendForm = async (form) => {
        const formData = new FormData(form);

        const url = form.action;

        if (!url) return;

        try {
            const response = await fetch(url, {
                method: "POST",
                body: new URLSearchParams(formData),
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.errors.join("\n"));
                return;
            }

            form.innerHTML = `<p style="font-size: 18px; color: #007088;">${data.message}</p>`;
        } catch (error) {
            alert("Ошибка соединения с сервером");
            console.error(error);
        }
    };

    document.querySelector("#ctaForm").addEventListener("submit", (e) => {
        e.preventDefault();
        sendForm(e.target);
    });
});
