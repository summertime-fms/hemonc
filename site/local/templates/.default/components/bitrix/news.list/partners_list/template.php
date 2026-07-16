<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

if (empty($arResult['ITEMS'])) {
    return;
}
?>

<div class="partners-grid">
    <?php foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction(
            $arItem['ID'],
            $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT')
        );
        $this->AddDeleteAction(
            $arItem['ID'],
            $arItem['DELETE_LINK'],
            CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'),
            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
        );

        $partnerName = trim((string) $arItem['NAME']);
        $partnerLink = trim((string) ($arItem['PROPERTIES']['LINK']['VALUE'] ?? ''));
        $logoSrc = $arItem['PREVIEW_PICTURE']['SRC'] ?? '';

        if ($logoSrc === '') {
            continue;
        }
        ?>
        <div class="partners-grid__item" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
            <?php if ($partnerLink !== '') { ?>
                <a
                    href="<?=htmlspecialcharsbx($partnerLink)?>"
                    class="partners-grid__link"
                    target="_blank"
                    rel="noopener noreferrer"
                    title="<?=htmlspecialcharsbx($partnerName)?>"
                >
                    <img
                        class="partners-grid__logo partner-info-logo"
                        src="<?=htmlspecialcharsbx($logoSrc)?>"
                        alt="<?=htmlspecialcharsbx($partnerName)?>"
                        loading="lazy"
                    >
                </a>
            <?php } else { ?>
                <div class="partners-grid__link partners-grid__link--static">
                    <img
                        class="partners-grid__logo partner-info-logo"
                        src="<?=htmlspecialcharsbx($logoSrc)?>"
                        alt="<?=htmlspecialcharsbx($partnerName)?>"
                        loading="lazy"
                    >
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
