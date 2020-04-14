<?php /* Template Name: categories */ ?>

<?php get_header() ?>
<?php 
  function custom_pagination() {
    global $wp_query;
    $big = 999999999;
    $pages = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?page=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_next' => false,
        'type' => 'array',
        'prev_next' => TRUE,
        'prev_text' => '&larr; Previous',
        'next_text' => 'Next &rarr;',
            ));
    if (is_array($pages)) {
        $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<ul class="pagination">';
        foreach ($pages as $i => $page) {
            if ($current_page == 1 && $i == 0) {
                echo "<li class='active'>$page</li>";
            } else {
                if ($current_page != 1 && $current_page == $i) {
                    echo "<li class='active'>$page</li>";
                } else {
                    echo "<li>$page</li>";
                }
            }
        }
        echo '</ul>';
    }
  } 
?>

<div class="container">
  <div class="product-category">
    <div class="product-category-inner">
      <div class="product-category-title">
        <?php
          global $wp;
          // get current url with query string.
          $current_url =  home_url( $wp->request );
          $current_cat;

          if (strpos($current_url, 'woman-watch') == true) {
            echo 'Woman Watch';
            $current_cat = 'woman watch';
          } else if (strpos($current_url, 'man-watch') == true) {
            echo 'Man Watch';
            $current_cat = 'man watch';
          } else if (strpos($current_url, 'accessories') == true) {
            echo 'Accessories';
            $current_cat = 'accessories';
          }
        ?>
      </div>
      <div class="product-category-list">
        <div class="product-wrapper">
          <?php
            global $paged;
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $args = array(
              'post_type'         => 'product',
              'posts_per_page'    => 15,
              'post_status'       => 'publish',
              'product_cat'       => $current_cat,
              'paged'             => $paged
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
      <nav class="product-category-nav">
        <ul class="product-category-ul">
          <li class="product-category-li"><?php previous_posts_link( '&laquo; PREV PAGE', $loop->max_num_pages) ?></li> 
          <li class="product-category-li"><?php next_posts_link( 'NEXT PAGE &raquo;', $loop->max_num_pages) ?></li>
        </ul>
      </nav>
    </div>
  </div>
</div>
