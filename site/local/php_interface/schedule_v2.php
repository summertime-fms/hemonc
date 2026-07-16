<?php

/**
 * Feature-flag нового UI расписания (schedule-v2).
 *
 * Включение:
 * 1) Глобально: define('SCHEDULE_UI_V2', true) в .settings.php (на проде — только после готовности)
 * 2) Для верстальщика/теста: ?schedule_v2=1 — ставит cookie на 7 дней
 * 3) Выключить cookie: ?schedule_v2=0
 * 4) Страница /schedule-v2/ всегда в режиме preview (мок-данные)
 */

if (!defined('SCHEDULE_UI_V2')) {
    define('SCHEDULE_UI_V2', false);
}

/**
 * Cookie / query override без смены константы на проде.
 */
function hemonc_schedule_v2_cookie_enabled(): bool
{
    $request = \Bitrix\Main\Context::getCurrent()->getRequest();

    if ($request->get('schedule_v2') === '1') {
        setcookie('schedule_v2', '1', time() + 7 * 86400, '/');
        return true;
    }

    if ($request->get('schedule_v2') === '0') {
        setcookie('schedule_v2', '', time() - 3600, '/');
        return false;
    }

    return ($request->getCookie('schedule_v2') === '1');
}

function hemonc_is_schedule_v2_enabled(): bool
{
    if (defined('SCHEDULE_UI_V2') && SCHEDULE_UI_V2 === true) {
        return true;
    }

    return hemonc_schedule_v2_cookie_enabled();
}

/**
 * Страница песочницы верстальщика — всегда грузит v2 + mock.
 */
function hemonc_is_schedule_v2_preview_page(): bool
{
    $request = \Bitrix\Main\Context::getCurrent()->getRequest();
    $uri = (string) $request->getRequestUri();

    return strpos($uri, '/schedule-v2') === 0;
}

/**
 * Подключение CSS/JS нового расписания.
 * Старые doctorsPopup.js / calendar.js / doctorsPopup.css не трогаем.
 */
function hemonc_register_schedule_v2_assets(): void
{
    if (!hemonc_is_schedule_v2_enabled() && !hemonc_is_schedule_v2_preview_page()) {
        return;
    }

    $asset = \Bitrix\Main\Page\Asset::getInstance();
    $base = SITE_TEMPLATE_PATH . '/schedule-v2';

    $asset->addCss($base . '/css/schedule-v2.css');

    // Порядок важен: api → модули → entry (перехватывает SelectDoctorPopup / ShowPersonalDoctorPopup)
    $asset->addJs($base . '/js/schedule-v2-api.js');
    $asset->addJs($base . '/js/schedule-v2-filters.js');
    $asset->addJs($base . '/js/schedule-v2-list.js');
    $asset->addJs($base . '/js/schedule-v2-card.js');
    $asset->addJs($base . '/js/schedule-v2-slots.js');
    $asset->addJs($base . '/js/schedule-v2-booking.js');
    $asset->addJs($base . '/js/schedule-v2.js');
}
