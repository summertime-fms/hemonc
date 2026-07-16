<!-- <form class="form-standard callback-form-data">
    <div class="input-container">
        <input type="tel" name="phone" placeholder="+7 (999) 999-99-99" required="required">
    </div>
    <button type="submit" class="button-blue">Перезвоните мне</button>
</form> -->
<?php $APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    [
        "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixCallback.php",
        "AREA_FILE_SHOW" => "file",
    ],
)?>
