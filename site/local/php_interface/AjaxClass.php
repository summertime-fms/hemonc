<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

namespace Hemonc;

use Bitrix\Main\Data\Cache;

class Ajax
{
    // / Ближайшее время приема у всех врачей клиники
    public static function getSchedule()
    {
        $cache  = Cache::createInstance();
        $result = [];

        if ($cache->initCache(70, "Hemonc_Ajax_getSсhedule", 'Hemonc_Ajax')) {
            $result = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            foreach (CLINICS_GUID as $guid) {
                $response = self::sendOnesRequest('nearestTimeWeekAll', [
                    'Klinika' => $guid,
                ]);
                $response = \json_decode($response, true);
                if (
                    is_array($response)
                    && !empty($response)
                ) {
                    foreach ($response as $v) {
                        $v             = \explode('_', $v);
                        $result[$v[1]] = $v[0];
                    }
                }
            }
            $cache->endDataCache($result);
        }

        return $result;
    }

    // Даты доктора в клинике
    public static function getDoctorSchedule(string $doctorGUID)
    {
        $cache  = Cache::createInstance();
        $result = [];

        if ($cache->initCache(75, "Hemonc_Ajax_getDoctorSchedule_" . $doctorGUID, 'Hemonc_Ajax')) {
            $result = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            foreach (CLINICS_GUID as $guid) {
                $response = self::sendOnesRequest('getMonth', [
                    'doctorid' => $doctorGUID,
                    'month'    => date('Ym'),
                    'Klinika'  => $guid,
                ]);
                $response = \json_decode($response, true);
                if (
                    is_array($response)
                    && !empty($response)
                ) {
                    foreach ($response as $v) {
                        $result[$v][] = $guid;
                    }
                }

                $response = self::sendOnesRequest('getMonth', [
                    'doctorid' => $doctorGUID,
                    'month'    => date('Ym', strtotime('first day of +1 month')),
                ]);
                $response = \json_decode($response, true);
                if (
                    is_array($response)
                    && !empty($response)
                ) {
                    foreach ($response as $v) {
                        $result[$v][] = $guid;
                    }
                }
            }

            $cache->endDataCache($result);
        }

        return $result;
    }

    // Свободные часы на дату
    public static function getDoctorHours(string $doctorGUID, string $date)
    {
        $result = [];

        foreach (CLINICS_GUID as $guid) {
            $response = self::sendOnesRequest('get', [
                'doctorid' => $doctorGUID,
                'date'     => $date,
                'Klinika'  => $guid,
            ]);
            $response = \json_decode($response, true);

            if (
                is_array($response)
                && !empty($response)
            ) {
                foreach ($response as $v) {
                    $result[] = $v;
                }
            }
        }

        return $result;
    }

    // Отправка заявки
    public static function setOnDoctorHour(string $doctorGUID, string $clinicGUID, string $dateTime, string $patient)
    {
        $result = false;

        $response = self::sendOnesRequest('set', [
            'doctorid' => $doctorGUID,
            'Klinika'  => $clinicGUID,
            'patient'  => str_replace(['+', '-', '(', ')'], '', filter_var($patient, FILTER_SANITIZE_NUMBER_INT)),
            'datetime' => $dateTime,
        ]);

        // $response = \json_decode($response, true);

        if (
            is_array($response)
            && !empty($response)
            && $response['result'] == 'true'
            || $response           == 'result: true, message: success'
        ) {
            $result = true;
        }

        return $result;
    }

    public static function sendOnesRequest(string $method, array $params = [])
    {
        $result = \json_encode('');

        if (
            !defined('ONESUSER')
            || !defined('ONESPWD')
        ) {
            return $result;
        }

        $httpClient = new \Bitrix\Main\Web\HttpClient();
        $httpClient->setAuthorization(ONESUSER, ONESPWD);

        $url = 'https://laskov.medconsult.ru/laskov/hs/OncoHTTPUpdate/ScheduleUpdate?action=' . $method;

        foreach ($params as $p => $v) {
            $url .= '&' . $p . '=' . $v;
        }

        $response = $httpClient->get($url);

        return $response;
    }

    public static function calendar($y = null, $m = null)
    {
        $result = [];

        $curYear         = $y ? $y : date('Y');
        $curMonth        = $m ? $m : date('n');
        $firstDayOfMonth = mktime(0, 0, 0, $curMonth, 1, $curYear);
        $numberDays      = date('t', $firstDayOfMonth);
        $dayOfWeek       = date('N', $firstDayOfMonth);
        $date_now        = (new \DateTime())->setTime(0, 0);

        if ($curMonth == 12) {
            $nextYear  = $curYear + 1;
            $nextMonth = 1;
            $prevYear  = $curYear;
            $prevMonth = $curMonth - 1;
        } elseif ($curMonth == 1) {
            $nextYear  = $curYear;
            $nextMonth = $curMonth + 1;
            $prevYear  = $curYear - 1;
            $prevMonth = 12;
        } else {
            $nextYear  = $curYear;
            $nextMonth = $curMonth + 1;
            $prevYear  = $curYear;
            $prevMonth = $curMonth - 1;
        }

        $monthHeaders  = explode(';', 'Месяца именительный;январь;февраль;март;апрель;май;июнь;июль;август;сентябрь;октябрь;ноябрь;декабрь');
        $monthHeaders2 = explode(';', 'Месяца родительный;января;февраля;марта;апреля;мая;июня;июля;августа;сентября;октября;ноября;декабря');

        $result['months']['current'] = $monthHeaders[$curMonth] . ' ' . $curYear;
        $result['months']['next']    = $monthHeaders[$nextMonth] . ' ' . $nextYear;
        $result['nextMonth']         = $nextMonth;
        $result['nextYear']          = $nextYear;

        $row = [];
        foreach (explode(';', 'Пн;Вт;Ср;Чт;Пт;Сб;Вс') as $value) {
            $row[] = $value;
        }
        $result['arNames'] = $row;
        $currentDay        = 1;

        $row = [];
        for ($i = 1; $i < 8; $i++) {
            if ($i < $dayOfWeek) {
                $row[] = [
                    'day'         => '',
                    'date'        => '',
                    'datedisplay' => '',
                ];
            } else {
                if ($date_now > new \DateTime("$curYear-$curMonth-$currentDay")) {
                    $row[] = [
                        'day'         => $currentDay,
                        'date'        => '',
                        'dmy'         => '',
                        'datedisplay' => '',
                    ];
                } else {
                    $row[] = [
                        'day'         => $currentDay,
                        'date'        => $curYear . sprintf("%02d", $curMonth) . sprintf("%02d", $currentDay),
                        'dmy'         => sprintf("%02d", $currentDay) . '.' . sprintf("%02d", $curMonth) . '.' . $curYear,
                        'datedisplay' => $currentDay . ' ' . $monthHeaders2[$curMonth],
                    ];
                }
                $currentDay++;
            }
        }
        $result['arWeeks'][] = $row;

        $row = [];
        while ($currentDay <= $numberDays) {
            if (count($row) == 7) {
                $result['arWeeks'][] = $row;
                $row                 = [];
            }
            if ($date_now > new \DateTime("$curYear-$curMonth-$currentDay")) {
                $row[] = [
                    'day'         => $currentDay,
                    'date'        => '',
                    'dmy'         => '',
                    'datedisplay' => '',
                ];
            } else {
                $row[] = [
                    'day'         => $currentDay,
                    'date'        => $curYear . sprintf("%02d", $curMonth) . sprintf("%02d", $currentDay),
                    'dmy'         => sprintf("%02d", $currentDay) . '.' . sprintf("%02d", $curMonth) . '.' . $curYear,
                    'datedisplay' => $currentDay . ' ' . $monthHeaders2[$curMonth],
                ];
            }
            $currentDay++;
        }

        if (!empty($row)) {
            for ($i = count($row); $i < 7; $i++) {
                $row[] = [
                    'day'         => '',
                    'date'        => '',
                    'datedisplay' => '',
                ];
            }
            $result['arWeeks'][] = $row;
        }

        return $result;
    }

    public static function sendCallTouchRequest($subject, $fio, $phoneNumber, array $params = [])
    {
        $httpClient = new \Bitrix\Main\Web\HttpClient();

        $params = array_merge($params, [
            'subject'     => $subject,
            'phoneNumber' => $phoneNumber,
            'fio'         => $fio,
        ]);

        $response = $httpClient->post(
            'https://api.calltouch.ru/calls-service/RestAPI/requests/8083/register/',
            $params,
        );

        \Bitrix\Main\Diag\Debug::dumpToFile($params, "params", "/local/debug/" . date('Y.m.d_H'));
        \Bitrix\Main\Diag\Debug::dumpToFile($response, "response", "/local/debug/" . date('Y.m.d_H'));

        return $response;
    }
}
