<?php /* Template Name: cart */ ?>

<?php get_header() ?>

<?php
    global $woocommerce;
    $cart = $woocommerce->cart->get_cart_contents();
    // var_dump($cart);
?>

<div class="container">
    <div class="cart-page">
        <div class="cart-data">
            <div class="cart-header">
                Your Cart
            </div>

            <?php do_action( 'woocommerce_before_cart' ); ?> 
            <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <?php do_action( 'woocommerce_before_cart_table' ); ?>
                <table class="cart-table">
                    <thead class="cart-table-head">
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            function rupiah($angka) {
                                $hasil_rupiah = number_format($angka , 2, ',' , '.');
                                return $hasil_rupiah;
                            }

                            function get_item_qty( $product ){
                                foreach( WC()->cart->get_cart() as $cart_item )
                                    // for variable products (product varations)
                                    $product_id = $product->get_parent_id();
                                    if( $product_id == 0 || empty( $product_id ) )
                                        $product_id = $product->get_id();
                            
                                    if ( $product_id == $cart_item['product_id'] ){
                                        return $cart_item['quantity'];
                                        // break;
                                    }
                                return;
                            }

                            do_action( 'woocommerce_before_cart_contents' );

                            foreach ($cart as $cart_item) { 
                                $product =  wc_get_product( $cart_item['data']->get_id() );
                                $getProductDetail = wc_get_product( $cart_item['product_id'] );
                                $productThumbnail = get_the_post_thumbnail_url($cart_item['data']->get_id());
                                $productName = $product->get_title();

                                //https://jboullion.com/list-woocommerce-cart-item-attributes/
                                $attributes = $product->get_attributes();
                        ?>
                            <tr class="tr-body">
                                <td> <img src="<?php echo $productThumbnail ?>" alt="cart image" class="cart-image"> </td>
                                <td> <?php echo $productName; ?></td>
                                <td>
                                    <?php
                                        //https://jboullion.com/list-woocommerce-cart-item-attributes/

                                        foreach ( $attributes as $attribute => $attribute_name ) {
                                            $term = get_term_by('slug', $attribute_name, $attribute);
                                            
                                            echo '<span>' . wc_attribute_label( $attribute ) . ', ' . '</span>';
                                        }
                                    ?>
                                </td>
                                <td> 
                                    <?php 
                                        echo 'Rp. ' . rupiah($product->get_price());
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo get_item_qty($product);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo rupiah($product->get_price() * get_item_qty($product));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item ) ),
                                                esc_html__( 'Remove this item', 'woocommerce' ),
                                                esc_attr( $product->get_id()),
                                                esc_attr( $product->get_sku() )
                                            ),
                                            $cart_item
                                        );
                                    ?>
                                    
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
            
        </div>
    </div>
</div>
