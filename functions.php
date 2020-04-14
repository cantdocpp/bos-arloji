<?php

  function theme_script() {
    wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), microtime() );
    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array(), '.0.0', true );
    // wp_enqueue_style( "style", get_stylesheet_uri() , NULL , microtime() );
    wp_enqueue_style( "reset-style", get_template_directory_uri() . '/assets/css/reset.css' , NULL , microtime() );
    wp_enqueue_style( "navigation-style", get_template_directory_uri() . '/assets/css/navigation.css' , NULL , microtime() );
    wp_enqueue_style( "home-style", get_template_directory_uri() . '/assets/css/home.css' , NULL , microtime() );
    wp_enqueue_style( "footer-style", get_template_directory_uri() . '/assets/css/footer.css' , NULL , microtime() );
    wp_enqueue_style( "category-style", get_template_directory_uri() . '/assets/css/category.css' , NULL , microtime() );
    wp_enqueue_style( "single-style", get_template_directory_uri() . '/assets/css/single.css' , NULL , microtime() );
    wp_enqueue_style( "register-style", get_template_directory_uri() . '/assets/css/register.css' , NULL , microtime() );
    wp_enqueue_style( "form-style", get_template_directory_uri() . '/assets/css/form.css' , NULL , microtime() );
    wp_enqueue_style( "user-style", get_template_directory_uri() . '/assets/css/user.css' , NULL , microtime() );
    wp_enqueue_style( "cart-style", get_template_directory_uri() . '/assets/css/cart.css' , NULL , microtime() );
    wp_enqueue_style( "checkout-style", get_template_directory_uri() . '/assets/css/checkout.css' , NULL , microtime() );
    wp_enqueue_style( "payment-style", get_template_directory_uri() . '/assets/css/payment.css' , NULL , microtime() );
  }

  function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }

  function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
      'thumbnail_image_width' => 150,
      'single_image_width'    => 300,
  
          'product_grid'          => array(
              'default_rows'    => 3,
              'min_rows'        => 2,
              'max_rows'        => 8,
              'default_columns' => 4,
              'min_columns'     => 2,
              'max_columns'     => 5,
          ),
    ) );
  }
  add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

  // when adding product to the cart success and user refresh the page,
  // it still adding the qty to the cart everytime user refresh
  // this function stop it
  function resolve_dupes_add_to_cart_redirect($url = false) {
      // If another plugin beats us to the punch, let them have their way with the URL
      if(!empty($url)) { return $url; }

      // Redirect back to the original page, without the 'add-to-cart' parameter.
      // We add the `get_bloginfo` part so it saves a redirect on https:// sites.
      return get_bloginfo('url').add_query_arg(array(), remove_query_arg('add-to-cart'));
  }

  // https://gist.github.com/magnific0/29c32c7dabc89ab9cae5
  function mysite_custom_define() {
    $custom_meta_fields = array();
    $custom_meta_fields['phone'] = 'Phone';
    return $custom_meta_fields;
  }

  function mysite_columns($defaults) {
    $meta_number = 0;
    $custom_meta_fields = mysite_custom_define();
    foreach ($custom_meta_fields as $meta_field_name => $meta_disp_name) {
      $meta_number++;
      $defaults[('mysite-usercolumn-' . $meta_number . '')] = __($meta_disp_name, 'user-column');
    }
    return $defaults;
  }
  
  function mysite_custom_columns($value, $column_name, $id) {
    $meta_number = 0;
    $custom_meta_fields = mysite_custom_define();
    foreach ($custom_meta_fields as $meta_field_name => $meta_disp_name) {
      $meta_number++;
      if( $column_name == ('mysite-usercolumn-' . $meta_number . '') ) {
        return get_the_author_meta($meta_field_name, $id );
      }
    }
  }

  function mysite_show_extra_profile_fields($user) {
    print('<h3>Personal Meta Data</h3>');
  
    print('<table class="form-table">');
  
    $meta_number = 0;
    $custom_meta_fields = mysite_custom_define();
    foreach ($custom_meta_fields as $meta_field_name => $meta_disp_name) {
      $meta_number++;
      print('<tr>');
      print('<th><label for="' . $meta_field_name . '">' . $meta_disp_name . '</label></th>');
      print('<td>');
      print('<input type="text" name="' . $meta_field_name . '" id="' . $meta_field_name . '" value="' . esc_attr( get_the_author_meta($meta_field_name, $user->ID ) ) . '" class="regular-text" /><br />');
      print('<span class="description"></span>');
      print('</td>');
      print('</tr>');
    }
    print('</table>');
  }

  function mysite_save_extra_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id))
      return false;
  
    $meta_number = 0;
    $custom_meta_fields = mysite_custom_define();
    foreach ($custom_meta_fields as $meta_field_name => $meta_disp_name) {
      $meta_number++;
      update_usermeta( $user_id, $meta_field_name, $_POST[$meta_field_name] );
    }
  }

  function woocommmerce_style() {
    wp_enqueue_style('woocommerce_stylesheet', WP_PLUGIN_URL. '/woocommerce/assets/css/woocommerce.css',false,'1.0',"all");
  }
  add_action( 'wp_head', 'woocommmerce_style' );

  add_action('show_user_profile', 'mysite_show_extra_profile_fields');
  add_action('edit_user_profile', 'mysite_show_extra_profile_fields');
  add_action('personal_options_update', 'mysite_save_extra_profile_fields');
  add_action('edit_user_profile_update', 'mysite_save_extra_profile_fields');
  add_action('manage_users_custom_column', 'mysite_custom_columns', 15, 3);
  add_filter('manage_users_columns', 'mysite_columns', 15, 1);    

  add_image_size('small', 150, 150, true);
  add_action("wp_enqueue_scripts", "theme_script");
  add_action('get_header', 'my_filter_head');
  add_action('add_to_cart_redirect', 'resolve_dupes_add_to_cart_redirect');
