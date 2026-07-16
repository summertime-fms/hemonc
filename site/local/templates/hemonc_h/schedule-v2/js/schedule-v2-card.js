/**
 * Карточка врача: фото, инфо, теги форматов, табы Первичный/Повторный, сетка слотов.
 */
(function (window) {
  'use strict';

  window.ScheduleV2Card = {
    /**
     * Возвращает HTML-строку карточки (каркас без финальной вёрстки).
     * @param {object} doctor
     * @returns {string}
     */
    render: function (doctor) {
      doctor = doctor || {};
      var guid = doctor.doctorGuid || '';
      var name = doctor.name || '';

      return (
        '<article class="sch2-card" data-doctor-guid="' + guid + '">' +
          '<div class="sch2-card__photo" data-sch2="photo"></div>' +
          '<div class="sch2-card__info" data-sch2="info">' +
            '<div class="sch2-card__name">' + name + '</div>' +
            '<div class="sch2-card__specialty"></div>' +
            '<div class="sch2-card__meta"></div>' +
          '</div>' +
          '<div class="sch2-card__formats" data-sch2="formats"></div>' +
          '<div class="sch2-card__visit-type" data-sch2="visit-type">' +
            '<!-- табы: primary / repeat -->' +
          '</div>' +
          '<div class="sch2-card__slots" data-sch2="slots">' +
            '<!-- ScheduleV2Slots.mount сюда -->' +
          '</div>' +
        '</article>'
      );
    }
  };
})(window);
