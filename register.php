<?php /* Template Name: register */ ?>

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

<?php function html_form_code() { ?>
    <div class="register-page" style="padding: 100px 0px">
        <form class="register-form form" method="POST" action="<?php $_SERVER['REQUEST_URI'] ?>">
            <div class="form-title">
                register form
            </div>

            <?php 
                if (isset($_POST['submit'])) {
                    my_validate_form();
                }
            ?>

            <div class="form-input-wrapper">
                <input class="form-input" type="text" placeholder="First Name" name="firstname">
            </div>
            <div class="form-input-wrapper">
                <input class="form-input" type="text" placeholder="Last Name" name="lastname">
            </div>
            <div class="form-input-wrapper">
                <input class="form-input" type="text" placeholder="email" name="email">
            </div>
            <div class="form-input-wrapper">
                <input class="form-input" type="text" placeholder="phone number" name="phone">
            </div>
            <div class="form-input-wrapper">
                <input class="form-input" type="password" placeholder="password" name="password">
            </div>
            <div class="form-input-wrapper">
                <input class="form-input form-submit" type="submit" name="submit" value="Register">    
            </div>

            <div class="form-footer">
                already have an account ? login <a href="<?php echo get_site_url() ?>/login/" class="form-link">here</a>
            </div>
            
        </form>
    </div>
<?php } ?> 



<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function my_validate_form() {
        $errors = new WP_Error();
        $email = test_input($_POST[ 'email' ]);
        
        if ( isset( $_POST[ 'phone' ] ) && $_POST[ 'phone' ] == '' ) {
            $errors->add('phone_error', 'Please fill in a valid phone number.' );
        } else if ( isset( $_POST[ 'email' ] ) && $_POST[ 'email' ] == '' ) {
            $errors->add('email_error', 'Please fill in a valid email.' );
        } else if ( isset( $_POST[ 'firstname' ] ) && $_POST[ 'firstname' ] == '' ) {
            $errors->add('firstname_error', 'Please fill in a valid firstname.' );
        }else if ( isset( $_POST[ 'lastname' ] ) && $_POST[ 'lastname' ] == '' ) {
            $errors->add('lastname_error', 'Please fill in a valid lastname.' );
        } else if ( isset( $_POST[ 'password' ] ) && $_POST[ 'password' ] == '' ) {
            $errors->add('password_error', 'Password cannot be empty.' );
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors->add('email_error', 'Invalid email format');
        } else if (email_exists($email)) {
            $errors->add('email_error', 'email already exists');
        } 
        
        if (is_wp_error($errors)) {
            echo '<div class="form-error">' . $errors->get_error_message() . '</div>';
        }

        return is_wp_error($errors);
    }

    if (isset($_POST['submit'])) {
        $userdata = array (
            'user_email'    =>  $_POST['email'],
            'user_pass'     =>  $_POST['password'],
            'user_login'    =>  $_POST['email'],
            'first_name'    =>  $_POST['firstname'],
            'last_name'     =>  $_POST['lastname']
        );
        $user_id = wp_insert_user( $userdata ) ;
        
        // Here you insert your user data with a 'customer' user role
        wp_update_user( array ('ID' => $user_id, 'role' => 'customer') ) ;
        
        //Once customer user is inserted/created, you can retrieve his ID
        // global $current_user;
        // $user = wp_get_current_user();
        // $user_id = $user->ID;
    
        if ( is_wp_error( $user_id  ) ) {
            echo $user_id->get_error_message();
            exit();
        }
    
        if( !is_wp_error( $user_id ) ) {
    
            // add_user_meta( $user_id, "billing_first_name", "patrick" );
            // update_user_meta( $user_id, 'billing_first_name', 'patrick' );
            // update_user_meta( $user_id, 'billing_address_1', 'jl. krendang selatan' );
            update_user_meta( $user_id, 'phone', $_POST['phone'] );

            if (!is_wp_error($user_id)) {
                // wp_set_current_user( $user_id, $_POST['email'] );
                // wp_set_auth_cookie( $user_id );
                $creds = array(
                    'user_login' => $_POST['email'],
                    'user_password' => $_POST['password'],
                );
                wp_signon($creds, false);
            } else{
                 echo $user_id->get_error_message();
            }
    
            wp_safe_redirect( home_url() ); 
            exit;
        
        } else {
            echo 'user not exist';
        }
    }
}
?>

<?php 
    get_header();
    html_form_code();
?>


