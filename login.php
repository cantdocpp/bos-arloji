<?php /* Template Name: login */ ?>

<?php 
    if (is_user_logged_in()) {
        // $current_user = wp_get_current_user();
        // printf( 'Personal Message For %s!', esc_html( $current_user->user_firstname ) );
        // $user_data = get_userdata(148);
        // echo $user_data->first_name;
        wp_safe_redirect( home_url() ); 
        exit();
    } else {
        $error = '';
?>

    <?php
        if (isset( $_POST[ 'submit' ] )) {
            $creds = array();
            $creds['user_login'] = $_POST[ 'email' ];
            $creds['user_password'] = $_POST[ 'password' ];

            $user = wp_signon( $creds, false );
            if (is_wp_error($user)) {
                echo 'email atau password salah';
            }
        }
    ?>

    <?php function html_form_code() { ?>
        <div class="login-page" style="padding: 100px 0px;">
            <form class="register-form form" method="POST" action="<?php $_SERVER['REQUEST_URI'] ?>">
                <div class="form-title">
                    login form
                </div>

                <?php 
                    if (isset( $_POST[ 'submit' ] )) {
                        $user = wp_authenticate($_POST[ 'email' ], $_POST[ 'password' ]);

                        if (is_wp_error($user)) {
                            echo '<div class="form-error">' . 'Email atau Password salah' . '</div>';
                        }
                    }
                ?>

                <div class="form-input-wrapper">
                    <input class="form-input" type="text" placeholder="email" name="email">
                </div>
                <div class="form-input-wrapper">
                    <input class="form-input" type="password" placeholder="password" name="password">
                </div>
                <div class="form-input-wrapper">
                    <input class="form-input form-submit" type="submit" name="submit" value="Login">    
                </div>

                <div class="form-footer">
                    don't have an account ? register <a href="<?php echo get_site_url() ?>/register/" class="form-link">here</a>
                </div>
                
            </form>
        </div>
    <?php } ?>


<?php } ?>

<?php
    get_header();
    html_form_code();
?>
