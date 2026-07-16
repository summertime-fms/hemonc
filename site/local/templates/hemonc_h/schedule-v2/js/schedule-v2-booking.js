/**
 * Поп-ап записи: сценарий А (к врачу) и Б (процедура).
 */
(function (window) {
  'use strict';

  window.ScheduleV2Booking = {
    /**
     * @param {HTMLElement} root — контейнер модалки/оверлея
     */
    mount: function (root) {
      this._root = root;
    },

    /**
     * Сценарий А
     * @param {{ doctor, date, time, format, visitType }} context
     */
    openDoctor: function (context) {
      if (!this._root) return;
      // TODO: верстка формы ФИО / телефон / email + кнопка «Подтвердить запись»
      this._root.innerHTML =
        '<div class="sch2-booking sch2-booking--doctor" data-sch2="booking-doctor">' +
          '<div class="sch2-booking__context"></div>' +
          '<form class="sch2-booking__form"></form>' +
        '</div>';
      this._context = context || {};
      this._mode = 'doctor';
    },

    /**
     * Сценарий Б
     * @param {{ procedure, date, time, cabinet }} context
     */
    openProcedure: function (context) {
      if (!this._root) return;
      this._root.innerHTML =
        '<div class="sch2-booking sch2-booking--procedure" data-sch2="booking-procedure">' +
          '<div class="sch2-booking__context"></div>' +
          '<form class="sch2-booking__form"></form>' +
        '</div>';
      this._context = context || {};
      this._mode = 'procedure';
    },

    close: function () {
      if (this._root) this._root.innerHTML = '';
      this._context = null;
      this._mode = null;
    }
  };
})(window);
