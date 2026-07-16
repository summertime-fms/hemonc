<?php

declare(strict_types=1);

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;

/**
 * Короткие ссылки /s/{code} → /apply/?pacient_id=
 * HL: UF_SHORTCODE, UF_PACIENT_GUID, UF_CREATED
 */
final class ShortLinkService
{
    private const CODE_LENGTH = 7;
    private const CODE_ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private const MAX_GENERATION_ATTEMPTS = 24;

    /** @var class-string|null */
    private static ?string $dataClass = null;

    public static function getDataClass(): string
    {
        if (self::$dataClass !== null) {
            return self::$dataClass;
        }

        if (!defined('HL_SHORT_LINKS_ID') || (int) HL_SHORT_LINKS_ID <= 0) {
            throw new \RuntimeException('Укажите HL_SHORT_LINKS_ID в local/php_interface/init.php');
        }

        if (!Loader::includeModule('highloadblock')) {
            throw new \RuntimeException('Модуль highloadblock не подключён');
        }

        $hlId = (int) HL_SHORT_LINKS_ID;
        $hlblock = HighloadBlockTable::getById($hlId)->fetch();
        if (!$hlblock) {
            throw new \RuntimeException('Highload-блок с ID=' . $hlId . ' не найден');
        }

        $entity = HighloadBlockTable::compileEntity($hlblock);
        self::$dataClass = $entity->getDataClass();

        return self::$dataClass;
    }

    public static function findByGuid(string $guid): ?array
    {
        $guid = trim($guid);
        if ($guid === '') {
            return null;
        }

        $dataClass = self::getDataClass();
        $row = $dataClass::getList([
            'filter' => ['=UF_PACIENT_GUID' => $guid],
            'limit' => 1,
        ])->fetch();

        return $row ?: null;
    }

    public static function findByCode(string $code): ?array
    {
        $code = trim($code);
        if ($code === '') {
            return null;
        }

        $dataClass = self::getDataClass();
        $row = $dataClass::getList([
            'filter' => ['=UF_SHORTCODE' => $code],
            'limit' => 1,
        ])->fetch();

        return $row ?: null;
    }

    /**
     * Создаёт запись или возвращает существующую по GUID.
     *
     * @return array{UF_SHORTCODE: string, UF_PACIENT_GUID: string}
     */
    public static function createOrReuse(string $pacientGuid): array
    {
        $pacientGuid = trim($pacientGuid);
        if ($pacientGuid === '') {
            throw new \InvalidArgumentException('Пустой pacientguid');
        }

        $existing = self::findByGuid($pacientGuid);
        if ($existing !== null) {
            return [
                'UF_SHORTCODE' => (string) $existing['UF_SHORTCODE'],
                'UF_PACIENT_GUID' => (string) $existing['UF_PACIENT_GUID'],
            ];
        }

        $dataClass = self::getDataClass();
        $now = new DateTime();

        $lastError = '';
        for ($attempt = 0; $attempt < self::MAX_GENERATION_ATTEMPTS; $attempt++) {
            $code = self::generateCode();

            $add = $dataClass::add([
                'UF_SHORTCODE' => $code,
                'UF_PACIENT_GUID' => $pacientGuid,
                'UF_CREATED' => $now,
            ]);

            if ($add->isSuccess()) {
                return [
                    'UF_SHORTCODE' => $code,
                    'UF_PACIENT_GUID' => $pacientGuid,
                ];
            }

            $lastError = implode('; ', $add->getErrorMessages());

            $race = self::findByGuid($pacientGuid);
            if ($race !== null) {
                return [
                    'UF_SHORTCODE' => (string) $race['UF_SHORTCODE'],
                    'UF_PACIENT_GUID' => (string) $race['UF_PACIENT_GUID'],
                ];
            }
        }

        throw new \RuntimeException('Не удалось создать запись: ' . $lastError);
    }

    private static function generateCode(): string
    {
        $len = strlen(self::CODE_ALPHABET);
        $out = '';
        for ($i = 0; $i < self::CODE_LENGTH; $i++) {
            $out .= self::CODE_ALPHABET[random_int(0, $len - 1)];
        }

        return $out;
    }

    public static function buildShortUrl(\Bitrix\Main\HttpRequest $request, string $code): string
    {
        $scheme = $request->isHttps() ? 'https' : 'http';
        $host = $request->getHttpHost() ?: 'hemonc.ru';
        return $scheme . '://' . $host . '/s/' . $code . '/';
    }

    public static function buildApplyUrl(\Bitrix\Main\HttpRequest $request, string $pacientGuid): string
    {
        $scheme = $request->isHttps() ? 'https' : 'http';
        $host = $request->getHttpHost() ?: 'hemonc.ru';
        $query = http_build_query(['pacient_id' => $pacientGuid], '', '&', PHP_QUERY_RFC3986);

        return $scheme . '://' . $host . '/apply/?' . $query;
    }
}
