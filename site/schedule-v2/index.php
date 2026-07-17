<?php

/**
 * Песочница нового расписания для верстальщика.
 * URL: /schedule-v2/
 *
 * Всегда использует mock JSON, не ломает боевую запись.
 * Старое расписание на сайте не затрагивается.
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Наши врачи');
$APPLICATION->SetPageProperty('title', 'Наши врачи');

$APPLICATION->AddViewContent('header-class', 'default-main-block-header full-width');
$APPLICATION->AddViewContent(
    'header-content',
    '<p>Команда специалистов — наша главная ценность. Наши врачи своевременно ставят диагнозы и подбирают подходящий способ лечения для каждого пациента, учитывая его личную ситуацию. Они станут вашими проводниками на всех этапах лечения.</p>'
);

// Гарантируем подключение ассетов, даже если cookie не выставлена
if (function_exists('hemonc_register_schedule_v2_assets')) {
    hemonc_register_schedule_v2_assets();
}
?>

<script>
  window.SCHEDULE_V2_PREVIEW = true;
</script>

<link rel="stylesheet" href="./tom-select/tom-select.min.css">
<link rel="stylesheet" href="./schedule.css">

<section class="schedule">
  <div class="wrapper">
    <form class="schedule-filters" aria-label="Фильтры расписания">
      <div class="schedule-filters__row">
        <label class="schedule-filter">
          <span class="schedule-filter__label">Специализация врача</span>
          <select class="schedule-filter__select" name="specialization[]" multiple data-filter="specialization" data-placeholder="Специализация врача">
            <optgroup label="Онкология">
              <option value="oncologist">Онколог</option>
              <option value="chemotherapist">Химиотерапевт</option>
              <option value="mammologist">Маммолог</option>
              <option value="onco-gynecologist">Онкогинеколог</option>
            </optgroup>
            <optgroup label="Диагностика">
              <option value="radiologist">Радиолог</option>
              <option value="ultrasound">Врач УЗИ</option>
              <option value="endoscopist">Эндоскопист</option>
            </optgroup>
            <optgroup label="Поддерживающая терапия">
              <option value="hematologist">Гематолог</option>
              <option value="nutritionist">Диетолог</option>
              <option value="psychotherapist">Психотерапевт</option>
            </optgroup>
          </select>
        </label>

        <label class="schedule-filter">
          <span class="schedule-filter__label">Заболевание</span>
          <select class="schedule-filter__select" name="disease[]" multiple data-filter="disease" data-placeholder="Заболевание">
            <option value="breast-cancer">Рак молочной железы</option>
            <option value="lung-cancer">Рак лёгкого</option>
            <option value="colon-cancer">Колоректальный рак</option>
            <option value="lymphoma">Лимфома</option>
            <option value="melanoma">Меланома</option>
            <option value="prostate-cancer">Рак предстательной железы</option>
          </select>
        </label>

        <label class="schedule-filter">
          <span class="schedule-filter__label">Услуга</span>
          <select class="schedule-filter__select" name="service[]" multiple data-filter="service" data-placeholder="Услуга">
            <option value="primary-consultation">Первичная консультация</option>
            <option value="second-opinion">Второе мнение</option>
            <option value="chemotherapy">Химиотерапия</option>
            <option value="check-up">Онкологический чек-ап</option>
            <option value="diagnostics">Диагностика</option>
            <option value="support-therapy">Поддерживающая терапия</option>
          </select>
        </label>

        <label class="schedule-filter schedule-filter--format">
          <span class="schedule-filter__label">Формат приёма</span>
          <select class="schedule-filter__select" name="format" data-filter="format" data-placeholder="Формат приёма">
            <option value="any">Любой</option>
            <option value="clinic">Очно в клинике</option>
            <option value="online">Онлайн-консультация (дистанционно)</option>
            <option value="home">Выезд на дом</option>
          </select>
        </label>

        <label class="schedule-filters__nearest">
          <input class="schedule-filters__nearest-input" type="checkbox" name="nearest">
          <span class="schedule-filters__nearest-box" aria-hidden="true"></span>
          <span class="schedule-filters__nearest-text">Нужен ближайший приём</span>
        </label>
      </div>
    </form>

    <ul class="schedule__list">
      <li class="schedule__list-item doctor-card">
        <div class="doctor-card__body">
          <div class="doctor-card__photo">
            <img src="https://hemonc.ru/upload/dev2fun.imagecompress/webp/iblock/f7a/m9clo41isnw1o0o8hjri1z3b1jdh7zx0.webp" alt="Рушниченко Анастасия Владимировна" loading="lazy">
          </div>

          <div class="doctor-card__name">Рушниченко Анастасия Владимировна</div>

          <div class="doctor-card__row">
            <div class="doctor-card__specializations">
              <div class="doctor-card__specializations-item">Онколог</div>
              <div class="doctor-card__specializations-item">Химиотерапевт</div>
            </div>

            <div class="doctor-card__type">
              <div class="doctor-card__type-item">Очный приём</div>
              <div class="doctor-card__type-item">Приём онлайн</div>
            </div>

            <div class="doctor-card__descr"></div>

            <a href="#" class="doctor-card__more">Подробнее о враче</a>
          </div>
        </div>

        <div class="doctor-card__footer">
          <div class="service-details">
            <div class="service-details__item">
              <span class="service-details__label">Стоимость приёма</span>
              <span class="service-details__dots"></span>
              <span class="service-details__value">от 5 500 ₽</span>
            </div>

            <div class="service-details__item">
              <span class="service-details__label">Ближайшая запись</span>
              <span class="service-details__dots"></span>
              <span class="service-details__value">16.07.2026 в 13:00</span>
            </div>
          </div>

          <button class="btn" type="button">Записаться на приём</button>
        </div>
      </li>
    </ul>
  </div>
</section>

<script src="./tom-select/tom-select.complete.min.js"></script>
<script src="./schedule.js"></script>

<!-- <script>
  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('sch2PreviewOpen');
    if (btn && window.ScheduleV2) {
      btn.addEventListener('click', function () {
        ScheduleV2.openList();
      });
      // Автозапуск списка на странице preview
      ScheduleV2.openList();
    }
  });
</script> -->

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
