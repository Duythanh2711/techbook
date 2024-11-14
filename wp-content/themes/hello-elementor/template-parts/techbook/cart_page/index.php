<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php
function enqueue_ajax_script() {
    ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
}
add_action('wp_head', 'enqueue_ajax_script');
?>
<?php  
wp_enqueue_script('index', get_template_directory_uri() . '/template-parts/techbook/cart_page/index.js', array('jquery'), null, true);
wp_localize_script('index', 'ajax_objectt', [
    'ajaxurl' => admin_url('admin-ajax.php')
]);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/cart_page/index.css">

<div id="loading-container"> 
    <i class="fas fa-spinner"></i> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</div>

<div class="cart-notices-wrapper">
    <div class="cart-message-updated" role="alert"> Cart updated successfully.</div>
</div>

<div class="container-fullwidth cart-page">
    <div class="container-boxed">
        <div class="main-content breadcrumb">
            <a href="<?php echo home_url(); ?>/home/" id="home-link">Home</a> > <span style="color: #1E00AE;"> Cart </span>
        </div>
        <div class="main-content page-title">
            <h1>Cart</h1>
        </div>
    </div>

    <div class="container-boxed">
        <div class="container">
            <div class="main-content list-cart">
                <div class="column-cart main-item-cart">
                    <div class="cart-header">
                        <span>Your Cart </span><span id="cart-count"></span>
                    </div>

                    <form class="form list-item-cart">
                        
                    </form>

                    <button type="submit" class="btn-update-cart button" name="update_cart" value="Update cart">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.953 12.8927C20.6752 15.5026 19.1964 17.9483 16.7494 19.3611C12.6839 21.7083 7.48539 20.3153 5.13818 16.2499L4.88818 15.8168M4.04613 11.1066C4.32393 8.49674 5.80272 6.05102 8.24971 4.63825C12.3152 2.29104 17.5137 3.68398 19.8609 7.74947L20.1109 8.18248M3.99316 18.0657L4.72521 15.3336L7.45727 16.0657M17.5424 7.93364L20.2744 8.66569L21.0065 5.93364" stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Update cart
                    </button>
                </div>
                
                <div class="column-cart sidebar-info-cart">
                    <div class="cart-header">
                        <span>Cart Totals </span>
                    </div>

                    <div class="list-info">
                        
                    </div>
                </div>
            </div>
            
            <div class="main-content checkout-cart">
                <div class="form-checkout-main">
                    <div class="cart-header">
                        <span>Checkout </span><span id="cart-count"></span>
                    </div>

                    <form class="form-checkout" id="orderForm" method="POST" action="">
                        <div class="group-input">
                            <div class="tb-col-6">
                                <label for="fullname">Name <span>*</span></label>
                                <input type="text" name="fullname" id="fullname" placeholder="Name" required>
                            </div>
                            <div class="tb-col-6">
                                <label for="phone">Phone number <span>*</span></label>
                                <input type="number" name="phone" id="phone" placeholder="Phone number" required>
                            </div>
                        </div>
                        <div class="group-input">
                            <div class="tb-col-6">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" name="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="tb-col-6">
                                <label for="address">Address <span>*</span></label>
                                <input type="text" name="address" id="address" placeholder="Address" required>
                            </div>
                        </div>
                        
                        <div class="form-textarea">
                            <label for="note">Note</label>
                            <textarea name="note" id="note" placeholder="Note..."></textarea>
                        </div>

                        <div class="button-order">
                            <button type="button" class="btn-order button" id="orderButton" name="order" value="Order">Order</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>