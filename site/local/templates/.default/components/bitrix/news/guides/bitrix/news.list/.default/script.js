(function () {
  function initGuideHub(hub) {
    var filterButtons = hub.querySelectorAll('[data-guide-tag]');
    var cards = hub.querySelectorAll('.guide-card[data-guide-tags]');
    var emptyState = hub.querySelector('.guide-hub__empty');

    if (!filterButtons.length || !cards.length) {
      return;
    }

    function applyFilter(tagId) {
      var visibleCount = 0;

      cards.forEach(function (card) {
        var cardTags = (card.getAttribute('data-guide-tags') || '')
          .split(/\s+/)
          .filter(Boolean);
        var isVisible = !tagId || cardTags.indexOf(tagId) !== -1;

        card.hidden = !isVisible;
        if (isVisible) {
          visibleCount += 1;
        }
      });

      filterButtons.forEach(function (button) {
        var isActive = (button.getAttribute('data-guide-tag') || '') === tagId;
        button.classList.toggle('is-active', isActive);
      });

      if (emptyState) {
        emptyState.hidden = visibleCount > 0;
      }
    }

    hub.addEventListener('click', function (event) {
      var button = event.target.closest('[data-guide-tag]');
      if (!button || !hub.contains(button)) {
        return;
      }

      event.preventDefault();
      applyFilter(button.getAttribute('data-guide-tag') || '');
    });
  }

  function boot() {
    document.querySelectorAll('[data-guide-hub]').forEach(initGuideHub);
  }

  if (typeof BX !== 'undefined' && typeof BX.ready === 'function') {
    BX.ready(boot);
  } else if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
