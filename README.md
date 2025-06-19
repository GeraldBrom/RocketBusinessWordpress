# 🚀 Rocket Business - WordPress Theme

**Тестовое задание для компании Rocket Business**

## 📋 Описание

Создана WordPress тема с кастомными типами записей и формой отправки писем.

## ✅ Выполнено

- **WordPress тема** `rocketbusiness`
- **Кастомные типы записей:**
  - `rb_articles` (Статьи) - с полями: автор, время чтения
  - `rb_services` (Акции) - с полями: цена, лейблы
- **Форма обратной связи** через WPForms
- **Адаптивный дизайн** для всех Мобильных устройств

## 🚀 Установка

1. Активируйте тему **Rocket Business** в админ-панели
2. Настройте **Постоянные ссылки** (Настройки → Постоянные ссылки)
3. Установите **WPForms Lite** для формы обратной связи
4. Создайте форму с ID `30` или измените в `index.php`

## 📁 Структура

```
wp-content/themes/rocketbusiness/
├── style.css                 # Стили темы
├── functions.php             # Функции и кастомные типы записей
├── index.php                 # Главная страница с формой
├── archive-rb_articles.php   # Архив статей
├── archive-rb_services.php   # Архив акций
├── single-rb_articles.php    # Отдельная статья
├── single-rb_services.php    # Отдельная акция
└── assets/js/slider.js       # Слайдер для акций
└── inc/image                 # Изображения для темы


## 📧 Форма обратной связи

Форма интегрирована в главную страницу через WPForms:
```php
<?php echo do_shortcode('[wpforms id="30" title="false"]'); ?>
```

## 🔧 Технологии

- WordPress 6.4+
- PHP 8.4
- WPForms для отправки писем
- Адаптивный CSS с Flexbox

---

**Автор:** Иван  
**Дата:** 2025.06.19
