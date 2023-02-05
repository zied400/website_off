	<div class="navigator-wrapper">
		<!-- Mobile Toggle -->
	    <div class="theme-mobile-nav d-lg-none d-block <?php echo esc_attr(specia_sticky_menu()); ?>">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="theme-mobile-menu">
	                        <div class="headtop-mobi">
	                            <div class="headtop-shift">
	                                <a href="javascript:void(0);" class="header-sidebar-toggle open-toggle"><span></span></a>
	                                <a href="javascript:void(0);" class="header-sidebar-toggle close-button"><span></span></a>
	                                <div id="mob-h-top" class="mobi-head-top animated"></div>
	                            </div>
	                        </div>
	                        <div class="mobile-logo">
	                            <a href="<?php echo esc_url(home_url( '/' )); ?>" class="navbar-brand">
	                                <?php
	                                    if(has_custom_logo())
	                                    {   
	                                        the_custom_logo();
	                                    }
	                                    else { 
	                                        echo esc_html(get_bloginfo('name'));
	                                    }
	                                ?>
	                                <?php
	                                    $ideate_description = get_bloginfo( 'description');
	                                    if ($ideate_description) : ?>
	                                        <p class="site-description"><?php echo esc_html($ideate_description); ?></p>
	                                <?php endif; ?>
	                            </a>
	                        </div>
	                        <div class="menu-toggle-wrap">
	                            <div class="hamburger-menu">
	                                <a href="javascript:void(0);" class="menu-toggle">
	                                    <div class="top-bun"></div>
	                                    <div class="meat"></div>
	                                    <div class="bottom-bun"></div>
	                                </a>
	                            </div>
	                        </div>
	                        <div id="mobile-m" class="mobile-menu">
	                            <div class="mobile-menu-shift">
	                                <a href="javascript:void(0);" class="close-style close-menu"></a>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- / -->

	    <!-- Top Menu -->
	    <div class="xl-nav-area d-none d-lg-block">
	        <div class="navigation <?php echo esc_attr(specia_sticky_menu()); ?>">
	            <div class="container">
	                <div class="row">
	                	<div class="col-md-3">
		                    <div class="logo">
	                            <?php
		                        if(has_custom_logo()) {   
		                            the_custom_logo();
		                        }
		                        else { ?>
		                        	<a href="<?php echo esc_url(home_url( '/' )); ?>" class="navbar-brand">
		                        		<?php echo esc_html(get_bloginfo('name')); ?>
		                        	</a>
		                        <?php }
		                        $ideate_description = get_bloginfo( 'description');
		                        if ($ideate_description) : ?>
		                            <p class="site-description"><?php echo esc_html($ideate_description); ?></p>
		                        <?php endif; ?>
	                        </div>
		                </div>
	                    <div class="col-md-9">
	                        <div class="theme-menu">
	                            <nav class="menubar">
	                                <?php
	                                    wp_nav_menu( 
	                                        array(  
	                                            'theme_location' => 'primary_menu',
	                                            'container'  => '',
	                                            'menu_class' => 'menu-wrap',
	                                            'fallback_cb' => 'specia_fallback_page_menu::fallback',
	                                            'walker' => new specia_nav_walker()
	                                             ) 
	                                        );
	                                ?>                               
	                            </nav>
								<div class="menu-right">
									<ul class="wrap-right">
	                                    <li class="search-button">
	                                        <a href="#" id="view-search-btn" class="header-search-toggle"><i class="fa fa-search"></i></a>
	                                        <!-- Quik search -->
	                                        <div class="view-search-btn header-search-popup">
	                                            <form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site Search', 'ideate' ); ?>">
	                                                <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'ideate' ); ?></span>
	                                                <input type="search" class="search-field header-search-field" placeholder="<?php esc_attr_e( 'Type To Search', 'ideate' ); ?>" name="s" id="popfocus" value="" autofocus>
	                                                <a href="#" class="close-style header-search-close"></a>
	                                            </form>
	                                        </div>
	                                        <!-- / -->
	                                    </li>
										<?php 
										 $ideate_header_cart= get_theme_mod('header_cart','1');
										if($ideate_header_cart == '1'){ ?>
											<li class="cart-wrapper">
												<div class="cart-icon-wrap">
													<a href="javascript:void(0)" id="cart"><i class="fa fa-shopping-bag"></i>
													<?php 
													if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
														$count = WC()->cart->cart_contents_count;
														$cart_url = wc_get_cart_url();
														
														if ( $count > 0 ) {
														?>
															 <span><?php echo esc_html( $count ); ?></span>
														<?php 
														}
														else {
															?>
															<span><?php echo esc_html_e( '0','ideate' ); ?></span>
															<?php 
														}
													}
													?>
													</a>
												</div>
												
												<!-- Shopping Cart -->
												<?php if ( class_exists( 'WooCommerce' ) ) { ?>
												<div id="header-cart" class="shopping-cart">
													<div class="cart-body">                                            
														<?php get_template_part('woocommerce/cart/mini','cart');     ?>
													</div>
												</div>
												<?php } ?>
												<!--end shopping-cart -->
											</li>
										<?php } ?>
	                                    <?php
											$ideate_button_label	= get_theme_mod('button_label');
											$ideate_button_url		= get_theme_mod('button_url');
											$ideate_button_target	= get_theme_mod('button_target');         
											$ideate_header_cart		= get_theme_mod('header_cart','1');
											$ideate_header_book_hs	= get_theme_mod('header_book_hide_show','1');
	                                        if(($ideate_button_target)== 1){ 
	                                            $ideate_button_target= "target='_blank'"; 
	                                        }   
	                                        if($ideate_header_book_hs == '1'  && !empty($ideate_button_label)) { 
	                                    ?>                            
	                                    <li class="menu-item header_btn">
	                                        <a href="<?php echo esc_url($ideate_button_url); ?>" <?php echo esc_attr($ideate_button_target); ?> class="bt-primary bt-effect-3"><?php echo esc_html($ideate_button_label); ?></a>
	                                    </li>
	                                    <?php } ?>
	                                </ul>
								</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

</header>
<?php 
if ( !is_page_template( 'templates/template-homepage-one.php' )) {
		specia_breadcrumbs_style(); 
	}
?>