<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php';

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";

if (
    !in_array(
        $_SERVER["HTTP_REFERER"],
        [
            'http://ghost-rider/',
        ],
    )
) {
    \Bitrix\Main\Diag\Debug::writeToFile('https://hemonc.ru' . $APPLICATION->GetCurPage(), date('Y-m-d H:i') . ' ' . $_SERVER["HTTP_REFERER"], "/local/debug/404");
}

$APPLICATION->SetTitle("404 Страница не найдена");
?>
<section class="error-main-block">
    <div class="wrapper">
        <h1>404</h1>
        <h2>Страница не найдена</h2>
        <p>Перейдите на действующие страницы сайта:</p>
        <footer>
            <a href="/" class="button-blue">Главная</a>
            <a href="/services/" class="button-blue">Услуги</a>
            <a href="/about-us/" class="button-blue">О нас</a>
        </footer>
    </div>
</section>
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";?>