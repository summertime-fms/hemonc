<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

if (empty($arResult["ITEMS"])) {
    return;
}

$validItems = array_filter($arResult["ITEMS"], function($item) {
    return !empty($item['PROPERTIES']['VIDEO']['VALUE']);
});

if (empty($validItems)) {
    return;
}
?>
<div class="hemonc2__videos">
    <div class="center-wrap">
        <div class="hemonc2__row">
            <div class="hemonc2__h2">Полезные&nbsp;видео</div>
            <a href="/video/" class="hemonc2__link">смотреть все</a>
        </div>
        <div class="hemonc2__videos-swiper">
            <?php foreach ($validItems as $arItem) {
                // Получаем файл видео
                $videoFile = $arItem['PROPERTIES']['VIDEO']['VALUE'];
                $videoSrc = '';

                if (is_array($videoFile) && !empty($videoFile['SRC'])) {
                    $videoSrc = $videoFile['SRC'];
                }
                elseif (is_numeric($videoFile)) {
                    $videoFileArray = CFile::GetFileArray($videoFile);
                    if ($videoFileArray) {
                        $videoSrc = $videoFileArray['SRC'];
                    }
                }
                elseif (is_string($videoFile) && !empty($videoFile)) {
                    $videoSrc = $videoFile;
                }

                if (empty($videoSrc)) {
                    continue;
                }
                ?>
                <div>
                    <div class="hemonc2__videos-link" data-fancybox data-type="iframe" data-src="<?= htmlspecialchars($videoSrc) ?>">
                        <div class="hemonc2__videos-logo"><span>—</span> Клиника доктора Ласкова.</div>
                        <div class="hemonc2__videos-title"><?= htmlspecialchars(empty($arItem['PREVIEW_TEXT']) ? $arItem['NAME'] : $arItem['PREVIEW_TEXT']) ?></div>
                        <div class="hemonc2__videos-author"><?= htmlspecialchars($arItem['PROPERTIES']['AUTHOR_DESCRIPTION']['~VALUE']) ?></div>
                    </div>
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
    $(document).ready(function() {
        var $slider = $('.hemonc2__videos-swiper');
        var itemCount = $slider.find('.hemonc2__videos-link').length;

        if (itemCount > 0) {
            $slider.slick({
                adaptiveHeight: true,
                mobileFirst: true,
                infinite: false,
                dots: true,
                dotsClass: 'hemonc2__reviews-dots',
                arrows: false,
                slidesToShow: 1,
                swipeToSlide: true,
                responsive: [
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: Math.min(itemCount, 2),
                        }
                    },{
                        breakpoint: 767,
                        settings: {
                            slidesToShow: Math.min(itemCount, 3),
                        }
                    },{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: Math.min(itemCount, 4),
                        }
                    }
                ]
            });

            // Инициализация Fancybox с проверкой
            $slider.on('click', '.hemonc2__videos-link', function(e) {
                var $this = $(this);
                var videoSrc = $this.data('src');

                if (!videoSrc) {
                    e.preventDefault();
                    console.warn('Video source is empty');
                    return false;
                }

                // Открываем fancybox
                $.fancybox.open({
                    src: videoSrc,
                    type: 'iframe',
                    iframe: {
                        preload: false,
                        css: {
                            width: '80%',
                            height: '80%'
                        }
                    }
                });

                e.preventDefault();
                return false;
            });
        }
    });
</script>
