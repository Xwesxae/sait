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