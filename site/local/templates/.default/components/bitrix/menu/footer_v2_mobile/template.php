<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

if (!empty($arResult)) {
    echo '<div class="header__mobile-menu" itemscope itemtype="http://schema.org/SiteNavigationElement">';

    $previousLevel = 0;

    foreach ($arResult as $arItem) {
        if ($arItem["DEPTH_LEVEL"] < $previousLevel) {
            echo '</div>';
        }

        if ($arItem["IS_PARENT"]) {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <a href="<?=$arItem["LINK"]?>" class="footer__main-link"><?=$arItem["TEXT"]?></a>
            <?php }
        } else {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <a
                    itemprop="url"
                    href="<?=$arItem["LINK"]?>"
                    class="footer__main-link <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                    ><?=$arItem["TEXT"]?></a>
            <?php } else {
                if ($arItem["DEPTH_LEVEL"] > $previousLevel) { ?>
                    <div class="footer__list">
                <?php } ?>
                <a
                    itemprop="url"
                    href="<?=$arItem["LINK"]?>"
                    class="footer__list-link <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                    ><?=$arItem["TEXT"]?></a>
            <?php }
        }

        $previousLevel = $arItem["DEPTH_LEVEL"];
    }

    if ($previousLevel > 1) {
        echo str_repeat("</div>", ($previousLevel - 1));
    }

    echo '</div>';
}

// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Услуги</a>
//         <div class="header__mobile-toggler"></div>
//     </div>
//     <div class="header__mobile-sub">
//         <a href="#" class="header__mobile-sublink">Диагностика</a>
//         <a href="#" class="header__mobile-sublink">Процедуры</a>
//         <a href="#" class="header__mobile-sublink">Онкология</a>
//         <a href="#" class="header__mobile-sublink">Психотерапия</a>
//         <a href="#" class="header__mobile-sublink">Урология</a>
//         <a href="#" class="header__mobile-sublink">Гематология</a>
//         <a href="#" class="header__mobile-sublink">Онкогематология</a>
//         <a href="#" class="header__mobile-sublink">Перевод медицинских документов</a>
//     </div>
// </div>

// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Врачи</a>
//     </div>
// </div>


// <div class="">
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">О клинике</a>
//         <div class="header__mobile-toggler"></div>
//     </div>
//     <div class="header__mobile-sub">
//         <a href="#" class="header__mobile-sublink">Лицензии и документы</a>
//         <a href="#" class="header__mobile-sublink">Как отправить документы</a>
//         <a href="#" class="header__mobile-sublink">Мы в СМИ</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Цены</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Услуги</a>
//         <div class="header__mobile-toggler"></div>
//     </div>
//     <div class="header__mobile-sub">
//         <a href="#" class="header__mobile-sublink">Диагностика</a>
//         <a href="#" class="header__mobile-sublink">Процедуры</a>
//         <a href="#" class="header__mobile-sublink">Онкология</a>
//         <a href="#" class="header__mobile-sublink">Психотерапия</a>
//         <a href="#" class="header__mobile-sublink">Урология</a>
//         <a href="#" class="header__mobile-sublink">Гематология</a>
//         <a href="#" class="header__mobile-sublink">Онкогематология</a>
//         <a href="#" class="header__mobile-sublink">Перевод медицинских документов</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Врачи</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Отзывы</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Новости</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Полезное</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Видео</a>
//     </div>
// </div>
// <div class="header__mobile-item">
//     <div class="header__mobile-row">
//         <a href="#" class="header__mobile-link">Контакты</a>
//     </div>
// </div>
// </div>