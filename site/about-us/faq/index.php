<link rel="stylesheet" href="./faq.css" />
<link rel="stylesheet" href="./accordion.css" />

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';


$APPLICATION->SetTitle("FAQ Часто задаваемые вопросы");
$APPLICATION->SetPageProperty(
    "description",
    "Ответы на часто задаваемые вопросы пациентов онкологической клиники доктора Ласкова в Москве. Как записаться на прием, получить второе мнение онколога и попасть на онлайн-консультацию. ✔Оптимальные цены. ✔Современные препараты. ✔Вдумчиво и бережно. Отвечаем на вопросы онлайн и по телефону 7 (499) 112-25-06"
);

$faqItems = [];

if (\Bitrix\Main\Loader::includeModule('iblock')) {
    $res = \CIBlockElement::GetList(
        ['SORT' => 'ASC', 'ID' => 'ASC'],
        [
            'IBLOCK_ID' => 26,
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
        ],
        false,
        false,
        [
            'ID',
            'NAME',
            'PREVIEW_TEXT',
            'PREVIEW_TEXT_TYPE',
        ]
    );

    while ($item = $res->GetNext()) {
        $content = (string)$item['PREVIEW_TEXT'];

        // Если тип html — выводим как есть.
        // Если вдруг text — экранируем и переносы превращаем в <br>.
        if ($item['PREVIEW_TEXT_TYPE'] !== 'html') {
            $content = nl2br(htmlspecialcharsbx($content));
        }

        $faqItems[] = [
            'TITLE' => $item['NAME'],
            'CONTENT' => $content,
        ];
    }
}
?>

<div class="wrapper">
    <section class="faq-page">
        <div class="accordion">
            <?php if (!empty($faqItems)): ?>
                <?php foreach ($faqItems as $index => $faqItem): ?>
                    <div class="accordion-item<?= $index === 0 ? ' active' : '' ?>">
                        <button class="accordion-header" type="button">
                            <span><?= htmlspecialcharsbx($faqItem['TITLE']) ?></span>
                            <span class="accordion-arrow">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6.778c0 .215.076.387.226.516l5.226 5.226a.71.71 0 00.516.226.821.821 0 00.548-.226l5.226-5.226a.747.747 0 00.226-.548.646.646 0 00-.226-.516.936.936 0 00-.516-.226c-.193-.022-.376.054-.548.226l-4.71 4.71-4.71-4.71a.71.71 0 00-.516-.226.71.71 0 00-.516.226.747.747 0 00-.226.548z" fill="currentColor"/>
                                </svg>
                            </span>
                        </button>

                        <div class="accordion-content">
                            <?= $faqItem['CONTENT'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="accordion-item active">
                    <div class="accordion-content" style="display:block;">
                        <p>Вопросы пока не добавлены.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script src="./accordion.js"></script>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>
