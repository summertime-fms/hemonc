<?php
$isLanding = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$elementCode = $_REQUEST["ELEMENT_CODE"];

if (empty($elementCode)) {
    LocalRedirect('/');
    return;
}

// Получаем элемент без проверки активности
$rsCheck = CIBlockElement::GetList(
    [],
    [
        "IBLOCK_ID" => 27,
        "CODE" => $elementCode
    ],
    false,
    false,
    ["ID", "ACTIVE", "NAME"]
);

$element = $rsCheck->Fetch();

if (!$element) {
    @define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");
    if (file_exists($_SERVER["DOCUMENT_ROOT"]."/404.php")) {
        include($_SERVER["DOCUMENT_ROOT"]."/404.php");
    }
    die();
}

// Логика доступа
$isActive = ($element["ACTIVE"] == "Y");
$isAuthorized = $USER->IsAuthorized();

if (!$isActive && !$isAuthorized) {
    // Неактивная страница для неавторизованных - 404
    @define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");
    if (file_exists($_SERVER["DOCUMENT_ROOT"]."/404.php")) {
        include($_SERVER["DOCUMENT_ROOT"]."/404.php");
    }
    die();
}

// Подключаем стили и скрипты
$APPLICATION->AddHeadString('<link rel="stylesheet" href="' . SITE_TEMPLATE_PATH . '/css/swiper-bundle.min.css?v=' . filemtime($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/css/swiper-bundle.min.css") . '">');
$APPLICATION->AddHeadString('<link rel="stylesheet" href="' . SITE_TEMPLATE_PATH . '/css/style.css?v=' . filemtime($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/css/style.css") . '">');
$APPLICATION->AddHeadString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/swiper-bundle.min.js", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/imask.js", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/phoneFileds.js", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/script.js", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/ctaForm.js", true);

// Данные элемента для SEO и шаблона (для неактивных в публичной части без прав чтения
// нужен CHECK_PERMISSIONS=N — гостей с неактивной страницей уже отсекли выше)
$elementDataFilter = [
    "IBLOCK_ID" => 27,
    "ID" => $element["ID"],
];
if ($isAuthorized && !$isActive) {
    $elementDataFilter["CHECK_PERMISSIONS"] = "N";
}

$rsElement = CIBlockElement::GetList(
    [],
    $elementDataFilter,
    false,
    false,
    ["*"]
);

$elementData = $rsElement->GetNextElement();
$landingFields = null;
$landingProps = null;
$seoData = [];
if ($elementData) {
    $landingFields = $elementData->GetFields();
    $landingProps = $elementData->GetProperties();

    $seoData["NAME"] = $landingFields["NAME"];
    $seoData["PREVIEW_TEXT"] = $landingFields["PREVIEW_TEXT"];
    $seoData["ACTIVE"] = $landingFields["ACTIVE"];
    $seoData["DETAIL_TEXT"] = $landingFields["DETAIL_TEXT"];

    if (!empty($landingProps["META_TITLE"]["VALUE"])) {
        $seoData["META_TITLE"] = $landingProps["META_TITLE"]["VALUE"];
    }
    if (!empty($landingProps["META_KEYWORDS"]["VALUE"])) {
        $seoData["META_KEYWORDS"] = $landingProps["META_KEYWORDS"]["VALUE"];
    }
    if (!empty($landingProps["META_DESCRIPTION"]["VALUE"])) {
        $seoData["META_DESCRIPTION"] = $landingProps["META_DESCRIPTION"]["VALUE"];
    }
}

if (!empty($seoData["META_TITLE"])) {
    $APPLICATION->SetTitle($seoData["META_TITLE"]);
} elseif (!empty($seoData["NAME"])) {
    $APPLICATION->SetTitle($seoData["NAME"]);
}

if (!empty($seoData["META_DESCRIPTION"])) {
    $APPLICATION->SetPageProperty("description", $seoData["META_DESCRIPTION"]);
} elseif (!empty($seoData["PREVIEW_TEXT"])) {
    $APPLICATION->SetPageProperty("description", strip_tags($seoData["PREVIEW_TEXT"]));
}

if (!empty($seoData["META_KEYWORDS"])) {
    $APPLICATION->SetPageProperty("keywords", $seoData["META_KEYWORDS"]);
}

// Показываем предупреждение для авторизованных на неактивной странице
if ($element["ACTIVE"] != "Y" && $USER->IsAuthorized()) {
    $APPLICATION->AddHeadString('<style>.preview-not-active{background:#fff3cd;border-left:4px solid #ffc107;padding:10px;margin-bottom:20px;position:relative;z-index:100;}</style>');
    echo '<div class="preview-not-active"><strong>Внимание:</strong> Эта страница не опубликована (неактивна) и видна только авторизованным пользователям.</div>';
}

// bitrix:news.detail всегда добавляет в фильтр ACTIVE => Y — неактивный элемент не загружается.
// Для предпросмотра черновика подключаем шаблон напрямую с тем же $arResult, что формирует компонент.
$isPreviewInactive = $isAuthorized && !$isActive;
if ($isPreviewInactive && $landingFields !== null && $landingProps !== null) {
    $arResult = $landingFields;
    $arResult["PROPERTIES"] = $landingProps;
    if (!empty($arResult["PREVIEW_PICTURE"]) && (int)$arResult["PREVIEW_PICTURE"] > 0) {
        $arResult["PREVIEW_PICTURE"] = CFile::GetFileArray($arResult["PREVIEW_PICTURE"]);
    } else {
        $arResult["PREVIEW_PICTURE"] = false;
    }
    if (!empty($arResult["DETAIL_PICTURE"]) && (int)$arResult["DETAIL_PICTURE"] > 0) {
        $arResult["DETAIL_PICTURE"] = CFile::GetFileArray($arResult["DETAIL_PICTURE"]);
    } else {
        $arResult["DETAIL_PICTURE"] = false;
    }
    include $_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/components/bitrix/news.detail/landing/template.php";
} elseif ($isPreviewInactive) {
    echo '<p class="preview-not-active">Не удалось загрузить данные страницы предпросмотра. Обратитесь к администратору.</p>';
} else {
    $arComponentParams = array(
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => 27,
        "ELEMENT_ID" => $element["ID"],
        "ELEMENT_CODE" => "",
        "CHECK_DATES" => "N",
        "SHOW_404" => "N",
        "SET_STATUS_404" => "N",
        "CACHE_TYPE" => "N",
        "CACHE_TIME" => "0",
        "USE_PERMISSIONS" => "N",
        "FIELD_CODE" => array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "ACTIVE"),
        "PROPERTY_CODE" => array(
            "HERO_TITLE",
            "HERO_TITLE_HIGHLIGHT",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
            "HERO_BUTTON_TEXT",
            "FEATURES_TITLE",
            "FEATURES_TEXT",
            "FEATURES_ITEMS",
            "SERVICE_TITLE",
            "SERVICE_ITEMS",
            "EXPERTS_TITLE",
            "EXPERTS_ITEMS",
            "PRICE_TITLE",
            "PRICE_TEXT",
            "PRICE_ITEMS",
            "META_TITLE",
            "META_KEYWORDS",
            "META_DESCRIPTION",
            "REVIEWS_TITLE",
            "REVIEWS_ITEMS"
        ),
    );

    $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "landing",
        $arComponentParams,
        false
    );
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
