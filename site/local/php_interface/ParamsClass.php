<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

namespace Hemonc;

class Params
{
    public static $params;

    public static function init()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock')) {
            exit('!iblock');
        }

        $paramssTable = \Bitrix\Iblock\Elements\ElementParamsTable::getList([
            'select' => [
                'ID',
                'CODE',
                'NAME',
                'PREVIEW_PICTURE',
                'PREVIEW_TEXT',
                'DETAIL_TEXT',
                // 'TITLE_' => 'TITLE',
            ],
            'filter' => [
                '=ACTIVE' => 'Y',
            ],
        ])->fetchAll();

        foreach ($paramssTable as $paramElement) {
            self::$params[$paramElement['CODE']] = $paramElement['PREVIEW_TEXT'];
        }
    }

    public static function p(string $param)
    {
        if (!is_array(self::$params) || empty(self::$params)) {
            self::init();
        }
        if (isset(self::$params[$param])) {
            return self::$params[$param];
        } else {
            return '';
        }
    }
}
