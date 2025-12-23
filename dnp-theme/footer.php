</main><!-- #main -->

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3 class="footer-title">ДНП "<?php echo (get_current_village() == 'zapovednoe') ? 'Заповедное' : 'Колосок'; ?>"</h3>
                <p>Ваш дачный поселок с современной инфраструктурой</p>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Быстрые ссылки</h3>
                <ul class="footer-links">
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#plots">Участки</a></li>
                    <li><a href="#infrastructure">Инфраструктура</a></li>
                    <li><a href="#contacts">Контакты</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Контакты</h3>
                <p>Телефон: <?php echo (get_current_village() == 'zapovednoe') ? '+7 (999) 123-45-67' : '+7 (999) 987-65-43'; ?></p>
                <p>Email: <?php echo (get_current_village() == 'zapovednoe') ? 'zapovednoe@dnp.ru' : 'kolosok@dnp.ru'; ?></p>
                <p>Адрес: Московская область</p>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> ДНП "Заповедное" и "Колосок"</p>
            <?php if (!current_user_can('administrator')): ?>
            <p><a href="?logout_village=1" class="change-village-link">Сменить поселок</a></p>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>