<?php get_header(); ?>

<div class="container">
  <div class="section-1">
    <div class="section-1-left">
      <div class="left__inner">
        <div class="main-text">
          <h1 class="section-1-text">We offer precious watches</h1>
        </div>

        <div class="section-1-subtext">
          A season of celebration beautifully honored with a selection of precious and remarkable pieces
        </div>

        <div class="section-1-button">
          <button class="section-1-cta">Discover More</button>
        </div>
      </div>
    </div>

    <div class="section-1-right">
      <div class="section-1-image-wrapper">
        <img src="<?php echo get_template_directory_uri() . "/assets/images/dw1.png"; ?>" class="section-1-image">
      </div>
      
    </div>
  </div>

  <div class="section-2">
    <div class="section-image-wrapper">
      <img src="<?php echo get_template_directory_uri() . "/assets/images/dw4.jpg"; ?>" class="section-image">
      <div class="section-background"></div>
    </div>
    <div class="section-tagline">
      <div class="section-title">
        cash on <br> delivery
      </div>
      <div class="line-divider"></div>
      <div class="section-subtitle">
        We support Cash On Delivery method. it will helps the buyer who don't have a bank account. you can pay for the item at the same time you receive it. all you need is just sellect COD Method at the payment information page, and we will send it to your address. just remember to prepared the money when our courier sent the item.
      </div>
    </div>
  </div>

  <div class="section-3">
    <div class="section-tagline section-3-tagline">
      <div class="section-title">
      Multiple Payment <br> Method
      </div>
      <div class="line-divider"></div>
      <div class="section-subtitle">
        We also have multiple payment method. it wil make buyers easier to paid the order. right now we support OVO, GOPAY, BANK BCA, BANK MANDIRI, and BANK BNI. others payment method is coming soon.
      </div>
    </div>
    <div class="section-image-wrapper">
      <img src="<?php echo get_template_directory_uri() . "/assets/images/dw7.png"; ?>" class="section-image section-3-image">
      <div class="section-background"></div>
    </div>
  </div>

  <div class="section-4">
    <div class="section-4-title">our newest watch</div>
    <div class="product-wrapper">
    <?php
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4
        );
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
        <div class="product">
          <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
            <?php 
              if (has_post_thumbnail( $loop->post->ID )) { 
            ?>
                <div class="product-thumbnail">
                  <?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
                </div>
            <?php } ?>
            <?php
              the_title( '<h3 class="product-title">', '</h3>' );
              echo '<div class="price">'. $product->get_price_html() .'</div>';
            ?>
          </a>
        </div>
    	<?php endwhile;
    	wp_reset_query();
    ?>
    </div>
  </div>
</div>
