<?php

/**
 * Песочница нового расписания для верстальщика.
 * URL: /schedule-v2/
 *
 * Всегда использует mock JSON, не ломает боевую запись.
 * Старое расписание на сайте не затрагивается.
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Расписание (preview v2)');
$APPLICATION->SetPageProperty('title', 'Расписание — preview v2');

// Гарантируем подключение ассетов, даже если cookie не выставлена
if (function_exists('hemonc_register_schedule_v2_assets')) {
    hemonc_register_schedule_v2_assets();
}
?>

<script>
  window.SCHEDULE_V2_PREVIEW = true;
</script>

<section class="sch2 sch2--preview" data-sch2-preview="1">
  <div class="container">
    <h1>Расписание — preview v2</h1>
    <p>
      Песочница для вёрстки. Данные из mock JSON.
      Боевые кнопки «Запись на приём» на сайте не меняются, пока не включён флаг
      <code>?schedule_v2=1</code> или константа <code>SCHEDULE_UI_V2</code>.
    </p>
    <p>
      <button type="button" class="btn" id="sch2PreviewOpen">Открыть список врачей</button>
      <a class="btn" href="?schedule_v2=1">Включить v2 на всём сайте (cookie)</a>
      <a class="btn" href="?schedule_v2=0">Выключить cookie</a>
    </p>

    <!-- Контейнер, куда entry монтирует UI (дублирует логику модалки) -->
    <div id="scheduleV2PreviewHost" class="sch2__preview-host">
      <div id="scheduleV2Root" class="sch2" data-sch2-root="1"></div>
      <div id="scheduleV2Booking" class="sch2-booking-host"></div>
    </div>
  </div>
</section>

<script>
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
</script>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
