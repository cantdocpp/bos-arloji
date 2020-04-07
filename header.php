<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title(); ?></title>

    <?php wp_head(); ?>
  </head>
  <body>

  <nav class="main__navigation">
    <div class="web__navigation">
      <div class="web__navigation__inner">
        <div class="site__logo">
          BosArloji
        </div>

        <div class="site__menu-center">
          <div class="dropdown__menu menu main__menu">
            <a href="#" class="dropdown__text">Watches</a>
            <div class="dropdown__content">
              <a href="<?php echo get_site_url() ?>/man-watch/" class="dropdown__content-item">Man Watch</a>
              <a href="<?php echo get_site_url() ?>/woman-watch/" class="dropdown__content-item">Woman Watch</a>
            </div>
          </div>
          
          <div class="menu main__menu">
            <a href="#" class="site__menu">
              Accessories
            </a>
          </div>
          
          <div class="menu main__menu">
            <a href="#" class="site__menu">
              Payment Confirmation
            </a>
          </div>
          
        </div>

        <div class="site__menu-right">
          <div class="cart menu">
            <a href="<?php echo get_site_url() ?>/cart/" class="cart__menu">
              <div class="cart">
                <img class="cart__logo" src="<?php echo get_template_directory_uri() . "/assets/images/icons/cart.svg" ?>" alt="cart">
                <div class="cart__menu__qty">
                  <?php 
                    global $woocommerce;
                    $count = $woocommerce->cart->cart_contents_count;
                    if ($count > 0) {
                        echo $count;
                    } else {
                        echo '0';
                    }
                  ?>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="mobile__navigation"></div>
  </nav>
