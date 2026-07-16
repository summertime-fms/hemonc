/**
 * Панель фильтров: специальность, услуга/заболевание, формат, «Ближайший приём».
 * Фильтрация — на клиенте по уже загруженному catalog.
 */
(function (window) {
  'use strict';

  window.ScheduleV2Filters = {
    /**
     * @param {HTMLElement} root
     * @param {{ onChange: function(filters): void }} options
     */
    mount: function (root, options) {
      // TODO: верстка + обработчики
      this._root = root;
      this._onChange = options && options.onChange;
      this._state = {
        specialties: [],
        serviceQuery: '',
        serviceId: null,
        format: 'any', // any | clinic | online | home
        sortNearest: false
      };
    },

    getState: function () {
      return Object.assign({}, this._state);
    },

    /**
     * @param {Array} doctors
     * @param {object} filters
     * @returns {Array}
     */
    apply: function (doctors, filters) {
      var list = doctors.slice();
      filters = filters || this._state;

      if (filters.specialties && filters.specialties.length) {
        list = list.filter(function (d) {
          return filters.specialties.indexOf(d.specialtyCode) !== -1;
        });
      }

      if (filters.serviceId) {
        list = list.filter(function (d) {
          return (d.serviceIds || []).indexOf(filters.serviceId) !== -1;
        });
      }

      if (filters.format && filters.format !== 'any') {
        list = list.filter(function (d) {
          return (d.formats || []).indexOf(filters.format) !== -1;
        });
      }

      if (filters.sortNearest) {
        list.sort(function (a, b) {
          var ta = a.nearestTs || Number.MAX_SAFE_INTEGER;
          var tb = b.nearestTs || Number.MAX_SAFE_INTEGER;
          return ta - tb;
        });
      }

      return list;
    },

    reset: function () {
      this._state = {
        specialties: [],
        serviceQuery: '',
        serviceId: null,
        format: 'any',
        sortNearest: false
      };
      if (this._onChange) this._onChange(this.getState());
    }
  };
})(window);
