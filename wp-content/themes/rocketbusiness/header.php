<?php
/**
 * Заголовок темы
 *
 * @package RocketBusiness
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="rb-page">
    <a class="rb-skip-link rb-screen-reader-text" href="#main">
        <?php _e('Перейти к основному содержимому', 'rocketbusiness'); ?>
    </a>

    <header id="masthead" class="rb-header">
        <div class="rb-container">
            <div class="rb-header__content">
                <div class="rb-header__logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <p>Header Logo</p>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="rb-content">
        <div class="rb-container">
            <div class="rb-content__wrapper">
                <div class="rb-content__main"> 