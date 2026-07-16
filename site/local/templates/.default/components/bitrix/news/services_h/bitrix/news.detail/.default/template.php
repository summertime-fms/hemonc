<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>

<div class="center-wrap ">
    <div class="hemonc2__prices" id="prices">
        <div class="hemonc2__row">
            <div class="hemonc2__h2">Стоимость услуги</div>
            <a href="/services/" class="hemonc2__link"><span>смотреть все</span></a>
        </div>
        <?php if (!empty($arResult['PROPERTIES']['PRICE_GRID']['VALUE'])) { ?>
            <div class="hemonc2__prices-grid">
                <?php foreach ($arResult['PROPERTIES']['PRICE_GRID']['~VALUE'] as $key => $value) { ?>
                    <div class="hemonc2__prices-row">
                        <div class="hemonc2__prices-name">
                            <?=$value?>
                        </div>
                        <div class="hemonc2__prices-price">
                            <?=number_format(intval($arResult['PROPERTIES']['PRICE_GRID']['~DESCRIPTION'][$key]), 0, '.', ' ')?>
                            ₽</div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php
        global $USER;
        $chemoSchemesList = [];
        if (!empty($arResult['CHEMO_SCHEME_HL_LIST']) && is_array($arResult['CHEMO_SCHEME_HL_LIST'])) {
            $chemoSchemesList = $arResult['CHEMO_SCHEME_HL_LIST'];
        } elseif (!empty($arResult['CHEMO_SCHEME_HL']) && is_array($arResult['CHEMO_SCHEME_HL'])) {
            $chemoSchemesList = [$arResult['CHEMO_SCHEME_HL']];
        }

        if ($chemoSchemesList !== []) {
            $roundK = static function (int $n): int {
                return (int) round($n / 1000) * 1000;
            };

            $allMkbCodes = [];
            foreach ($chemoSchemesList as $chemo) {
                if (!is_array($chemo) || empty($chemo['UF_DIAGNOSES'])) {
                    continue;
                }

                $diagDecoded = is_string($chemo['UF_DIAGNOSES'])
                    ? json_decode($chemo['UF_DIAGNOSES'], true)
                    : $chemo['UF_DIAGNOSES'];

                if (is_array($diagDecoded)) {
                    foreach ($diagDecoded as $d) {
                        $code = trim((string)($d['mkb'] ?? ''));
                        if ($code !== '') {
                            $allMkbCodes[$code] = true;
                        }
                    }
                }
            }

            $mkbNamesMap = [];
            if (!empty($allMkbCodes) && \Bitrix\Main\Loader::includeModule('highloadblock')) {
                $hlblockId = 5; // ID инфоблока/HL-блока диагнозов
                $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlblockId)->fetch();
                if ($hlblock) {
                    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
                    $entityDataClass = $entity->getDataClass();

                    $rsDiags = $entityDataClass::getList([
                        'select' => ['UF_MKB_CODE', 'UF_SHORTNAME', 'UF_NAME'],
                        'filter' => ['=UF_MKB_CODE' => array_keys($allMkbCodes)]
                    ]);

                    while ($diagRow = $rsDiags->fetch()) {
                        $shortName = trim((string)$diagRow['UF_SHORTNAME']);
                        $mkbNamesMap[$diagRow['UF_MKB_CODE']] = $shortName !== '' ? $shortName : trim((string)$diagRow['UF_NAME']);
                    }
                }
            }

            ?>
          <div class="hemonc2__chemo-schemes">
              <?php
              foreach ($chemoSchemesList as $idx => $chemo) {
                  if (!is_array($chemo)) {
                      continue;
                  }
                  $titleLight = trim((string) ($chemo['UF_SCHEME_NAME_LIGHT'] ?? ''));
                  $titleShort = trim((string) ($chemo['UF_SCHEME_NAME_SHORT'] ?? ''));
                  $titleName = trim((string) ($chemo['UF_NAME'] ?? $chemo['UF_SCHEME_NAME'] ?? ''));
                  $chemoTitle = $titleLight !== '' ? $titleLight : ($titleShort !== '' ? $titleShort : ($titleName !== '' ? $titleName : 'Схема химиотерапии'));
                  if ($titleLight !== '' && $titleShort !== '') {
                      $chemoSubtitle = $titleShort;
                  } elseif ($titleLight !== '' && $titleName !== '') {
                      $chemoSubtitle = $titleName !== $chemoTitle ? $titleName : '';
                  } else {
                      $chemoSubtitle = $titleName !== '' && $titleName !== $chemoTitle ? $titleName : '';
                  }
                  $priceMin = (int) ($chemo['UF_PRICE_MIN'] ?? 0);
                  $priceMax = (int) ($chemo['UF_PRICE_MAX'] ?? 0);
                  $priceMinR = $roundK($priceMin);
                  $priceMaxR = $roundK($priceMax);
                  $casesCount = (int) ($chemo['UF_CASES_COUNT'] ?? 0);
                  $drugsRaw = $chemo['UF_DRUGS'] ?? '';
                  $drugsList = [];
                  if (is_string($drugsRaw) && $drugsRaw !== '') {
                      $decoded = json_decode($drugsRaw, true);
                      if (is_array($decoded)) {
                          foreach ($decoded as $item) {
                              if (!is_array($item)) {
                                  continue;
                              }
                              $mnn = trim((string) ($item['mnn'] ?? ''));
                              if ($mnn !== '') {
                                  $drugsList[] = $mnn;
                              }
                          }
                      }
                  }

                  $diagTags = [];
                  $diagRaw = $chemo['UF_DIAGNOSES'] ?? '';
                  if (is_string($diagRaw) && $diagRaw !== '') {
                      $diagDecoded = json_decode($diagRaw, true);
                      if (is_array($diagDecoded)) {
                          foreach ($diagDecoded as $d) {
                              if (!is_array($d)) {
                                  continue;
                              }
                              $code = trim((string)($d['mkb'] ?? ''));
                              if ($code !== '' && isset($mkbNamesMap[$code]) && $mkbNamesMap[$code] !== '') {
                                  $diagTags[] = $mkbNamesMap[$code];
                              }
                          }
                      }
                  }
                  $diagTags = array_unique($diagTags);

                  $schemeId = (int) ($chemo['ID'] ?? 0);
                  $courseLo = 0;
                  $courseHi = 0;
                  if ($casesCount > 0) {
                      $courseLo = $roundK($priceMin * $casesCount);
                      $courseHi = $roundK($priceMax * $casesCount);
                      if ($priceMax <= 0 && $priceMin > 0) {
                          $courseHi = $courseLo;
                      }
                      if ($priceMin <= 0 && $priceMax > 0) {
                          $courseLo = $courseHi;
                      }
                  }
                  $showCourseEst = ($courseLo > 0 || $courseHi > 0);
                  $durationWeeks = ($casesCount > 0) ? (int) round($casesCount * 21 / 7) : 0;
                  $cardClass = 'hemonc2__chemo-card' . ($isFeatured ? ' hemonc2__chemo-card--featured' : '');
                  ?>
                <article class="<?= htmlspecialcharsbx($cardClass) ?>" id="chemo-scheme-<?= $schemeId ?>">

                  <div class="hemonc2__chemo-card__main">
                    <div class="hemonc2__chemo-card__text">
                      <h3 class="hemonc2__chemo-card__title"><?= htmlspecialcharsbx($chemoTitle) ?></h3>
                        <?php if ($diagTags !== [] || $casesCount > 0) { ?>
                          <div class="hemonc2__chemo-card__tags">
                              <?php
                              $tagI = 0;
                              foreach ($diagTags as $t) {
                                  if ($tagI >= 4) {
                                      break;
                                  }

                                  $cleanText = trim(preg_replace('/\s+/', ' ', $t));
                                  ?>
                                <span class="hemonc2__chemo-card__tag hemonc2__chemo-card__tag--diag">
            <?= htmlspecialcharsbx($cleanText) ?>
        </span>
                                  <?php
                                  $tagI++;
                              }
                              ?>
                          </div>
                        <?php } ?>
                    </div>
                    <div class="hemonc2__chemo-card__price-block">
                      <div class="hemonc2__chemo-card__price">
                          <?php if ($priceMinR === $priceMaxR) { ?>
                              <?= number_format($priceMinR, 0, '.', ' ') ?> ₽
                          <?php } else { ?>
                              <?= number_format($priceMinR, 0, '.', ' ') ?> — <?= number_format($priceMaxR, 0, '.', ' ') ?> ₽
                          <?php } ?>
                      </div>
                    </div>
                  </div>

                    <?php if ($drugsList !== []) { ?>
                      <div class="hemonc2__chemo-card__drugs" id="chemo-scheme-<?= $schemeId ?>-drugs">
                          <?php //foreach ($drugsList as $drug) { ?>
                          <?php //= htmlspecialcharsbx($drug) ?><?php //} ?>
                      </div>
                    <?php } ?>
                </article>
              <?php } ?>
          </div>
            <?php
        }
        ?>
    </div>
</div>

<?php $this->SetViewTarget('service-mid-section'); ?>
<div class="center-wrap ">
    <div class="hemonc2__description" id="service">
        <div class="hemonc2__description-grid">
            <div class="hemonc2__description-content">
                <div class="hemonc2__row">
                    <div class="hemonc2__h2">Об&nbsp;услуге</div>
                </div>
                <div class="hemonc2__description-text">
                    <?=$arResult['PROPERTIES']['SERVICE_TEXT']['~VALUE']['TEXT'] ?? ''?>
                </div>
                <a onclick="SelectDoctorPopup()" class="hemonc2__description-btn">Запись на прием</a>
            </div>
            <?php if (!empty($arResult['PROPERTIES']['H_VIDEO']['VALUE'])): ?>
                <div class="hemonc2__description-wrap">
                    <?php
                    $video = $arResult['PROPERTIES']['H_VIDEO'];

                    if (is_numeric($video['VALUE'])) {
                        $file = CFile::GetFileArray($video['VALUE']);
                        $videoSrc = $file['SRC'];
                    } else {
                        $videoSrc = $video['VALUE']['SRC'] ?? $video['VALUE'];
                    }

                    $posterSrc = '';
                    $poster = $arResult['PROPERTIES']['POSTER'] ?? null;
                    if (is_array($poster) && !empty($poster['VALUE'])) {
                        if (is_numeric($poster['VALUE'])) {
                            $posterFile = CFile::GetFileArray($poster['VALUE']);
                            $posterSrc = is_array($posterFile) ? (string) ($posterFile['SRC'] ?? '') : '';
                        } else {
                            $posterSrc = (string) ($poster['VALUE']['SRC'] ?? $poster['VALUE'] ?? '');
                        }
                    }
                    ?>

                    <?php if (!empty($videoSrc)): ?>
                        <video width="100%" controls preload="metadata"<?= $posterSrc !== '' ? ' poster="' . htmlspecialcharsbx($posterSrc) . '"' : '' ?>>
                            <source src="<?=htmlspecialchars($videoSrc)?>" type="video/mp4">
                            Ваш браузер не поддерживает тег video.
                        </video>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->EndViewTarget(); ?>

<?php $this->SetViewTarget('service-main-section'); ?>
<div class="hemonc2__detail">
    <div class="center-wrap">
        <div class="hemonc2__row">
            <div class="hemonc2__h2">
                <?=$arResult['PROPERTIES']['AUTHOR_TITLE']['VALUE']?>
            </div>
        </div>

        <?php if ($arResult['PROPERTIES']['AUTHOR_TEXT']['~VALUE'] && count($arResult['PROPERTIES']['AUTHOR_TEXT']['VALUE'])) { ?>
            <div class="hemonc2__detail-text">
                <div class="hemonc2__detail-row">
                    <?php foreach ($arResult['PROPERTIES']['AUTHOR_TEXT']['~VALUE'] as $key => $value) { ?>
                        <div class="hemonc2__detail-block">
                            <?php if (!empty($arResult['PROPERTIES']['AUTHOR_TEXT']['~DESCRIPTION'][$key])) { ?>
                                <div class="hemonc2__detail-num">
                                    <?=$arResult['PROPERTIES']['AUTHOR_TEXT']['~DESCRIPTION'][$key]?>
                                </div>
                            <?php } ?>
                            <div class="hemonc2__detail-subtext">
                                <?=$value['TEXT']?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($arResult['DETAIL_PICTURE']['SRC']): ?>
            <div class="hemonc2__detail-wrap">
                <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"
                     alt="alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']?>"">
            </div>
        <?php endif; ?>

        <?php if ($arResult['AUTHOR']) { ?>
            <div class="hemonc2__detail-author">
                <div class="hemonc2__detail-author-top">
                    материал подготовлен врачом:
                </div>
                <div class="hemonc2__detail-author-body">
                    <div class="hemonc2__detail-author-row">
                        <div class="hemonc2__detail-author-img">
                            <img src="<?=$arResult['AUTHOR']['PREVIEW_PICTURE']['SRC']?>"
                                 alt="<?=$arResult['AUTHOR']['FULL_NAME']?>">
                        </div>
                        <div class="hemonc2__detail-author-content">
                            <a href="<?=$arResult['AUTHOR']['DETAIL_PAGE_URL']?>"
                               class="hemonc2__detail-author-name"><?=$arResult['AUTHOR']['FULL_NAME']?></a>
                            <div class="hemonc2__detail-author-pos">
                                <?=$arResult['AUTHOR']['PROPERTY_TITLE_VALUE']?>
                            </div>
                            <div class="hemonc2__detail-author-exp"><?=$arResult['AUTHOR']['PROPERTY_TITLE2_VALUE']?></div>
                        </div>
                    </div>
                    <div class="hemonc2__detail-author-data">
                        <?php if ($arResult['DATE_ACTIVE_FROM']) { ?>
                            <div class="hemonc2__detail-author-subtitle">Дата публикации:</div>
                            <div class="hemonc2__detail-author-date">
                                <?=$arResult['DATE_ACTIVE_FROM']?>
                            </div>
                        <?php } ?>
                        <div class="hemonc2__detail-author-views">
                            <?=$arResult['SHOW_COUNTER']?>
                            просмотров</div>
                    </div>

                    <!-- <div class="hemonc2__detail-author-rating">
                                <div class="hemonc2__detail-author-grade">4.8</div>
                                <div class="hemonc2__detail-author-stars">
                                    <div class="hemonc2__detail-author-star"></div>
                                    <div class="hemonc2__detail-author-star"></div>
                                    <div class="hemonc2__detail-author-star"></div>
                                    <div class="hemonc2__detail-author-star"></div>
                                    <div class="hemonc2__detail-author-star"></div>
                                </div>
                                <div class="hemonc2__detail-author-total">0 оценок</div>
                                <form action="#" class="hemonc2__detail-author-form">
                                    <div class="hemonc2__detail-author-rows">
                                        <input type="radio" id="rating-5" name="rating" value="5"><label for="rating-5"></label>
                                        <input type="radio" id="rating-4" name="rating" value="4"><label for="rating-4"></label>
                                        <input type="radio" id="rating-3" name="rating" value="3"><label for="rating-3"></label>
                                        <input type="radio" id="rating-2" name="rating" value="2"><label for="rating-2"></label>
                                        <input type="radio" id="rating-1" name="rating" value="1"><label for="rating-1"></label>
                                    </div>
                                    <button type="submit">Оцените статью</button>
                                </form>
                            </div> -->

                    <div class="hemonc2__detail-author-btns">
                    <span class="hemonc2__detail-author-btn btn"
                          onclick="ShowPersonalDoctorPopup(<?=$arResult['AUTHOR']['ID']?>);">Запись
                        на консультацию</span>
                        <a href="<?=$arResult['AUTHOR']['DETAIL_PAGE_URL']?>"
                           class="hemonc2__detail-author-btn btn --trans">Подробнее о враче</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php $this->EndViewTarget(); ?>

<?php $this->SetViewTarget('service-gallery-section'); ?>
<?php if ($arResult['GALLERY']) { ?>
    <div class="hemonc2__gallery" id="gallery">
        <div class="center-wrap">
            <div class="hemonc2__row">
                <div class="hemonc2__h2">В&nbsp;клинике</div>
            </div>
            <div class="hemonc2__gallery-swiper">
                <?php foreach ($arResult['GALLERY'] as $gallery) { ?>
                    <div class="hemonc2__gallery-item">
                        <a href="<?=$gallery?>" class="hemonc2__gallery-wrap" data-fancybox="gallery">
                            <img src="<?=$gallery?>" alt="">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fancybox-3.5.7/dist/jquery.fancybox.min.css");
    \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/fancybox-3.5.7/dist/jquery.fancybox.min.js");
    ?>
    <script>
        $('.hemonc2__gallery-swiper').slick({
            adaptiveHeight: true,
            variableWidth: false,
            mobileFirst: true,
            infinite: true,
            dots: false,
            arrows: false,
            slidesToShow: 2,
            swipeToSlide: true,
            autoplay: true,
            // centerMode: true,
            // variableWidth: true,
            responsive: [
                {
                    breakpoint: 320,
                    settings: {
                        slidesToShow: 2
                    }
                },{
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 4
                    }
                },{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 5
                    }
                }
            ]
        });
    </script>
<?php } ?>
<?php $this->EndViewTarget(); ?>
