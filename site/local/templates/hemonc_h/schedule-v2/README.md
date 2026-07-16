# schedule-v2 — новое расписание (для верстальщика)

Старое расписание (`js/doctorsPopup.js`, `js/calendar.js`, `css/doctorsPopup.css`) **не трогаем**.

## Как смотреть результат

| Способ | URL |
|--------|-----|
| Песочница (рекомендуется) | `/schedule-v2/` |
| Подмена кнопок на сайте | любая страница + `?schedule_v2=1` |
| Выключить подмену | `?schedule_v2=0` |

На `/schedule-v2/` всегда мок-данные из папки `mock/`.

## Что править

| Задача | Файлы |
|--------|-------|
| Стили | `css/schedule-v2.css` |
| Фильтры | `js/schedule-v2-filters.js` |
| Список / empty / loader | `js/schedule-v2-list.js` |
| Карточка врача | `js/schedule-v2-card.js` |
| Сетка слотов | `js/schedule-v2-slots.js` |
| Поп-ап записи | `js/schedule-v2-booking.js` |
| Тестовые данные | `mock/catalog.json`, `mock/slots.json` |
| Чеклист блоков | `markup/_blocks.md` |

Префикс классов: **`sch2-`** — чтобы не пересечься со старыми стилями.

## Чего не делать

- Не править `doctorsPopup.js` / `calendar.js` / `doctorsPopup.css`
- Не подключать v2-стили глобально в `site-f.css`
- Не ходить в 1С из вёрстки — только mock, пока бэкенд не подключит live mode в `schedule-v2-api.js`
