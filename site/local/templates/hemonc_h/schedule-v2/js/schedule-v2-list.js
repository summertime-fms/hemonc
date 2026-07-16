/**
 * Список карточек врачей + empty/error/loading.
 */
(function (window) {
  'use strict';

  window.ScheduleV2List = {
    /**
     * @param {HTMLElement} root
     * @param {{ onSelectSlot: function, onShowNearest: function }} options
     */
    mount: function (root, options) {
      this._root = root;
      this._options = options || {};
    },

    showLoading: function () {
      if (!this._root) return;
      this._root.innerHTML = '<div class="sch2-state sch2-state--loading" data-sch2-state="loading"></div>';
    },

    showError: function (message) {
      if (!this._root) return;
      this._root.innerHTML =
        '<div class="sch2-state sch2-state--error" data-sch2-state="error">' +
        '<p>' + (message || 'Не удалось загрузить расписание') + '</p>' +
        '</div>';
    },

    showEmpty: function () {
      if (!this._root) return;
      this._root.innerHTML =
        '<div class="sch2-state sch2-state--empty" data-sch2-state="empty">' +
        '<p>Врачи не найдены</p>' +
        '<button type="button" data-sch2-action="reset-filters">Сбросить фильтры</button>' +
        '</div>';
    },

    /**
     * @param {Array} doctors
     */
    render: function (doctors) {
      if (!this._root) return;
      if (!doctors || !doctors.length) {
        this.showEmpty();
        return;
      }

      // TODO: верстка списка — вызывать ScheduleV2Card.render(doctor) для каждой карточки
      var html = '<div class="sch2-list" data-sch2="list">';
      for (var i = 0; i < doctors.length; i++) {
        html += window.ScheduleV2Card
          ? window.ScheduleV2Card.render(doctors[i])
          : '<div class="sch2-card" data-doctor-guid="' + doctors[i].doctorGuid + '"></div>';
      }
      html += '</div>';
      this._root.innerHTML = html;
    }
  };
})(window);
