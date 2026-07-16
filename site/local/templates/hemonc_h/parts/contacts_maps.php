<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$walkSteps = [];

if (\Bitrix\Main\Loader::includeModule('iblock')) {
    $IBLOCK_ID = 25;
    $SECTION_ID = (int)$arResult['ID'];
    $arSelect = [
        'ID',
        'IBLOCK_ID',
        'NAME',
        'PREVIEW_TEXT',
        'SORT',
    ];

    $arFilter = [
        'IBLOCK_ID' => $IBLOCK_ID,
        'ACTIVE' => 'Y',
        'SECTION_ID' => $SECTION_ID,
        'INCLUDE_SUBSECTIONS' => 'N',
    ];

    $rsElements = \CIBlockElement::GetList(
        ['SORT' => 'ASC', 'ID' => 'ASC'],
        $arFilter,
        false,
        false,
        $arSelect
    );

    while ($obElement = $rsElements->GetNextElement()) {
        $arFields = $obElement->GetFields();
        $arProps = $obElement->GetProperties();

        $stepText = trim((string)$arFields['PREVIEW_TEXT']);
        $photos = [];

        if (!empty($arProps['PHOTOS']['VALUE'])) {
            $photoIds = is_array($arProps['PHOTOS']['VALUE'])
                ? $arProps['PHOTOS']['VALUE']
                : [$arProps['PHOTOS']['VALUE']];

            foreach ($photoIds as $photoId) {
                $photoId = (int)$photoId;
                if ($photoId <= 0) {
                    continue;
                }

                $arFile = \CFile::GetFileArray($photoId);
                if (!$arFile || empty($arFile['SRC'])) {
                    continue;
                }

                $photos[] = [
                    'SRC' => $arFile['SRC'],
                    'ALT' => $arFields['NAME'] ?: $stepText,
                    'TITLE' => $stepText ?: $arFields['NAME'],
                ];
            }
        }

        if ($stepText !== '' && !empty($photos)) {
            $walkSteps[] = [
                'NUMBER' => count($walkSteps) + 1,
                'TEXT' => $stepText,
                'PHOTOS' => $photos,
            ];
        }
    }
}
?>

<div class="contacts-main-block">
    <div class="content-block">
        <div class="content-block__row">
            <div class="left-block">
                <h3>НА МАШИНЕ</h3>

                <p>
                    <strong>
                        КАК ДОЕХАТЬ ДО КЛИНИКИ НА «ВАРШАВСКОЙ» НА МАШИНЕ:
                    </strong>
                </p>
            </div>
            <div class="right-block">
                <p>Москва, улица Болотниковская, д. 3, к. 1</p>
                <p>
                    <a
                            rel="nofollow noopener"
                            href="https://yandex.ru/maps/org/klinika_doktora_laskova/124211366467/?ll=37.615230%2C55.655444&amp;utm_source=share&amp;z=16"
                            target="_blank"
                            title="https://yandex.ru/maps/org/klinika_doktora_laskova/124211366467/?ll=37.615230%2C55.655444&amp;utm_source=share&amp;z=16"
                    ><span style="text-decoration: underline"
                        >Открыть в Яндекс.Картах</span
                        ></a>
                </p>
                <br />
                <p>
                    Клиника находится недалеко от Варшавского шоссе. Если вы
                    едете из центра, вам нужно будет съехать влево на улицу
                    Болотниковская. <br />
                    Вам нужен дом 3, корпус 1 – панельный многоэтажный
                    жёлто-белый дом, он будет по левой стороне по ходу движения.
                    Нужно проехать его до конца, свернуть налево и проехать до
                    конца здания. Вход в клинику находится в самом конце дома, в
                    нише – это стеклянная дверь с прозрачным козырьком.
                </p>
            </div>
        </div>
    </div>

    <div class="content-block">
        <div class="content-block__row" style="margin-bottom: 20px">
            <div class="left-block">
                <h3>ПЕШКОМ</h3>

                <p>
                    <strong>
                        КАК ДОЕХАТЬ ДО КЛИНИКИ НА «ВАРШАВСКОЙ» НА ОБЩЕСТВЕННОМ
                        ТРАНСПОРТЕ:
                    </strong>
                </p>
            </div>

            <div class="right-block">
                <p>Москва, улица Болотниковская, д. 3, к. 1</p>
                <p>
                    <a
                            rel="nofollow noopener"
                            href="https://yandex.ru/maps/org/klinika_doktora_laskova/124211366467/?ll=37.615230%2C55.655444&amp;utm_source=share&amp;z=16"
                            target="_blank"
                            title="https://yandex.ru/maps/org/klinika_doktora_laskova/124211366467/?ll=37.615230%2C55.655444&amp;utm_source=share&amp;z=16"
                    ><span style="text-decoration: underline"
                        >Открыть в Яндекс.Картах</span
                        ></a>
                </p>
            </div>
        </div>

        <?php if (!empty($walkSteps)): ?>
            <?php foreach ($walkSteps as $step): ?>
                <div class="content-block__row content-block__row-info">
                    <div class="left-block">
                        <div class="content-block__gallery">
                            <?php foreach ($step['PHOTOS'] as $photo): ?>
                                <a
                                        rel="lightbox"
                                        href="<?= htmlspecialchars($photo['SRC']) ?>"
                                        class="image n-photo"
                                        title="<?= htmlspecialchars($photo['TITLE']) ?>"
                                >
                                    <img
                                            src="<?= htmlspecialchars($photo['SRC']) ?>"
                                            alt="<?= htmlspecialchars($photo['ALT']) ?>"
                                    />
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="right-block">
                        <div class="text">
                            <div class="number"><?= (int)$step['NUMBER'] ?>.</div>
                            <p><?= htmlspecialchars($step['TEXT']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .contacts-main-block {
        width: 100% !important;
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .content-block__row {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .content-block__row h3 {
        margin: 0 0 16px;
    }

    .content-block__row-info {
        padding: 20px 0;
        flex-direction: column-reverse;
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }

    .content-block .content-block__row-info:last-of-type {
        border-bottom: none;
        padding: 20px 0 0;
    }

    .content-block__gallery {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .image {
        display: block;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }

    .image img {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        object-fit: cover;
    }

    .content-block__gallery .image {
        height: 200px;
    }

    .text {
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    @media (min-width: 1200px) {
        .contacts-main-block {
            gap: 40px;
        }

        .content-block__row {
            gap: 28px;
        }

        .content-block {
            padding: 24px;
            box-shadow: 0px 0px 20px 0px #0000000a;
            border-radius: 8px;
        }

        .content-block__row {
            flex-direction: row;
            gap: 45px;
        }

        .left-block {
            flex: 0 0 28%;
        }

        .right-block {
            flex-grow: 1;
        }

        .content-block__gallery .image {
            height: 200px;
        }

        .text {
            display: flex;
            align-items: flex-start;
        }
    }

    @media (min-width: 1440px) {
        .left-block {
            flex: 0 0 30%;
        }
    }
</style>

<?php
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fancybox/jquery.fancybox.css");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/fancybox/jquery.fancybox.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs("/contacts/script.js");
?>
