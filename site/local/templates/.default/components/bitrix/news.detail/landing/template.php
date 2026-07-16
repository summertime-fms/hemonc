<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

?>
<style>
    ul {
        list-style: disc !important;
    }

    .section-about ol {
        padding-left: 15px;
    }

    .section-about ul {
        padding-left: 24px;
    }
</style>
    <div class="wrapper">
        <section class="section hero">
            <div class="container hero-grid">
                <div class="hero-card fade-up">
                    <h1>
                        <?php
                        $heroTitle = $arResult["PROPERTIES"]["HERO_TITLE"]["VALUE"];
                        $highlighted = $arResult["PROPERTIES"]["HERO_TITLE_HIGHLIGHT"]["VALUE"];

                        if (!empty($heroTitle) && !empty($highlighted)) {
                            echo htmlspecialchars($heroTitle) . ' <span style="color: #007088">' . htmlspecialchars($highlighted) . '</span>';
                        } elseif (!empty($heroTitle)) {
                            echo htmlspecialchars($heroTitle);
                        } elseif (!empty($arResult["NAME"])) {
                            echo htmlspecialchars($arResult["NAME"]);
                        } else {
                            echo "Онкологическая и гематологическая помощь
                        <span style=\"color: #007088\">экспертного уровня</span>";
                        }
                        ?>
                    </h1>
                    <p>
                        <?php
                        if ($arResult["PROPERTIES"]["PREVIEW_TEXT"]["VALUE"]) {
                            echo $arResult["PROPERTIES"]["PREVIEW_TEXT"]["VALUE"];
                        } else {
                            echo "Вдумчиво и бережно лечим рак и заболевания крови.
                        Консультации ведущих специалистов, точная диагностика,
                        персонализированное лечение.";
                        }
                        ?>
                    </p>

                    <button
                        type="button"
                        class="button-active btn"
                        title="Записаться на консультацию"
                        onclick="SelectDoctorPopup()"
                    >
                        <?php
                        $buttonText = $arResult["PROPERTIES"]["HERO_BUTTON_TEXT"]["VALUE"];
                        echo $buttonText ?: "Записаться на консультацию";
                        ?>
                    </button>
                </div>

                <div class="hero-media fade-up delay-2">
                    <div class="hero-visual">
                        <?php
                        if ($arResult["PROPERTIES"]["PREVIEW_PICTURE"]["VALUE"]) {
                            $imageFile = CFile::GetPath($arResult["PROPERTIES"]["PREVIEW_PICTURE"]["VALUE"]);
                            if ($imageFile) {
                                echo '<img src="' . $imageFile . '" alt="Молекулы в борьбе с раком" />';
                            }
                        } elseif ($arResult["PREVIEW_PICTURE"]["SRC"]) {
                            echo '<img src="' . $arResult["PREVIEW_PICTURE"]["SRC"] . '" alt="Молекулы в борьбе с раком" />';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-about">
            <div class="container">
                <div class="section-head">
                    <h2>
                        <?php
                        $featuresTitle = $arResult["PROPERTIES"]["FEATURES_TITLE"]["VALUE"];
                        echo htmlspecialchars($featuresTitle);
                        ?>
                    </h2>
                    <p>
                        <?php
                        $featuresText = $arResult["PROPERTIES"]["FEATURES_TEXT"]["VALUE"];

                        if (is_array($featuresText) && isset($featuresText['TEXT'])) {
                            $featuresText = $featuresText['TEXT'];
                        } elseif (is_array($featuresText)) {
                            $featuresText = implode(' ', $featuresText);
                        }

                        $featuresText = htmlspecialchars_decode($featuresText);
                        $featuresText = htmlspecialchars_decode($featuresText); // Двойное декодирование на всякий случай

                        echo $featuresText;
                        ?>
                    </p>
                </div>

                <div class="card-grid section-about__card-grid">
                    <?php
                    $featuresItems = $arResult["PROPERTIES"]["FEATURES_ITEMS"]["VALUE"];
                    if (!empty($featuresItems) && is_array($featuresItems)) {
                        $linkedElements = [];
                        $elementIds = array_filter($featuresItems, function($item) {
                            return is_numeric($item) && $item > 0;
                        });

                        if (!empty($elementIds)) {
                            $rsElements = CIBlockElement::GetList(
                                [],
                                ["ID" => $elementIds],
                                false,
                                false,
                                ["ID", "NAME", "IBLOCK_ID", "PREVIEW_TEXT", "PREVIEW_PICTURE"]
                            );

                            while ($element = $rsElements->GetNext()) {
                                if ($element["PREVIEW_PICTURE"] > 0) {
                                    $element["ICON_PATH"] = CFile::GetPath($element["PREVIEW_PICTURE"]);
                                }

                                $linkedElements[$element["ID"]] = $element;
                            }
                        }

                        $delayIndex = 0;
                        foreach ($featuresItems as $key => $itemId) {
                            $name = "";
                            $iconHtml = "";

                            if (is_numeric($itemId) && $itemId > 0 && isset($linkedElements[$itemId])) {
                                $element = $linkedElements[$itemId];
                                $name = $element["PREVIEW_TEXT"];

                                if (!empty($element["ICON_PATH"])) {
                                    $iconHtml = '<img src="' . htmlspecialchars($element["ICON_PATH"]) . '" alt="иконка" style="width: 48px; height: 48px;" />';
                                }
                            }

                            if (empty($name)) {
                                continue;
                            }

                            if (empty($iconHtml)) {
                                $iconHtml = '<div class="icon">★</div>';
                            } else {
                                $iconHtml = '<div class="icon">' . $iconHtml . '</div>';
                            }

                            $delayClass = $delayIndex > 0 ? ' delay-' . $delayIndex : '';
                            ?>
                            <div class="card fade-up<?= $delayClass ?>">
                                <?= $iconHtml ?>
                                <h3><?= $name ?></h3>
                            </div>
                            <?php
                            $delayIndex++;
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <section class="section section-services">
            <div class="container">
                <div class="section-head">
                    <h2>
                        <?php
                        $serviceTitle = $arResult["PROPERTIES"]["SERVICE_TITLE"]["VALUE"];
                        echo htmlspecialchars($serviceTitle);
                        ?>
                    </h2>
                </div>

                <div class="card-grid services-grid">
                    <?php
                    $serviceItems = $arResult["PROPERTIES"]["SERVICE_ITEMS"]["VALUE"];
                    $serviceItemsDesc = $arResult["PROPERTIES"]["SERVICE_ITEMS"]["DESCRIPTION"];

                    if (!empty($serviceItems) && is_array($serviceItems)) {
                        $linkedElements = [];
                        $elementIds = array_filter($serviceItems, function($item) {
                            return is_numeric($item) && $item > 0;
                        });

                        if (!empty($elementIds)) {
                            $rsElements = CIBlockElement::GetList(
                                [],
                                ["ID" => $elementIds],
                                false,
                                false,
                                ["ID", "NAME", "PREVIEW_TEXT", "IBLOCK_ID"]
                            );

                            while ($element = $rsElements->GetNext()) {
                                $dbProperty = CIBlockElement::GetProperty($element["IBLOCK_ID"], $element["ID"], [], ["CODE" => "ICON"]);
                                if ($prop = $dbProperty->Fetch()) {
                                    $element["ICON"] = CFile::GetPath($prop["VALUE"]);
                                }
                                $linkedElements[$element["ID"]] = $element;
                            }
                        }

                        $delayIndex = 0;
                        foreach ($serviceItems as $key => $itemId) {
                            $name = "";
                            $previewText = "";
                            $iconSrc = "";

                            if (is_numeric($itemId) && $itemId > 0 && isset($linkedElements[$itemId])) {
                                $element = $linkedElements[$itemId];
                                $name = $element["NAME"];
                                $previewText = $element["PREVIEW_TEXT"];
                                $iconSrc = $element["ICON"] ?? "";
                            }

                            if (empty($name) && isset($serviceItemsDesc[$key]) && !empty($serviceItemsDesc[$key])) {
                                $name = $serviceItemsDesc[$key];
                            }

                            if (empty($name)) {
                                continue;
                            }

                            $delayClass = $delayIndex > 0 ? ' delay-' . $delayIndex : '';
                            ?>
                            <div class="card fade-up<?= $delayClass ?>">
                                <div class="icon">
                                    <?php if (!empty($iconSrc)): ?>
                                        <img src="<?= htmlspecialchars($iconSrc) ?>" alt="<?= htmlspecialchars($name) ?>">
                                    <?php endif; ?>
                                </div>
                                <h3><?= htmlspecialchars($name) ?></h3>
                                <?php if (!empty($previewText)): ?>
                                    <p><?= $previewText ?></p>
                                <?php endif; ?>
                            </div>
                            <?php
                            $delayIndex++;
                        }
                    }
                    ?>
                </div>

                <div class="section__footer">
                    <a class="button-active" href="/services/" aria-label="Все услуги">Все услуги</a>
                </div>
            </div>
        </section>

        <section class="section section-team section-slider">
            <div class="container">
                <div class="section-head">
                    <h2>
                        <?php
                        $expertsTitle = $arResult["PROPERTIES"]["EXPERTS_TITLE"]["VALUE"];
                        echo htmlspecialchars($expertsTitle);
                        ?>
                    </h2>

                    <div class="slider-controls">
                        <button class="slider-btn slider-btn-prev doctors-prev" aria-label="Previous slide">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.175 9H0V7h12.175l-5.6-5.6L8 0l8 8-8 8-1.425-1.4 5.6-5.6z" fill="currentColor"></path>
                            </svg>
                        </button>

                        <button class="slider-btn slider-btn-next doctors-next" aria-label="Next slide">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.175 9H0V7h12.175l-5.6-5.6L8 0l8 8-8 8-1.425-1.4 5.6-5.6z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="swiper doctors-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $expertsItems = $arResult["PROPERTIES"]["EXPERTS_ITEMS"]["VALUE"];

                        if (!empty($expertsItems) && is_array($expertsItems)) {
                            $linkedDoctors = [];
                            $doctorIds = array_filter($expertsItems, function($item) {
                                return is_numeric($item) && $item > 0;
                            });

                            if (!empty($doctorIds)) {
                                $rsDoctors = CIBlockElement::GetList(
                                    [],
                                    ["ID" => $doctorIds],
                                    false,
                                    false,
                                    ["ID", "NAME", "CODE", "PREVIEW_TEXT", "PREVIEW_PICTURE", "IBLOCK_ID"]
                                );

                                while ($doctor = $rsDoctors->GetNext()) {
                                    $doctor["PREVIEW_PICTURE_SRC"] = CFile::GetPath($doctor["PREVIEW_PICTURE"]);

                                    $dbProps = CIBlockElement::GetProperty($doctor["IBLOCK_ID"], $doctor["ID"], [], []);
                                    while ($prop = $dbProps->Fetch()) {
                                        $doctor["PROPERTIES"][$prop["CODE"]] = $prop;
                                    }

                                    $linkedDoctors[$doctor["ID"]] = $doctor;
                                }
                            }

                            foreach ($expertsItems as $key => $doctorId) {
                                if (is_numeric($doctorId) && $doctorId > 0 && isset($linkedDoctors[$doctorId])) {
                                    $doctor = $linkedDoctors[$doctorId];

                                    $firstName = $doctor["PROPERTIES"]["FIRST_NAME"]["VALUE"];
                                    $midName = $doctor["PROPERTIES"]["MID_NAME"]["VALUE"];
                                    $lastName = $doctor["NAME"];

                                    $fullName = $lastName;
                                    if (!empty($firstName)) {
                                        $fullName .= " " . $firstName;
                                    }
                                    if (!empty($midName)) {
                                        $fullName .= " " . $midName;
                                    }

                                    $title = $doctor["PROPERTIES"]["TITLE"]["VALUE"];
                                    $experience = $doctor["PROPERTIES"]["EXPIERENCE"]["VALUE"];
                                    $description = $doctor["PREVIEW_TEXT"];
                                    $photoSrc = $doctor["PREVIEW_PICTURE_SRC"];
                                    ?>
                                    <article class="swiper-slide card doctor-card">
                                        <?php if (!empty($photoSrc)): ?>
                                            <div class="card__image">
                                                <img src="<?= htmlspecialchars($photoSrc) ?>" alt="<?= htmlspecialchars($fullName) ?>" loading="lazy">
                                            </div>
                                        <?php endif; ?>

                                        <h3 class="card__title"><?= htmlspecialchars($fullName) ?></h3>

                                        <?php if (!empty($title)): ?>
                                            <span><?= htmlspecialchars($title) ?></span>
                                        <?php endif; ?>

                                        <?php if (!empty($experience)): ?>
                                            <p><strong>Стаж:</strong> <?= htmlspecialchars($experience) ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($description)): ?>
                                            <p><?= $description ?></p>
                                        <?php endif; ?>

                                        <div class="card__footer">
                                            <?php
                                            $doctorDetailUrl = "";
                                            if (!empty($doctor["DETAIL_PAGE_URL"])) {
                                                $doctorDetailUrl = $doctor["DETAIL_PAGE_URL"];
                                            } elseif (!empty($doctor["CODE"])) {
                                                $doctorDetailUrl = "/about-us/our-doctors/" . $doctor["CODE"] . "/";
                                            } else {
                                                $doctorDetailUrl = "#";
                                            }
                                            ?>
                                            <a class="button-main" href="<?= htmlspecialchars($doctorDetailUrl) ?>" aria-label="Подробнее о докторе">
                                                Подробнее о докторе
                                            </a>
                                        </div>
                                    </article>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-price">
            <div class="container">
                <div class="section-head">
                    <h2>
                        <?php
                        $priceTitle = $arResult["PROPERTIES"]["PRICE_TITLE"]["VALUE"];
                        echo htmlspecialchars($priceTitle);
                        ?>
                    </h2>

                    <p>
                        <?php
                        $priceText = $arResult["PROPERTIES"]["PRICE_TEXT"]["VALUE"];

                        if (is_array($priceText) && isset($priceText['TEXT'])) {
                            $priceText = $priceText['TEXT'];
                        } elseif (is_array($priceText)) {
                            $priceText = implode(' ', $priceText);
                        }

                        $priceText = htmlspecialchars_decode($priceText);

                        echo strip_tags($priceText, '<br><ul><li><strong><em><b><i>');
                        ?>
                    </p>
                </div>

                <table class="price-table">
                    <thead>
                    <tr>
                        <th>Услуга</th>
                        <th>Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $priceItems = $arResult["PROPERTIES"]["PRICE_ITEMS"]["VALUE"];

                    if (!empty($priceItems) && is_array($priceItems)) {
                        $linkedServices = [];
                        $serviceIds = array_filter($priceItems, function($item) {
                            return is_numeric($item) && $item > 0;
                        });

                        if (!empty($serviceIds)) {
                            $rsServices = CIBlockElement::GetList(
                                [],
                                ["ID" => $serviceIds],
                                false,
                                false,
                                ["ID", "NAME", "IBLOCK_ID"]
                            );

                            while ($service = $rsServices->GetNext()) {
                                $dbProperty = CIBlockElement::GetProperty($service["IBLOCK_ID"], $service["ID"], [], ["CODE" => "PRICE"]);
                                if ($prop = $dbProperty->Fetch()) {
                                    $service["PRICE"] = $prop["VALUE"];
                                }
                                $linkedServices[$service["ID"]] = $service;
                            }
                        }

                        foreach ($priceItems as $key => $serviceId) {
                            if (is_numeric($serviceId) && $serviceId > 0 && isset($linkedServices[$serviceId])) {
                                $service = $linkedServices[$serviceId];
                                $name = $service["NAME"];
                                $price = $service["PRICE"];

                                if (empty($name)) {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($name) ?></td>
                                    <td><b><?= htmlspecialchars($price) ?></b></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>

                <div class="section__footer">
                    <a class="button-main" href="/services/" aria-label="Все услуги">Все услуги</a>
                </div>
            </div>
        </section>

        <?php
        // Блок отзывов
        $reviewsTitle = $arResult["PROPERTIES"]["REVIEWS_TITLE"]["VALUE"];
        $reviewsItems = $arResult["PROPERTIES"]["REVIEWS_ITEMS"]["VALUE"];

        if (!empty($reviewsItems) && is_array($reviewsItems)):
            // Загружаем элементы отзывов
            $reviewsData = [];
            $reviewIds = array_filter($reviewsItems, function($item) {
                return is_numeric($item) && $item > 0;
            });

            if (!empty($reviewIds)) {
                $rsReviews = CIBlockElement::GetList(
                    ["SORT" => "ASC"],
                    ["ID" => $reviewIds],
                    false,
                    false,
                    ["ID", "NAME", "DETAIL_TEXT"]
                );
                while ($review = $rsReviews->GetNext()) {
                    $reviewsData[$review["ID"]] = $review;
                }
            }
            ?>
            <section class="section section-reviews section-slider">
                <div class="container">
                    <div class="section-head">
                        <h2><?= htmlspecialchars($reviewsTitle) ?></h2>

                        <div class="slider-controls">
                            <button class="slider-btn slider-btn-prev reviews-prev" aria-label="Назад">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.175 9H0V7h12.175l-5.6-5.6L8 0l8 8-8 8-1.425-1.4 5.6-5.6z" fill="currentColor" />
                                </svg>
                            </button>

                            <button class="slider-btn slider-btn-next reviews-next" aria-label="Вперед">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.175 9H0V7h12.175l-5.6-5.6L8 0l8 8-8 8-1.425-1.4 5.6-5.6z" fill="currentColor" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="swiper reviews-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($reviewsItems as $reviewId):
                                if (!is_numeric($reviewId) || !isset($reviewsData[$reviewId])) continue;
                                $review = $reviewsData[$reviewId];
                                $text = $review["DETAIL_TEXT"];
                                if (empty($text)) continue;
                                ?>
                                <article class="swiper-slide card review-card">
                                    <div class="review-card__wrapper">
                                        <p><?= $text ?></p>
                                        <div class="card__footer">
                                            <h3 class="card__title">
                                                <?php // Автор временно скрыт ?>
                                            </h3>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="section section-contacts">
            <div class="container">
                <div class="contacts-page__body card">
                    <div class="contacts-page__content">
                        <div class="contacts-page__main-info">
                            <h2>Как нас найти</h2>

                            <div class="row">
                                <div>
                                    <h3>АДРЕС</h3>
                                    <p>
                                        <?=\Hemonc\Params::p('address')?>
                                    </p>
                                    <p class="pseudo-table-row">&nbsp;</p>
                                </div>

                                <div>
                                    <h3>Телефон</h3>
                                    <a href="tel:<?=preg_replace('/[\(\)\s-]/', '', \Hemonc\Params::p('phone'))?>"><?=\Hemonc\Params::p('phone')?></a>
                                </div>

                                <div>
                                    <h3>E‑mail</h3>
                                    <p>
                                        <a href="mailto:<?=\Hemonc\Params::p('email')?>"><?=\Hemonc\Params::p('email')?></a>

                                        >
                                    </p>
                                </div>

                                <h3>Режим работы</h3>
                                <div class="pseudo-table" style="color: #007088">
                                    <?=\Hemonc\Params::p('footer_raspisanie')?>

                                </div>

                                <div>
                                    <h3>Соцсети</h3>

                                    <div class="section-contacts__social">
                                        <a
                                                class="section-contacts__icon"
                                                href="https://t.me/+z3v7RkC3cjJlYjMy"
                                                aria-label="Мы в Telegram"
                                                target="_blank"
                                        >
                                            <img
                                                    src="<?=SITE_TEMPLATE_PATH?>/images/icons/tg.svg"
                                                    alt="Telegram"
                                            />
                                        </a>

                                        <a
                                                class="section-contacts__icon"
                                                href="https://vk.com/hemoncmoscow"
                                                aria-label="Мы в VK"
                                                target="_blank"

                                        >
                                            <img
                                                    src="<?=SITE_TEMPLATE_PATH?>/images/icons/vk.svg"
                                                    alt="VK"
                                            /></a>

                                        <a
                                                class="section-contacts__icon"
                                                href="https://www.youtube.com/channel/UC1jbQ7IIAQc5CFl8C8R-T0w"
                                                aria-label="Мы на YouTube"
                                                target="_blank"

                                        >
                                            <img
                                                    src="<?=SITE_TEMPLATE_PATH?>/images/icons/youtube.svg"
                                                    alt="YouTube"
                                            /></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="contacts-page__map-block">
                            <div class="map-body">
                                <div class="map-wrapper">
                                    <div id="map"></div>
                                    <div class="panel-menu">
                                        <div class="panel-menu__control">
                                            <button
                                                    class="geo-btn btn"
                                                    id="geo-btn"
                                            >
                                                Построить маршрут до клиники
                                            </button>
                                        </div>
                                        <div class="geo-links" id="geo-links">
                                            <a
                                                    href="https://yandex.ru/maps/-/CLGcVMMN"
                                                    target="_blank"
                                                    id="open-yandex"
                                            >Открыть в Яндекс картах</a
                                            >
                                            <a
                                                    href="https://go.2gis.com/C5yYD"
                                                    target="_blank"
                                                    id="open-2gis"
                                            >Открыть в 2ГИС</a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-cta">
            <div class="container">
                <div class="card">
                    <div class="section-head">
                        <h2>Запишитесь на консультацию сегодня</h2>

                        <p>
                            Оставьте заявку — наш координатор перезвонит в течение
                            15 минут, ответит на вопросы и подберёт удобное время
                            приёма.
                        </p>
                    </div>

                    <form class="form" action="/api/sendRequest.php" id="ctaForm">
                        <div class="form-grid">
                            <label for="name"><input id="name" name="name" type="text" placeholder="Ваше имя" required></label>

                            <label for="phone">
                                <input type="tel" class="phone-field" id="phone" maxlength="18" minlength="18" placeholder="+7 (___) ___-__-__" required>
                                <input type="hidden" name="phone">
                            </label>

                            <label for="speciality">
                                <select id="speciality" name="speciality" placeholder="Специализация врача" required>
                                    <option value="" disabled="" selected="">
                                        Специализация врача
                                    </option>
                                    <?=\Hemonc\Params::p('spisok-spetsializatsiya-vrachey-dlya-formy-lendingov')?>
                                </select></label>

                            <label for="comment">
                                <textarea id="comment" name="comment" placeholder="Диагноз, цель визита" required></textarea>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button class="button-active" type="submit">
                                Отправить заявку
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
