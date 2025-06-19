<?php
/**
 * Главный файл темы
 *
 * @package RocketBusiness
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="rb-main">
    <div class="rb-container">
        <div class="rb-articles">
            <h1 class="rb-articles__title">Статьи</h1>
            <div class="rb-articles__container">
                <?php
                $articles = rocketbusiness_get_articles(['posts_per_page' => 3]);
                
                if ($articles) :
                    foreach ($articles as $article) :
                        setup_postdata($article);
                        ?>
                        <div class="rb-article-item">
                            <a href="<?php echo esc_url(get_permalink($article->ID)); ?>" class="rb-article-item__link">
                                <?php if (has_post_thumbnail($article->ID)) : ?>
                                    <div class="rb-article-item__image-container">
                                        <?php echo get_the_post_thumbnail($article->ID, 'medium', ['class' => 'rb-article-item__image']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h2 class="rb-article-item__title"><?php echo esc_html($article->post_title); ?></h2>
                                
                                <?php if ($article->post_excerpt) : ?>
                                    <p class="rb-article-item__description"><?php echo esc_html($article->post_excerpt); ?></p>
                                <?php endif; ?>
                                
                                <p class="rb-article-item__date"><?php echo esc_html(get_the_date('', $article->ID)); ?></p>
                            </a>
                        </div>
                        <?php
                    endforeach;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="rb-article-item">
                        <?php rocketbusiness_display_image('post1.png', 'Статья 1', 'rb-article-item__image'); ?>
                        <h2 class="rb-article-item__title">Февральское поступление товара и актуальные скидки</h2>
                        <p class="rb-article-item__description">Экономьте на ремонте своего автомобиля, не упуская выгодных возможностей</p>
                        <p class="rb-article-item__date">2024-01-01</p>
                    </div>
                    <div class="rb-article-item">
                        <?php rocketbusiness_display_image('post2.png', 'Статья 2', 'rb-article-item__image'); ?>
                        <h2 class="rb-article-item__title">Январское поступление товара и актуальные скидки</h2>
                        <p class="rb-article-item__description">Экономьте на ремонте своего автомобиля, не упуская выгодных возможностей</p>
                        <p class="rb-article-item__date">2024-01-01</p>
                    </div>
                    <div class="rb-article-item">
                        <?php rocketbusiness_display_image('post3.png', 'Статья 3', 'rb-article-item__image'); ?>
                        <h2 class="rb-article-item__title">Декабрьское поступление товара и актуальные скидки</h2>
                        <p class="rb-article-item__description">Экономьте на ремонте своего автомобиля, не упуская выгодных возможностей</p>
                        <p class="rb-article-item__date">2024-01-01</p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>

        
        
        <div class="rb-services">
            <h1 class="rb-services__title">Акции</h1>
            <div class="rb-services__container">
                <?php
                $services = rocketbusiness_get_services(['posts_per_page' => 4]);
                
                if ($services) :
                    foreach ($services as $service) :
                        setup_postdata($service);
                        $price = rocketbusiness_get_service_price($service->ID);
                        $labels = rocketbusiness_get_service_labels($service->ID);
                        ?>
                        <div class="rb-service-item">
                            <a href="<?php echo esc_url(get_permalink($service->ID)); ?>" class="rb-service-item__link">
                                <div class="rb-service-item__image-container">
                                    <?php if (has_post_thumbnail($service->ID)) : ?>
                                        <?php echo get_the_post_thumbnail($service->ID, 'medium', ['class' => 'rb-service-item__image']); ?>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($labels)) : ?>
                                        <?php foreach ($labels as $index => $label) : ?>
                                            <p class="rb-service-item__label"><?php echo esc_html($label); ?></p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <h2 class="rb-service-item__title"><?php echo esc_html($service->post_title); ?></h2>
                                
                                <?php if ($price) : ?>
                                    <p class="rb-service-item__price"><?php echo esc_html($price); ?></p>
                                <?php endif; ?>
                            </a>
                        </div>
                        <?php
                    endforeach;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="rb-service-item">
                        <div class="rb-service-item__image-container">
                            <?php rocketbusiness_display_image('service1.png', 'Услуга 1', 'rb-service-item__image'); ?>
                            <p class="rb-service-item__label">Товар месяца</p>
                        </div>
                        <h2 class="rb-service-item__title">Настроим цифровую технику в вашем присутствии</h2>
                        <p class="rb-service-item__price">от 200 ₽</p>
                    </div>
                    <div class="rb-service-item">
                        <div class="rb-service-item__image-container">
                            <?php rocketbusiness_display_image('service2.jpg', 'Услуга 2', 'rb-service-item__image'); ?>
                            <p class="rb-service-item__label">Скидка</p>
                            <p class="rb-service-item__label">Акция</p>
                        </div>
                        <h2 class="rb-service-item__title">Настроим цифровую технику в вашем присутствии</h2>
                        <p class="rb-service-item__price">от 200 ₽</p>
                    </div>
                    <div class="rb-service-item">
                        <div class="rb-service-item__image-container">
                            <?php rocketbusiness_display_image('service3.jpg', 'Услуга 3', 'rb-service-item__image'); ?>
                            <p class="rb-service-item__label">Новинка</p>
                        </div>
                        <h2 class="rb-service-item__title">Настроим цифровую технику в вашем присутствии</h2>
                        <p class="rb-service-item__price">от 200 ₽</p>
                    </div>
                    <div class="rb-service-item">
                        <div class="rb-service-item__image-container">
                            <?php rocketbusiness_display_image('service4.jpg', 'Услуга 4', 'rb-service-item__image'); ?>
                            <p class="rb-service-item__label">Товар месяца</p>
                        </div>
                        <h2 class="rb-service-item__title">Настроим цифровую технику в вашем присутствии</h2>
                        <p class="rb-service-item__price">от 200 ₽</p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            
            <div class="rb-services__dots">
                <button class="rb-services__dot active" data-slide="0" aria-label="Перейти к слайду 1"></button>
                <button class="rb-services__dot" data-slide="1" aria-label="Перейти к слайду 2"></button>
                <button class="rb-services__dot" data-slide="2" aria-label="Перейти к слайду 3"></button>
                <button class="rb-services__dot" data-slide="3" aria-label="Перейти к слайду 4"></button>
            </div>
        </div>
        
        <div class="rb-contact-form">
            <h1 class="rb-contact-form__title">Свяжитесь с нами</h1>
            <div class="rb-contact-form__container">
                <?php echo do_shortcode('[wpforms id="30" title="false"]'); ?>
            </div>
        </div>
        
    </div>
</main>

<?php get_footer(); ?> 