<?php
/**
 * Функции темы
 *
 * @package RocketBusiness
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Настройка темы
 */
function rocketbusiness_setup() {
    load_theme_textdomain('rocketbusiness', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    add_theme_support('custom-background', [
        'default-color' => 'ffffff',
        'default-image' => '',
    ]);

    add_theme_support('custom-header', [
        'default-image'      => '',
        'default-text-color' => '000000',
        'width'              => 1000,
        'height'             => 250,
        'flex-height'        => true,
    ]);

    register_nav_menus([
        'primary' => __('Главное меню', 'rocketbusiness'),
        'footer'  => __('Меню в подвале', 'rocketbusiness'),
    ]);

    add_theme_support('align-wide');

    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');

    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'rocketbusiness_setup');

/**
 * Регистрация областей виджетов
 */
function rocketbusiness_widgets_init() {
    register_sidebar([
        'name'          => __('Боковая панель', 'rocketbusiness'),
        'id'            => 'sidebar-1',
        'description'   => __('Добавьте виджеты сюда.', 'rocketbusiness'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    register_sidebar([
        'name'          => __('Подвал 1', 'rocketbusiness'),
        'id'            => 'footer-1',
        'description'   => __('Виджеты для первой колонки подвала.', 'rocketbusiness'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Подвал 2', 'rocketbusiness'),
        'id'            => 'footer-2',
        'description'   => __('Виджеты для второй колонки подвала.', 'rocketbusiness'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'rocketbusiness_widgets_init');

/**
 * Подключение стилей и скриптов
 */
function rocketbusiness_scripts() {
    wp_enqueue_style('rocketbusiness-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));

    wp_enqueue_style('rocketbusiness-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', [], null);

    wp_enqueue_script('rocketbusiness-navigation', get_template_directory_uri() . '/js/navigation.js', [], wp_get_theme()->get('Version'), true);
    
    wp_enqueue_script('rocketbusiness-slider', get_template_directory_uri() . '/assets/js/slider.js', [], wp_get_theme()->get('Version'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'rocketbusiness_scripts');

/**
 * Резервное меню
 */
function rocketbusiness_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Главная', 'rocketbusiness') . '</a></li>';
    
    $pages = get_pages();
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Кастомная длина отрывка
 */
function rocketbusiness_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'rocketbusiness_excerpt_length');

/**
 * Кастомное окончание отрывка
 */
function rocketbusiness_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'rocketbusiness_excerpt_more');

/**
 * Добавление классов к body
 */
function rocketbusiness_body_classes($classes) {
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    if (wp_is_mobile()) {
        $classes[] = 'mobile-device';
    }

    return $classes;
}
add_filter('body_class', 'rocketbusiness_body_classes');

/**
 * Кастомизация комментариев
 */
function rocketbusiness_comment($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    
    <div class="comment-author vcard">
        <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>
        <?php printf(__('<cite class="fn">%s</cite> <span class="says">говорит:</span>', 'rocketbusiness'), get_comment_author_link()); ?>
    </div>
    
    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Ваш комментарий ожидает модерации.', 'rocketbusiness'); ?></em>
        <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata">
        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
            <?php printf(__('%1$s в %2$s', 'rocketbusiness'), get_comment_date(), get_comment_time()); ?>
        </a>
        <?php edit_comment_link(__('(Редактировать)', 'rocketbusiness'), '  ', ''); ?>
    </div>

    <?php comment_text(); ?>

    <div class="reply">
        <?php comment_reply_link(array_merge($args, ['add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']])); ?>
    </div>
    
    <?php if ('div' != $args['style']) : ?>
        </div>
    <?php endif; ?>
    <?php
}

/**
 * Безопасность: отключение версии WordPress
 */
function rocketbusiness_remove_version() {
    return '';
}
add_filter('the_generator', 'rocketbusiness_remove_version');

/**
 * Добавление поддержки WooCommerce
 */
function rocketbusiness_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'rocketbusiness_woocommerce_support');

/**
 * Функция для получения URL изображения темы
 * 
 * @param string $image_path Путь к изображению относительно папки inc/images
 * @return string Полный URL к изображению
 */
function rocketbusiness_get_image_url($image_path) {
    return get_template_directory_uri() . '/inc/images/' . ltrim($image_path, '/');
}

/**
 * Функция для отображения изображения темы с проверкой существования
 * 
 * @param string $image_path Путь к изображению относительно папки inc/images
 * @param string $alt Альтернативный текст
 * @param string $class CSS классы
 * @param array $attributes Дополнительные атрибуты
 */
function rocketbusiness_display_image($image_path, $alt = '', $class = '', $attributes = []) {
    $image_url = rocketbusiness_get_image_url($image_path);
    $full_path = get_template_directory() . '/inc/images/' . ltrim($image_path, '/');
    
    if (!file_exists($full_path)) {
        error_log("Изображение не найдено: " . $full_path);
        return;
    }
    
    $attr_string = '';
    if (!empty($attributes)) {
        foreach ($attributes as $key => $value) {
            $attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }
    }
    
    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($class) . '"' . $attr_string . '>';
}

/**
 * Регистрация кастомных типов записей
 */
function rocketbusiness_register_post_types() {
    register_post_type('rb_articles', [
        'labels' => [
            'name'               => __('Статьи', 'rocketbusiness'),
            'singular_name'      => __('Статья', 'rocketbusiness'),
            'menu_name'          => __('Статьи', 'rocketbusiness'),
            'name_admin_bar'     => __('Статья', 'rocketbusiness'),
            'add_new'            => __('Добавить новую', 'rocketbusiness'),
            'add_new_item'       => __('Добавить новую статью', 'rocketbusiness'),
            'new_item'           => __('Новая статья', 'rocketbusiness'),
            'edit_item'          => __('Редактировать статью', 'rocketbusiness'),
            'view_item'          => __('Просмотреть статью', 'rocketbusiness'),
            'all_items'          => __('Все статьи', 'rocketbusiness'),
            'search_items'       => __('Искать статьи', 'rocketbusiness'),
            'parent_item_colon'  => __('Родительские статьи:', 'rocketbusiness'),
            'not_found'          => __('Статьи не найдены.', 'rocketbusiness'),
            'not_found_in_trash' => __('В корзине статьи не найдены.', 'rocketbusiness')
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'articles'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-post',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions'],
        'show_in_rest'        => true,
    ]);

    register_post_type('rb_services', [
        'labels' => [
            'name'               => __('Акции', 'rocketbusiness'),
            'singular_name'      => __('Акция', 'rocketbusiness'),
            'menu_name'          => __('Акции', 'rocketbusiness'),
            'name_admin_bar'     => __('Акция', 'rocketbusiness'),
            'add_new'            => __('Добавить новую', 'rocketbusiness'),
            'add_new_item'       => __('Добавить новую акцию', 'rocketbusiness'),
            'new_item'           => __('Новая акция', 'rocketbusiness'),
            'edit_item'          => __('Редактировать акцию', 'rocketbusiness'),
            'view_item'          => __('Просмотреть акцию', 'rocketbusiness'),
            'all_items'          => __('Все акции', 'rocketbusiness'),
            'search_items'       => __('Искать акции', 'rocketbusiness'),
            'parent_item_colon'  => __('Родительские акции:', 'rocketbusiness'),
            'not_found'          => __('Акции не найдены.', 'rocketbusiness'),
            'not_found_in_trash' => __('В корзине акции не найдены.', 'rocketbusiness')
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'services'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-megaphone',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions'],
        'show_in_rest'        => true,
    ]);
}
add_action('init', 'rocketbusiness_register_post_types');

/**
 * Регистрация таксономий для кастомных типов записей
 */
function rocketbusiness_register_taxonomies() {
    register_taxonomy('rb_article_category', 'rb_articles', [
        'labels' => [
            'name'              => __('Категории статей', 'rocketbusiness'),
            'singular_name'     => __('Категория статей', 'rocketbusiness'),
            'search_items'      => __('Искать категории', 'rocketbusiness'),
            'all_items'         => __('Все категории', 'rocketbusiness'),
            'parent_item'       => __('Родительская категория', 'rocketbusiness'),
            'parent_item_colon' => __('Родительская категория:', 'rocketbusiness'),
            'edit_item'         => __('Редактировать категорию', 'rocketbusiness'),
            'update_item'       => __('Обновить категорию', 'rocketbusiness'),
            'add_new_item'      => __('Добавить новую категорию', 'rocketbusiness'),
            'new_item_name'     => __('Название новой категории', 'rocketbusiness'),
            'menu_name'         => __('Категории', 'rocketbusiness'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'article-category'],
        'show_in_rest'      => true,
    ]);

    register_taxonomy('rb_service_category', 'rb_services', [
        'labels' => [
            'name'              => __('Категории акций', 'rocketbusiness'),
            'singular_name'     => __('Категория акций', 'rocketbusiness'),
            'search_items'      => __('Искать категории', 'rocketbusiness'),
            'all_items'         => __('Все категории', 'rocketbusiness'),
            'parent_item'       => __('Родительская категория', 'rocketbusiness'),
            'parent_item_colon' => __('Родительская категория:', 'rocketbusiness'),
            'edit_item'         => __('Редактировать категорию', 'rocketbusiness'),
            'update_item'       => __('Обновить категорию', 'rocketbusiness'),
            'add_new_item'      => __('Добавить новую категорию', 'rocketbusiness'),
            'new_item_name'     => __('Название новой категории', 'rocketbusiness'),
            'menu_name'         => __('Категории', 'rocketbusiness'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'service-category'],
        'show_in_rest'      => true,
    ]);

    register_taxonomy('rb_service_tags', 'rb_services', [
        'labels' => [
            'name'              => __('Теги акций', 'rocketbusiness'),
            'singular_name'     => __('Тег акции', 'rocketbusiness'),
            'search_items'      => __('Искать теги', 'rocketbusiness'),
            'all_items'         => __('Все теги', 'rocketbusiness'),
            'edit_item'         => __('Редактировать тег', 'rocketbusiness'),
            'update_item'       => __('Обновить тег', 'rocketbusiness'),
            'add_new_item'      => __('Добавить новый тег', 'rocketbusiness'),
            'new_item_name'     => __('Название нового тега', 'rocketbusiness'),
            'menu_name'         => __('Теги', 'rocketbusiness'),
        ],
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'service-tag'],
        'show_in_rest'      => true,
    ]);
}
add_action('init', 'rocketbusiness_register_taxonomies');

/**
 * Добавление кастомных полей для акций
 */
function rocketbusiness_add_service_meta_boxes() {
    add_meta_box(
        'rb_service_details',
        __('Детали акции', 'rocketbusiness'),
        'rocketbusiness_service_meta_box_callback',
        'rb_services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'rocketbusiness_add_service_meta_boxes');

/**
 * Callback функция для отображения кастомных полей акции
 */
function rocketbusiness_service_meta_box_callback($post) {
    wp_nonce_field('rocketbusiness_save_service_meta', 'rocketbusiness_service_meta_nonce');

    $price = get_post_meta($post->ID, '_rb_service_price', true);
    $labels = get_post_meta($post->ID, '_rb_service_labels', true);
    
    if (!is_array($labels)) {
        $labels = [];
    }
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="rb_service_price"><?php _e('Цена', 'rocketbusiness'); ?></label>
            </th>
            <td>
                <input type="text" id="rb_service_price" name="rb_service_price" value="<?php echo esc_attr($price); ?>" class="regular-text" />
                <p class="description"><?php _e('Введите цену акции (например: 1000 руб.)', 'rocketbusiness'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php _e('Лейблы', 'rocketbusiness'); ?></label>
            </th>
            <td>
                <div id="rb_service_labels_container">
                    <?php 
                    if (!empty($labels)) {
                        foreach ($labels as $index => $label) {
                            echo '<div class="rb_label_row">';
                            echo '<input type="text" name="rb_service_labels[]" value="' . esc_attr($label) . '" class="regular-text" />';
                            echo '<button type="button" class="button remove-label">' . __('Удалить', 'rocketbusiness') . '</button>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <button type="button" class="button add-label"><?php _e('Добавить лейбл', 'rocketbusiness'); ?></button>
                <p class="description"><?php _e('Добавьте лейблы для акции (например: "Новинка", "Хит продаж")', 'rocketbusiness'); ?></p>
            </td>
        </tr>
    </table>

    <script>
    jQuery(document).ready(function($) {
        $('.add-label').on('click', function() {
            var newRow = '<div class="rb_label_row">' +
                '<input type="text" name="rb_service_labels[]" value="" class="regular-text" />' +
                '<button type="button" class="button remove-label"><?php _e('Удалить', 'rocketbusiness'); ?></button>' +
                '</div>';
            $('#rb_service_labels_container').append(newRow);
        });

        $(document).on('click', '.remove-label', function() {
            $(this).closest('.rb_label_row').remove();
        });
    });
    </script>

    <style>
    .rb_label_row {
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .rb_label_row input {
        flex: 1;
    }
    </style>
    <?php
}

/**
 * Сохранение кастомных полей акции
 */
function rocketbusiness_save_service_meta($post_id) {
    if (!isset($_POST['rocketbusiness_service_meta_nonce']) || 
        !wp_verify_nonce($_POST['rocketbusiness_service_meta_nonce'], 'rocketbusiness_save_service_meta')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['rb_service_price'])) {
        update_post_meta($post_id, '_rb_service_price', sanitize_text_field($_POST['rb_service_price']));
    }

    if (isset($_POST['rb_service_labels']) && is_array($_POST['rb_service_labels'])) {
        $labels = array_map('sanitize_text_field', $_POST['rb_service_labels']);
        $labels = array_filter($labels);
        update_post_meta($post_id, '_rb_service_labels', $labels);
    } else {
        delete_post_meta($post_id, '_rb_service_labels');
    }
}
add_action('save_post', 'rocketbusiness_save_service_meta');

/**
 * Добавление кастомных полей для статей
 */
function rocketbusiness_add_article_meta_boxes() {
    add_meta_box(
        'rb_article_details',
        __('Детали статьи', 'rocketbusiness'),
        'rocketbusiness_article_meta_box_callback',
        'rb_articles',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'rocketbusiness_add_article_meta_boxes');

/**
 * Callback функция для отображения кастомных полей статьи
 */
function rocketbusiness_article_meta_box_callback($post) {
    wp_nonce_field('rocketbusiness_save_article_meta', 'rocketbusiness_article_meta_nonce');

    $read_time = get_post_meta($post->ID, '_rb_article_read_time', true);
    $author_name = get_post_meta($post->ID, '_rb_article_author_name', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="rb_article_read_time"><?php _e('Время чтения', 'rocketbusiness'); ?></label>
            </th>
            <td>
                <input type="text" id="rb_article_read_time" name="rb_article_read_time" value="<?php echo esc_attr($read_time); ?>" class="regular-text" />
                <p class="description"><?php _e('Время чтения статьи (например: 5 мин)', 'rocketbusiness'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="rb_article_author_name"><?php _e('Имя автора', 'rocketbusiness'); ?></label>
            </th>
            <td>
                <input type="text" id="rb_article_author_name" name="rb_article_author_name" value="<?php echo esc_attr($author_name); ?>" class="regular-text" />
                <p class="description"><?php _e('Имя автора статьи (если отличается от пользователя WordPress)', 'rocketbusiness'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Сохранение кастомных полей статьи
 */
function rocketbusiness_save_article_meta($post_id) {
    if (!isset($_POST['rocketbusiness_article_meta_nonce']) || 
        !wp_verify_nonce($_POST['rocketbusiness_article_meta_nonce'], 'rocketbusiness_save_article_meta')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['rb_article_read_time'])) {
        update_post_meta($post_id, '_rb_article_read_time', sanitize_text_field($_POST['rb_article_read_time']));
    }

    if (isset($_POST['rb_article_author_name'])) {
        update_post_meta($post_id, '_rb_article_author_name', sanitize_text_field($_POST['rb_article_author_name']));
    }
}
add_action('save_post', 'rocketbusiness_save_article_meta');

/**
 * Функции для получения данных
 */

/**
 * Получить цену акции
 */
function rocketbusiness_get_service_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_rb_service_price', true);
}

/**
 * Получить лейблы акции
 */
function rocketbusiness_get_service_labels($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $labels = get_post_meta($post_id, '_rb_service_labels', true);
    return is_array($labels) ? $labels : [];
}

/**
 * Получить время чтения статьи
 */
function rocketbusiness_get_article_read_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_rb_article_read_time', true);
}

/**
 * Получить имя автора статьи
 */
function rocketbusiness_get_article_author_name($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $author_name = get_post_meta($post_id, '_rb_article_author_name', true);
    return $author_name ? $author_name : get_the_author_meta('display_name', get_post_field('post_author', $post_id));
}

/**
 * Получить все статьи
 */
function rocketbusiness_get_articles($args = []) {
    $default_args = [
        'post_type' => 'rb_articles',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    
    $args = wp_parse_args($args, $default_args);
    return get_posts($args);
}

/**
 * Получить все акции
 */
function rocketbusiness_get_services($args = []) {
    $default_args = [
        'post_type' => 'rb_services',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    
    $args = wp_parse_args($args, $default_args);
    return get_posts($args);
}

/**
 * Пересоздание правил перезаписи при активации темы
 */
function rocketbusiness_rewrite_flush() {
    rocketbusiness_register_post_types();
    rocketbusiness_register_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'rocketbusiness_rewrite_flush');

/**
 * Принудительное обновление правил перезаписи
 * Выполните эту функцию один раз для исправления ошибок 404
 */
function rocketbusiness_force_rewrite_flush() {
    register_post_type('rb_articles', [
        'labels' => [
            'name'               => __('Статьи', 'rocketbusiness'),
            'singular_name'      => __('Статья', 'rocketbusiness'),
            'menu_name'          => __('Статьи', 'rocketbusiness'),
            'name_admin_bar'     => __('Статья', 'rocketbusiness'),
            'add_new'            => __('Добавить новую', 'rocketbusiness'),
            'add_new_item'       => __('Добавить новую статью', 'rocketbusiness'),
            'new_item'           => __('Новая статья', 'rocketbusiness'),
            'edit_item'          => __('Редактировать статью', 'rocketbusiness'),
            'view_item'          => __('Просмотреть статью', 'rocketbusiness'),
            'all_items'          => __('Все статьи', 'rocketbusiness'),
            'search_items'       => __('Искать статьи', 'rocketbusiness'),
            'parent_item_colon'  => __('Родительские статьи:', 'rocketbusiness'),
            'not_found'          => __('Статьи не найдены.', 'rocketbusiness'),
            'not_found_in_trash' => __('В корзине статьи не найдены.', 'rocketbusiness')
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'articles'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-post',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions'],
        'show_in_rest'        => true,
    ]);

    register_post_type('rb_services', [
        'labels' => [
            'name'               => __('Акции', 'rocketbusiness'),
            'singular_name'      => __('Акция', 'rocketbusiness'),
            'menu_name'          => __('Акции', 'rocketbusiness'),
            'name_admin_bar'     => __('Акция', 'rocketbusiness'),
            'add_new'            => __('Добавить новую', 'rocketbusiness'),
            'add_new_item'       => __('Добавить новую акцию', 'rocketbusiness'),
            'new_item'           => __('Новая акция', 'rocketbusiness'),
            'edit_item'          => __('Редактировать акцию', 'rocketbusiness'),
            'view_item'          => __('Просмотреть акцию', 'rocketbusiness'),
            'all_items'          => __('Все акции', 'rocketbusiness'),
            'search_items'       => __('Искать акции', 'rocketbusiness'),
            'parent_item_colon'  => __('Родительские акции:', 'rocketbusiness'),
            'not_found'          => __('Акции не найдены.', 'rocketbusiness'),
            'not_found_in_trash' => __('В корзине акции не найдены.', 'rocketbusiness')
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'services'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-megaphone',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions'],
        'show_in_rest'        => true,
    ]);

    register_taxonomy('rb_article_category', 'rb_articles', [
        'labels' => [
            'name'              => __('Категории статей', 'rocketbusiness'),
            'singular_name'     => __('Категория статей', 'rocketbusiness'),
            'search_items'      => __('Искать категории', 'rocketbusiness'),
            'all_items'         => __('Все категории', 'rocketbusiness'),
            'parent_item'       => __('Родительская категория', 'rocketbusiness'),
            'parent_item_colon' => __('Родительская категория:', 'rocketbusiness'),
            'edit_item'         => __('Редактировать категорию', 'rocketbusiness'),
            'update_item'       => __('Обновить категорию', 'rocketbusiness'),
            'add_new_item'      => __('Добавить новую категорию', 'rocketbusiness'),
            'new_item_name'     => __('Название новой категории', 'rocketbusiness'),
            'menu_name'         => __('Категории', 'rocketbusiness'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'article-category'],
        'show_in_rest'      => true,
    ]);

    register_taxonomy('rb_service_category', 'rb_services', [
        'labels' => [
            'name'              => __('Категории акций', 'rocketbusiness'),
            'singular_name'     => __('Категория акций', 'rocketbusiness'),
            'search_items'      => __('Искать категории', 'rocketbusiness'),
            'all_items'         => __('Все категории', 'rocketbusiness'),
            'parent_item'       => __('Родительская категория', 'rocketbusiness'),
            'parent_item_colon' => __('Родительская категория:', 'rocketbusiness'),
            'edit_item'         => __('Редактировать категорию', 'rocketbusiness'),
            'update_item'       => __('Обновить категорию', 'rocketbusiness'),
            'add_new_item'      => __('Добавить новую категорию', 'rocketbusiness'),
            'new_item_name'     => __('Название новой категории', 'rocketbusiness'),
            'menu_name'         => __('Категории', 'rocketbusiness'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'service-category'],
        'show_in_rest'      => true,
    ]);

    register_taxonomy('rb_service_tags', 'rb_services', [
        'labels' => [
            'name'              => __('Теги акций', 'rocketbusiness'),
            'singular_name'     => __('Тег акции', 'rocketbusiness'),
            'search_items'      => __('Искать теги', 'rocketbusiness'),
            'all_items'         => __('Все теги', 'rocketbusiness'),
            'edit_item'         => __('Редактировать тег', 'rocketbusiness'),
            'update_item'       => __('Обновить тег', 'rocketbusiness'),
            'add_new_item'      => __('Добавить новый тег', 'rocketbusiness'),
            'new_item_name'     => __('Название нового тега', 'rocketbusiness'),
            'menu_name'         => __('Теги', 'rocketbusiness'),
        ],
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'service-tag'],
        'show_in_rest'      => true,
    ]);

    flush_rewrite_rules();
    
    return true;
}

/**
 * Добавляем пункт меню для обновления правил перезаписи (только для администраторов)
 */
function rocketbusiness_add_rewrite_menu() {
    if (current_user_can('manage_options')) {
        add_management_page(
            'Обновить правила перезаписи',
            'Обновить правила',
            'manage_options',
            'rocketbusiness-rewrite',
            'rocketbusiness_rewrite_page'
        );
    }
}
add_action('admin_menu', 'rocketbusiness_add_rewrite_menu');

/**
 * Страница для обновления правил перезаписи
 */
function rocketbusiness_rewrite_page() {
    if (isset($_POST['update_rewrite_rules']) && wp_verify_nonce($_POST['_wpnonce'], 'update_rewrite_rules')) {
        rocketbusiness_force_rewrite_flush();
        echo '<div class="notice notice-success"><p><strong>Успешно!</strong> Правила перезаписи обновлены.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Обновить правила перезаписи</h1>
        <p>Эта страница поможет исправить ошибки 404 на страницах статей и акций.</p>
        
        <form method="post">
            <?php wp_nonce_field('update_rewrite_rules'); ?>
            <p class="submit">
                <input type="submit" name="update_rewrite_rules" class="button-primary" value="Обновить правила перезаписи">
            </p>
        </form>
        
        <h2>Что это делает?</h2>
        <ul>
            <li>Регистрирует кастомные типы записей "Статьи" и "Акции"</li>
            <li>Создает правила для URL: /articles/ и /services/</li>
            <li>Обновляет правила перезаписи WordPress</li>
            <li>Исправляет ошибки 404 на страницах статей и акций</li>
        </ul>
        
        <h2>После обновления</h2>
        <p>После успешного обновления правил:</p>
        <ol>
            <li>Перейдите в <strong>Настройки → Постоянные ссылки</strong></li>
            <li>Нажмите <strong>Сохранить изменения</strong></li>
            <li>Проверьте работу страниц статей и акций</li>
        </ol>
    </div>
    <?php
} 