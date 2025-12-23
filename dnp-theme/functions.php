<?php
/**
 * DNP Theme Functions
 */

// ========== СИСТЕМА ВЫБОРА И АВТОРИЗАЦИИ ПОСЕЛКА ==========
if (!session_id()) {
    session_start();
}

// Проверка выбора поселка
function dnp_check_village_selection() {
    // Администратор может всё
    if (current_user_can('administrator')) {
        return true;
    }
    
    // Если уже выбрал в сессии
    if (isset($_SESSION['user_village'])) {
        return true;
    }
    
    // Если выбрал через форму
    if (isset($_POST['select_village'])) {
        $village = sanitize_text_field($_POST['village']);
        if (in_array($village, ['zapovednoe', 'kolosok'])) {
            $_SESSION['user_village'] = $village;
            setcookie('user_village', $village, time() + (86400 * 30), "/"); // 30 дней
            return true;
        }
    }
    
    // Проверяем куки
    if (isset($_COOKIE['user_village'])) {
        $_SESSION['user_village'] = $_COOKIE['user_village'];
        return true;
    }
    
    // Показываем форму выбора
    if (!is_admin()) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Выберите поселок</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: Arial, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .selection-box {
                    background: white;
                    padding: 50px;
                    border-radius: 20px;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                    text-align: center;
                    max-width: 600px;
                    width: 100%;
                }
                h1 { margin-bottom: 30px; color: #333; font-size: 32px; }
                .village-options {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 30px;
                    margin-bottom: 40px;
                }
                .village-btn {
                    padding: 40px 20px;
                    border: 3px solid #e0e0e0;
                    border-radius: 15px;
                    background: white;
                    cursor: pointer;
                    transition: all 0.3s;
                    text-decoration: none;
                    color: inherit;
                    display: block;
                }
                .village-btn:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
                }
                .village-btn.selected {
                    border-color: #2E7D32;
                    background: #E8F5E9;
                }
                .kolosok-btn.selected {
                    border-color: #F57C00;
                    background: #FFF3E0;
                }
                .village-icon {
                    font-size: 60px;
                    margin-bottom: 20px;
                }
                .village-name {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                .village-desc {
                    color: #666;
                    font-size: 14px;
                    line-height: 1.5;
                }
                .warning-note {
                    margin-top: 30px;
                    padding: 15px;
                    background: #fff3cd;
                    border: 1px solid #ffeaa7;
                    border-radius: 10px;
                    color: #856404;
                    font-size: 14px;
                }
                .warning-note strong {
                    display: block;
                    margin-bottom: 5px;
                }
            </style>
        </head>
        <body>
            <div class="selection-box">
                <h1>Вход в информационную систему ДНП</h1>
                <p style="margin-bottom: 30px; color: #666;">Пожалуйста, выберите ваш поселок для доступа к информации</p>
                
                <div class="village-options">
                    <a href="?village=zapovednoe" class="village-btn" onclick="return confirm('Вы уверены, что проживаете в поселке Заповедное?')">
                        <div class="village-icon">🌲</div>
                        <div class="village-name">Заповедное</div>
                        <div class="village-desc">Только для жителей<br>поселка "Заповедное"</div>
                    </a>
                    
                    <a href="?village=kolosok" class="village-btn kolosok-btn" onclick="return confirm('Вы уверены, что проживаете в поселке Колосок?')">
                        <div class="village-icon">🌾</div>
                        <div class="village-name">Колосок</div>
                        <div class="village-desc">Только для жителей<br>поселка "Колосок"</div>
                    </a>
                </div>
                
                <div class="warning-note">
                    <strong>⚠️ Внимание!</strong>
                    <p>Каждый поселок имеет отдельную информационную систему. 
                    Доступ к информации другого поселка будет заблокирован.</p>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
    
    return false;
}
add_action('template_redirect', 'dnp_check_village_selection', 1);

// Установка поселка через GET параметр
function dnp_set_village_from_url() {
    if (isset($_GET['village']) && !current_user_can('administrator')) {
        $village = sanitize_text_field($_GET['village']);
        if (in_array($village, ['zapovednoe', 'kolosok'])) {
            $_SESSION['user_village'] = $village;
            setcookie('user_village', $village, time() + (86400 * 30), "/");
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('init', 'dnp_set_village_from_url');

// Получение текущего поселка
function get_current_village() {
    // Админ может переключаться
    if (current_user_can('administrator') && isset($_GET['village'])) {
        return sanitize_text_field($_GET['village']);
    }
    
    // Обычный пользователь - только свой
    if (isset($_SESSION['user_village'])) {
        return $_SESSION['user_village'];
    }
    
    return 'zapovednoe';
}

// Проверка доступа к контенту
function dnp_check_content_access() {
    // Админы могут всё
    if (current_user_can('administrator')) {
        return;
    }
    
    $current_village = get_current_village();
    $page_slug = get_post_field('post_name', get_post());
    
    // Разные контенты для разных поселков
    $village_pages = array(
        'zapovednoe' => array('o-poselke-zapovednoe', 'uchastki-zapovednoe', 'infrastruktura-zapovednoe', 'dokumenty-zapovednoe'),
        'kolosok' => array('o-poselke-kolosok', 'uchastki-kolosok', 'infrastruktura-kolosok', 'dokumenty-kolosok')
    );
    
    // Если страница принадлежит другому поселку
    if (in_array($page_slug, $village_pages['zapovednoe']) && $current_village != 'zapovednoe') {
        wp_die(
            '<div style="text-align:center; padding:100px 20px;">
                <h1 style="color:#dc3545;">🚫 Доступ запрещен</h1>
                <p style="font-size:18px; margin:20px 0;">Эта информация доступна только жителям поселка "Заповедное"</p>
                <p>Вы авторизованы как житель поселка "' . ($current_village == 'zapovednoe' ? 'Заповедное' : 'Колосок') . '"</p>
                <p style="margin-top:30px;">
                    <a href="?logout_village=1" style="background:#2E7D32; color:white; padding:12px 30px; text-decoration:none; border-radius:5px;">
                        Сменить поселок
                    </a>
                </p>
            </div>',
            'Доступ запрещен',
            403
        );
    }
    
    if (in_array($page_slug, $village_pages['kolosok']) && $current_village != 'kolosok') {
        wp_die(
            '<div style="text-align:center; padding:100px 20px;">
                <h1 style="color:#dc3545;">🚫 Доступ запрещен</h1>
                <p style="font-size:18px; margin:20px 0;">Эта информация доступна только жителям поселка "Колосок"</p>
                <p>Вы авторизованы как житель поселка "' . ($current_village == 'zapovednoe' ? 'Заповедное' : 'Колосок') . '"</p>
                <p style="margin-top:30px;">
                    <a href="?logout_village=1" style="background:#F57C00; color:white; padding:12px 30px; text-decoration:none; border-radius:5px;">
                        Сменить поселок
                    </a>
                </p>
            </div>',
            'Доступ запрещен',
            403
        );
    }
}
add_action('template_redirect', 'dnp_check_content_access');

// ========== РАЗНЫЙ КОНТЕНТ ДЛЯ РАЗНЫХ ПОСЕЛКОВ ==========
function dnp_get_village_content($section) {
    $current_village = get_current_village();
    
    $content = array(
        'zapovednoe' => array(
            'about' => 'Поселок "Заповедное" расположен в экологически чистом районе Подмосковья. Площадь поселка: 15 гектаров. Основан в 2015 году.',
            'infrastructure' => 'В поселке: охраняемая территория, асфальтированные дороги, центральное водоснабжение, электричество 15 кВт, детская площадка, зона BBQ.',
            'news' => '15.01.2024 - Общее собрание жителей 20 января в 18:00<br>10.01.2024 - Завершено строительство новой детской площадки',
            'plots' => 'Свободные участки: №15 (8 соток), №22 (10 соток), №30 (6 соток). Все участки с подключенными коммуникациями.',
            'contacts' => 'Председатель: Иванов И.И.<br>Телефон: +7 (999) 123-45-67<br>Email: zapovednoe@dnp.ru'
        ),
        'kolosok' => array(
            'about' => 'Поселок "Колосок" - современный дачный поселок с развитой инфраструктурой. Площадь: 12 гектаров. Основан в 2018 году.',
            'infrastructure' => 'Инфраструктура: видеонаблюдение, газоснабжение, скважина с очисткой воды, спортивная площадка, магазин, парковка для гостей.',
            'news' => '20.01.2024 - Планируется подключение оптоволокна<br>05.01.2024 - Установлены новые системы видеонаблюдения',
            'plots' => 'Доступные участки: №7 (9 соток), №12 (7 соток), №25 (11 соток). Участки с подведенным газом и электричеством.',
            'contacts' => 'Председатель: Петров П.П.<br>Телефон: +7 (999) 987-65-43<br>Email: kolosok@dnp.ru'
        )
    );
    
    return isset($content[$current_village][$section]) ? $content[$current_village][$section] : '';
}

// ========== ОСНОВНЫЕ НАСТРОЙКИ ==========
function dnp_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(['primary' => 'Главное меню']);
}
add_action('after_setup_theme', 'dnp_setup');

function dnp_styles() {
    wp_enqueue_style('dnp-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'dnp_styles');

// ========== ВЫХОД ИЗ ПОСЕЛКА ==========
function dnp_logout_village() {
    if (isset($_GET['logout_village'])) {
        unset($_SESSION['user_village']);
        setcookie('user_village', '', time() - 3600, "/");
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'dnp_logout_village');
<?php
/**
 * Шаблон для вывода участка
 */
$plot_area = get_post_meta(get_the_ID(), 'plot_area', true);
$plot_price = get_post_meta(get_the_ID(), 'plot_price', true);
$plot_number = get_post_meta(get_the_ID(), 'plot_number', true);
$plot_features = get_post_meta(get_the_ID(), 'plot_features', true);
?>

<article id="plot-<?php the_ID(); ?>" <?php post_class('plot-card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
    <div class="plot-image">
        <?php the_post_thumbnail('large'); ?>
    </div>
    <?php endif; ?>
    
    <div class="plot-content">
        <header class="plot-header">
            <h3 class="plot-title"><?php the_title(); ?></h3>
            <?php if ($plot_number) : ?>
            <div class="plot-number">Участок №<?php echo esc_html($plot_number); ?></div>
            <?php endif; ?>
        </header>
        
        <div class="plot-meta">
            <?php if ($plot_area) : ?>
            <div class="plot-area">
                <span class="meta-label">Площадь:</span>
                <span class="meta-value"><?php echo esc_html($plot_area); ?> соток</span>
            </div>
            <?php endif; ?>
            
            <?php if ($plot_price) : ?>
            <div class="plot-price">
                <span class="meta-label">Цена:</span>
                <span class="meta-value"><?php echo number_format($plot_price, 0, '', ' '); ?> ₽</span>
            </div>
            <?php endif; ?>
            
            <div class="plot-status">
                <span class="meta-label">Статус:</span>
                <span class="meta-value status-<?php echo get_plot_status_slug(); ?>">
                    <?php echo get_plot_status_name(); ?>
                </span>
            </div>
        </div>
        
        <?php if (has_excerpt()) : ?>
        <div class="plot-excerpt">
            <?php the_excerpt(); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($plot_features) : ?>
        <div class="plot-features">
            <h4>Особенности:</h4>
            <p><?php echo esc_html($plot_features); ?></p>
        </div>
        <?php endif; ?>
        
        <footer class="plot-footer">
            <a href="<?php the_permalink(); ?>" class="btn btn-secondary">Подробнее</a>
            <button class="btn btn-primary" data-plot-id="<?php the_ID(); ?>">Забронировать</button>
        </footer>
    </div>
</article>

<?php
// Вспомогательные функции
function get_plot_status_slug() {
    $terms = wp_get_post_terms(get_the_ID(), 'plot_status');
    if (!empty($terms)) {
        return $terms[0]->slug;
    }
    return 'available';
}

function get_plot_status_name() {
    $terms = wp_get_post_terms(get_the_ID(), 'plot_status');
    if (!empty($terms)) {
        return $terms[0]->name;
    }
    return 'Свободен';
}
?>