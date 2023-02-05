<?php ob_start(); ?>
<div class="htoptions-sidebar-adds-area">

    <div class="htoption-banner-area">
        <div class="htoption-banner-head">
            <div class="htoption-logo">
                <img src="<?php echo esc_url(HTMEGA_ADDONS_PL_URL.'admin/assets/images/logo.png'); ?>" alt="<?php echo esc_attr__( 'HTMega', 'htmega-addons' ); ?>">
            </div>
            <div class="htoption-intro">
                <p><?php echo wp_kses_post( 'HTMega is an absolute addon for elementor that includes 107+ elements & 782+ Blocks with unlimited variations. HT Mega brings limitless possibilities. Embellish your site with the elements of HT Mega.' ); ?></p>
            </div>
        </div>

        <ul class="htoption-feature">
            <li><?php echo esc_html__( '107+ Elementor Elements', 'htmega-addons' ); ?></li>
            <li><?php echo esc_html__( '782+ Elementor Blocks', 'htmega-addons' ); ?></li>
            <li><?php echo esc_html__( '39 Categories and 491 Page Templates.', 'htmega-addons' ); ?></li>
            <li><?php echo esc_html__( 'Drag n Drop, No coding Required', 'htmega-addons' ); ?></li>
            <li><?php echo esc_html__( 'Responsive, supports all major devices', 'htmega-addons' ); ?></li>
        </ul>

        <div class="htoption-action-btn">
            <a class="htoption-btn" href="<?php echo esc_url( 'https://wphtmega.com/pricing/' ); ?>" target="_blank">
                <span class="htoption-btn-text"><?php echo esc_html__( 'Get Pro Now', 'htmega-addons' ); ?></span>
                <span class="htoption-btn-icon"><img src="<?php echo esc_url(HTMEGA_ADDONS_PL_URL.'admin/assets/images/icon/plus.png'); ?>" alt="<?php echo esc_attr__( 'Get pro now', 'htmega-addons' ); ?>"></span>
            </a>
        </div>
    </div>

    <div class="htoption-rating-area">
        <div class="htoption-rating-icon">
            <img src="<?php echo esc_url(HTMEGA_ADDONS_PL_URL.'admin/assets/images/icon/rating.png'); ?>" alt="<?php echo esc_attr__( 'Rating icon', 'htmega-addons' ); ?>">
        </div>
        <div class="htoption-rating-intro">
            <?php echo esc_html__('If you’re loving how our product has helped your business, please let the WordPress community know by','htmega-addons'); ?> <a target="_blank" href="https://wordpress.org/support/plugin/ht-mega-for-elementor/reviews/?filter=5#new-post"><?php echo esc_html__( 'leaving us a review on our WP repository', 'htmega-addons' ); ?></a>. <?php echo esc_html__( 'Which will motivate us a lot.', 'htmega-addons' ); ?>
        </div>
    </div>

</div>
<?php echo apply_filters('htmega_sidebar_adds_banner', ob_get_clean() ); ?>