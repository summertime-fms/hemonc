"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const selects = Array.from(document.querySelectorAll(".schedule-filter__select"));

  if (!selects.length || typeof window.TomSelect === "undefined") {
    return;
  }

  const tomSelects = [];

  const closeOtherDropdowns = (activeSelect) => {
    tomSelects.forEach((select) => {
      if (select !== activeSelect) {
        select.close();
      }
    });
  };

  const getOptionText = (data) => data.text || data.label || "";

  const renderOptionWithCheckbox = (data, escape) => {
    return `
      <div class="schedule-filter__option">
        <span class="schedule-filter__option-check" aria-hidden="true"></span>
        <span class="schedule-filter__option-text">${escape(getOptionText(data))}</span>
      </div>
    `;
  };

  const renderPlainOption = (data, escape) => {
    return `
      <div class="schedule-filter__option">
        <span class="schedule-filter__option-text">${escape(getOptionText(data))}</span>
      </div>
    `;
  };

  selects.forEach((selectElement) => {
    const filterType = selectElement.dataset.filter;
    const isFormat = filterType === "format";

    if (isFormat) {
      selectElement.selectedIndex = -1;
    }

    const tomSelect = new TomSelect(selectElement, {
      plugins: isFormat ? ["clear_button"] : ["clear_button", "dropdown_input"],
      maxItems: selectElement.multiple ? null : 1,
      closeAfterSelect: isFormat,
      hideSelected: false,
      create: false,
      persist: false,
      allowEmptyOption: true,
      placeholder: selectElement.dataset.placeholder || "",
      searchField: isFormat ? [] : ["text"],
      render: {
        option: isFormat ? renderPlainOption : renderOptionWithCheckbox,
        item(data, escape) {
          return `<div>${escape(getOptionText(data))}</div>`;
        },
        no_results() {
          return '<div class="no-results">Ничего не найдено</div>';
        },
      },
      onDropdownOpen() {
        closeOtherDropdowns(this);
      },
    });

    if (isFormat) {
      tomSelect.control_input.setAttribute("readonly", "readonly");
    }

    tomSelects.push(tomSelect);
  });

  document.addEventListener("click", (event) => {
    if (event.target.closest(".schedule-filter")) {
      return;
    }

    tomSelects.forEach((select) => select.close());
  });
});
