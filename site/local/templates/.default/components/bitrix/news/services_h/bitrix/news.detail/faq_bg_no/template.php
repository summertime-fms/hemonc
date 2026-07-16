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

<?php if ($arResult['PROPERTIES']['FAQ_TOP']['~VALUE'] && count($arResult['PROPERTIES']['FAQ_TOP']['VALUE'])) { ?>
	<div class="center-wrap">
		<div class="hemonc2__faq-list">
			<?php
			$open_faq_numbers = [];
			if (isset($arResult['PROPERTIES']['FAQ_OPEN']['VALUE']) && is_array($arResult['PROPERTIES']['FAQ_OPEN']['VALUE'])) {
				$open_faq_numbers = $arResult['PROPERTIES']['FAQ_OPEN']['VALUE'];
			}
			?>
	
			<?php foreach ($arResult['PROPERTIES']['FAQ_TOP']['~VALUE'] as $key => $value) {
				$item_number = $key + 1;
	
				$is_open = in_array($item_number, $open_faq_numbers);
				
				$item_classes = 'hemonc2__faq-item hemonc2__faq-item-top';
				if ($is_open) {
					$item_classes .= ' active'; // Добавляем класс, если нужно
				}
	
				$body_style = $is_open ? 'display: block;' : 'display: none;';
			?>
				<div class="<?php echo $item_classes; ?>">
					<div class="hemonc2__faq-top">
						<div class="hemonc2__faq-name">
							<?=$arResult['PROPERTIES']['FAQ_TOP']['~DESCRIPTION'][$key] ? $arResult['PROPERTIES']['FAQ_TOP']['~DESCRIPTION'][$key] : '~~~'?>
						</div>
						<div class="hemonc2__faq-toggler"></div>
					</div>
					<div class="hemonc2__faq-body" style="<?php echo $body_style; ?>">
						<?=$value['TEXT']?>
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