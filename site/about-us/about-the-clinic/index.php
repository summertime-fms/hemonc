<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "page_text",
    [
        "ACTIVE_DATE_FORMAT"         => "j F Y",
        "ADD_ELEMENT_CHAIN"          => "N",
        "ADD_SECTIONS_CHAIN"         => "N",
        "AJAX_MODE"                  => "N",
        "AJAX_OPTION_ADDITIONAL"     => "",
        "AJAX_OPTION_HISTORY"        => "N",
        "AJAX_OPTION_JUMP"           => "N",
        "AJAX_OPTION_STYLE"          => "N",
        "BROWSER_TITLE"              => "TITLE",
        "CACHE_GROUPS"               => "N",
        "CACHE_TIME"                 => "36000000",
        "CACHE_TYPE"                 => "A",
        "CHECK_DATES"                => "Y",
        "COMPOSITE_FRAME_MODE"       => "A",
        "COMPOSITE_FRAME_TYPE"       => "AUTO",
        "ELEMENT_CODE"               => "about-the-clinic",
        "ELEMENT_ID"                 => "",
        "FIELD_CODE"                 => [],
        "IBLOCK_ID"                  => "7",
        "IBLOCK_TYPE"                => "site",
        "IBLOCK_URL"                 => "",
        "INCLUDE_IBLOCK_INTO_CHAIN"  => "N",
        "MESSAGE_404"                => "",
        "META_DESCRIPTION"           => "DESCRIPTION",
        "META_KEYWORDS"              => "KEYWORDS",
        "PROPERTY_CODE"              => [],
        "SET_BROWSER_TITLE"          => "Y",
        "SET_CANONICAL_URL"          => "Y",
        "SET_LAST_MODIFIED"          => "N",
        "SET_META_DESCRIPTION"       => "Y",
        "SET_META_KEYWORDS"          => "N",
        "SET_STATUS_404"             => "N",
        "SET_TITLE"                  => "Y",
        "SHOW_404"                   => "N",
        "STRICT_SECTION_CHECK"       => "N",
        "USE_PERMISSIONS"            => "N",
        "CSS_CLASS_BODY"             => "about-page",
        "CSS_CLASS_HEADER"           => "default-main-block-header full-width",
        "HEADER_TEXT_CONTAINER"      => "header-content",
    ],
);
?>

<div class="image-slider-block">
    <div class="wrapper">
        <div class="slick-slider image-slider-block-slider slick-dots-default">
            <div>
                <img src="/about-us/about-the-clinic/img1.jpg" alt=""/>
            </div>
            <div>
                <img src="/about-us/about-the-clinic/img2.jpg" alt=""/>
            </div>
            <div>
                <img src="/about-us/about-the-clinic/img3.jpg" alt=""/>
            </div>
            <div>
                <img src="/about-us/about-the-clinic/img4.jpg" alt=""/>
            </div>
            <div>
                <img src="/about-us/about-the-clinic/img5.jpg" alt=""/>
            </div>
            <div>
                <img src="/about-us/about-the-clinic/img6.jpg" alt=""/>
            </div>
        </div>
    </div>
</div>

<section class="our-features-block title-block">
    <div class="wrapper">
        <div class="gray-block">
            <h2 class="title">Наши ценности</h2>
            <div class="text-column col-b2 text-block">
                <p><strong>Мы лечим людей с раком и заболеваниями крови <br /></strong><span style="font-weight: 400;">Когда человек впервые слышит диагноз «рак», то сталкивается со страхом и неизвестностью. Чаще всего пациент и его близкие остаются без поддержки и достоверной информации, предоставленными сами себе. Не знают, куда бежать и что делать.</span></p>
                <p><strong>Бережем ваши нервы<br /></strong><span style="font-weight: 400;">Избавить человека от страха и сделать лечение эмоционально комфортным — наша первая задача. Консультация врача в нашей клинике длится час, а не пятнадцать минут, как в большинстве больниц. Мы общаемся не только с пациентом, но и его близкими — даем всю необходимую информацию, отвечаем на вопросы и снижаем уровень тревоги. Нам важно ваше спокойствие и комфорт.</span></p>
                <p><strong>Бережем ваше время<br /></strong><span style="font-weight: 400;">Следующий шаг — маршрутизация. Мы проводим тщательную диагностику и разрабатываем индивидуальную «карту лечения», учитывая картину болезни и личные обстоятельства жизни человека (в том числе, временные и материальные). Выйдя от нашего врача, вы будете знать, что делать дальше. Срок диагностики редко превышает неделю.</span></p>
                <p><strong>Бережем ваши средства<br /></strong><span style="font-weight: 400;">Существует миф, что лечение в частных клиниках — недоступная и неоправданная роскошь. В нашем случае это не так.</span></p>
                <p><span style="font-weight: 400;">Мы решили не тратиться на аренду помещения в центре Москвы, поэтому наша клиника находится за пределами Третьего транспортного кольца. У нас нет роскошных палат и дорогостоящей аппаратуры — все процедуры мы проводим амбулаторно, а при необходимости направляем своих пациентов в проверенный диагностический центр или стационар к нашим партнерам.</span></p>
                <p><span style="font-weight: 400;"><strong>Наша главная ценность — высококлассные специалисты</strong><br />Мы тщательно выбираем наших врачей и партнеров из других клиник и научных центров. Мы знаем, где хорошо сделают операцию, проведут диагностику или лучевую терапию — и, при необходимости, отправим вас именно туда. </span><span style="font-weight: 400;">Среди наших партнеров – онкологическая клиника РМАНПО, Гематологический научный центр, Центр им. Бурназяна, 62-ая онкологическая больница, РОНЦ им.Блохина, лаборатория UNIM.</span></p>
                <p><strong>Мы знаем, что рак и заболевания крови — это очень страшно. Но наши врачи будут рядом с вами на протяжении всего лечения.</strong></p>
            </div>
            <div class="our-features-slider slick-slider">
                <div>
                    <i class="svg-icon-serv-consult"></i>
                    <p>Наши врачи умеют не только ставить точные диагнозы, но и разговаривать с пациентами и их близкими. Вы получите ответы на все вопросы и будете знать, что делать дальше.</p>
                </div>
                <div>
                    <i class="svg-icon-serv-about"></i>
                    <p>Наша клиника небольшая и находится за пределами центра столицы. Мы вкладываемся не в дорогой дизайн или аренду, а в квалифицированных специалистов.</p>
                </div>
                <div>
                    <i class="svg-icon-serv-heal"></i>
                    <p>Основная специализация нашей клиники — химиотерапия. Мы применяем препараты иностранного производства (Израиль, Германия) и работаем по международным протоколам лечения злокачественных опухолей.</p>
                </div>
                <div>
                    <i class="svg-icon-serv-diag"></i>
                    <p>Курсы химиотерапии мы проводим амбулаторно, как делают в 90% случаев в странах с развитой медициной (Израиль, Швейцария, Скандинавия). Во время процедуры рядом с вами будет ваш врач.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="our-doctors-block-alt">
    <div class="wrapper">
        <div class="title-link-block bgdefault grid-row-root">
        <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "doctors_list",
                [
                    "COMPONENT_TEMPLATE"        => ".default",
                    "IBLOCK_TYPE"               => "content",
                    "IBLOCK_ID"                 => "15",
                    "NEWS_COUNT"                => "15",
                    "SORT_BY1"                  => "ACTIVE_FROM",
                    "SORT_ORDER1"               => "DESC",
                    "SORT_BY2"                  => "SORT",
                    "SORT_ORDER2"               => "ASC",
                    "FILTER_NAME"               => "",
                    "FIELD_CODE"                => ['DETAIL_TEXT'],
                    "PROPERTY_CODE"             => ['FIRST_NAME'],
                    "CHECK_DATES"               => "Y",
                    "AJAX_MODE"                 => "N",
                    "AJAX_OPTION_JUMP"          => "N",
                    "AJAX_OPTION_STYLE"         => "Y",
                    "AJAX_OPTION_HISTORY"       => "N",
                    "AJAX_OPTION_ADDITIONAL"    => "",
                    "CACHE_TYPE"                => "A",
                    "CACHE_TIME"                => "36000000",
                    "CACHE_FILTER"              => "N",
                    "CACHE_GROUPS"              => "N",
                    "ACTIVE_DATE_FORMAT"        => "j M Y",
                    "SET_TITLE"                 => "N",
                    "SET_BROWSER_TITLE"         => "N",
                    "SET_META_KEYWORDS"         => "N",
                    "SET_META_DESCRIPTION"      => "N",
                    "SET_LAST_MODIFIED"         => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN"        => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
                    "PARENT_SECTION"            => "",
                    "PARENT_SECTION_CODE"       => "",
                    "INCLUDE_SUBSECTIONS"       => "N",
                    "STRICT_SECTION_CHECK"      => "N",
                    "DISPLAY_DATE"              => "Y",
                    "DISPLAY_NAME"              => "Y",
                    "DISPLAY_PICTURE"           => "Y",
                    "DISPLAY_PREVIEW_TEXT"      => "Y",
                    "PAGER_TEMPLATE"            => ".default",
                    "DISPLAY_TOP_PAGER"         => "N",
                    "DISPLAY_BOTTOM_PAGER"      => "N",
                    "SET_STATUS_404"            => "N",
                    "SHOW_404"                  => "N",
                    "MESSAGE_404"               => "",
                ],
                false,
            );?>
        </div>
    </div>
</section>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
