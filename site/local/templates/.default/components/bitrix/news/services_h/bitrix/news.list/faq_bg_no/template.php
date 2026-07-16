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
<?php if ($arResult['ITEMS'] && count($arResult['ITEMS'])) { ?>
	<div class="center-wrap">
		<div class="hemonc2__faq-list">
			<?php foreach ($arResult['ITEMS'] as $arItem) { ?>
				<div class="hemonc2__faq-item hemonc2__faq-item-top">
					<div class="hemonc2__faq-top">
						<div class="hemonc2__faq-name">
                            <?=$arItem['PREVIEW_TEXT'] ? $arItem['PREVIEW_TEXT'] : '~~~'?>
						</div>
						<div class="hemonc2__faq-toggler"></div>
					</div>
					<div class="hemonc2__faq-body" style="display: none;">
						<?=$arItem['DETAIL_TEXT']?>
					</div>
				</div>
			<?php } ?>
		</div>

		<script>
			$(document).ready(function() {
				$('.hemonc2__faq-item-top').click(function() {
					$(this).toggleClass('active');
					$(this).children('.hemonc2__faq-body').slideToggle();
				});
			});
		</script>
	</div>
<?php } ?>
