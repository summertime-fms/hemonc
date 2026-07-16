"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const telInputs = document.querySelectorAll(".phone-field");

    if (telInputs.length) {
        const maskOptions = {
            mask: "+{7} (000) 000-00-00",
        };

        const initMask = (input) => {
            const mask = IMask(input, maskOptions);
            input.addEventListener("input", () => {
                if (
                    (input.value.length === 4 && input.value[1] === "8") ||
                    (input.value.length === 4 && input.value[1] === "7")
                ) {
                    const initialValue = [...input.value];
                    initialValue.splice(1, 1);
                    input.value = initialValue.join("").toString();
                    mask.updateValue();
                }

                const inputToSend = input.nextElementSibling;
                inputToSend.value = `${input.value}`;
            });
        };

        telInputs.forEach((input) => initMask(input));
    }
});
