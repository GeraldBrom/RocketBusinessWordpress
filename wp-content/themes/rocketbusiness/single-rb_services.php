<?php
/**
 * Шаблон для отображения одиночной акции
 *
 * @package RocketBusiness
 */

get_header(); ?>

<div class="rb-container">
    <div class="rb-content__wrapper">
        <main class="rb-content__main">
            <div class="rb-content">
                
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('rb-single-service'); ?>>
                        <header class="rb-single-service__header">
                            <h1 class="rb-single-service__title"><?php the_title(); ?></h1>
                            
                            <div class="rb-single-service__meta">
                                <div class="rb-single-service__meta-item">
                                    <span class="rb-single-service__meta-icon">📅</span>
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </time>
                                </div>
                                
                                <div class="rb-single-service__meta-item">
                                    <span class="rb-single-service__meta-icon">👤</span>
                                    <span class="rb-single-service__author">
                                        <?php echo esc_html(get_the_author()); ?>
                                    </span>
                                </div>
                                
                                <?php 
                                $price = rocketbusiness_get_service_price();
                                if ($price) : ?>
                                    <div class="rb-single-service__meta-item">
                                        <span class="rb-single-service__meta-icon">💰</span>
                                        <span class="rb-single-service__price"><?php echo esc_html($price); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php 
                                $categories = get_the_terms(get_the_ID(), 'rb_service_category');
                                if ($categories && !is_wp_error($categories)) : ?>
                                    <div class="rb-single-service__meta-item">
                                        <span class="rb-single-service__meta-icon">📂</span>
                                        <span class="rb-single-service__categories">
                                            <?php 
                                            $category_names = [];
                                            foreach ($categories as $category) {
                                                $category_names[] = '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                                            }
                                            echo implode(', ', $category_names);
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="rb-single-service__thumbnail">
                                <?php the_post_thumbnail('large', ['class' => 'rb-single-service__image']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="rb-single-service__content">
                            <?php the_content(); ?>
                        </div>

                        <?php 
                        $labels = rocketbusiness_get_service_labels();
                        if (!empty($labels)) : ?>
                            <div class="rb-single-service__labels">
                                <h3><?php _e('Лейблы акции:', 'rocketbusiness'); ?></h3>
                                <div class="rb-single-service__labels-list">
                                    <?php foreach ($labels as $label) : ?>
                                        <span class="rb-single-service__label"><?php echo esc_html($label); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <footer class="rb-single-service__footer">
                            <?php if (current_user_can('edit_post', get_the_ID())) : ?>
                                <div class="rb-single-service__edit-link">
                                    <a href="<?php echo esc_url(get_edit_post_link()); ?>">
                                        <?php _e('Редактировать акцию', 'rocketbusiness'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </footer>
                    </article>

                    <?php
                    $prev_post = get_previous_post(true, '', 'rb_service_category');
                    $next_post = get_next_post(true, '', 'rb_service_category');
                    
                    if ($prev_post || $next_post) : ?>
                        <nav class="rb-post-navigation">
                            <div class="rb-post-navigation__links">
                                <?php if ($prev_post) : ?>
                                    <div class="rb-post-navigation__prev">
                                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                                            <span class="rb-post-navigation__icon">←</span>
                                            <?php echo esc_html($prev_post->post_title); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($next_post) : ?>
                                    <div class="rb-post-navigation__next">
                                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                                            <?php echo esc_html($next_post->post_title); ?>
                                            <span class="rb-post-navigation__icon">→</span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </nav>
                    <?php endif; ?>

                <?php endwhile; ?>
                <div class="rb-back-button">
                    <a href="javascript:history.back()" class="rb-back-button__link">
                        <span class="rb-back-button__icon">←</span>
                        <span class="rb-back-button__text"><?php _e('Вернуться назад', 'rocketbusiness'); ?></span>
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?> 