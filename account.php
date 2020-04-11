<?php /* Template Name: My Account */ ?>

<?php
    if (!is_user_logged_in()) {
        // $current_user = wp_get_current_user();
        // printf( 'Personal Message For %s!', esc_html( $current_user->user_firstname ) );
        // $user_data = get_userdata(148);
        // echo $user_data->first_name;
        wp_redirect( home_url('/login') ); 
        exit();
    }
?>

<?php
    $user = wp_get_current_user();
    $userId = $user->ID;
    $userData = get_userdata($userId);
    // var_dump($userData);

    $userFirstname = $userData->first_name;
    $userLastname = $userData->last_name;
    $userEmail = $userData->user_email;
    $userPhone = get_user_meta($userId, 'phone', true);
    $userAddress = get_user_meta($userId, 'address', true);
?>

<?php
    if(isset($_POST["logout"])) { 
        wp_logout();
        wp_redirect( home_url() );
        exit();
    }
?>

<?php get_header(); ?>

<div class="user-page">
    <div class="logout-button">
        <form method="POST" action="<?php $_SERVER['REQUEST_URI'] ?>">
            <input type="submit" value="logout" name="logout" class="user-form-button user-form-logout">
        </form>
    </div>
    <form class="user-form" method="POST" action="<?php $_SERVER['REQUEST_URI'] ?>">
        <div class="user-form-header">
            personal info
        </div>
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
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors->add('email_error', 'Invalid email format');
                }
                
                if (is_wp_error($errors)) {
                    if (strlen($errors->get_error_message() > 0)) {
                        echo '<div class="form-error">' . $errors->get_error_message() . '</div>';
                    }
                }
        
                return is_wp_error($errors);
            }

             if (isset($_POST['submit'])) {
                if (my_validate_form() !== 1) {
                    // echo 'finish validate';
                    $userSubmitData = array(
                        'ID'            => $userId,
                        'user_login'    => $_POST[ 'email' ],
                        'first_name'    => $_POST[ 'firstname' ],
                        'last_name'     => $_POST[ 'lastname' ],
                        'user_email'    => $_POST[ 'email' ]
                    );

                    $userInsert = wp_update_user( $userSubmitData );
                    if (is_wp_error($userInsert)) {
                        echo $userInsert->get_error_message();
                    }
                    if (is_wp_error($userInsert) !== 1) {
                        $updatePhone = $_POST[ 'phone' ];
                        $updateAddress = $_POST[ 'address' ];
                        $updateUserPhone = update_user_meta($userId, 'phone', $updatePhone);
                        $updateUserAddress = update_user_meta($userId, 'address', $updateAddress);
                    }
                }
             }
        ?>

        <div class="user-form-field">
            <label class="user-form-label">first name :</label><br />
            <input type="text" class="user-form-input" placeholder="first name" name="firstname" value="<?php echo $userFirstname; ?>">
        </div>
        <div class="user-form-field">
            <label class="user-form-label">last name :</label><br />
            <input type="text" class="user-form-input" placeholder="last name" name="lastname" value="<?php echo $userLastname; ?>">
        </div>
        <div class="user-form-field">
            <label class="user-form-label">email :</label><br />
            <input type="text" class="user-form-input" placeholder="email" name="email" value="<?php echo $userEmail; ?>">
        </div>
        <div class="user-form-field">
            <label class="user-form-label">phone number :</label><br />
            <input type="text" class="user-form-input" placeholder="phone number" name="phone" value="<?php echo $userPhone; ?>">
        </div>
        <div class="user-form-field">
            <label class="user-form-label">address :</label><br />
            <textarea name="address" class="user-form-text" value="<?php echo $userAddress; ?>"> <?php echo $userAddress; ?> </textarea>
        </div>
        <div class="user-form-footer">
            <input class="user-form-button" type="submit" name="submit" value="Submit">
        </div>
    </form>
</div>
