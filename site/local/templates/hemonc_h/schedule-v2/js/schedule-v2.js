/**
 * Entry schedule-v2.
 *
 * При включённом флаге перехватывает:
 *   SelectDoctorPopup()
 *   ShowPersonalDoctorPopup(bitrixId)
 * Старые реализации остаются в doctorsPopup.js и вызываются, если v2 выключен
 * или этот файл не подключён.
 */
(function (window, document) {
  'use strict';

  var ROOT_ID = 'scheduleV2Root';
  var BOOKING_ID = 'scheduleV2Booking';

  function ensureRoots() {
    var host = document.getElementById('referenceDateModal');
    if (!host) {
      host = document.body;
    }

    var root = document.getElementById(ROOT_ID);
    if (!root) {
      root = document.createElement('div');
      root.id = ROOT_ID;
      root.className = 'sch2';
      root.setAttribute('data-sch2-root', '1');
      host.appendChild(root);
    }

    var booking = document.getElementById(BOOKING_ID);
    if (!booking) {
      booking = document.createElement('div');
      booking.id = BOOKING_ID;
      booking.className = 'sch2-booking-host';
      host.appendChild(booking);
    }

    return { root: root, booking: booking };
  }

  function openList() {
    var nodes = ensureRoots();
    var filtersEl;
    var listEl;

    nodes.root.innerHTML =
      '<div class="sch2__layout">' +
        '<aside class="sch2__sidebar" data-sch2="filters-host"></aside>' +
        '<main class="sch2__main" data-sch2="list-host"></main>' +
      '</div>';

    filtersEl = nodes.root.querySelector('[data-sch2="filters-host"]');
    listEl = nodes.root.querySelector('[data-sch2="list-host"]');

    if (window.ScheduleV2Filters) {
      ScheduleV2Filters.mount(filtersEl, {
        onChange: function (filters) {
          if (!window._sch2Catalog) return;
          var filtered = ScheduleV2Filters.apply(window._sch2Catalog.doctors, filters);
          ScheduleV2List.render(filtered);
        }
      });
    }

    if (window.ScheduleV2List) {
      ScheduleV2List.mount(listEl, {});
      ScheduleV2List.showLoading();
    }

    if (window.ScheduleV2Booking) {
      ScheduleV2Booking.mount(nodes.booking);
    }

    // На preview-странице UI уже на странице; на сайте — в старой модалке
    if (!window.SCHEDULE_V2_PREVIEW && window.jQuery && jQuery('#referenceDateModal').modal) {
      jQuery('#referenceDateModal').modal('show');
    }

    ScheduleV2Api.loadCatalog()
      .then(function (catalog) {
        window._sch2Catalog = catalog;
        var doctors = (ScheduleV2Filters && ScheduleV2Filters.apply)
          ? ScheduleV2Filters.apply(catalog.doctors || [], ScheduleV2Filters.getState())
          : (catalog.doctors || []);
        ScheduleV2List.render(doctors);
      })
      .catch(function (err) {
        console.error(err);
        ScheduleV2List.showError();
      });
  }

  function openDoctor(bitrixId) {
    // TODO: найти врача в каталоге / догрузить GetDoctor-аналог и показать одну карточку
    openList();
    console.info('[ScheduleV2] openDoctor', bitrixId);
  }

  var ScheduleV2 = {
    isEnabled: function () {
      return true;
    },
    openList: openList,
    openDoctor: openDoctor
  };

  window.ScheduleV2 = ScheduleV2;

  // Перехват entry-точек после загрузки doctorsPopup.js
  if (typeof window.SelectDoctorPopup === 'function') {
    window._SelectDoctorPopupLegacy = window.SelectDoctorPopup;
    window.SelectDoctorPopup = function () {
      return openList();
    };
  }

  if (typeof window.ShowPersonalDoctorPopup === 'function') {
    window._ShowPersonalDoctorPopupLegacy = window.ShowPersonalDoctorPopup;
    window.ShowPersonalDoctorPopup = function (id) {
      return openDoctor(id);
    };
  }
})(window, document);
