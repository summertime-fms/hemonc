"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const selects = Array.from(
    document.querySelectorAll(".schedule-filter__select"),
  );
  const filtersForm = document.querySelector(".schedule-filters");
  const nearestInput = document.querySelector(
    ".schedule-filters__nearest-input",
  );
  const resetButton = document.querySelector(".schedule-filters__reset-btn");

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

  const updateClearButtonState = (tomSelect) => {
    const hasValue = tomSelect.items.length > 0;
    const extraCount = Math.max(0, tomSelect.items.length - 1);
    const firstItem = tomSelect.control.querySelector(".item");

    tomSelect.wrapper.classList.toggle("has-selected-value", hasValue);
    tomSelect.wrapper.classList.toggle("has-selected-extra", extraCount > 0);

    if (!firstItem) {
      return;
    }

    if (extraCount > 0) {
      firstItem.dataset.extraCount = extraCount;
    } else {
      delete firstItem.dataset.extraCount;
    }
  };

  const hasActiveFilters = () => {
    return (
      tomSelects.some((select) => {
        if (select.input.dataset.filter === "format") {
          return select.items.some((value) => value !== "any");
        }

        return select.items.length > 0;
      }) || Boolean(nearestInput && nearestInput.checked)
    );
  };

  const updateResetButtonState = () => {
    if (!resetButton) {
      return;
    }

    resetButton.hidden = !hasActiveFilters();
  };

  const refreshTomSelect = (tomSelect) => {
    updateClearButtonState(tomSelect);
    tomSelect.refreshOptions(false);
    tomSelect.refreshItems();
  };

  const getOptionValue = (optionElement) => {
    return (
      optionElement.dataset.value || optionElement.getAttribute("data-value")
    );
  };

  const positionMobileDropdown = (tomSelect) => {
    if (!window.matchMedia("(max-width: 1023px)").matches) {
      tomSelect.dropdown.style.removeProperty("--schedule-filter-dropdown-top");
      return;
    }

    const viewportGap = 16;
    const buttonGap = 8;
    const dropdownHeight = Math.min(
      tomSelect.dropdown.offsetHeight || 460,
      460,
      window.innerHeight - viewportGap * 2,
    );
    let controlRect = tomSelect.control.getBoundingClientRect();
    let dropdownTop = controlRect.bottom + buttonGap;
    const overflowBottom =
      dropdownTop + dropdownHeight + viewportGap - window.innerHeight;

    if (overflowBottom > 0) {
      window.scrollBy({
        top: overflowBottom,
        behavior: "auto",
      });

      controlRect = tomSelect.control.getBoundingClientRect();
      dropdownTop = controlRect.bottom + buttonGap;
    }

    tomSelect.dropdown.style.setProperty(
      "--schedule-filter-dropdown-top",
      `${Math.max(viewportGap, dropdownTop)}px`,
    );
  };

  const bindClearButton = (tomSelect) => {
    const clearSelectedValues = (event) => {
      if (
        !(event.target instanceof Element) ||
        !event.target.closest(".clear-button")
      ) {
        return;
      }

      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();

      tomSelect.clear();
      tomSelect.close();
      refreshTomSelect(tomSelect);
    };

    tomSelect.wrapper.addEventListener("mousedown", clearSelectedValues, true);
    tomSelect.wrapper.addEventListener("click", clearSelectedValues, true);
  };

  const bindMultiselectOptionToggle = (tomSelect) => {
    if (!tomSelect.input.multiple) {
      return;
    }

    let toggledValue = null;

    const toggleSelectedOption = (event) => {
      if (!(event.target instanceof Element)) {
        return;
      }

      const optionElement = event.target.closest("[data-selectable]");

      if (!optionElement) {
        return;
      }

      const value = getOptionValue(optionElement);

      if (!value) {
        return;
      }

      if (event.type === "click" && value === toggledValue) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        toggledValue = null;
        return;
      }

      if (!optionElement.classList.contains("selected")) {
        return;
      }

      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();

      toggledValue = value;
      tomSelect.removeItem(value);
      refreshTomSelect(tomSelect);
    };

    tomSelect.dropdown_content.addEventListener(
      "mousedown",
      toggleSelectedOption,
      true,
    );
    tomSelect.dropdown_content.addEventListener(
      "click",
      toggleSelectedOption,
      true,
    );
  };

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
    const buttonLabel = selectElement.dataset.placeholder || "";

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

        requestAnimationFrame(() => {
          positionMobileDropdown(this);
        });
      },
      onDropdownClose() {
        this.dropdown.style.removeProperty("--schedule-filter-dropdown-top");
      },
      onChange() {
        updateClearButtonState(this);
        updateResetButtonState();
      },
    });

    if (isFormat) {
      tomSelect.control_input.setAttribute("readonly", "readonly");
    }

    tomSelect.control.setAttribute("data-button-label", buttonLabel);
    bindClearButton(tomSelect);
    bindMultiselectOptionToggle(tomSelect);
    updateClearButtonState(tomSelect);
    tomSelects.push(tomSelect);
  });

  if (nearestInput) {
    nearestInput.addEventListener("change", updateResetButtonState);
  }

  if (resetButton) {
    resetButton.addEventListener("click", () => {
      tomSelects.forEach((select) => {
        select.clear();
        select.close();
        refreshTomSelect(select);
      });

      if (nearestInput) {
        nearestInput.checked = false;
        nearestInput.dispatchEvent(new Event("change", { bubbles: true }));
      }

      updateResetButtonState();
    });
  }

  if (filtersForm) {
    filtersForm.addEventListener("reset", () => {
      requestAnimationFrame(updateResetButtonState);
    });
  }

  updateResetButtonState();

  document.addEventListener("click", (event) => {
    if (!(event.target instanceof Element)) {
      return;
    }

    if (
      event.target.closest(".schedule-filter") ||
      event.target.closest(".ts-dropdown")
    ) {
      return;
    }

    tomSelects.forEach((select) => select.close());
  });
});
