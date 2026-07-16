<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2024
 */

define('STOP_STATISTICS', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$GLOBALS['APPLICATION']->RestartBuffer();

if (!$request->isPost()) {
    exit('False');
}


if ($request['action'] === 'short_link_create') {
    header('Content-Type: application/json; charset=utf-8');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/ShortLinkService.php';

    if (defined('SHORT_LINK_API_TOKEN') && SHORT_LINK_API_TOKEN !== '') {
        $token = (string) $request->getHeader('X-Short-Link-Token');
        if ($token !== SHORT_LINK_API_TOKEN) {
            http_response_code(403);
            exit(json_encode(['success' => false, 'error' => 'Forbidden'], JSON_UNESCAPED_UNICODE));
        }
    }

    $raw = (string) file_get_contents('php://input');
    $input = json_decode($raw, true);
    if (!is_array($input)) {
        $input = [];
    }

    $guid = trim((string) ($input['pacientguid'] ?? $input['UF_PACIENT_GUID'] ?? $request->getPost('pacientguid') ?? ''));

    if ($guid === '') {
        http_response_code(400);
        exit(json_encode(['success' => false, 'error' => 'Укажите pacientguid'], JSON_UNESCAPED_UNICODE));
    }

    try {
        $row = ShortLinkService::createOrReuse($guid);
        $code = $row['UF_SHORTCODE'];
        exit(json_encode([
            'success' => true,
            'code' => $code,
            'url' => ShortLinkService::buildShortUrl($request, $code),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    } catch (Throwable $e) {
        http_response_code(500);
        exit(json_encode(['success' => false, 'error' => $e->getMessage()], JSON_UNESCAPED_UNICODE));
    }
}

\Bitrix\Main\Loader::includeModule('iblock');

if ($request["action"] == 'DoctorsSelectPopup') {
    $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([
        'select' => [
            'ID',
            'NAME',
            'PREVIEW_PICTURE',
            'ONES_GUID_'  => 'ONES_GUID',
            'CLINIC_GUID_'  => 'CLINIC_GUID',
            'MID_NAME_'   => 'MID_NAME',
            'FIRST_NAME_' => 'FIRST_NAME',
            'TITLE_'      => 'TITLE',
            'PRICE_CLINIC_' => 'PRICE_CLINIC',
            'PRICE_ONLINE_' => 'PRICE_ONLINE',
        ],
        'filter' => [
            '=ACTIVE' => 'Y',
        ],
        'order' => [
            'SORT' => 'ASC',
        ],
    ])->fetchAll();

    $ScheduleUpdate = \Hemonc\Ajax::getSchedule();

    foreach ($doctors as $k => $doctor) {
        if (empty($doctor['ONES_GUID_VALUE'])) {
            // unset($doctors[$k]);
            // continue;
        }
        if (isset($ScheduleUpdate[$doctor['ONES_GUID_VALUE']])) {
            $doctors[$k]['ScheduleUpdate'] = '<div class="doctor-nearest-time-info">Ближайшее свободное время:<br>' . $ScheduleUpdate[$doctor['ONES_GUID_VALUE']] . '</div>';
            $doctors[$k]['hasSchedule'] = true;
        } else {
            $doctors[$k]['ScheduleUpdate'] = '<div class="doctor-nearest-time-info">Запись по телефону</div>';
            $doctors[$k]['hasSchedule'] = false;

            $doctors[$k]['hasSchedule'] = true;
        }
    }
    ?>

    <div class="popup-form">
        <div class="popup-title">
            <span>Запись на прием</span>
            <button class="modal-close" onclick="CloseDoctorsPopup()"></button>
        </div>
        <div class="popup-info">
            Выберите карточку врача, после чего появится форма, которую необходимо заполнить.
        </div>
        <div class="popup-items-scroll customscroll-gray">
            <div class="popup-items-container">
                <?php foreach ($doctors as $doctor) { ?>
                    <div class="our-doctor-item bgdefault card" <?=$doctor['hasSchedule'] ? 'onclick="ShowPersonalDoctorPopup(' . $doctor['ID'] . ');"' : ''?>>
                        <div class="head">
                            <div class="up">
                                <?php if (!empty($doctor["PREVIEW_PICTURE"])) { ?>
                                    <a class="img">
                                        <img src="<?=\CFile::GetPath($doctor["PREVIEW_PICTURE"])?>" class="doctor-list-item__photo" />
                                    </a>
                                <?php }?>
                                <a class="name">
                                    <?=$doctor['FIRST_NAME_VALUE']?>
                                    <?=$doctor['MID_NAME_VALUE']?>
                                    <em><?=$doctor['NAME']?></em>
                                </a>

                                <small>
                                    <?=$doctor['TITLE_VALUE']?>
                                </small>
                                <div class="doctor-card-first-price">
                                    Первичный прием - <?=$doctor['PRICE_CLINIC_VALUE'] ?: $doctor['PRICE_ONLINE_VALUE']?>
                                    <?=$doctor['ScheduleUpdate']?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } elseif ($request["action"] == 'GetDoctor') {
    $notAvail = false;

    if (!isset($request["doctorId"])) {
        $notAvail = true;
    }

    if (!isset($request["inline"]) || $request["inline"] != true) {
        $inline = false;
    } else {
        $inline = true;
    }

    if (!$notAvail) {
        $doctor = \Bitrix\Iblock\Elements\ElementDoctorsTable::getByPrimary($request["doctorId"], [
            'select' => [
                'ID',
                'NAME',
                'PREVIEW_PICTURE',
                'ONES_GUID_'  => 'ONES_GUID',
                'CLINIC_GUID_'  => 'CLINIC_GUID',
                'MID_NAME_'   => 'MID_NAME',
                'FIRST_NAME_' => 'FIRST_NAME',
                'TITLE_'      => 'TITLE',
                'PRICE_CLINIC_' => 'PRICE_CLINIC',
                'PRICE_ONLINE_' => 'PRICE_ONLINE',
            ],
            'filter' => [
                '=ACTIVE' => 'Y',
            ],
        ])->fetch();
    }

    if (
        !$doctor
        || !$doctor['ONES_GUID_VALUE']
    ) {
        $notAvail = true;
    }

    if (!$notAvail) {
        $doctorSchedule = \Hemonc\Ajax::getDoctorSchedule($doctor['ONES_GUID_VALUE']);

        if (empty($doctorSchedule)) {
            $notAvail = true;
        } else {
            foreach ($doctorSchedule as $doctorDate => $guid) {
                if (strtotime($doctorDate) > strtotime('now')) {
                    $notAvail = false;
                } else {
                    $notAvail = true;
                }
            }
        }
    }

    if ($notAvail) { ?>
        <script>
            $(function () {
                $(".modal-close").click(function () {
                    $("#referenceDateModal").modal("hide");
                });
            });
        </script>
        <button class="modal-return" onclick="SelectDoctorPopup()"></button>
        <button class="modal-close"></button>

        <span class="modal-title">Для записи позвоните нам или оставьте номер</span>
        <div class="set-time-block">
            <div class="online-subtitle">
                <a href="#" class="doctor-name-item">
                    <span class="img">
                        <img src="<?=\CFile::GetPath($doctor["PREVIEW_PICTURE"])?>"/>
                    </span>
                    <span class="name">
                        <?=$doctor["NAME"]?>
                        <?=$doctor["FIRST_NAME_VALUE"]?>
                        <?=$doctor["MID_NAME_VALUE"]?>
                    </span>
                </a>
            </div>
            <div class="clearfix"></div>

            <div class="online-subtitle__call-today">
                Хотите записаться?
            </div>
            <?php $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                [
                    "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixCallback.php",
                    "AREA_FILE_SHOW" => "file",
                ],
            ); ?>
        </div>
    <?php } else {
        $calendar     = \Hemonc\Ajax::calendar();
        $calendarNext = \Hemonc\Ajax::calendar($calendar['nextYear'], $calendar['nextMonth']);

        if (!$inline) { ?>
            <script>
                $(function () {
                    $(".modal-close").click(function () {
                        $("#referenceDateModal").modal("hide");
                    });
                });
            </script>
            <button class="modal-return" onclick="SelectDoctorPopup()"></button>
            <button class="modal-close"></button>

            <span class="modal-title">Выберите дату и время</span>

            <div class="set-time-block">
                <div class="online-subtitle">
                    <a href="#" class="doctor-name-item">
                        <span class="img">
                            <img src="<?=\CFile::GetPath($doctor["PREVIEW_PICTURE"])?>"/>
                        </span>
                        <span class="name">
                            <?=$doctor["NAME"]?>
                            <?=$doctor["FIRST_NAME_VALUE"]?>
                            <?=$doctor["MID_NAME_VALUE"]?>
                        </span>
                    </a>
                    <?=\array_key_exists(date('d.m.Y'), $doctorSchedule) ? '
                                    <div class="online-subtitle__call-today">
                                        Хотите записаться на сегодня?<br/>Позвоните по телефону или напишите в чат.
                                    </div>' : ''?>
                </div>
                <div class="clearfix"></div>

                <div class="set-time-calendar">
                    <div>
                        <div class="dnc-calendar">
                            <div class="dnc-calendar__prev" onclick="scrollMonthPrev();"></div>
                            <div class="dnc-calendar__months-list">
                                <div class="dnc-calendar__month">
                                    <div class="dnc-calendar__month-title">
                                        <?=$calendar['months']['current']?>
                                    </div>
                                    <div class="dnc-calendar__month-days">
                                        <?php foreach ($calendar['arNames'] as $dayName) {
                                            echo '<span>' . $dayName . '</span>';
                                        } ?>
                                    </div>
                                    <?php foreach ($calendar['arWeeks'] as $week) {?>
                                        <div class="dnc-calendar__week">
                                            <?php foreach ($week as $day) {
                                                $day['enabled'] = \array_key_exists($day['dmy'], $doctorSchedule) ? "enabled" : 'false';?>
                                                <div class="dnc-calendar__day
                                            <?=$day['enabled'] == 'enabled' ? 'dnc-calendar__day-enabled' : 'dnc-calendar__day-dism'?>
                                            <?=$day['day'] == date('j') ? 'dnc-calendar__day-now-' : ''?>
                                            "
                                                     data-enabled="<?=$day['enabled']?>"
                                                     data-date="<?=$day['date']?>"
                                                     data-datedisplay="<?=$day['datedisplay']?>"
                                                     onclick="selectDay(this);">
                                                    <?=$day['day']?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="dnc-calendar__month">
                                    <div class="dnc-calendar__month-title">
                                        <?=$calendarNext['months']['current']?>
                                    </div>
                                    <div class="dnc-calendar__month-days">
                                        <?php foreach ($calendar['arNames'] as $dayName) {
                                            echo '<span>' . $dayName . '</span>';
                                        } ?>
                                    </div>
                                    <?php foreach ($calendarNext['arWeeks'] as $week) {?>
                                        <div class="dnc-calendar__week">
                                            <?php foreach ($week as $day) {
                                                $day['enabled'] = \array_key_exists($day['dmy'], $doctorSchedule) ? 'enabled' : 'false'; ?>
                                                <div class="dnc-calendar__day
                                            <?=$day['enabled'] == 'enabled' ? 'dnc-calendar__day-enabled' : 'dnc-calendar__day-dism'?>"
                                                     data-enabled="<?=$day['enabled']?>"
                                                     data-date="<?=$day['date']?>"
                                                     data-datedisplay="<?=$day['datedisplay']?>"
                                                     onclick="selectDay(this);">
                                                    <?=$day['day']?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="dnc-calendar__next" onclick="scrollMonthNext();"></div>
                        </div>
                    </div>
                </div>

                <div class="set-time-time">
                    <div class="dnc-time-container">
                        <div class="dnc-time-select">
                            <?php for ($h = 1; $h <= 10; $h++) { ?>
                                <div class="dnc-time-select__hour"
                                     data-time="<?=sprintf("%02d", $h)?>00"
                                     data-timedisplay="<?=$h?>:00"
                                     data-enabled="false">
                                    ..:..
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="floatingBarsGBG floatingBarsGBG-time"></div>
                    <div class="floatingBarsG floatingBarsG-time">
                        <div class="blockG rotateG_01"></div>
                        <div class="blockG rotateG_02"></div>
                        <div class="blockG rotateG_03"></div>
                        <div class="blockG rotateG_04"></div>
                        <div class="blockG rotateG_05"></div>
                        <div class="blockG rotateG_06"></div>
                        <div class="blockG rotateG_07"></div>
                        <div class="blockG rotateG_08"></div>
                    </div>
                </div>

                <div class="set-time-form">
                    <div class="set-time-form-head">
                        <span class="set-time-title">ПРИЁМ</span>
                        <span class="set-time-result"><span class="result-date-time-order">...</span></span>
                        <p>Введите номер телефона</p>
                    </div>
                    <form class="form-standard reception-form-data">
                        <div class="input-container">
                            <input type="tel" placeholder="+7 (999) 999-99-99" id="phone" required="required" onkeydown="return checkPhoneKey(event.key)" />
                        </div>
                        <div class="form-info-message">
                            Запись считается подтверждённой после звонка администратора
                        </div>
                        <button type="submit" class="button-blue" disabled>Отправить</button>
                    </form>
                    <div id="err"></div>
                </div>
            </div>

            <div class="floatingBarsGBG floatingBarsGBG-form"></div>
            <div class="floatingBarsG floatingBarsG-form">
                <div class="blockG rotateG_01"></div>
                <div class="blockG rotateG_02"></div>
                <div class="blockG rotateG_03"></div>
                <div class="blockG rotateG_04"></div>
                <div class="blockG rotateG_05"></div>
                <div class="blockG rotateG_06"></div>
                <div class="blockG rotateG_07"></div>
                <div class="blockG rotateG_08"></div>
            </div>
        <?php } else { ?>
            <div class="reception-doctor-item">
                <span class="img">
                    <img src="<?=\CFile::GetPath($doctor["PREVIEW_PICTURE"])?>"/>
                </span>
                <a href="#" class="name">
                    <?=$doctor["NAME"]?><br>
                    <?=$doctor["FIRST_NAME_VALUE"]?><br>
                    <?=$doctor["MID_NAME_VALUE"]?>
                </a>
                <span class="price">
                    <?=$doctor['PRICE_CLINIC_VALUE'] ?: $doctor['PRICE_ONLINE_VALUE']?>
                </span>
                <button class="sel">Сменить врача</button>
            </div>

            <div class="set-time-calendar">
                <div>
                    <div class="dnc-calendar">
                        <div class="dnc-calendar__prev" onclick="scrollMonthPrev();"></div>
                        <div class="dnc-calendar__months-list">
                            <div class="dnc-calendar__month">
                                <div class="dnc-calendar__month-title">
                                    <?=$calendar['months']['current']?>
                                </div>
                                <div class="dnc-calendar__month-days">
                                    <?php foreach ($calendar['arNames'] as $dayName) {
                                        echo '<span>' . $dayName . '</span>';
                                    } ?>
                                </div>
                                <?php foreach ($calendar['arWeeks'] as $week) {?>
                                    <div class="dnc-calendar__week">
                                        <?php foreach ($week as $day) {
                                            $day['enabled'] = \array_key_exists($day['dmy'], $doctorSchedule) ? 'enabled' : 'false'; ?>
                                            <div class="dnc-calendar__day
                                        <?=$day['enabled'] == 'enabled' ? 'dnc-calendar__day-enabled' : 'dnc-calendar__day-dism'?>
                                        <?=$day['day'] == date('j') ? 'dnc-calendar__day-now-' : ''?>
                                        "
                                                 data-enabled="<?=$day['enabled']?>"
                                                 data-date="<?=$day['date']?>"
                                                 data-datedisplay="<?=$day['datedisplay']?>"
                                                 onclick="selectDay(this);">
                                                <?=$day['day']?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="dnc-calendar__month">
                                <div class="dnc-calendar__month-title">
                                    <?=$calendarNext['months']['current']?>
                                </div>
                                <div class="dnc-calendar__month-days">
                                    <?php foreach ($calendar['arNames'] as $dayName) {
                                        echo '<span>' . $dayName . '</span>';
                                    } ?>
                                </div>
                                <?php foreach ($calendarNext['arWeeks'] as $week) {?>
                                    <div class="dnc-calendar__week">
                                        <?php foreach ($week as $day) {
                                            $day['enabled'] = \array_key_exists($day['dmy'], $doctorSchedule) ? 'enabled' : 'false'; ?>
                                            <div class="<?=$day['enabled'] == 'enabled' ? 'dnc-calendar__day-enabled' : 'dnc-calendar__day-dism'?>"
                                                 data-enabled="<?=$day['enabled']?>"
                                                 data-date="<?=$day['date']?>"
                                                 data-datedisplay="<?=$day['datedisplay']?>"
                                                 onclick="selectDay(this);">
                                                <?=$day['day']?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="dnc-calendar__next" onclick="scrollMonthNext();"></div>
                    </div>
                </div>
                <div class="disable-calc"></div>
            </div>

            <div class="set-time-time set-time-time-page">
                <div class="dnc-time-container">
                    <div class="dnc-time-select">
                        <?php for ($h = 9; $h <= 20; $h++) { ?>
                            <div class="dnc-time-select__hour"
                                 data-time="<?=sprintf("%02d", $h)?>00"
                                 data-timedisplay="<?=$h?>:00"
                                 data-enabled="false" onclick="selectHour(this);">
                                <?=sprintf("%02d", $h)?>:00
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="floatingBarsGBG floatingBarsGBG-time floatingBarsGBG-time-page"></div>
                <div class="floatingBarsG floatingBarsG-time floatingBarsG-time-page">
                    <div class="blockG rotateG_01"></div>
                    <div class="blockG rotateG_02"></div>
                    <div class="blockG rotateG_03"></div>
                    <div class="blockG rotateG_04"></div>
                    <div class="blockG rotateG_05"></div>
                    <div class="blockG rotateG_06"></div>
                    <div class="blockG rotateG_07"></div>
                    <div class="blockG rotateG_08"></div>
                </div>
            </div>

            <div class="set-time-form">
                <div class="set-time-form-head">
                    <span class="set-time-title">ПРИЁМ</span>
                    <span class="set-time-result"><span class="result-date-time-order">---</span></span>
                    <p>Введите номер телефона</p>
                </div>
                <form class="form-standard reception-form-data">
                    <div class="input-container">
                        <input type="tel" placeholder="+7 (999) 999-99-99" id="phone" required="required" onkeydown="return checkPhoneKey(event.key)" />
                    </div>
                    <div class="form-info-message">
                        Запись считается подтверждённой после звонка администратора
                    </div>
                    <button type="submit" class="button-blue" disabled>Отправить</button>
                </form>
            </div>

            <div class="floatingBarsGBG floatingBarsGBG-time-load"></div>
            <div class="floatingBarsG floatingBarsG-time-load">
                <div class="blockG rotateG_01"></div>
                <div class="blockG rotateG_02"></div>
                <div class="blockG rotateG_03"></div>
                <div class="blockG rotateG_04"></div>
                <div class="blockG rotateG_05"></div>
                <div class="blockG rotateG_06"></div>
                <div class="blockG rotateG_07"></div>
                <div class="blockG rotateG_08"></div>
            </div>
        <?php } ?>

        <input id="totalData" type="hidden" value="" />
        <input id="doctorName" type="hidden" value="<?=$doctor["NAME"]?> <?=$doctor["FIRST_NAME_VALUE"]?> <?=$doctor["MID_NAME_VALUE"]?>" />

        <script>
            $(function() {
                <?php if (!$inline) { ?>
                initDoctorDialog("<?=$doctor["ONES_GUID_VALUE"]?>", "<?=$doctor["CLINIC_GUID_VALUE"]?>", true);
                <?php } else { ?>
                initDoctorDialog("<?=$doctor["ONES_GUID_VALUE"]?>", "<?=$doctor["CLINIC_GUID_VALUE"]?>", false);
                <?php } ?>
            });
        </script>
    <?php } ?>
<?php } elseif ($request["action"] == 'GetHours') {
    if (
        !isset($request["doctorID"])
        || !isset($request["date"])
    ) {
        exit();
    }
    $doctorHours = \Hemonc\Ajax::getDoctorHours($request["doctorID"], $request["date"]);?>

    <div class="dnc-time-select">
        <?php if (!empty($doctorHours)) {
            for ($h = 1; $h <= 23; $h++) {
                if (in_array(sprintf("%02d", $h) . ':00', $doctorHours)) : ?>
                    <div class="dnc-time-select__hour dnc-time-select__hour--enabled"
                         data-time="<?=sprintf("%02d", $h)?>00"
                         data-timedisplay="<?=$h?>:00"
                         data-enabled="enabled"
                         onclick="selectHour(this);">
                        <?=sprintf("%02d", $h)?>:00
                    </div>
                <?php endif;
            }
        } else {
            for ($h = 1; $h <= 7; $h++) { ?>
                <div class="dnc-time-select__hour"
                     data-time="<?=sprintf("%02d", $h)?>00"
                     data-timedisplay="<?=$h?>:00"
                     data-enabled="false">
                    ..:..
                </div>
            <?php }
        } ?>
    </div>
<?php } elseif ($request["action"] == 'SetOrder') {
    if (
        !isset($request["doctorid"])
        || !isset($request["clinicId"])
        || !isset($request["datetime"])
        || !isset($request["patient"])
    ) {
        exit('False');
    }

    $setOrder = \Hemonc\Ajax::setOnDoctorHour($request["doctorid"], $request["clinicId"], $request["datetime"], $request["patient"]);
    if ($setOrder == false) {
        exit('false');
    } else {
        exit('Ok');
    }
} elseif ($request['action'] == 'form') {
    if (
        !isset($request["Phone"])
        || !isset($request["Title"])
    ) {
        exit('false');
    }
    exit('Ok');
} elseif ($request['action'] == 'apply_proxy') {
    header('Content-Type: application/json; charset=utf-8');

    $rawBody = file_get_contents('php://input');
    $decoded = json_decode($rawBody, true);

    if (!is_array($decoded) || empty($decoded['endpoint']) || empty($decoded['payload']) || !is_array($decoded['payload'])) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'error' => 'Некорректные данные запроса']));
    }

    $endpoint = (string) $decoded['endpoint'];
    $payload = $decoded['payload'];

    if (!preg_match('#^https?://#i', $endpoint)) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'error' => 'Некорректный endpoint']));
    }

    $ch = curl_init($endpoint);
    if ($ch === false) {
        http_response_code(500);
        exit(json_encode(['success' => false, 'error' => 'Не удалось инициализировать запрос']));
    }

    $auth = base64_encode('Администратор:123100');

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json, text/plain, */*',
            'Authorization: Basic ' . $auth,
        ],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $responseBody = curl_exec($ch);
    $curlErrNo = curl_errno($ch);
    $curlError = curl_error($ch);
    $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($curlErrNo) {
        http_response_code(502);
        exit(json_encode(['success' => false, 'error' => 'Ошибка связи с 1С: ' . $curlError]));
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        http_response_code($statusCode ?: 502);
        exit(json_encode([
            'success' => false,
            'error' => '1С вернула ошибку',
            'status' => $statusCode,
            'body' => $responseBody
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    exit(json_encode([
        'success' => true,
        'status' => $statusCode,
        'body' => $responseBody
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
} elseif ($request['action'] == 'hemonc2__callback-form') {
    $params = [];

    if (isset($request["sessionId"])) {
        $params['sessionId'] = $request["sessionId"];
    }

    if (isset($request["requestUrl"])) {
        $params['requestUrl'] = $request["requestUrl"];
    }

    $ct = \Hemonc\Ajax::sendCallTouchRequest(
        'Заявка с сайта КДЛ',
        $request["name"],
        $request["phone"],
        $params
    );

    exit('Ok');
}
