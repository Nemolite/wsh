<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'storefront_before_site' ); ?>

	<div id="page" class="hfeed site">
		<?php do_action( 'storefront_before_header' ); ?>
		<?php echo get_custom_logo(); ?>
		
		<?php if(is_product()): ?>
			<header class="site-header" id="masthead">
				<div class="col-full">		
					<div class="site-branding">
						<div class="beta site-title">
							<a href="http://localhost/wsh/" rel="home">Bloggers Unite</a>
						</div>
						<p class="site-description">Just another WordPress site</p>		
					</div>
					<?php echo get_search_form(); ?>
				</div>		
			</header>
			<div class="header-sidebar">
				<div class="header-sidebar__text">shipping <span class="header-sidebar__date"></span></div>
			</div>
			<style>
				.header-sidebar__text {
					background: #E58C27;
					font-weight: bold;
					font-style: italic;
					font-size: 16px;
					color: #fff;
					letter-spacing: 0;
					text-align: center;
					padding: 0px;
					line-height: 23px;
					margin-bottom: 40px;
				}

				.search-submit {
					display: none !important;;
				}
			</style>

			<?php else: ?>
				<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">

					<?php
		/**
		 * Functions hooked into storefront_header action
		 *
		 * @hooked storefront_header_container                 - 0
		 * @hooked storefront_skip_links                       - 5
		 * @hooked storefront_social_icons                     - 10
		 * @hooked storefront_site_branding                    - 20
		 * @hooked storefront_secondary_navigation             - 30
		 * @hooked storefront_product_search                   - 40
		 * @hooked storefront_header_container_close           - 41
		 * @hooked storefront_primary_navigation_wrapper       - 42
		 * @hooked storefront_primary_navigation               - 50
		 * @hooked storefront_header_cart                      - 60
		 * @hooked storefront_primary_navigation_wrapper_close - 68
		 */
		do_action( 'storefront_header' );
		?>

	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

<?php endif;?>

<script>
	let shippingDate = {
		dateBlock: document.querySelector('.header-sidebar__date'),

		generateDate: function () {
			let date = new Date();
			let year = date.getFullYear()
			let month = date.getMonth() + 1
			let day = date.getDate()
			let dayInMonth = new Date(year, month, 0).getDate()
			let dayDifferent = dayInMonth - day
			if (dayDifferent == 0 & month == 12) {
				year++
				month = 1 
				day = 2
			} else if (dayDifferent == 1 & month == 12) {
				year++
				month = 1 
				day = 1
			} else if (dayDifferent == 0) {
				month++
				day = 2
			} else if (dayDifferent == 1) {
				month++
				day = 1
			} else {
				day = day + 2
			}

			this.dateBlock.innerHTML = `${year}.${month}.${day}`
		}
	}

	shippingDate.generateDate()
</script>


<div id="content" class="site-content" tabindex="-1">
	<div class="col-full">

		<?php
		do_action( 'storefront_content_top' );
