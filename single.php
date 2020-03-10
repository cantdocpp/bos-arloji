<?php /* Template Name: single */ ?>

<?php get_header() ?>

<?php 
    function splitImageUrl($url) {
        $stringUrl = '';
        $urlArray = [];
        for ($i = 0; $i < strlen($url); $i++) {
            if ($url[$i] == 'j' && $url[$i + 1] == 'p' && $url[$i + 2] == 'g') {
                $stringUrl .= 'jpg';
                array_push($urlArray, $stringUrl);
                $stringUrl = '';
            } else {
                $stringUrl .= strval($url[$i]);
            }
        }
        return $urlArray;
    }
?>

<div class="container">
    <div class="single-product-page">
        <?php
            global $post;
            $product_id = $post->ID;
            
            $product = new WC_product($product_id);
            $attachment_ids = $product->get_gallery_image_ids();
            $imageUrlinArray = [];

            foreach( $attachment_ids as $attachment_id ) {
                //Get URL of Gallery Images - default wordpress image sizes
                $shop_single_image_url = wp_get_attachment_image_src( $attachment_id, 'shop_single' )[0];
                $imageUrlinArray = splitImageUrl($shop_single_image_url);
                print_r($imageUrlinArray);
            }
        ?>
        <div class="single-product-gallery">
            
        </div>
        <div class="single-product-desc"></div>
    </div>
</div>
