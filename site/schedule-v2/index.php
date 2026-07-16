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
    <p>
      Команда специалистов — наша главная ценность. Наши врачи своевременно ставят диагнозы и подбирают подходящий способ лечения для каждого пациента, учитывая его личную ситуацию. Они станут вашими проводниками на всех этапах лечения.
    </p>

  </div>
</section>

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
