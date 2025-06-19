<?php
/**
 * Тестовый файл для проверки кастомных типов записей
 * 
 * @package RocketBusiness
 */

// Загружаем WordPress
require_once('wp-config.php');

echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Тест кастомных типов записей - Rocket Business</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .post-item { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 4px; }
        .post-title { font-weight: bold; margin-bottom: 5px; }
        .post-meta { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Тест кастомных типов записей</h1>
        <p>Этот файл проверяет работу кастомных типов записей "Статьи" и "Акции".</p>';

// Проверяем, что функции темы загружены
if (!function_exists('rocketbusiness_get_articles')) {
    echo '<div class="error">❌ Функции темы не загружены. Убедитесь, что тема активирована.</div>';
    echo '</div></body></html>';
    exit;
}

// Проверяем статьи
echo '<h2>📰 Статьи</h2>';
$articles = rocketbusiness_get_articles(['posts_per_page' => 5]);

if ($articles) {
    echo '<div class="success">✅ Найдено статей: ' . count($articles) . '</div>';
    foreach ($articles as $article) {
        echo '<div class="post-item">';
        echo '<div class="post-title"><a href="' . get_permalink($article->ID) . '">' . esc_html($article->post_title) . '</a></div>';
        echo '<div class="post-meta">Дата: ' . get_the_date('', $article->ID) . ' | Автор: ' . get_the_author_meta('display_name', $article->post_author) . '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="info">ℹ️ Статей не найдено. Создайте несколько статей в админ панели.</div>';
}

// Проверяем акции
echo '<h2>🎯 Акции</h2>';
$services = rocketbusiness_get_services(['posts_per_page' => 5]);

if ($services) {
    echo '<div class="success">✅ Найдено акций: ' . count($services) . '</div>';
    foreach ($services as $service) {
        echo '<div class="post-item">';
        echo '<div class="post-title"><a href="' . get_permalink($service->ID) . '">' . esc_html($service->post_title) . '</a></div>';
        echo '<div class="post-meta">Дата: ' . get_the_date('', $service->ID) . ' | Автор: ' . get_the_author_meta('display_name', $service->post_author) . '</div>';
        $price = rocketbusiness_get_service_price($service->ID);
        if ($price) {
            echo '<div class="post-meta">Цена: ' . esc_html($price) . '</div>';
        }
        echo '</div>';
    }
} else {
    echo '<div class="info">ℹ️ Акций не найдено. Создайте несколько акций в админ панели.</div>';
}

// Проверяем URL
echo '<h2>🔗 Проверка URL</h2>';
echo '<div class="info">';
echo '<p><strong>Архивные страницы:</strong></p>';
echo '<ul>';
echo '<li><a href="' . home_url('/articles/') . '" target="_blank">' . home_url('/articles/') . '</a> - все статьи</li>';
echo '<li><a href="' . home_url('/services/') . '" target="_blank">' . home_url('/services/') . '</a> - все акции</li>';
echo '</ul>';

if ($articles) {
    echo '<p><strong>Примеры одиночных страниц:</strong></p>';
    echo '<ul>';
    echo '<li><a href="' . get_permalink($articles[0]->ID) . '" target="_blank">' . get_permalink($articles[0]->ID) . '</a></li>';
    echo '</ul>';
}

if ($services) {
    echo '<ul>';
    echo '<li><a href="' . get_permalink($services[0]->ID) . '" target="_blank">' . get_permalink($services[0]->ID) . '</a></li>';
    echo '</ul>';
}

echo '</div>';

// Проверяем правила перезаписи
echo '<h2>⚙️ Правила перезаписи</h2>';
$rewrite_rules = get_option('rewrite_rules');
$has_articles_rule = false;
$has_services_rule = false;

if ($rewrite_rules) {
    foreach ($rewrite_rules as $rule => $rewrite) {
        if (strpos($rule, 'articles') !== false) {
            $has_articles_rule = true;
        }
        if (strpos($rule, 'services') !== false) {
            $has_services_rule = true;
        }
    }
}

if ($has_articles_rule) {
    echo '<div class="success">✅ Правило для статей найдено</div>';
} else {
    echo '<div class="error">❌ Правило для статей не найдено</div>';
}

if ($has_services_rule) {
    echo '<div class="success">✅ Правило для акций найдено</div>';
} else {
    echo '<div class="error">❌ Правило для акций не найдено</div>';
}

if (!$has_articles_rule || !$has_services_rule) {
    echo '<div class="info">';
    echo '<p><strong>Для исправления:</strong></p>';
    echo '<ol>';
    echo '<li>Запустите файл <a href="' . home_url('/fix-404.php') . '">fix-404.php</a></li>';
    echo '<li>Перейдите в <strong>Настройки → Постоянные ссылки</strong></li>';
    echo '<li>Нажмите <strong>Сохранить изменения</strong></li>';
    echo '</ol>';
    echo '</div>';
}

echo '<h2>📝 Рекомендации</h2>';
echo '<div class="info">';
echo '<ul>';
echo '<li>Если URL не работают, запустите <a href="' . home_url('/fix-404.php') . '">fix-404.php</a></li>';
echo '<li>Создайте несколько тестовых статей и акций в админ панели</li>';
echo '<li>Проверьте права доступа к файлу .htaccess (если используете Apache)</li>';
echo '<li>Убедитесь, что mod_rewrite включен на сервере</li>';
echo '</ul>';
echo '</div>';

echo '</div></body></html>'; 