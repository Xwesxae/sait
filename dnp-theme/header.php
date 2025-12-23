<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ДНП <?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?></title>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body>

<header class="site-header">
    <div class="container">
        <div class="header-content">
            <!-- Логотип -->
            <div class="logo-section">
                <a href="#home" class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" 
                         alt="Логотип ДНП" 
                         class="logo-img">
                </a>
                <div class="village-header">
                    <div class="village-name">
                        ДНП "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"
                    </div>
                    <div class="village-status">
                        <?php if (current_user_can('administrator')): ?>
                            <span class="admin-badge">👑 Администратор</span>
                        <?php else: ?>
                            <span class="resident-badge">👤 Житель поселка</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Информация о доступе -->
            <div class="access-info">
                <?php if (!current_user_can('administrator')): ?>
                <div class="access-badge">
                    <span class="badge-icon">🔒</span>
                    <span class="badge-text">
                        Доступ только к поселку "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"
                    </span>
                    <a href="?logout_village=1" class="logout-link">(выйти)</a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Переключатель для админа -->
            <?php if (current_user_can('administrator')): ?>
            <div class="village-switcher">
                <div class="switcher-label">Поселок:</div>
                <a href="?village=zapovednoe" 
                   class="switcher-btn <?php echo (get_current_village() == 'zapovednoe') ? 'active' : ''; ?>">
                    Заповедное
                </a>
                <a href="?village=kolosok" 
                   class="switcher-btn <?php echo (get_current_village() == 'kolosok') ? 'active' : ''; ?>">
                    Колосок
                </a>
                <a href="/wp-admin" class="admin-panel-btn">Админка</a>
            </div>
            <?php endif; ?>

            <!-- Меню -->
            <nav class="main-nav">
                <ul>
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#about">О поселке</a></li>
                    <li><a href="#news">Новости</a></li>
                    <li><a href="#infrastructure">Инфраструктура</a></li>
                    <li><a href="#plots">Участки</a></li>
                    <li><a href="#contacts">Контакты</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<main id="main">