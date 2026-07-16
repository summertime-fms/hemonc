/**
 * Слой данных schedule-v2.
 * Preview (/schedule-v2/): мок из /local/templates/.../schedule-v2/mock/
 * Боевой режим: позже — те же AJAX action, парсинг расширенных ответов 1С.
 */
(function (window) {
  'use strict';

  var MOCK_BASE = '/local/templates/hemonc_h/schedule-v2/mock';

  function isPreview() {
    return !!window.SCHEDULE_V2_PREVIEW;
  }

  function fetchJson(url) {
    return fetch(url, { credentials: 'same-origin' }).then(function (r) {
      if (!r.ok) throw new Error('HTTP ' + r.status + ' ' + url);
      return r.json();
    });
  }

  window.ScheduleV2Api = {
    /**
     * Список врачей + ближайшие слоты + форматы (для фильтров на клиенте).
     * @returns {Promise<{doctors: Array, specialties: Array, services: Array}>}
     */
    loadCatalog: function () {
      if (isPreview()) {
        return fetchJson(MOCK_BASE + '/catalog.json');
      }
      // TODO: POST /ajax/ action=DoctorsSelectPopupV2 (или расширенный DoctorsSelectPopup → JSON)
      return Promise.reject(new Error('ScheduleV2Api.loadCatalog: live mode not wired yet'));
    },

    /**
     * Слоты врача на неделю (или день).
     * @param {{doctorGuid: string, visitType?: string, format?: string}} params
     */
    loadSlots: function (params) {
      if (isPreview()) {
        return fetchJson(MOCK_BASE + '/slots.json').then(function (data) {
          var key = params && params.doctorGuid;
          return (data && data[key]) || data._default || { days: [] };
        });
      }
      // TODO: GetHours / пакетный запрос по дням
      return Promise.reject(new Error('ScheduleV2Api.loadSlots: live mode not wired yet'));
    },

    /**
     * Создание записи (сценарий А — к врачу).
     */
    bookDoctor: function (payload) {
      if (isPreview()) {
        console.info('[ScheduleV2Api] mock bookDoctor', payload);
        return Promise.resolve({ result: true, message: 'success' });
      }
      // TODO: SetOrder + новые поля format, visitType, patientName, patientEmail
      return Promise.reject(new Error('ScheduleV2Api.bookDoctor: live mode not wired yet'));
    },

    /**
     * Создание записи (сценарий Б — процедура).
     */
    bookProcedure: function (payload) {
      if (isPreview()) {
        console.info('[ScheduleV2Api] mock bookProcedure', payload);
        return Promise.resolve({ result: true, message: 'success' });
      }
      return Promise.reject(new Error('ScheduleV2Api.bookProcedure: live mode not wired yet'));
    }
  };
})(window);
