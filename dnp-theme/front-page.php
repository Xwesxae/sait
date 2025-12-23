<?php get_header(); ?>

<!-- Герой -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Добро пожаловать в ДНП "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"</h1>
            <p class="hero-subtitle">
                <?php 
                echo (get_current_village() == 'zapovednoe') 
                    ? 'Экологически чистый поселок в сосновом бору' 
                    : 'Современный поселок с развитой инфраструктурой';
                ?>
            </p>
            <div class="hero-buttons">
                <a href="#about" class="btn">О поселке</a>
                <a href="#plots" class="btn btn-outline">Участки</a>
            </div>
        </div>
    </div>
</section>

<!-- О поселке -->
<section class="about-section" id="about">
    <div class="container">
        <h2 class="section-title">О поселке "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"</h2>
        
        <div class="about-content">
            <div class="about-text">
                <?php echo dnp_get_village_content('about'); ?>
            </div>
            
            <div class="about-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo (get_current_village() == 'zapovednoe') ? '15' : '12'; ?></div>
                    <div class="stat-label">гектаров</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo (get_current_village() == 'zapovednoe') ? '45' : '38'; ?></div>
                    <div class="stat-label">участков</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo (get_current_village() == 'zapovednoe') ? '2015' : '2018'; ?></div>
                    <div class="stat-label">год основания</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Новости поселка -->
<section class="news-section" id="news">
    <div class="container">
        <h2 class="section-title">Новости поселка</h2>
        
        <div class="news-content">
            <div class="news-item">
                <div class="news-icon">📢</div>
                <div class="news-text">
                    <?php echo dnp_get_village_content('news'); ?>
                </div>
            </div>
            
            <div class="access-info">
                <div class="access-icon">🔒</div>
                <div class="access-text">
                    <strong>Доступ ограничен:</strong> Эта информация доступна только жителям поселка 
                    "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Инфраструктура -->
<section class="infrastructure-section" id="infrastructure">
    <div class="container">
        <h2 class="section-title">Инфраструктура поселка</h2>
        
        <div class="infrastructure-content">
            <div class="infrastructure-text">
                <?php echo dnp_get_village_content('infrastructure'); ?>
            </div>
            
            <div class="infrastructure-images">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/infrastructure-1.jpg" 
                     alt="Инфраструктура">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nature-1.jpg" 
                     alt="Природа">
            </div>
        </div>
    </div>
</section>

<!-- Участки -->
<section class="plots-section" id="plots">
    <div class="container">
        <h2 class="section-title">Свободные участки</h2>
        
        <div class="plots-info">
            <div class="plots-text">
                <?php echo dnp_get_village_content('plots'); ?>
            </div>
            
            <div class="plots-grid">
                <div class="plot-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plot-1.jpg" 
                         alt="Участок" 
                         class="plot-image">
                    <div class="plot-content">
                        <h3 class="plot-title">
                            <?php echo (get_current_village() == 'zapovednoe') ? 'Участок №15' : 'Участок №7'; ?>
                        </h3>
                        <p class="plot-meta">
                            Площадь: <?php echo (get_current_village() == 'zapovednoe') ? '8 соток' : '9 соток'; ?>
                        </p>
                        <p class="plot-price">
                            <?php echo (get_current_village() == 'zapovednoe') ? '1 500 000 ₽' : '1 650 000 ₽'; ?>
                        </p>
                        <a href="#contacts" class="btn">Забронировать</a>
                    </div>
                </div>
                
                <div class="plot-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plot-2.jpg" 
                         alt="Участок" 
                         class="plot-image">
                    <div class="plot-content">
                        <h3 class="plot-title">
                            <?php echo (get_current_village() == 'zapovednoe') ? 'Участок №22' : 'Участок №12'; ?>
                        </h3>
                        <p class="plot-meta">
                            Площадь: <?php echo (get_current_village() == 'zapovednoe') ? '10 соток' : '7 соток'; ?>
                        </p>
                        <p class="plot-price">
                            <?php echo (get_current_village() == 'zapovednoe') ? '1 800 000 ₽' : '1 400 000 ₽'; ?>
                        </p>
                        <a href="#contacts" class="btn">Забронировать</a>
                    </div>
                </div>
                
                <div class="plot-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plot-1.jpg" 
                         alt="Участок" 
                         class="plot-image">
                    <div class="plot-content">
                        <h3 class="plot-title">
                            <?php echo (get_current_village() == 'zapovednoe') ? 'Участок №30' : 'Участок №25'; ?>
                        </h3>
                        <p class="plot-meta">
                            Площадь: <?php echo (get_current_village() == 'zapovednoe') ? '6 соток' : '11 соток'; ?>
                        </p>
                        <p class="plot-price">
                            <?php echo (get_current_village() == 'zapovednoe') ? '1 200 000 ₽' : '1 900 000 ₽'; ?>
                        </p>
                        <a href="#contacts" class="btn">Забронировать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Контакты -->
<section class="contacts-section" id="contacts">
    <div class="container">
        <h2 class="section-title">Контакты поселка</h2>
        
        <div class="contacts-content">
            <div class="contacts-info">
                <div class="contacts-text">
                    <?php echo dnp_get_village_content('contacts'); ?>
                </div>
                
                <div class="access-warning">
                    <div class="warning-icon"⚠️</div>
                    <div class="warning-text">
                        <strong>Только для жителей:</strong> Контактная информация доступна исключительно 
                        жителям поселка "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h3>Написать правлению</h3>
                <form>
                    <div class="form-group">
                        <input type="text" placeholder="Ваше имя" required>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Номер участка" required>
                    </div>
                    <div class="form-group">
                        <textarea placeholder="Текст обращения" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>