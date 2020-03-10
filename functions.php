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
  }

  function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }

  add_image_size('small', 150, 150, true);
  add_action("wp_enqueue_scripts", "theme_script");
  add_action('get_header', 'my_filter_head');

