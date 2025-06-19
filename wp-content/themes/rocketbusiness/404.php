<?php
/**
 * Шаблон страницы 404
 *
 * @package RocketBusiness
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="rb-main">
    <div class="rb-container">
        <div class="rb-error-404">
            <header class="rb-error-404__header">
                <h1 class="rb-error-404__title"><?php _e('Ой! Страница не найдена.', 'rocketbusiness'); ?></h1>
            </header>

            <div class="rb-error-404__content">
                <p class="rb-error-404__description"><?php _e('Похоже, что ничего не найдено по этому адресу. Возможно, попробуйте одну из ссылок ниже или поиск.', 'rocketbusiness'); ?></p>

                <div class="rb-error-404__actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="rb-btn rb-btn--primary">
                        <?php _e('Вернуться на главную', 'rocketbusiness'); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/?s=')); ?>" class="rb-btn rb-btn--primary">
                        <?php _e('Поиск по сайту', 'rocketbusiness'); ?>
                    </a>
                </div>

                <div class="rb-error-404__widgets">
                    <div class="rb-error-404__widget rb-error-404__widget--posts">
                        <h2 class="rb-error-404__widget-title"><?php _e('Последние записи', 'rocketbusiness'); ?></h2>
                        <ul class="rb-error-404__widget-list">
                            <?php
                            $recent_posts = wp_get_recent_posts([
                                'posts_per_page' => 5,
                                'post_status'    => 'publish',
                            ]);
                            
                            if ($recent_posts) {
                                foreach ($recent_posts as $post) {
                                    echo '<li><a href="' . esc_url(get_permalink($post['ID'])) . '">' . esc_html($post['post_title']) . '</a></li>';
                                }
                            } else {
                                echo '<li>' . __('Записей не найдено', 'rocketbusiness') . '</li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="rb-error-404__widget rb-error-404__widget--categories">
                        <h2 class="rb-error-404__widget-title"><?php _e('Категории', 'rocketbusiness'); ?></h2>
                        <ul class="rb-error-404__widget-list">
                            <?php
                            wp_list_categories([
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                                'show_count' => 1,
                                'title_li'   => '',
                                'number'     => 10,
                            ]);
                            ?>
                        </ul>
                    </div>

                    <div class="rb-error-404__widget rb-error-404__widget--archives">
                        <h2 class="rb-error-404__widget-title"><?php _e('Архивы', 'rocketbusiness'); ?></h2>
                        <ul class="rb-error-404__widget-list">
                            <?php
                            wp_get_archives([
                                'type'  => 'monthly',
                                'limit' => 12,
                            ]);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?> 