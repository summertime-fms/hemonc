# Новое расписание без поломки старого (schedule-v2)

## Идея

Старый UI записи (`doctorsPopup.js` + `calendar.js` + HTML из `/ajax/`) остаётся как есть.  
Новый UI живёт в отдельной папке `schedule-v2/` и подключается только по флагу или на preview-странице.

```
Прод (флаг OFF)          Верстальщик / QA (флаг ON или /schedule-v2/)
─────────────────        ────────────────────────────────────────────
SelectDoctorPopup   →    SelectDoctorPopup перехвачен schedule-v2.js
  ↓ старый AJAX HTML       ↓ mock JSON / позже новые AJAX
старая модалка             .sch2-* UI
```

## Файловая структура

```
site/
  schedule-v2/
    index.php                          ← песочница /schedule-v2/

  local/
    php_interface/
      schedule_v2.php                  ← флаг + регистрация ассетов
      init.php                         ← require schedule_v2.php

    templates/hemonc_h/
      header.php                       ← вызов hemonc_register_schedule_v2_assets()

      js/doctorsPopup.js               ← НЕ ТРОГАТЬ
      js/calendar.js                   ← НЕ ТРОГАТЬ
      css/doctorsPopup.css             ← НЕ ТРОГАТЬ

      schedule-v2/
        README.md                      ← инструкция верстальщику
        css/schedule-v2.css
        js/
          schedule-v2-api.js           ← mock / live данные
          schedule-v2-filters.js
          schedule-v2-list.js
          schedule-v2-card.js
          schedule-v2-slots.js
          schedule-v2-booking.js
          schedule-v2.js               ← entry + перехват popup-функций
        mock/
          catalog.json
          slots.json
        markup/
          _blocks.md                   ← чеклист блоков ТЗ
```

## Почему отдельные JS-файлы

| Файл | Зона ответственности |
|------|----------------------|
| `schedule-v2-api.js` | Данные (мок ↔ 1С), без UI |
| `schedule-v2-filters.js` | Панель фильтров + client-side filter |
| `schedule-v2-list.js` | Список, loader, error, empty |
| `schedule-v2-card.js` | Карточка врача |
| `schedule-v2-slots.js` | Сетка дней/слотов |
| `schedule-v2-booking.js` | Поп-ап записи А/Б |
| `schedule-v2.js` | Сборка + перехват entry |

Верстальщик может править CSS и один модуль (например карточку), не конфликтуя с бэкендом в `api`.

Префикс классов: **`sch2-`**.

## Как включать

| Режим | Как |
|-------|-----|
| Песочница | открыть `/schedule-v2/` |
| Подмена кнопок на сайте | `?schedule_v2=1` (cookie 7 дней) |
| Выключить | `?schedule_v2=0` |
| Глобально на проде | `define('SCHEDULE_UI_V2', true)` в `.settings.php` — только после приёмки |

Пока флаг выключен и нет cookie — сайт работает по-старому на 100%.

## Этапы

1. **Сейчас** — каркас + моки; верстальщик наполняет CSS/HTML в `render`/`mount`.
2. **Бэкенд** — JSON-action для каталога/слотов (или расширение текущих), wiring в `schedule-v2-api.js` live mode.
3. **1С** — расширение полей (см. `docs/1с_schedule.md`).
4. **Переключение** — cookie → `SCHEDULE_UI_V2=true` → позже удаление legacy.

## Важно

- Старые AJAX (`DoctorsSelectPopup`, `GetDoctor`, `GetHours`, `SetOrder`) продолжают обслуживать старый UI.
- Новый UI на preview не зависит от 1С.
- Не смешивать стили v2 в `site-f.css` / `doctorsPopup.css`.
