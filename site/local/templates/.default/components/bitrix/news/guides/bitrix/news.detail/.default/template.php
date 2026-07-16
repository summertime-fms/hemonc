<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

$container = $arParams['HEADER_TEXT_CONTAINER'] ?? 'header-next-content';
$this->SetViewTarget($container);

$picture = $arResult['DETAIL_PICTURE'] ?? $arResult['PREVIEW_PICTURE'] ?? null;
$detailText = trim((string) ($arResult['DETAIL_TEXT'] ?? ''));

$tagsProperty = $arResult['PROPERTIES']['GUIDE_TAGS'] ?? null;
$itemTagLabels = [];

if (is_array($tagsProperty) && !empty($tagsProperty['VALUE'])) {
    $itemTagLabels = $tagsProperty['VALUE'];

    if (!is_array($itemTagLabels)) {
        $itemTagLabels = [$itemTagLabels];
    }
}
?>

<div class="default-main-block-content guide-page">
    <?php if ($itemTagLabels !== []) { ?>
        <div class="guide-page__tags">
            <?php foreach ($itemTagLabels as $index => $tagLabel) {
                $tagLabel = trim((string) $tagLabel);
                if ($tagLabel === '') {
                    continue;
                }
                ?>
                <span class="guide-page__tag">#<?= htmlspecialcharsbx($tagLabel) ?></span>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (is_array($picture) && !empty($picture['SRC'])) { ?>
        <figure class="guide-page__figure">
            <img
                src="<?= htmlspecialcharsbx((string) $picture['SRC']) ?>"
                alt="<?= htmlspecialcharsbx((string) ($picture['ALT'] ?: $arResult['NAME'])) ?>"
                loading="lazy"
            >
        </figure>
    <?php } ?>

    <?php if ($detailText !== '') { ?>
        <div class="text-block guide-page__text">
            <?= $arResult['DETAIL_TEXT'] ?>
        </div>
    <?php } ?>

    <?php require __DIR__ . '/article_eeat_blocks.php'; ?>
</div>

<?php
$this->EndViewTarget();
