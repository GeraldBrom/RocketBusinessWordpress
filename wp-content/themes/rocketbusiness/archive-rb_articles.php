<?php
/**
 * Шаблон для отображения архивной страницы статей
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
                        if (is_tax('rb_article_category')) {
                            single_term_title(__('Категория: ', 'rocketbusiness'));
                        } else {
                            _e('Статьи', 'rocketbusiness');
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
                    <div class="rb-articles">
                        <div class="rb-articles__container">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('rb-article-item'); ?>>
                                    <a href="<?php the_permalink(); ?>" class="rb-article-item__link">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="rb-article-item__image-container">
                                                <?php the_post_thumbnail('medium', ['class' => 'rb-article-item__image']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="rb-article-item__content">
                                            <h2 class="rb-article-item__title"><?php the_title(); ?></h2>
                                            
                                            <?php if (has_excerpt()) : ?>
                                                <p class="rb-article-item__description"><?php the_excerpt(); ?></p>
                                            <?php endif; ?>
                                            
                                            <div class="rb-article-item__meta">
                                                <time class="rb-article-item__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </time>
                                                
                                                <?php 
                                                $read_time = rocketbusiness_get_article_read_time();
                                                if ($read_time) : ?>
                                                    <span class="rb-article-item__read-time">⏱️ <?php echo esc_html($read_time); ?></span>
                                                <?php endif; ?>
                                            </div>
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
                        <h2><?php _e('Статьи не найдены', 'rocketbusiness'); ?></h2>
                        <p><?php _e('К сожалению, статьи не найдены. Попробуйте поискать что-то другое.', 'rocketbusiness'); ?></p>
                        
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