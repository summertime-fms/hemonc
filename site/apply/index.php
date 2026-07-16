<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Анкета пациента');

$pacientId = isset($_GET['pacient_id']) ? trim((string) $_GET['pacient_id']) : '';
?>
<main class="apply-page">
    <div class="wrapper">
        <section class="apply-card">
            <h1 class="apply-title">Заполнение анкеты пациента</h1>
            <p class="apply-subtitle">Поля со звездочкой обязательны для заполнения.</p>

            <form
                id="apply-form"
                class="apply-form"
                action="https://laskov.medconsult.ru/laskov/hs/MobHTTP/api?action=pacientdata"
                data-proxy-url="/ajax/index.php?action=apply_proxy"
                method="post"
                novalidate
            >
                <input type="hidden" name="pacientguid" id="pacientguid" value="<?=htmlspecialchars($pacientId)?>">

                <div class="apply-field">
                    <label for="surname">Фамилия <span class="required">*</span></label>
                    <input type="text" id="surname" name="surname" autocomplete="family-name" required>
                    <div class="apply-error" data-error-for="surname"></div>
                </div>

                <div class="apply-field">
                    <label for="name">Имя <span class="required">*</span></label>
                    <input type="text" id="name" name="name" autocomplete="given-name" required>
                    <div class="apply-error" data-error-for="name"></div>
                </div>

                <div class="apply-field">
                    <label for="patronymic">Отчество</label>
                    <input type="text" id="patronymic" name="patronymic" autocomplete="additional-name">
                    <div class="apply-error" data-error-for="patronymic"></div>
                </div>

                <div class="apply-field">
                    <label for="birthday">Дата рождения <span class="required">*</span></label>
                    <input type="text" id="birthday" name="birthday" placeholder="ДД.ММ.ГГГГ" required>
                    <div class="apply-error" data-error-for="birthday"></div>
                </div>

                <div class="apply-field">
                    <label for="email">E-mail <span class="required">*</span></label>
                    <input type="email" id="email" name="email" autocomplete="email" required>
                    <div class="apply-error" data-error-for="email"></div>
                </div>

                <div class="apply-field">
                    <label for="passports">Серия паспорта</label>
                    <input type="text" id="passports" name="passports">
                    <div class="apply-error" data-error-for="passports"></div>
                </div>

                <div class="apply-field">
                    <label for="passportn">Номер паспорта</label>
                    <input type="text" id="passportn" name="passportn">
                    <div class="apply-error" data-error-for="passportn"></div>
                </div>

                <div class="apply-field">
                    <label for="passportdate">Дата выдачи паспорта</label>
                    <input type="text" id="passportdate" name="passportdate" placeholder="ДД.ММ.ГГГГ">
                    <div class="apply-error" data-error-for="passportdate"></div>
                </div>

                <div class="apply-field">
                    <label for="passportpcode">Код подразделения</label>
                    <input type="text" id="passportpcode" name="passportpcode">
                    <div class="apply-error" data-error-for="passportpcode"></div>
                </div>

                <div class="apply-field">
                    <label for="vydan">Кем выдан</label>
                    <textarea id="vydan" name="vydan" rows="3"></textarea>
                    <div class="apply-error" data-error-for="vydan"></div>
                </div>

                <div class="apply-common-error" id="apply-common-error"></div>
                <div class="apply-success" id="apply-success"></div>

                <button type="submit" class="apply-submit" id="apply-submit">
                    <span class="btn-text">Отправить</span>
                    <span class="btn-loader" aria-hidden="true"></span>
                </button>
            </form>
        </section>
    </div>
</main>

<style>
    .apply-page {
        margin-top: 20px;
        padding: 40px 0 80px;
        color: #0F2531;
    }
    .apply-card {
        max-width: 680px;
        margin: 0 auto;
        padding: 32px;
        border: 1px solid rgba(15, 37, 49, 0.15);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(15, 37, 49, 0.06);
    }
    .apply-title {
        margin: 0 0 8px;
        color: #0F2531;
    }
    .apply-subtitle {
        margin: 0 0 24px;
        color: #0F2531;
        opacity: 0.8;
    }
    .apply-field {
        margin-bottom: 16px;
    }
    .apply-field label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #0F2531;
    }
    .required {
        color: var(--pink, #F6AE9C);
    }
    .apply-field input,
    .apply-field textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid rgba(15, 37, 49, 0.25);
        border-radius: 10px;
        color: #0F2531;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
    }
    .apply-field input:focus,
    .apply-field textarea:focus {
        outline: none;
        border-color: var(--green, #007088);
        box-shadow: 0 0 0 3px rgba(0, 112, 136, 0.15);
    }
    .apply-field.is-invalid input,
    .apply-field.is-invalid textarea {
        border-color: var(--pink, #F6AE9C);
        box-shadow: 0 0 0 3px rgba(246, 174, 156, 0.2);
    }
    .apply-error,
    .apply-common-error {
        display: none;
        margin-top: 4px;
        color: #c1442e;
        font-size: 13px;
    }
    .apply-error:not(:empty),
    .apply-common-error:not(:empty) {
        display: block;
    }
    .apply-success {
        display: none;
        margin: 6px 0 12px;
        color: var(--green, #007088);
        font-weight: 600;
    }
    .apply-success:not(:empty) {
        display: block;
    }
    .apply-submit {
        width: 100%;
        min-height: 48px;
        border: 0;
        border-radius: 12px;
        background: var(--green, #007088);
        color: #fff;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: opacity .2s;
    }
    .apply-submit:hover {
        opacity: 0.92;
    }
    .apply-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .btn-loader {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.4);
        border-top-color: #fff;
        border-radius: 50%;
        display: none;
        animation: apply-spin .8s linear infinite;
    }
    .apply-submit.is-loading .btn-loader {
        display: inline-block;
    }
    @keyframes apply-spin {
        to { transform: rotate(360deg); }
    }
    @media (max-width: 768px) {
        .apply-page {
            padding: 20px 0 48px;
        }
        .apply-card {
            padding: 20px;
        }
    }

    #vydan {
        resize: none;
    }
</style>

<script>
    (function () {
        var form = document.getElementById('apply-form');
        if (!form) {
            return;
        }
        var submitButton = document.getElementById('apply-submit');
        var submitText = submitButton.querySelector('.btn-text');
        var successNode = document.getElementById('apply-success');
        var commonErrorNode = document.getElementById('apply-common-error');

        var requiredFields = {
            surname: 'Введите фамилию',
            name: 'Введите имя',
            birthday: 'Введите дату рождения',
            email: 'Введите e-mail'
        };

        function setLoading(state) {
            submitButton.disabled = state;
            submitButton.classList.toggle('is-loading', state);
            submitText.textContent = state ? 'Отправляем...' : 'Отправить';
        }

        function clearErrors() {
            var errors = form.querySelectorAll('.apply-error');
            var fields = form.querySelectorAll('.apply-field');
            errors.forEach(function (errorNode) {
                errorNode.textContent = '';
            });
            fields.forEach(function (fieldNode) {
                fieldNode.classList.remove('is-invalid');
            });
            commonErrorNode.textContent = '';
        }

        function setFieldError(fieldName, message) {
            var input = form.querySelector('[name="' + fieldName + '"]');
            var errorNode = form.querySelector('[data-error-for="' + fieldName + '"]');

            if (input && input.parentElement) {
                input.parentElement.classList.add('is-invalid');
            }
            if (errorNode) {
                errorNode.textContent = message;
            }
        }

        function validateEmail(value) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        }

        function validateDate(value) {
            if (!value) {
                return true;
            }
            if (!/^\d{2}\.\d{2}\.\d{4}$/.test(value)) {
                return false;
            }

            var parts = value.split('.');
            var day = Number(parts[0]);
            var month = Number(parts[1]) - 1;
            var year = Number(parts[2]);
            var date = new Date(year, month, day);

            return date.getFullYear() === year
                && date.getMonth() === month
                && date.getDate() === day;
        }

        function convertDateToServerFormat(dateStr) {
            if (!dateStr) return '';
            var parts = dateStr.split('.');
            if (parts.length === 3) {
                return parts[2] + parts[1] + parts[0];
            }
            return dateStr;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearErrors();
            successNode.textContent = '';

            var formData = new FormData(form);
            var payload = {
                pacientguid: String(formData.get('pacientguid') || '').trim(),
                surname: String(formData.get('surname') || '').trim(),
                name: String(formData.get('name') || '').trim(),
                patronymic: String(formData.get('patronymic') || '').trim(),
                birthday: String(formData.get('birthday') || '').trim(),
                email: String(formData.get('email') || '').trim(),
                passports: String(formData.get('passports') || '').trim(),
                passportn: String(formData.get('passportn') || '').trim(),
                passportdate: String(formData.get('passportdate') || '').trim(),
                passportpcode: String(formData.get('passportpcode') || '').trim(),
                vydan: String(formData.get('vydan') || '').trim()
            };

            var hasErrors = false;

            Object.keys(requiredFields).forEach(function (fieldName) {
                if (!payload[fieldName]) {
                    hasErrors = true;
                    setFieldError(fieldName, requiredFields[fieldName]);
                }
            });

            if (payload.email && !validateEmail(payload.email)) {
                hasErrors = true;
                setFieldError('email', 'Некорректный e-mail');
            }

            if (payload.birthday && !validateDate(payload.birthday)) {
                hasErrors = true;
                setFieldError('birthday', 'Используйте формат ДД.ММ.ГГГГ');
            }

            if (payload.passportdate && !validateDate(payload.passportdate)) {
                hasErrors = true;
                setFieldError('passportdate', 'Используйте формат ДД.ММ.ГГГГ');
            }

            if (!payload.pacientguid) {
                hasErrors = true;
                commonErrorNode.textContent = 'Не передан pacient_id в адресной строке.';
            }

            if (hasErrors) {
                return;
            }

            // Конвертируем даты в формат ГГГГММДД
            payload.birthday = convertDateToServerFormat(payload.birthday);
            payload.passportdate = convertDateToServerFormat(payload.passportdate);

            setLoading(true);

            fetch(form.dataset.proxyUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json, text/plain, */*'
                },
                body: JSON.stringify({
                    endpoint: form.action,
                    payload: payload
                })
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Ошибка отправки: ' + response.status);
                    }
                    return response.json();
                })
                .then(function (data) {
                    successNode.textContent = 'Анкета успешно отправлена.';
                    form.reset();
                    document.getElementById('pacientguid').value = payload.pacientguid;
                })
                .catch(function (error) {
                    commonErrorNode.textContent = error.message || 'Не удалось отправить форму.';
                })
                .finally(function () {
                    setLoading(false);
                });
        });
    })();
</script>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
