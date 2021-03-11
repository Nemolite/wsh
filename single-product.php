<?php get_header(); ?>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<?php
global $product;
$product_meta = get_post_meta($product->id);
$productDiscount = $product_meta['o-discount'][0];


$posThreeDiscount = strripos($productDiscount, '";}}}');
$posTwoDiscount = strripos($productDiscount, '";}i:1;a:3');


$twoProductDiscount = substr($productDiscount, $posTwoDiscount - 2 , 2);
$threeProductDiscount = substr($productDiscount, $posThreeDiscount - 2 , 2);



$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average = $product->get_average_rating(); ?>




<div class="product">
	<?php echo do_shortcode("[cusrev_all_reviews]") ?>
	<div class="product__top-block">
		<div class="product__top-block-left">
			<div class="product__slider-wrap">
				<div class="product__sale-block product__sale-slider">-23%</div>
				<div class="product__slider swiper-container">
					<div class="swiper-wrapper">
						<?php $attachment_ids = $product->get_gallery_image_ids();

						foreach( $attachment_ids as $attachment_id ) {
							$image_link = wp_get_attachment_url( $attachment_id ); ?>
							<div class="swiper-slide">
								<div class="product__slider-item">
									<img class="product-img" src="<?php echo $image_link; ?>" alt="">
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
			<?php if (get_field('product_timer')): ?>
				<div class="product__sale-timer">
					<?php echo get_field('product_timer'); ?>
				</div>
			<?php endif ?>
		</div>

		<div class="product__content">
			<div class="product__name"><?php the_title(); ?></div>
			<div class="product__stock">Осталось: <?php echo $product->get_stock_quantity(); ?></div>
			<div class="product__star-rating">
				<?php echo wc_get_rating_html($average, $rating_count); ?>
				<div>
					Review amount: 
					<?php printf( _n( '%s',$review_count,'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>
				</div>
			</div>
			<div class="product__short-inform">
				<?php echo get_field('product_short_inform'); ?>
			</div>

			<div class="product__price__wrap">
				<div class="product__price">
					<div class="product__sale-block product__sale-price"></div>
					<div class="product__price-item product__price-without-sale">
						<div class="product__price-title">Stara cena</div>
						<div class="product__price-value">
							<span class="product__regular-price"></span> 
							<?php echo '&nbsp' . get_woocommerce_currency_symbol()?>
						</div>
					</div>
					<div class="product__price-item product__price-with-sale">
						<div class="product__price-title">Nowa cena</div>
						<div class="product__price-value">
							<span class="product__sale-price-value"></span>
							<?php echo '&nbsp' . get_woocommerce_currency_symbol()?>
						</div>
					</div>
				</div>
				<div class="free-shipping">+ free shipping</div>
			</div>


			<div class="product-quantity">
				<div class="product-quantity__item product-quantity-1">
					<span class="product-quantity__count">1</span>
					<span>x</span>
					<span class="product-quantity__price"></span>
					<span class="product-quantity__curency">
						<?php echo get_woocommerce_currency_symbol(); ?>
					</span>
				</div>
				<div class="product-quantity__item product-quantity-2">
					<span class="product-quantity__count">2</span>
					<span>x</span>
					<span class="product-quantity__price"></span>
					<span class="product-quantity__curency">
						<?php echo get_woocommerce_currency_symbol(); ?>
					</span>
				</div>
				<div class="product-quantity__item product-quantity-3">
					<span class="product-quantity__count">3</span>
					<span>x</span>
					<span class="product-quantity__price"></span>
					<span class="product-quantity__curency">
						<?php echo get_woocommerce_currency_symbol(); ?>
					</span>
				</div>
			</div>

			<?php 
			echo do_shortcode('[add_to_cart id="'.$post->ID.'"]');
			?> 
			<div class="product__user-in-site">Quantity user in this page: <span class="user-count"></span></div>
		</div>

	</div>
	<div class="features">
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
	</div>


	<?php if (get_field('product_video')): ?>
		<div class="video">
			<div class="video__title"><?php echo get_field('product_video_title') ?></div>
			<div class="video__container">
				<iframe class="video__block" src="<?php echo get_field('product_video') ?>" frameborder="0"></iframe>
			</div>
		</div>
	<?php endif ?>

	<div class="description">
		<div class="description__title"><?php the_title(); ?></div>
		<div class="description__content">
			<?php echo $product->description; ?>
		</div>
	</div>

	<div class="order-step">
		<div class="order-step__item">
			<div class="order-step__icon">
				<i class="fab fa-app-store-ios"></i>
			</div>
			<div class="order-step__title">2. Dostawa i płatność</div>
			<div class="order-step__text">Wybierz sposób dostawy</div>
		</div>
		<div class="order-step__item">
			<div class="order-step__icon">
				<i class="fab fa-app-store-ios"></i>
			</div>
			<div class="order-step__title">2. Dostawa i płatność</div>
			<div class="order-step__text">Wybierz sposób dostawy, metodę płatności(online lub płatność za pobraniem) i dane do wysyłki.</div>
		</div>
		<div class="order-step__item">
			<div class="order-step__icon">
				<i class="fab fa-app-store-ios"></i>
			</div>
			<div class="order-step__title">2. Dostawa i płatność</div>
			<div class="order-step__text">Wybierz sposób dostawy, metodę płatności(online lub płatność za pobraniem) i dane do wysyłki.</div>
		</div>
		<div class="order-step__item">
			<div class="order-step__icon">
				<i class="fab fa-app-store-ios"></i>
			</div>
			<div class="order-step__title">2. Dostawa i płatność</div>
			<div class="order-step__text">Wybierz sposób dostawy, metodę płatności(online lub płatność za pobraniem) i dane do wysyłki.</div>
		</div>
	</div>

	<div class="instruction">
		<div class="instruction__item">
			<div class="instruction__item-title">Отгрузка<i class="fas fa-chevron-down"></i></div>
			<div class="instruction__content">
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
			</div>
		</div>
		<div class="instruction__item">
			<div class="instruction__item-title">Отгрузка<i class="fas fa-chevron-down"></i></div>
			<div class="instruction__content">
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
			</div>
		</div>
		<div class="instruction__item">
			<div class="instruction__item-title">Отгрузка<i class="fas fa-chevron-down"></i></div>
			<div class="instruction__content">
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
			</div>
		</div>
		<div class="instruction__item">
			<div class="instruction__item-title">Отгрузка<i class="fas fa-chevron-down"></i></div>
			<div class="instruction__content">
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
				<div class="instruction__elem"><span>Standardowa</span>(3-5 dni): 0,00 zł</div>
			</div>
		</div>
	</div>

	<style>
		.star-rating span:before, .quantity .plus, .quantity .minus, p.stars a:hover:after, p.stars a:after, .star-rating span:before, #payment .payment_methods li input[type=radio]:first-child:checked+label:before {
			color: yellow;
		}

		.comment-reply-link {
			display: none;
		}

		.review__wrap {
			margin-bottom: 80px;
			background-color: #F6F6F6;
			padding: 100px 20px;
		}

		.review__img img {
			width: 100px;
			height: 100px;
			border-radius: 50%;
			margin: 0 auto 30px;
		}

		.review__author {
			text-align: center;
			margin-bottom: 20;
			font-weight: bold;
			font-size: 20px;
		}

		.review__content {
			text-align: center;
		}

		.review__rating .star-rating {
			margin: 0 auto;
		}

		.star-rating {
			font-size: 1.5em;
		}

		.review {
			padding: 20px;
			background: #fff;
		}
	</style>


	<div class="review__wrap">
		<div class="review__slider swiper-container">
			<div class="swiper-wrapper">
				<?php
				$comments = get_comments( [
				'post_id' => $product->id, // правильно post_id, а не post_ID
			] );

				foreach( $comments as $comment ){
					$ratingValue = get_comment_meta( $comment->comment_ID, 'rating', true);
					?>
					<div class="swiper-slide">
						<div class="review">
							<div class="review__img">
								<img src="<?php echo $comment->comment_author_url ?>" alt="">
							</div>
							<div class="review__rating">
								<?php echo wc_get_rating_html($ratingValue); ?>
							</div>
							<div class="review__author"><?php echo $comment->comment_author ?></div>
							<div class="review__content"><?php echo $comment->comment_content ?></div>	
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
	</div>	

	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

	<script>
		var reviewSwiper = new Swiper('.review__slider', {
			slidesPerView: 1,
			loop: true,
			breakpoints: {
				576: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 3,	
				},
			},
			loopedSlides: 3,
			spaceBetween: 20,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
	</script>

	<div class="product__top-block">
		<div class="product__top-block-left">
			<div class="product__slider-wrap">
				<div class="product__sale-block product__sale-slider">-23%</div>
				<div class="product__slider swiper-container">
					<div class="swiper-wrapper">
						<?php $attachment_ids = $product->get_gallery_image_ids();

						foreach( $attachment_ids as $attachment_id ) {
							$image_link = wp_get_attachment_url( $attachment_id ); ?>
							<div class="swiper-slide">
								<div class="product__slider-item">
									<img class="product-img" src="<?php echo $image_link; ?>" alt="">
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
			<?php if (get_field('product_timer')): ?>
				<div class="product__sale-timer">
					<?php echo get_field('product_timer'); ?>
				</div>
			<?php endif ?>
		</div>

		<div class="product__content">
			<div class="product__name"><?php the_title(); ?></div>
			<div class="product__stock">Осталось: <?php echo $product->get_stock_quantity(); ?></div>
			<div class="product__star-rating">
				<?php echo wc_get_rating_html($average, $rating_count); ?>
				<div>
					Review amount: 
					<?php printf( _n( '%s',$review_count,'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>
				</div>
			</div>
			<div class="product__short-inform">
				<?php echo get_field('product_short_inform'); ?>
			</div>

			<div class="product__price__wrap">
				<div class="product__price">
					<div class="product__sale-block product__sale-price"></div>
					<div class="product__price-item product__price-without-sale">
						<div class="product__price-title">Stara cena</div>
						<div class="product__price-value">
							<span class="product__regular-price"></span> 
							<?php echo '&nbsp' . get_woocommerce_currency_symbol()?>
						</div>
					</div>
					<div class="product__price-item product__price-with-sale">
						<div class="product__price-title">Nowa cena</div>
						<div class="product__price-value">
							<span class="product__sale-price-value"></span>
							<?php echo '&nbsp' . get_woocommerce_currency_symbol()?>
						</div>
					</div>
				</div>
				<div class="free-shipping">+ free shipping</div>
			</div>

			<div class="product-quantity">
				<div class="product-quantity__item product-quantity-1">
					<span class="product-quantity__count">1</span>
					<span>x</span>
					<span class="product-quantity__price"></span>
					<span class="product-quantity__curency">
						<?php echo get_woocommerce_currency_symbol(); ?>
					</span>
				</div>
				<div class="product-quantity__item product-quantity-2">
					<span class="product-quantity__count">2</span>
					<span>x</span>
					<span class="product-quantity__price"></span>
					<span class="product-quantity__curency">
						<?php echo get_woocommerce_currency_symbol(); ?>
					</span>
				</div>
				<div class="product-quantity__item product-quantity-3">
					<span class="product-quantity__count">3</span>
					<span>x</span>
					<span class="product-quantity__price"></span>
					<span class="product-quantity__curency">
						<?php echo get_woocommerce_currency_symbol(); ?>
					</span>
				</div>
			</div>

			<?php 
			echo do_shortcode('[add_to_cart id="'.$post->ID.'"]');
			?> 
			<div class="product__user-in-site">Quantity user in this page: <span class="user-count"></span></div>
		</div>

	</div>





	<div class="features">
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
		<div class="features__item">
			<i class="fab fa-amazon"></i>
			<div class="features__item-text">100% bezpieczny zakup</div>
		</div>
	</div>
</div>


<style> 
	.free-shipping {
		text-align: right;
		font-weight: bold;
		padding-right: 5px;
	}

	.product__star-rating {
		display: flex;
	}

	.product-quantity {
		display: flex;
		margin-top: 50px;
	}

	.product-quantity__item {
		cursor: pointer;
		border: 1px solid #CCCCCC;
		border-radius: 3.93px;
		height: 100%;
		padding: 10px 5px 8px;
		text-align: center;
		height: 51px;
		display: flex;
		justify-content: center;
		align-items: center;
		margin-right: 20px;
	}

	.product-quantity__item span {
		display: inline-block;
		padding: 0 2px;
	}

	.active-product-count {
		border: 3px solid #F3C352;
		background: rgba(245,136,12,0.1);
	}

	.instruction {
		display: flex;
		flex-wrap: wrap;
		margin-bottom: 80px;
	}

	.instruction__item {
		flex: 1 1 calc(50% - 40px);
		margin: 0 20px 40px;
	}

	.instruction__content {
		display: none;
	}

	.show-instruction {
		display: block;
	}

	.instruction__item-title {
		background: #eee;
		border-radius: 3px;
		font-weight: 400;
		font-size: 18px;
		color: #222;
		letter-spacing: 0;
		padding: 9px 17px 11px 15px;
		position: relative;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 0;
	}


	.order-step {
		display: flex;
		margin: 0 0 100px;
	}

	.order-step__item {
		margin: 0 20px;
		flex: 1 1 25%;
		background: #FFFFFF;
		box-shadow: 0 2px 8px 0 rgb(0 0 0 / 20%);
		border-radius: 4.65px;
		padding: 18px 18px 24px;
	}

	.order-step__icon {
		background: #E58C27;
		width: 75px;
		height: 75px;
		border-radius: 50%;
		display: flex;
		justify-content: center;
		align-items: center;
		margin-bottom: 23px;
	}

	.order-step__text {
		font-weight: 400;
		font-size: 18px;
		color: #666;
		line-height: 27.89px;
	}

	.order-step__title {
		font-weight: 600;
		font-size: 20px;
		color: #222222;
		margin-bottom: 6px;
		width: 100%;
	}

	@media(max-width: 992px) {
		.order-step {
			flex-wrap: wrap;
		}

		.order-step__item {
			flex: 1 1 calc(50% - 40px);
			margin-bottom: 30px;
		}
	}

	.order-step__icon i {
		font-size: 30px;
		color: #fff;
	}

	.description {
		padding: 80px 0;
	}

	.description__title {
		font-weight: bold;
		font-size: 24px;
		color: #222;
		letter-spacing: 0.5px;
		text-align: center;
		margin-bottom: 25px;
	}

	.video {
		background: #1B2632;
		padding: 50px 0 60px;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.video__title {
		font-weight: bold;
		font-size: 30px;
		letter-spacing: 1px;
		text-align: center;
		margin: 0 auto 56px;
		color: #fff;
	}

	.video__block {
		width: 100%;
		height: 100%;
	}

	.video__container {
		width: 700px;
		height: 400px;
	}

	@media(max-width: 768px) {
		.video__container {
			width: 100%;
			height: 300px;
		}
	}

	.features {
		margin: 50px 0;
		display: flex;
		justify-content: space-between;
	}

	.features__item {
		display: flex;
		align-items: center;
	}

	.features__item i {
		color: #F3C352;
		font-size: 50px;
		display: inline-block;
		margin-right: 15px;
	}

	.features__item-text {
		max-width: 140px;
	}

	@media(max-width: 992px) {
		.features {
			flex-wrap: wrap;
		}

		.features__item {
			flex: 0 0 50%;
			margin-bottom: 30px;
		}

	}

	@media(max-width: 576px) {
		.features__item {
			flex: 0 0 100%;
		}
	}

	.product__sale-price {
		position: absolute;
		right: 0;
		top: -25px;
		height: 50px;
		width: 50px;
		border-radius: 50%;
		display: flex;
		text-align: center;
		justify-content: center;
		background: #000;
		color: #fff;
		font-size: 18px;
		line-height: 50px;
	}

	.product__slider-wrap {
		margin-bottom: 40px;
	}

	.add_to_cart_inline {
		margin-top: 30px;
		margin-bottom: 60px;
		border: none !important;
		padding: 0 !important;
	}

	.add_to_cart_inline del, .add_to_cart_inline ins {
		display: none;
	}

	.product__quantity-sale img {
		width: 100%;
		height: 100px;
		object-fit: contain;
	}

	.product__price-without-sale {
		background: transparent;
	}

	.product__price-with-sale {
		background: #1B2632;
	}

	.product__price-without-sale .product__price-title {
		color: #222;
	}

	.product__price-with-sale .product__price-title {
		color: #fff;
	}

	.product__price-without-sale .product__price-value {
		color: #222222;
	}

	.product__price-without-sale .product__price-value:before {
		width: 100%;
		height: 4px;
		background: #222222;
		content: '';
		position: absolute;
		left: 0;
		top: calc(50% - 1px);
		display: inline-block;
	}

	.product__price-with-sale .product__price-value {
		color: #F3C352;
		font-weight: bold;
	}

	.product__price-value {
		position: relative;
		font-size: 39px;
		letter-spacing: 0;
		text-align: center;
		line-height: 34.1px;
	}

	.product__price-title {
		font-weight: 400;
		font-size: 18px;
		letter-spacing: 0;
		text-align: center;
		line-height: 18px;
		width: 100%;
		display: block;
		margin-bottom: 6px;
	}

	.product__price {
		position: relative;
		margin-top: 80px;
		display: flex;
		border-radius: 5px;
		border: 1px solid #ccc;
	}

	.product__price-item {
		flex: 1 1 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 95px;
		flex-direction: column;
	}

	.su-service {
		margin-bottom: 15px !important;
	}

	.su-service-title {
		position: relative;
		font-size: 18px;
		color: #222;
		letter-spacing: 0;
		line-height: 24px;
		padding-left: 30px;
		margin-bottom: 0 !important;
		font-weight: 400 !important;
	}

	.product__name {
		color: #000;
		line-height: 1.5;
		font-size: 40px;
		margin-bottom: 10px;
	}

	.product__stock {
		display: inline-block;
		background: #009F3E;
		padding: 4px 10px 5px;
		border-radius: 16px;
		font-weight: bold;
		font-size: 14px;
		color: #fff;
		letter-spacing: 0;
		text-align: center;
		margin-bottom: 19px;
		margin-bottom: 16px;
	}

	.product__star-rating img {
		max-width: 400px;
		height: 50px;
		object-fit: cover;
	}

	.product__top-block {
		display: flex;
		justify-content: space-between;
	}

	.product-slider {
		margin-right: auto;
		margin-left: 0;
	}

	.product__slider-wrap {
		position: relative;
	}

	.product__content {
		flex: 1 1 100%;
	}

	.product__sale-slider {
		position: absolute;
		left: 0;
		top: 0;
		height: 70px;
		width: 70px;
		background: #000;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 100;
		color: #fff;
		font-size: 20px;
		font-weight: 700;
	}

	.product__slider {
		width: 500px;
		height: 350px;
	}

	.product__slider-item {
		width: 500px;
		height: 350px;
	}

	.product-img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	@media(max-width: 1200px) {
		.product__slider {
			width: 400px;
			height: 300px;
		}

		.product__slider-item {
			width: 400px;
			height: 300px;
		}
	}

	@media(max-width: 992px) {
		.product__slider {
			width: 300px;
			height: 200px;
		}

		.product__slider-item {
			width: 300px;
			height: 200px;
		}
	}

	@media(max-width: 768px) {
		.product__top-block {
			flex-direction: column;
		}
	}
</style>

<!-- Initialize Swiper -->
<script>
	let addCartQuantity1 = {
		addCartBtn: document.querySelector('.add_to_cart_button'),
		oneProduct: document.querySelector('.product-quantity-1'),
		twoProduct: document.querySelector('.product-quantity-2'),
		threeProduct: document.querySelector('.product-quantity-3'),
		regularPriceBlock: document.querySelector('.product__regular-price'),
		salePriceBlock: document.querySelector('.product__sale-price-value'),

		start: function () {
			this.generetaPriceBlock(1)
			let that = this
			this.oneProduct.addEventListener('click', (e) => {
				that.changeProductOrderCount(1)
				that.activateClickElement(1)
				that.generetaPriceBlock(1)
				addCartQuantity2.changeProductOrderCount(1)
				addCartQuantity2.generetaPriceBlock(1)
				addCartQuantity2.activateClickElement(1)
			})
			this.twoProduct.addEventListener('click', (e) => {
				that.changeProductOrderCount(2)
				that.activateClickElement(2)
				that.generetaPriceBlock(2)
				addCartQuantity2.changeProductOrderCount(2)
				addCartQuantity2.generetaPriceBlock(2)
				addCartQuantity2.activateClickElement(2)
			})
			this.threeProduct.addEventListener('click', (e) => {
				that.changeProductOrderCount(3)
				that.activateClickElement(3)
				that.generetaPriceBlock(3)
				addCartQuantity2.changeProductOrderCount(3)
				addCartQuantity2.generetaPriceBlock(3)
				addCartQuantity2.activateClickElement(3)
			})
		},

		getPriceOptionBlock: function () {
			return ({
				oneProductPrice: this.oneProduct.querySelector('.product-quantity__price'),
				twoProductPrice: this.twoProduct.querySelector('.product-quantity__price'),
				threeProductPrice: this.threeProduct.querySelector('.product-quantity__price'),
			})
		},

		generetaCountOptionPrice: function () {
			let productPrice = (<?php echo $product->sale_price; ?>)
			let twoProductSale = (100 - (<?php echo $twoProductDiscount; ?>)) / 100
			let threeProductSale = (100 - (<?php echo $threeProductDiscount; ?>)) / 100
			this.getPriceOptionBlock().oneProductPrice.innerHTML = parseFloat(productPrice).toFixed(2)
			this.getPriceOptionBlock().twoProductPrice.innerHTML = parseFloat(productPrice * twoProductSale ).toFixed(2)
			this.getPriceOptionBlock().threeProductPrice.innerHTML = parseFloat(productPrice * threeProductSale ).toFixed(2)
		},

		generetaPriceBlock: function (count) {
			this.generetaCountOptionPrice()
			let regularPrice = (<?php echo $product->regular_price ?>)
			let productPrice = (<?php echo $product->sale_price; ?>)
			if (count == 1) {
				this.regularPriceBlock.innerHTML = parseFloat(regularPrice).toFixed(2)
				this.salePriceBlock.innerHTML = parseFloat(this.getPriceOptionBlock().oneProductPrice.innerHTML * 1).toFixed(2)
			}
			if (count == 2) {
				this.regularPriceBlock.innerHTML = parseFloat(regularPrice * 2 ).toFixed(2)
				console.log()
				this.salePriceBlock.innerHTML = parseFloat(this.getPriceOptionBlock().twoProductPrice.innerHTML * 2).toFixed(2)
			}
			if (count == 3) {
				this.regularPriceBlock.innerHTML = parseFloat(regularPrice * 3).toFixed(2)
				console.log()
				this.salePriceBlock.innerHTML = parseFloat(this.getPriceOptionBlock().threeProductPrice.innerHTML * 3).toFixed(2)
			}
		},

		activateClickElement: function (count) {
			if (count == 1) {
				this.oneProduct.classList.add('active-product-count')
			}
			if (count == 2) {
				this.twoProduct.classList.add('active-product-count')
			}
			if (count == 3) {
				this.threeProduct.classList.add('active-product-count')
			}
			if (count != 1) {
				this.oneProduct.classList.remove('active-product-count')
			}
			if (count != 2) {
				this.twoProduct.classList.remove('active-product-count')
			}
			if (count != 3) {
				this.threeProduct.classList.remove('active-product-count')
			}
		},

		changeProductOrderCount: function (count) {
			this.addCartBtn.dataset.quantity = count
		}
	}

	addCartQuantity1.start()



	let addCartQuantity2 = {
		addCartBtn: document.querySelectorAll('.add_to_cart_button')[1],
		oneProduct: document.querySelectorAll('.product-quantity-1')[1],
		twoProduct: document.querySelectorAll('.product-quantity-2')[1],
		threeProduct: document.querySelectorAll('.product-quantity-3')[1],
		regularPriceBlock: document.querySelectorAll('.product__regular-price')[1],
		salePriceBlock: document.querySelectorAll('.product__sale-price-value')[1],

		start: function () {
			this.generetaPriceBlock(1)
			let that = this
			this.oneProduct.addEventListener('click', (e) => {
				that.changeProductOrderCount(1)
				that.activateClickElement(1)
				that.generetaPriceBlock(1)
				addCartQuantity1.changeProductOrderCount(1)
				addCartQuantity1.generetaPriceBlock(1)
				addCartQuantity1.activateClickElement(1)
			})
			this.twoProduct.addEventListener('click', (e) => {
				that.changeProductOrderCount(2)
				that.activateClickElement(2)
				that.generetaPriceBlock(2)
				addCartQuantity1.changeProductOrderCount(2)
				addCartQuantity1.generetaPriceBlock(2)
				addCartQuantity1.activateClickElement(2)
			})
			this.threeProduct.addEventListener('click', (e) => {
				that.changeProductOrderCount(3)
				that.activateClickElement(3)
				that.generetaPriceBlock(3)
				addCartQuantity1.changeProductOrderCount(3)
				addCartQuantity1.generetaPriceBlock(3)
				addCartQuantity1.activateClickElement(3)
			})
		},

		getPriceOptionBlock: function () {
			return ({
				oneProductPrice: this.oneProduct.querySelector('.product-quantity__price'),
				twoProductPrice: this.twoProduct.querySelector('.product-quantity__price'),
				threeProductPrice: this.threeProduct.querySelector('.product-quantity__price'),
			})
		},

		generetaCountOptionPrice: function () {
			let productPrice = (<?php echo $product->sale_price; ?>)
			let twoProductSale = (100 - (<?php echo $twoProductDiscount; ?>)) / 100
			let threeProductSale = (100 - (<?php echo $threeProductDiscount; ?>)) / 100
			this.getPriceOptionBlock().oneProductPrice.innerHTML = parseFloat(productPrice).toFixed(2)
			this.getPriceOptionBlock().twoProductPrice.innerHTML = parseFloat(productPrice * twoProductSale ).toFixed(2)
			this.getPriceOptionBlock().threeProductPrice.innerHTML = parseFloat(productPrice * threeProductSale ).toFixed(2)
		},

		generetaPriceBlock: function (count) {
			this.generetaCountOptionPrice()
			let regularPrice = (<?php echo $product->regular_price ?>)
			let productPrice = (<?php echo $product->sale_price; ?>)
			if (count == 1) {
				this.regularPriceBlock.innerHTML = parseFloat(regularPrice).toFixed(2)
				this.salePriceBlock.innerHTML = parseFloat(this.getPriceOptionBlock().oneProductPrice.innerHTML * 1).toFixed(2)
			}
			if (count == 2) {
				this.regularPriceBlock.innerHTML = parseFloat(regularPrice * 2 ).toFixed(2)
				console.log()
				this.salePriceBlock.innerHTML = parseFloat(this.getPriceOptionBlock().twoProductPrice.innerHTML * 2).toFixed(2)
			}
			if (count == 3) {
				this.regularPriceBlock.innerHTML = parseFloat(regularPrice * 3).toFixed(2)
				console.log()
				this.salePriceBlock.innerHTML = parseFloat(this.getPriceOptionBlock().threeProductPrice.innerHTML * 3).toFixed(2)
			}
		},

		activateClickElement: function (count) {
			if (count == 1) {
				this.oneProduct.classList.add('active-product-count')
			}
			if (count == 2) {
				this.twoProduct.classList.add('active-product-count')
			}
			if (count == 3) {
				this.threeProduct.classList.add('active-product-count')
			}
			if (count != 1) {
				this.oneProduct.classList.remove('active-product-count')
			}
			if (count != 2) {
				this.twoProduct.classList.remove('active-product-count')
			}
			if (count != 3) {
				this.threeProduct.classList.remove('active-product-count')
			}
		},

		changeProductOrderCount: function (count) {
			this.addCartBtn.dataset.quantity = count
		}
	}

	addCartQuantity2.start()





	let instruction = {
		instructionArray: document.querySelectorAll('.instruction__item'),

		start: function () {
			if (this.instructionArray) {
				let that = this
				for (let i = 0; i < this.instructionArray.length; i++) {
					this.instructionArray[i].addEventListener('click', (e) => {
						that.showInstruction(e)
					})
				}
			}
		},

		showInstruction: function (elem) {
			let clickElem = elem.target
			if (clickElem.classList.contains('instruction__item-title') || clickElem.classList.contains('fa-chevron-down')) {
				let clickBlock = elem.currentTarget
				let instructionContent = clickBlock.querySelector('.instruction__content')
				instructionContent.classList.toggle('show-instruction')
			}
		}
	}

	instruction.start()

	let users = {
		usserCount: document.querySelectorAll('.user-count'),



		start: function () {
			let that = this
			setInterval(() => {that.generateNumber()}, 10000)
		},

		generateNumber: function () {
			let number = Math.random()
			let floatNumber = this.floatNumber(number) 
			let clearNumber = Math.ceil(20 * floatNumber)
			if (clearNumber < 5) {
				clearNumber = clearNumber + 5
			}
			for (var i = 0; i < this.usserCount.length; i++) {
				this.usserCount[i].innerHTML = clearNumber
			}

		},

		floatNumber: function (number) {
			return Number.parseFloat(number).toFixed(2);
		}
	}

	users.generateNumber()
	users.start()

	let sale = {
		saleBlock: document.querySelectorAll('.product__sale-block'),
		priceWithoutSale: <?php echo $product->regular_price ?>,
		priceWithSale: <?php echo $product->sale_price ?>,

		start: function () {
			let saleInProcent = Math.ceil(this.priceWithSale/(this.priceWithoutSale / 100))
			for (let i = 0; i < this.saleBlock.length; i++) {
				this.saleBlock[i].innerHTML = `-${saleInProcent}%`
			}
		}
	}

	sale.start()

	var swiper = new Swiper('.product__slider', {
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});

</script>

<?php get_footer(); ?>