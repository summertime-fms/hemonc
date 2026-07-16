<?php
/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>

<?php
/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>

<?php foreach ($arResult["ITEMS"] as $arSection) { ?>
    <h2 class="video-chart-title"><?=htmlspecialchars($arSection['NAME'])?></h2>
    <div class="videos-container">
        <?php foreach ($arSection['ELEMENTS'] as $arItem) { ?>
            <?php
            $videoFileId = $arItem['PROPERTIES']['VIDEO']['VALUE'] ?? null;
            $localVideoPath = '';

            if (!empty($videoFileId)) {
                $videoFile = CFile::GetPath($videoFileId);
                if ($videoFile) {
                    $localVideoPath = $videoFile;
                }
            }

            $posterId = $arItem['PROPERTIES']['POSTER']['VALUE'] ?? null;
            $posterPath = '';

            if (!empty($posterId)) {
                $posterFile = CFile::GetPath($posterId);
                if ($posterFile) {
                    $posterPath = $posterFile;
                }
            }

            if (empty($posterPath) && !empty($arItem['PREVIEW_PICTURE']['SRC'])) {
                $posterPath = $arItem['PREVIEW_PICTURE']['SRC'];
            }

            $hasLocalVideo = !empty($localVideoPath);
            $youtubeId = $arItem['PROPERTIES']['YOUTUBE_ID']['VALUE'] ?? null;
            ?>

            <div class="video-card">
                <?php if ($hasLocalVideo) { ?>
                    <!-- Локальное видео -->
                    <div class="local-video">
                        <video class="local-video__media" controls preload="metadata" poster="<?=htmlspecialchars($posterPath)?>">
                            <source src="<?=htmlspecialchars($localVideoPath)?>" type="video/mp4">
                            <?php
                            $videoExt = strtolower(pathinfo($localVideoPath, PATHINFO_EXTENSION));
                            if ($videoExt === 'webm') {
                                echo '<source src="'.htmlspecialchars($localVideoPath).'" type="video/webm">';
                            } elseif ($videoExt === 'ogg') {
                                echo '<source src="'.htmlspecialchars($localVideoPath).'" type="video/ogg">';
                            }
                            ?>
                            Ваш браузер не поддерживает тег video.
                        </video>
                        <?php if (empty($posterPath)) { ?>
                            <button class="local-video__play-btn" aria-label="Запустить видео">
                                <svg width="68" height="48" viewBox="0 0 68 48">
                                    <path class="local-video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                    <path class="yt-video__button-icon" d="M 45,24 27,14 27,34"></path>
                                </svg>
                            </button>
                        <?php } ?>
                    </div>
                <?php } elseif ($youtubeId) { ?>
                    <!-- YouTube видео -->
                    <div class="yt-video">
                        <a class="yt-video__link" href="https://youtu.be/<?=htmlspecialchars($youtubeId)?>">
                            <picture>
                                <source srcset="https://i.ytimg.com/vi_webp/<?=htmlspecialchars($youtubeId)?>/maxresdefault.webp" type="image/webp">
                                <img class="yt-video__media" src="https://i.ytimg.com/<?=htmlspecialchars($youtubeId)?>/maxresdefault.jpg" data-media="<?=htmlspecialchars($youtubeId)?>" alt="<?=htmlspecialchars($arItem['NAME'])?>">
                            </picture>
                        </a>
                        <button class="yt-video__button" aria-label="Запустить видео">
                            <svg width="68" height="48" viewBox="0 0 68 48">
                                <path class="yt-video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                <path class="yt-video__button-icon" d="M 45,24 27,14 27,34"></path>
                            </svg>
                        </button>
                    </div>
                <?php } else { ?>
                    <!-- Встраиваемый контент из DETAIL_TEXT -->
                    <div class="video-card__container <?=(mb_stripos($arItem['DETAIL_TEXT'], 'youtube') !== false ? 'video-card__container--yt' : 'video-card__container--nonyt')?>">
                        <?=$arItem['DETAIL_TEXT']?>
                    </div>
                <?php } ?>

                <div class="video-card__title">
                    <?=htmlspecialchars($arItem['NAME'])?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const localVideoContainers = document.querySelectorAll('.local-video');

        localVideoContainers.forEach(container => {
            const video = container.querySelector('.local-video__media');
            const playBtn = container.querySelector('.local-video__play-btn');

            if (video && playBtn) {
                playBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    video.play();
                    playBtn.style.display = 'none';
                });

                video.addEventListener('play', function() {
                    playBtn.style.display = 'none';
                });

                video.addEventListener('pause', function() {
                    if (!video.ended) {
                        playBtn.style.display = 'flex';
                    }
                });

                video.addEventListener('ended', function() {
                    playBtn.style.display = 'flex';
                    video.currentTime = 0;
                });

                video.addEventListener('mouseenter', function() {
                    if (!video.paused) {
                        playBtn.style.opacity = '0';
                    }
                });

                video.addEventListener('mouseleave', function() {
                    if (!video.paused && !video.ended) {
                        playBtn.style.opacity = '1';
                    }
                });
            }
        });
    });
</script>
<style>

.videos-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 20px;
}

.video-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.local-video,
.yt-video,
.video-card__container {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #000;
    overflow: hidden;
}

.local-video__media {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.local-video__media--contain {
    object-fit: contain;
}

.local-video__play-btn,
.yt-video__button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 68px;
    height: 68px;
    background: rgba(0, 0, 0, 0.7);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    z-index: 2;
    transition: all 0.3s ease;
}

.local-video__play-btn:hover,
.yt-video__button:hover {
    background: rgba(255, 0, 0, 0.8);
    transform: translate(-50%, -50%) scale(1.05);
}

.video-card__title {
    padding: 12px;
    font-size: 14px;
    line-height: 1.4;
    color: #333;
    flex-grow: 1;
}

.video-card__container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

@media (max-width: 768px) {
    .videos-container {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .local-video__play-btn,
    .yt-video__button {
        width: 50px;
        height: 50px;
    }
}
