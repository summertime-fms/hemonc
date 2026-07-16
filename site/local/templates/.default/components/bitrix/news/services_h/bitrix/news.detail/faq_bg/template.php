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

<?php if ($arResult['PROPERTIES']['FAQ_BOTTOM']['~VALUE'] && count($arResult['PROPERTIES']['FAQ_BOTTOM']['VALUE'])) { ?>
    <div class="hemonc2__faq" id="faq">
        <div class="center-wrap">
            <div class="hemonc2__row">
                <div class="hemonc2__h2">Вопросы и ответы</div>
            </div>
            <div class="hemonc2__faq-list">
                <?php foreach ($arResult['PROPERTIES']['FAQ_BOTTOM']['~VALUE'] as $key => $value) { ?>
                <div class="hemonc2__faq-item hemonc2__faq-item-bottom">
                    <div class="hemonc2__faq-top">
                        <div class="hemonc2__faq-name">
                            <?=$arResult['PROPERTIES']['FAQ_BOTTOM']['~DESCRIPTION'][$key] ? $arResult['PROPERTIES']['FAQ_BOTTOM']['~DESCRIPTION'][$key] : '~~~'?>
                        </div>
                        <div class="hemonc2__faq-toggler"></div>
                    </div>
                    <div class="hemonc2__faq-body">
                        <?=$value['TEXT']?></div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        $('.hemonc2__faq-item-bottom').click(function() {
            $(this).toggleClass('active');
            $(this).children('.hemonc2__faq-body').slideToggle();
        })
    </script>
<?php } ?>