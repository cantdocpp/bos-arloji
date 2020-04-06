<?php /* Template Name: single */ ?>

<?php get_header() ?>

<?php 
    function splitImageUrl($url) {
        $stringUrl = '';
        $urlArray = [];
        for ($i = 0; $i < strlen($url); $i++) {
            $imageFormat = checkImageFormat($url, $i);
            if ($imageFormat) {
                $stringUrl .= $imageFormat;
                array_push($urlArray, $stringUrl);
                $stringUrl = '';
            } else {
                $stringUrl .= strval($url[$i]);
            }
        }
        return $urlArray;
    }

    function checkImageFormat($image, $index) {
        if ($image[$index] == 'j' && $image[$index + 1] == 'p' && $image[$index + 2] == 'g') {
            return 'jpg';
        } else if ($image[$index] == 'p' && $image[$index + 1] == 'n' && $image[$index + 2] == 'g') {
            return 'png';
        } else {
            return false;
        }
    }

    function rupiah($angka){
	
        $hasil_rupiah = number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }
?>

<div class="container">
    <div class="single-product-page">
        <?php
            global $post;
            $product_id = $post->ID;
            echo $product_id;
            
            $product = new WC_product($product_id);
            $attachment_ids = $product->get_gallery_image_ids();
            $imageUrlinSplittedArray = [];
            $imageUrlInOneArray = [];

            foreach( $attachment_ids as $attachment_id ) {
                //Get URL of Gallery Images - default wordpress image sizes
                $shop_single_image_url = wp_get_attachment_image_src( $attachment_id, 'shop_single' )[0];
                $imageUrlinSplittedArray = splitImageUrl($shop_single_image_url);
                array_push($imageUrlInOneArray, $imageUrlinSplittedArray[0]);
            }
        ?>
        <div class="single-product-main">
            <div class="single-product-gallery">
                <div class="single-main-image-wrapper">
                    <img src="<?php echo $imageUrlInOneArray[0] ?>" class="single-main-image" alt="main image">
                </div>
                <div class="single-child-image-container">
                    <div class="single-child-image-wrapper">
                        <img src="<?php echo $imageUrlInOneArray[1] ?>" class="single-child-image" alt="child image">
                    </div>
                    <div class="single-child-image-wrapper">
                        <img src="<?php echo $imageUrlInOneArray[2] ?>" class="single-child-image" alt="child image">
                    </div>
                    <div class="single-child-image-wrapper">
                        <img src="<?php echo $imageUrlInOneArray[3] ?>" class="single-child-image" alt="child image">
                    </div>
                    <div class="single-child-image-wrapper">
                        <img src="<?php echo $imageUrlInOneArray[4] ?>" class="single-child-image" alt="child image">
                    </div>
                </div>
            </div>
            <div class="single-product-desc">
                <div class="single-product-title">
                    <?php echo $product->get_title() ?>
                </div>
                <div class="single-product-price">
                    <span class="single-product-currency">Rp.</span>
                    <?php 
                        $productPrice = $product->get_price();
                        echo rupiah($productPrice);
                    ?>
                </div>
                <div class="single-product-description">
                    <?php echo $product->post->post_content; ?>
                </div>
                <div class="single-add-cart">
                    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

                    <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

                        <?php
                        do_action( 'woocommerce_before_add_to_cart_quantity' );

                        woocommerce_quantity_input(
                            array(
                                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                            )
                        );

                        do_action( 'woocommerce_after_add_to_cart_quantity' );
                        ?>

                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="button-add-cart single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

                        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                    </form>

                    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
