<?php /* Template Name: categories */ ?>

<?php get_header() ?>

<div class="container">
  <div class="product-category">
    <div class="product-category-inner">
      <div class="product-category-title">
        <?php
          global $wp;
          // get current url with query string.
          $current_url =  home_url( $wp->request );

          if (strpos($current_url, 'man-watch')) {
            echo 'Man Watch';
          } else if (strpos($current_url, 'woman-watch')) {
            echo 'Woman Watch';
          }
        ?>
      </div>
      <div class="product-category-list">
        <div class="product-wrapper">
          <?php
            $args = array(
              'post_type'         => 'product',
              'posts_per_page'    => 5,
              'post_status'       => 'publish',
              'product_cat'       => 'man watch'
            );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
            <div class="product">
              <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" class="product__link">
                <div class="product-thumbnail">
                  <?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
                </div>
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
  </div>
</div>
