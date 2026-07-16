<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    return;
}

$doctor = $arResult['ARTICLE_DOCTOR'] ?? false;
$sources = $arResult['ARTICLE_SOURCES'] ?? [];

if (!$doctor && $sources === []) {
    return;
}
?>

<div class="article-eeat guide-page__eeat">
    <?php if ($doctor) { ?>
        <aside class="article-eeat-author">
            <div class="article-eeat-author__badge">Подготовил врач</div>
            <div class="article-eeat-author__body">
                <?php if (!empty($doctor['PHOTO_SRC'])) { ?>
                    <a href="<?= htmlspecialcharsbx((string) $doctor['DETAIL_PAGE_URL']) ?>" class="article-eeat-author__photo">
                        <img
                            src="<?= htmlspecialcharsbx((string) $doctor['PHOTO_SRC']) ?>"
                            alt="<?= htmlspecialcharsbx((string) $doctor['FULL_NAME']) ?>"
                            loading="lazy"
                            width="88"
                            height="88"
                        >
                    </a>
                <?php } ?>
                <div class="article-eeat-author__info">
                    <a href="<?= htmlspecialcharsbx((string) $doctor['DETAIL_PAGE_URL']) ?>" class="article-eeat-author__name">
                        <?= htmlspecialcharsbx((string) $doctor['FULL_NAME']) ?>
                    </a>
                    <?php if (!empty($doctor['POSITION'])) { ?>
                        <div class="article-eeat-author__position"><?= htmlspecialcharsbx((string) $doctor['POSITION']) ?></div>
                    <?php } ?>
                    <?php if (!empty($doctor['EXPERIENCE'])) { ?>
                        <div class="article-eeat-author__experience"><?= htmlspecialcharsbx((string) $doctor['EXPERIENCE']) ?></div>
                    <?php } ?>
                    <a href="<?= htmlspecialcharsbx((string) $doctor['DETAIL_PAGE_URL']) ?>" class="article-eeat-author__link">
                        Подробнее о враче
                    </a>
                </div>
            </div>
        </aside>
    <?php } ?>

    <?php if ($sources !== []) { ?>
        <details class="article-eeat-sources">
            <summary class="article-eeat-sources__summary">
                <span>Источники и клинические рекомендации</span>
                <span class="article-eeat-sources__arrow" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6.778c0 .215.076.387.226.516l5.226 5.226a.71.71 0 00.516.226.821.821 0 00.548-.226l5.226-5.226a.747.747 0 00.226-.548.646.646 0 00-.226-.516.936.936 0 00-.516-.226c-.193-.022-.376.054-.548.226l-4.71 4.71-4.71-4.71a.71.71 0 00-.516-.226.71.71 0 00-.516.226.747.747 0 00-.226.548z" fill="currentColor"/>
                    </svg>
                </span>
            </summary>
            <div class="article-eeat-sources__content">
                <ul class="article-eeat-sources__list">
                    <?php foreach ($sources as $source) { ?>
                        <li>
                            <a href="<?= htmlspecialcharsbx($source['URL']) ?>" target="_blank" rel="noopener">
                                <?= htmlspecialcharsbx($source['TITLE']) ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </details>
    <?php } ?>
</div>
