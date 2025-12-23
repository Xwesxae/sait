jQuery(document).ready(function($) {
    console.log('DNP Theme loaded');
    
    // Анимация шапки при скролле
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });
    
    // Плавный скролл
    $('a[href^="#"]').on('click', function(e) {
        if ($(this).attr('href') !== '#') {
            e.preventDefault();
            const target = $(this).attr('href');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 80
                }, 500);
            }
        }
    });
    
    // Анимация элементов при скролле
    function animateOnScroll() {
        $('.fade-in-up, .fade-in-left, .fade-in-right').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animated');
            }
        });
    }
    
    // Запуск анимации
    animateOnScroll();
    $(window).scroll(animateOnScroll);
    
    // Простая форма
    $('.contact-form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        // Здесь будет AJAX отправка
        alert('Заявка отправлена! Мы свяжемся с вами в ближайшее время.');
        $(this).trigger('reset');
    });
    
    // Переключение поселков
    $('.village-switcher a').on('click', function(e) {
        e.preventDefault();
        
        // Убираем активный класс у всех
        $('.village-switcher a').removeClass('active');
        
        // Добавляем активный класс текущему
        $(this).addClass('active');
        
        // Показываем загрузку
        $('main').fadeOut(300, function() {
            // После загрузки контента
            setTimeout(function() {
                $('main').fadeIn(300);
            }, 300);
        });
    });
    
    // Галерея (простая версия)
    $('.gallery-item').on('click', function() {
        const imgSrc = $(this).find('img').attr('src');
        const imgAlt = $(this).find('img').attr('alt');
        
        // Создаем модальное окно
        const modal = $('<div class="gallery-modal"></div>');
        const modalContent = $('<div class="modal-content"></div>');
        const modalImg = $('<img src="' + imgSrc + '" alt="' + imgAlt + '">');
        
        modalContent.append(modalImg);
        modal.append(modalContent);
        $('body').append(modal);
        
        // Закрытие по клику
        modal.on('click', function() {
            $(this).remove();
        });
    });
});