<div class="map-route">
    <h3>НА МАШИНЕ</h3>
    <?=\Hemonc\Params::p('contacts-on-car')?>
</div>

<div>
    <h3>ПЕШКОМ</h3>
    <div class="map-route">
        <?=\Hemonc\Params::p('contacts-on-foot')?>
    </div>
    <div class="contacts-track-photos">
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/1-1_e.jpg" class="n-photo" title="Выйти на станции метро «Варшавская» из выхода №2.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/1-1_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/1-2_e.jpg" class="n-photo" title="Выйти на станции метро «Варшавская» из выхода №2.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/1-2_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/2_e.jpg" class="n-photo" title="Выйдя из метро, повернуть налево, пройти мимо дома 4, к. 1 и торца дома 4 к. 2 по Чонгарскому бульвару, затем свернуть налево во двор.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/2_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/3-1_e.jpg" class="n-photo" title="Направо по диагонали вы увидите многоэтажный панельный жёлто-белый дом. Клиника находится в нём.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/3-1_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/3-2_e.jpg" class="n-photo" title="Направо по диагонали вы увидите многоэтажный панельный жёлто-белый дом. Клиника находится в нём.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/3-2_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/5-1_e.jpg" class="n-photo" title="Пройти правее вдоль торца дома с адресом ул.Болотниковская, д. 1, к. 4 и вновь пойти налево по диагонали через двор с детской площадкой – так вы дойдете до дома с адресом ул. Болотниковская, д. 3, к. 1.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/5-1_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/5-2_e.jpg" class="n-photo" title="Пройти правее вдоль торца дома с адресом ул.Болотниковская, д. 1, к. 4 и вновь пойти налево по диагонали через двор с детской площадкой – так вы дойдете до дома с адресом ул. Болотниковская, д. 3, к. 1.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/5-2_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/5-3_e.jpg" class="n-photo" title="Пройти правее вдоль торца дома с адресом ул.Болотниковская, д. 1, к. 4 и вновь пойти налево по диагонали через двор с детской площадкой – так вы дойдете до дома с адресом ул. Болотниковская, д. 3, к. 1.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/5-3_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/6-1_e.jpg" class="n-photo" title="Вход в клинику находится в нише за левым углом этого дома, стеклянная дверь с прозрачным козырьком.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/6-1_e.jpg" alt="" />
        </a>
        <a rel="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/contacts2/6-2_e.jpg" class="n-photo" title="Вход в клинику находится в нише за левым углом этого дома, стеклянная дверь с прозрачным козырьком.">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/contacts2/6-2_e.jpg" alt="" />
        </a>
    </div>
</div>

<?php
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fancybox/jquery.fancybox.css");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/fancybox/jquery.fancybox.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs("/contacts/script.js");
?>
