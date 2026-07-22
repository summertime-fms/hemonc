"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const selects = Array.from(
    document.querySelectorAll(".schedule-filter__select"),
  );
  const filtersForm = document.querySelector(".schedule-filters");
  const nearestInput = document.querySelector(
    ".schedule-filters__nearest-input",
  );
  const resetButtons = Array.from(
    new Set(document.querySelectorAll(".reset-filters")),
  );
  const doctorsList = document.querySelector(".schedule__list");
  const emptyState = document.querySelector(".schedule__list-empty");
  const loader = document.querySelector(".schedule-loader");
  const mockUrl = "./mock/doctors.json";
  let doctors = [];

  if (!selects.length || typeof window.TomSelect === "undefined") {
    return;
  }

  if (doctorsList && emptyState && emptyState.parentElement === doctorsList) {
    doctorsList.after(emptyState);
  }

  if (doctorsList) {
    doctorsList.innerHTML = "";
  }

  const tomSelects = [];
  const tomSelectByFilter = {};

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
    if (!resetButtons.length) {
      return;
    }

    const shouldHide = !hasActiveFilters();

    resetButtons.forEach((button) => {
      button.hidden = shouldHide;
    });
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

  const escapeHtml = (value) => {
    return String(value || "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  };

  const formatLabels = {
    clinic: { label: "Очный приём", className: "type_ftf" },
    online: { label: "Приём онлайн", className: "type_online" },
    home: { label: "Приём на дому", className: "type_home" },
  };

  const renderDoctorFormats = (formats) => {
    return (formats || [])
      .map((format) => {
        const item = formatLabels[format];

        if (!item) {
          return "";
        }

        return `<div class="doctor-card__type-item ${item.className}">${escapeHtml(item.label)}</div>`;
      })
      .join("");
  };

  const renderDoctorCard = (doctor) => {
    const formats = renderDoctorFormats(doctor.formats);
    const specializations = (doctor.specializations || [])
      .map((specialization) => {
        return `<div class="doctor-card__specializations-item">${escapeHtml(specialization.label)}</div>`;
      })
      .join("");
    const description = escapeHtml(doctor.description);

    return `
      <li class="schedule__list-item doctor-card">
        <div class="doctor-card__header">
          <div class="doctor-card__type">${formats}</div>
        </div>

        <div class="doctor-card__body">
          <div class="doctor-card__photo">
            <img src="${escapeHtml(doctor.photo)}" alt="${escapeHtml(doctor.name)}" loading="lazy" />
          </div>

          <div class="doctor-card__main-content">
            <div class="doctor-card__name">${escapeHtml(doctor.name)}</div>

            <div class="doctor-card__row">
              <div class="doctor-card__specializations">${specializations}</div>
              <div class="doctor-card__type">${formats}</div>
            </div>

            <div class="doctor-card__descr" tabindex="0" data-full-text="${description}">
              <span class="doctor-card__descr-text">${description}</span>
            </div>

            <a href="${escapeHtml(doctor.detailUrl || "#")}" class="doctor-card__more">Подробнее о враче</a>
          </div>
        </div>

        <div class="doctor-card__footer">
          <div class="service-details">
            <div class="service-details__item">
              <span class="service-details__label">Стоимость приёма</span>
              <span class="service-details__dots"></span>
              <span class="service-details__value">${doctor.price || ""}</span>
            </div>

            <div class="service-details__item">
              <span class="service-details__label">Ближайшая запись</span>
              <span class="service-details__dots"></span>
              <span class="service-details__value">${escapeHtml(doctor.nearest)}</span>
            </div>
          </div>

          <button class="btn" type="button">Записаться на приём</button>
        </div>
      </li>
    `;
  };

  const renderDoctors = (items) => {
    if (!doctorsList) {
      return;
    }

    doctorsList.innerHTML = items.map(renderDoctorCard).join("");

    if (emptyState) {
      emptyState.hidden = items.length > 0;
    }
  };

  const setLoading = (isLoading) => {
    if (loader) {
      loader.hidden = !isLoading;
    }
  };

  const getFilterValues = (filterName) => {
    const select = tomSelectByFilter[filterName];
    const value = select ? select.getValue() : [];
    return Array.isArray(value) ? value : value ? [value] : [];
  };

  const hasAnyIntersection = (doctorValues, filterValues) => {
    return filterValues.some((value) => (doctorValues || []).includes(value));
  };

  const applyFilters = () => {
    const specializationValues = getFilterValues("specialization");
    const diseaseValues = getFilterValues("disease");
    const serviceValues = getFilterValues("service");
    const formatValue = getFilterValues("format")[0] || "any";
    let filteredDoctors = doctors.slice();

    if (specializationValues.length) {
      filteredDoctors = filteredDoctors.filter((doctor) => {
        const doctorSpecializations = (doctor.specializations || []).map(
          (specialization) => specialization.value,
        );
        return hasAnyIntersection(doctorSpecializations, specializationValues);
      });
    }

    if (diseaseValues.length) {
      filteredDoctors = filteredDoctors.filter((doctor) => {
        return hasAnyIntersection(doctor.diseases, diseaseValues);
      });
    }

    if (serviceValues.length) {
      filteredDoctors = filteredDoctors.filter((doctor) => {
        return hasAnyIntersection(doctor.services, serviceValues);
      });
    }

    if (formatValue !== "any") {
      filteredDoctors = filteredDoctors.filter((doctor) => {
        return (doctor.formats || []).includes(formatValue);
      });
    }

    if (nearestInput && nearestInput.checked) {
      filteredDoctors.sort((firstDoctor, secondDoctor) => {
        return (firstDoctor.nearestTs || 0) - (secondDoctor.nearestTs || 0);
      });
    }

    renderDoctors(filteredDoctors);
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
        applyFilters();
      },
    });

    if (isFormat) {
      tomSelect.control_input.setAttribute("readonly", "readonly");
    }

    tomSelect.control.setAttribute("data-button-label", buttonLabel);
    bindClearButton(tomSelect);
    bindMultiselectOptionToggle(tomSelect);
    updateClearButtonState(tomSelect);
    tomSelectByFilter[filterType] = tomSelect;
    tomSelects.push(tomSelect);

    selectElement.addEventListener("change", () => {
      updateClearButtonState(tomSelect);
      updateResetButtonState();
      applyFilters();
    });
  });

  if (nearestInput) {
    nearestInput.addEventListener("change", () => {
      updateResetButtonState();
      applyFilters();
    });
  }

  const resetFilters = () => {
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
    applyFilters();
  };

  if (resetButtons.length) {
    resetButtons.forEach((button) => {
      button.addEventListener("click", resetFilters);
    });
  }

  if (filtersForm) {
    filtersForm.addEventListener("reset", () => {
      requestAnimationFrame(() => {
        updateResetButtonState();
        applyFilters();
      });
    });
  }

  updateResetButtonState();
  setLoading(true);

  fetch(mockUrl)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Mock request failed: ${response.status}`);
      }

      return response.json();
    })
    .then((data) => {
      doctors = Array.isArray(data.doctors) ? data.doctors : [];
      setLoading(false);
      applyFilters();
    })
    .catch(() => {
      doctors = [];
      setLoading(false);
      renderDoctors([]);
    });

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
