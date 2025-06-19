<?php
/**
 * Шаблон для отображения архивной страницы акций
 *
 * @package RocketBusiness
 */

get_header(); ?>

<div class="rb-container">
    <div class="rb-content__wrapper">
        <main class="rb-content__main">
            <div class="rb-content">
                <header class="rb-archive-header">
                    <h1 class="rb-archive-title">
                        <?php 
                        if (is_tax('rb_service_category')) {
                            single_term_title(__('Категория: ', 'rocketbusiness'));
                        } elseif (is_tax('rb_service_tags')) {
                            single_term_title(__('Тег: ', 'rocketbusiness'));
                        } else {
                            _e('Акции', 'rocketbusiness');
                        }
                        ?>
                    </h1>
                    
                    <?php 
                    $archive_description = get_the_archive_description();
                    if ($archive_description) : ?>
                        <div class="rb-archive-description">
                            <?php echo wp_kses_post($archive_description); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="rb-services">
                        <div class="rb-services__container">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('rb-service-item'); ?>>
                                    <a href="<?php the_permalink(); ?>" class="rb-service-item__link">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="rb-service-item__image-container">
                                                <?php the_post_thumbnail('medium', ['class' => 'rb-service-item__image']); ?>
                                                
                                                <?php 
                                                $labels = rocketbusiness_get_service_labels();
                                                if (!empty($labels)) : ?>
                                                    <?php foreach ($labels as $index => $label) : ?>
                                                        <span class="rb-service-item__label"><?php echo esc_html($label); ?></span>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="rb-service-item__content">
                                            <h2 class="rb-service-item__title"><?php the_title(); ?></h2>
                                            
                                            <?php if (has_excerpt()) : ?>
                                                <p class="rb-service-item__description"><?php the_excerpt(); ?></p>
                                            <?php endif; ?>
                                            
                                            <?php 
                                            $price = rocketbusiness_get_service_price();
                                            if ($price) : ?>
                                                <p class="rb-service-item__price"><?php echo esc_html($price); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <?php
                    the_posts_pagination([
                        'mid_size'  => 2,
                        'prev_text' => __('← Предыдущая', 'rocketbusiness'),
                        'next_text' => __('Следующая →', 'rocketbusiness'),
                    ]);
                    ?>

                <?php else : ?>
                    <div class="rb-no-posts">
                        <h2><?php _e('Акции не найдены', 'rocketbusiness'); ?></h2>
                        <p><?php _e('К сожалению, акции не найдены. Попробуйте поискать что-то другое.', 'rocketbusiness'); ?></p>
                        
                        <div class="rb-no-posts__actions">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="rb-btn rb-btn--primary">
                                <?php _e('Вернуться на главную', 'rocketbusiness'); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?> 