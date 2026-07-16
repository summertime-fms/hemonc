/**
 * Горизонтальная сетка дней + слоты с цветовым кодированием format.
 */
(function (window) {
  'use strict';

  window.ScheduleV2Slots = {
    /**
     * @param {HTMLElement} root
     * @param {{ days: Array, visitType: string, onSelect: function }} options
     */
    mount: function (root, options) {
      this._root = root;
      this._options = options || {};
      if (options && options.days) {
        this.render(options.days, options.visitType || 'primary');
      }
    },

    /**
     * @param {Array<{date: string, label?: string, slots: Array}>} days
     * @param {string} visitType primary|repeat
     */
    render: function (days, visitType) {
      if (!this._root) return;
      days = days || [];
      visitType = visitType || 'primary';

      var html = '<div class="sch2-slots" data-sch2="slots-grid"><div class="sch2-slots__days">';

      for (var i = 0; i < days.length; i++) {
        var day = days[i];
        var slots = day.slots || [];
        var visible = slots.filter(function (s) {
          return !s.visitTypes || s.visitTypes.indexOf(visitType) !== -1;
        });

        html += '<div class="sch2-slots__day" data-date="' + (day.date || '') + '">';
        html += '<div class="sch2-slots__day-label">' + (day.label || day.date || '') + '</div>';

        if (!visible.length) {
          html +=
            '<a href="#" class="sch2-slots__empty" data-sch2-action="show-nearest">Показать ближайшие</a>';
        } else {
          for (var j = 0; j < visible.length; j++) {
            var s = visible[j];
            var fmt = s.format || 'clinic';
            html +=
              '<button type="button" class="sch2-slots__slot sch2-slots__slot--' + fmt + '"' +
              ' data-time="' + (s.time || '') + '"' +
              ' data-format="' + fmt + '">' +
              (s.time || '') +
              '</button>';
          }
        }

        html += '</div>';
      }

      html += '</div></div>';
      this._root.innerHTML = html;
    }
  };
})(window);
