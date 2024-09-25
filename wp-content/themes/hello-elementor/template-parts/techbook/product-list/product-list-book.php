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

<style>





.product-image {
    width: 200px;
    height: 183px;
    margin: 10px 0;
    border-radius: 5px;
    padding: 10px 30px;
}
.discount {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    color: #fff;
    border-radius: 5px;
    margin: -10px;
    height: 25px;
    transition: all 0.3s ease;
    position: relative;
}
.product-item:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-color: #157FFF;
    cursor: pointer;
}

.has-discount {
    background-color: #FF2E00;
}

.no-discount {
    background-color: transparent;
}

.product-category, .product-title, .product-group, .product-price {
    min-height: 20px;
}

.product-category {
    color: #157FFF;
    margin-top: -10px;
    font-family: Ford Antenna;
    font-size: 12px;
    font-weight: 300;
    line-height: 36px;
}

.product-title {
    font-family: Ford Antenna;
    font-size: 16px;
    font-weight: 500;
    line-height: 24px;
    margin-bottom: 5px;
}

.product-group {
    font-family: Ford Antenna;
    font-size: 12px;
    font-weight: 300;
    line-height: 21px;
    color: #7E7E7E;
    margin-bottom: 5px;
}

.product-price {
    font-family: Ford Antenna;
    font-size: 16px;
    font-weight: 500;
    line-height: 27px;
    margin-bottom: 5px;
}

.product-icons-list-book{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-right: -10px;
}
.icon-list-book1{
    display: none;
    border-right: 1px solid #EDEDE8;
    padding-right: 20px;
}
.icon-list-book2{
    display: none;
}

.product-item:hover .icon-list-book1,
.product-item:hover .icon-list-book2{
    display: flex;
}
.product-item:hover .product-image {
    clip-path: inset(0 0 20% 0); 
    height: 183px;
}

.product-item:hover .product-category{
    margin-top: -50px;
}

.product-item {
    flex: 0 0 208px; 
    box-sizing: border-box;
    padding: 10px;
    background-color: #fff;
    border-radius: 5px;
    border: 1px solid #EDEDED;
}



</style>

<div class="product-item">
    <p class="discount <?= isset($product['discount']) && !empty($product['discount']) ? 'has-discount' : 'no-discount'; ?>">
        <?= isset($product['discount']) && !empty($product['discount']) ? $product['discount'] : '&nbsp;'; ?>
    </p>

    <img src="<?= isset($product['image']) ? $product['image'] : 'default-image.jpg'; ?>" alt="Product Image" class="product-image">

    <p class="product-category"><?= isset($product['category']) && !empty($product['category']) ? $product['category'] : '&nbsp;'; ?></p>

    <h3 class="product-title"><?= isset($product['title']) && !empty($product['title']) ? $product['title'] : '&nbsp;'; ?></h3>

    <p class="product-group"><?= isset($product['group']) && !empty($product['group']) ? $product['group'] : '&nbsp;'; ?></p>

    <p class="product-price"><?= isset($product['price']) && !empty($product['price']) ? $product['price'] : '&nbsp;'; ?></p>

    <div class="product-icons-list-book">
        <div class="icon-list-book1">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02-3.svg" alt="Add to Cart">
        </div>
        <div class="icon-list-book2">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-13.svg" alt="Add to Favorites">
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
    $('.product-item').on('click', function() {
        window.location.href = '<?php echo home_url(); ?>/techbook/detail-book/';
    });
});
</script>

