<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
$this->addExternalJS($this->GetFolder() . '/script.js');

$tagIdByLabel = [];
foreach ($arResult['ALL_TAGS'] as $tag) {
    $tagIdByLabel[$tag['LABEL']] = $tag['ID'];
}
?>

<?php $this->SetViewTarget('article-next-content'); ?>

<section class="guide-hub" data-guide-hub>
    <div class="wrapper">
        <?php if (!empty($arResult['ALL_TAGS'])) { ?>
            <div class="guide-hub__tags">
                <button type="button" class="guide-hub__tag is-active" data-guide-tag="">Все</button>
                <?php foreach ($arResult['ALL_TAGS'] as $tag) { ?>
                    <button type="button" class="guide-hub__tag" data-guide-tag="<?= htmlspecialcharsbx($tag['ID']) ?>">
                        #<?= htmlspecialcharsbx($tag['LABEL']) ?>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if (!empty($arResult['ITEMS'])) { ?>
            <div class="guide-hub__grid">
                <?php foreach ($arResult['ITEMS'] as $arItem) {
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => 'Удалить элемент?']);

                    $tagsProperty = $arItem['PROPERTIES']['GUIDE_TAGS'] ?? null;
                    $itemTagIds = $arItem['GUIDE_TAG_IDS'] ?? [];
                    $itemTagLabels = [];

                    if (is_array($tagsProperty) && !empty($tagsProperty['VALUE'])) {
                        $itemTagLabels = $tagsProperty['VALUE'];
                        if (!is_array($itemTagLabels)) {
                            $itemTagLabels = [$itemTagLabels];
                        }
                    }

                    if ($itemTagIds === [] && $itemTagLabels !== []) {
                        foreach ($itemTagLabels as $tagLabel) {
                            $tagLabel = trim((string) $tagLabel);
                            if ($tagLabel !== '' && isset($tagIdByLabel[$tagLabel])) {
                                $itemTagIds[] = $tagIdByLabel[$tagLabel];
                            }
                        }
                    }
                    ?>
                    <article
                        class="guide-card bgdefault"
                        id="<?= $this->GetEditAreaId($arItem['ID']) ?>"
                        data-guide-tags="<?= htmlspecialcharsbx(implode(' ', $itemTagIds)) ?>"
                    >
                        <h2 class="guide-card__title">
                            <a href="<?= htmlspecialcharsbx($arItem['DETAIL_PAGE_URL']) ?>">
                                <?= htmlspecialcharsbx($arItem['NAME']) ?>
                            </a>
                        </h2>
                        <?php if (trim((string) ($arItem['PREVIEW_TEXT'] ?? '')) !== '') { ?>
                            <div class="guide-card__text"><?= $arItem['PREVIEW_TEXT'] ?></div>
                        <?php } ?>
                        <?php if ($itemTagLabels !== []) { ?>
                            <div class="guide-card__tags">
                                    <?php foreach ($itemTagLabels as $index => $tagLabel) {
                                    $tagLabel = trim((string) $tagLabel);
                                    if ($tagLabel === '') {
                                        continue;
                                    }

                                    $tagId = trim((string) ($itemTagIds[$index] ?? ($tagIdByLabel[$tagLabel] ?? '')));
                                    ?>
                                    <?php if ($tagId !== '') { ?>
                                        <button type="button" class="guide-card__tag" data-guide-tag="<?= htmlspecialcharsbx($tagId) ?>">
                                            #<?= htmlspecialcharsbx($tagLabel) ?>
                                        </button>
                                    <?php } else { ?>
                                        <span class="guide-card__tag guide-card__tag--static">#<?= htmlspecialcharsbx($tagLabel) ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <a href="<?= htmlspecialcharsbx($arItem['DETAIL_PAGE_URL']) ?>" class="guide-card__link">
                            Читать инструкцию
                        </a>
                    </article>
                <?php } ?>
            </div>
            <p class="guide-hub__empty" hidden>Инструкции по выбранному тегу не найдены.</p>
        <?php } else { ?>
            <p class="guide-hub__empty">Инструкции пока не добавлены.</p>
        <?php } ?>
    </div>
</section>

<?php $this->EndViewTarget(); ?>
