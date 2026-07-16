<?php

$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    [
        "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixCallback.php",
        "AREA_FILE_SHOW" => "file",
    ],
);
