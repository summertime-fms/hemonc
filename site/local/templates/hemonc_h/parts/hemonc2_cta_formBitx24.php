<style>
    .hemonc2__callback {
        padding: 5rem 0;
        background: #F4FDFF;
    }

    @media screen and (max-width: 768px) {
        .hemonc2__callback {
                padding: 2rem 0;
            }
    }

    .hemonc2__callback-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8rem;
    }

    @media screen and (max-width: 768px) {
        .hemonc2__callback-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
    }

    .hemonc2__callback-title {
        color: var(--h, #0F2531);
        font-family: 'Gerbera', sans-serif;
        font-size: 2rem;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    @media screen and (max-width: 768px) {
        .hemonc2__callback-title {
                font-size: 1.5rem;
            }
    }

    .hemonc2__callback-wrap {
        width: 100%;
        position: relative;
        padding-bottom: 65.63467492260062%;
    }

    .hemonc2__callback-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 1rem;
    }

    @media screen and (max-width: 768px) {
        .hemonc2__callback-wrap,
        .hemonc2__callback-wrap img {
            
        }
    }

    .hemonc2__callback .hemonc2__callback-grid .hemonc2__callback-content .b24-form-wrapper .b24-form-content.b24-form-padding-side {
    }
    
    .b24-form-header-padding {
    }
</style>

<section class="hemonc2__callback">
    <div class="center-wrap">
        <div class="hemonc2__callback-grid">
            <div class="hemonc2__callback-content">
                <div class="hemonc2__callback-title b24-form-padding-side">Остались вопросы?<br>Будем рады на них ответить</div>
                <div class="inline-container">
                    <script data-b24-form="inline/32/4fplvo" data-skip-moving="true">
                        (function(w,d,u){var s=d.createElement('script');
                            s.async=true;
                            s.src=u+'?'+(Date.now()/180000|0);
                            var h=d.getElementsByTagName('script')[0];
                            h.parentNode.insertBefore(s,h);
                        })(window,document,'https://cdn-ru.bitrix24.ru/b27438580/crm/form/loader_32.js');
                    </script>
                </div>
            </div>
            <div class="hemonc2__callback-wrap">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/cta-form/services-form-sq.jpg" alt="Мы на связи">
            </div>
        </div>
    </div>
</section>