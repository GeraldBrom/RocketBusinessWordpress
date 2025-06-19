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
                    // Fallback контент для статей
                    $fallback_articles = [
                        [
                            'title' => 'Добро пожаловать в RocketBusiness',
                            'description' => 'Мы рады представить вам нашу компанию и рассказать о том, как мы можем помочь вашему бизнесу расти и развиваться.',
                            'date' => date('d.m.Y')
                        ],
                        [
                            'title' => 'Наши услуги для бизнеса',
                            'description' => 'Предлагаем широкий спектр услуг для развития вашего бизнеса: от консультаций до полного сопровождения проектов.',
                            'date' => date('d.m.Y', strtotime('-1 day'))
                        ],
                        [
                            'title' => 'Почему выбирают нас',
                            'description' => 'Более 10 лет опыта, индивидуальный подход к каждому клиенту и гарантированный результат - вот что отличает нас от конкурентов.',
                            'date' => date('d.m.Y', strtotime('-2 days'))
                        ]
                    ];
                    
                    foreach ($fallback_articles as $article) :
                        ?>
                        <div class="rb-article-item">
                            <div class="rb-article-item__link">
                                <div class="rb-article-item__image-container">
                                    <div class="rb-article-item__image-placeholder">
                                        <svg width="300" height="200" viewBox="0 0 300 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="300" height="200" fill="#f5f5f5"/>
                                            <path d="M150 80C166.569 80 180 66.5685 180 50C180 33.4315 166.569 20 150 20C133.431 20 120 33.4315 120 50C120 66.5685 133.431 80 150 80Z" fill="#ddd"/>
                                            <path d="M100 140L130 110L150 130L170 110L200 140V180H100V140Z" fill="#ddd"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <h2 class="rb-article-item__title"><?php echo esc_html($article['title']); ?></h2>
                                <p class="rb-article-item__description"><?php echo esc_html($article['description']); ?></p>
                                <p class="rb-article-item__date"><?php echo esc_html($article['date']); ?></p>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <div class="rb-services">
            <h1 class="rb-services__title">Услуги</h1>
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
                    // Fallback контент для услуг
                    $fallback_services = [
                        [
                            'title' => 'Бизнес-консультации',
                            'price' => 'от 5 000 ₽',
                            'label' => 'Популярно'
                        ],
                        [
                            'title' => 'Маркетинговые услуги',
                            'price' => 'от 15 000 ₽',
                            'label' => 'Новинка'
                        ],
                        [
                            'title' => 'Разработка стратегии',
                            'price' => 'от 25 000 ₽',
                            'label' => 'Топ'
                        ],
                        [
                            'title' => 'Анализ рынка',
                            'price' => 'от 10 000 ₽',
                            'label' => 'Акция'
                        ]
                    ];
                    
                    foreach ($fallback_services as $service) :
                        ?>
                        <div class="rb-service-item">
                            <div class="rb-service-item__link">
                                <div class="rb-service-item__image-container">
                                    <div class="rb-service-item__image-placeholder">
                                        <svg width="300" height="200" viewBox="0 0 300 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="300" height="200" fill="#f5f5f5"/>
                                            <circle cx="150" cy="100" r="40" fill="#ddd"/>
                                            <path d="M140 100L150 90L160 100L150 110L140 100Z" fill="#999"/>
                                        </svg>
                                    </div>
                                    <p class="rb-service-item__label"><?php echo esc_html($service['label']); ?></p>
                                </div>
                                
                                <h2 class="rb-service-item__title"><?php echo esc_html($service['title']); ?></h2>
                                <p class="rb-service-item__price"><?php echo esc_html($service['price']); ?></p>
                            </div>
                        </div>
                        <?php
                    endforeach;
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