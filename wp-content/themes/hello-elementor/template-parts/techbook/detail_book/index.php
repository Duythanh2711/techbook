<?php

/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$product_id = get_query_var('book_id');
$product = get_product_by_id($product_id);
$product_data = prepare_product_data($product);
$custom_title = $product_data['title'] ? $product_data['title'] : 'Trang chi tiết';

// Thiết lập tiêu đề
add_filter('pre_get_document_title', function ($title) use ($custom_title) {
    return $custom_title;
});

wp_enqueue_script('index', get_template_directory_uri() . '/template-parts/techbook/detail_book/index.js', array('jquery'), null, true);
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_book/index.css">
<!-- <script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_book/index.js"></script> -->

<div class="container-fullwidth">

    <div class="container-boxed">
        <div class=" title-home">
            <a href="<?php echo home_url(); ?>/home/" id="home-link">Home</a> &gt;
            <a href="<?php echo home_url(); ?>/publisher/" id="home-link">Publisher</a> &gt;

            <span style="color: #1E00AE;"> <?= esc_html($product_data['title']); ?> </span>
        </div>
    </div>
    <div class="container-boxed">
        <div class="product-detail">
            <div class="book-detail-container">
                <!-- Bên trái: Hình ảnh sách và các nút -->
                <div class="book-image-container product-item-book" data-book-id="<?php echo $product_id; ?>">
                    <img
                        src="<?php echo !empty($product_data['isbn']) ? 'https://techdoc-storage.s3.ap-southeast-1.amazonaws.com/books/cover/' . esc_attr($product_data['isbn']) . '.jpg' : home_url() . '/wp-content/uploads/2024/09/Rectangle-17873.png'; ?>"
                        alt="Book Image"
                        class="book-image"
                        onerror="
                        let imgElement = this;
                        let extensions = ['jpg', 'png', 'jpeg', 'webp', 'gif'];
                        let currentExtensionIndex = 1; 
                        let baseSrc = '<?php echo !empty($product_data['isbn']) ? 'https://techdoc-storage.s3.ap-southeast-1.amazonaws.com/books/cover/' . esc_attr($product_data['isbn']) : ''; ?>';

                        function tryNextExtension() {
                            if (currentExtensionIndex < extensions.length) {
                                imgElement.src = baseSrc + '.' + extensions[currentExtensionIndex];
                                currentExtensionIndex++;
                            } else {
                                imgElement.src = '<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17873.png';
                            }
                        }

                        imgElement.onerror = tryNextExtension;
                        tryNextExtension();
                    ">

                    <div class="book-icons">
                        <!-- <button class="butoon-book-icon1" id="butoon-book-icon1">
                            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-5.svg" alt="Icon 2">
                        </button> -->
                        <button class="butoon-book-icon1 icon-action icon-wishlist" id="butoon-book-icon2">
                            <svg class="icon-heart" xmlns="http://www.w3.org/2000/svg" width="22" height="21" viewBox="0 0 22 21" fill="none">
                                <path d="M15.1111 1.41016C18.6333 1.41016 21 4.76266 21 7.89016C21 14.2239 11.1778 19.4102 11 19.4102C10.8222 19.4102 1 14.2239 1 7.89016C1 4.76266 3.36667 1.41016 6.88889 1.41016C8.91111 1.41016 10.2333 2.43391 11 3.33391C11.7667 2.43391 13.0889 1.41016 15.1111 1.41016Z"
                                    stroke="#157FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Bên phải: Thông tin sách -->
                <div class="book-info" id="book-info-container">
                    <h1 id="book-title" class="book-title"><?= esc_html($product_data['title']); ?></h1>
                    <!-- <h2 id="book-subtitle" class="book-subtitle"><?= esc_html($product_data['subjects']); ?></h2> -->
                    <p><strong>Author:</strong> <span id="book-author" class="book-standard-by"><?= esc_html($product_data['author']); ?></span></p>
                    <p><strong>Publisher:</strong> <span id="book-standard-by" class="book-standard-by"><?= esc_html($product_data['publisher']); ?></span></p>
                    <p><strong>Publication date:</strong> <span id="book-published-date" class="book-published-date"><?= esc_html($product_data['publication_date']); ?></span></p>

                    <p><strong>Abstract:</strong></p>
                    <p><span id="book-abstract" class="abstract-text"><?= esc_html($product_data['abstract']); ?></span></p>
                    <a href="#" class="view-more" id="view-more-link">View more ></a>
                </div>
            </div>
        </div>


        <!-- Các phiên bản -->
        <div class="versions">
            <h2>Format</h2>
            <!-- <div class="language-selector">
                <label for="language">Language:</label>
                <select id="language" name="language">
                    <option value="english">English</option>
                    <option value="vietnamese">Vietnamese</option>
                </select>
            </div> -->
        </div>

        <div class="formats-container product-item-book" data-book-id="<?php echo $product->id; ?>" data-book-name="<?= esc_html($product_data['title']); ?>">
            <div class="format-row">
                <div class="format-label">
                    <strong class="Formats1">Available Formats </strong>
                </div>
                <div class="availability">
                    <strong class="Formats1">Availability </strong>
                </div>
                <div class="price">
                    <div><strong class="Formats1">Priced</strong></div>
                    <!-- <div class="discount-header">20%</div> -->
                </div>
                <div class="quantity">
                    <div><strong class="Formats1">Quantity</strong></div>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="format-row">
                <div class="format-label">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225-1.svg" alt="E-Book">
                </div>
                <div class="availability">Download</div>
                <div class="price">
                    <span class="discount"><?= esc_html($product_data['price_ebook']); ?>$</span>
                    <!-- <del>$</del> -->
                </div>
                <div class="cart-item-quantity">
                    <input type="number" min="0" class="qty-input" data-book-quantity="quantity_price_ebook" value="1">
                </div>
                <div class="actions">
                    <button class="add-to-cart btn-cart-detail" data-book-pricebook="<?= esc_html($product_data['price_ebook']); ?>" data-book-price="price_ebook">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1"> <span class="add_botton">Add to cart</span>
                    </button>
                    <!-- <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon"> <p class="add_botton">Instant purchase</p> 
                    </button> -->
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="format-row">
                <div class="format-label">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225-2.svg" alt="Printed">
                </div>
                <div class="availability">Ships in 1-2 business days</div>
                <div class="price">
                    <span class="discount"><?= esc_html($product_data['price_print']); ?>$</span>
                    <!-- <del>$</del> -->
                </div>
                <div class="cart-item-quantity">
                    <input type="number" min="0" class="qty-input" data-book-quantity="quantity_price_print" value="1">
                </div>
                <div class="actions">
                    <button class="add-to-cart btn-cart-detail" data-book-pricebook="<?= esc_html($product_data['price_print']); ?>" data-book-price="price_print">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1">
                        <p class="add_botton">Add to cart</p>
                    </button>
                </div>
            </div>
        </div>


        <div class="formats-container-moblie product-item-book" data-book-id="<?php echo $product->id; ?>" data-book-name="<?= esc_html($product_data['title']); ?>">
            <div class="format-moblie">
                <div class="detail-row">
                    <strong class="Formats1">Available Formats </strong><div class="format-right"> <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225-1.svg" alt="E-Book">
                </div>
                </div>
                <div class="detail-row">
                    <strong class="Formats1">Availability </strong>
                    <div class="format-right">
                        <span class="availability">Download</span>
                    </div>
                </div>
                <div class="detail-row">
                    <strong class="Formats1">Priced</strong>
                    <div class="format-right">
                        <span class="discount"><?= esc_html($product_data['price_ebook']); ?>$</span>
                    </div>
                </div>
                <div class="detail-row">
                    <strong class="Formats1">Quantity</strong>
                    <div class="cart-item-quantity">
                        <input type="number" min="0" class="qty-input" data-book-quantity="quantity_price_ebook" value="1">
                    </div>
                </div>
                <div class="actions">
                    <button class="add-to-cart btn-cart-detail" data-book-pricebook="<?= esc_html($product_data['price_ebook']); ?>" data-book-price="price_ebook">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1"> <span class="add_botton">Add to cart</span>
                    </button>
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="format-moblie">
                <div class="detail-row">
                    <strong class="Formats1">Available Formats </strong><div class="format-right"> <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225-2.svg" alt="Printed"></div>
                </div>
                <div class="detail-row">
                    <strong class="Formats1">Availability </strong> 
                    <div class="format-right">
                        <span class="availability">Ships in 1-2 business days</span>
                    </div>
                </div>
                <div class="detail-row">
                    <strong class="Formats1">Priced</strong> 
                    <div class="format-right">
                        <span class="discount"><?= esc_html($product_data['price_print']); ?>$</span>
                    </div>
                </div>
                <div class="detail-row">
                    <strong class="Formats1">Quantity</strong>
                    <div class="cart-item-quantity">
                        <input type="number" min="0" class="qty-input" data-book-quantity="quantity_price_print" value="1">
                    </div>
                </div>
                <div class="actions">
                    <button class="add-to-cart btn-cart-detail" data-book-pricebook="<?= esc_html($product_data['price_print']); ?>" data-book-price="price_print">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1">
                        <p class="add_botton">Add to cart</p>
                    </button>
                </div>
            </div>
        </div>




        <div class="container-boxed">

            <!-- Các phần mô tả -->
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'product-details')">Product Details</button>
                <button class="tab-link" onclick="openTab(event, 'full-description')">Full Description</button>
            </div>



            <div id="product-details" class="tab-content">
                <div class="book-details">
                    <!-- <?php if (!empty($product_data['subjects_code'])): ?>
                    <div class="detail-row">
                        <span class="label"><strong>• </strong> Code:</span>
                        <span class="value"><?= esc_html($product_data['subjects_code']); ?></span>
                    </div>
                <?php endif; ?> -->

                    <?php if (!empty($product_data['title'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Title:</span>
                            <span class="value"><?= esc_html($product_data['title']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['subjects'])): ?>
                        <?php
                        $codes = preg_split('/[*;,]+/', $product_data['subjects']);
                        $display = array();

                        global $wpdb;
                        $table_name = $wpdb->prefix . 'tecbook_subjects';

                        foreach ($codes as $code) {
                            $code = trim($code);
                            if (!empty($code)) {
                                $name = $wpdb->get_var(
                                    $wpdb->prepare(
                                        "SELECT subjects FROM $table_name WHERE code = %s",
                                        $code
                                    )
                                );


                                // Nếu tìm thấy tên (name) trong DB
                                if (!empty($name)) {
                                    // Link sử dụng tên (name) thay vì code
                                    $display[] = '<a href="' . esc_url(home_url('/techbook/search-book/')) . '?subject=' . urlencode($name) . '">' . esc_html($name) . '</a>';
                                } else {
                                    // Nếu không có tên, dùng code làm fallback
                                    $display[] = '<a href="' . esc_url(home_url('/techbook/search-book/')) . '?subject=' . urlencode($code) . '">' . esc_html($code) . '</a>';
                                }
                            }
                        }

                        $direct_codes = array_filter($display, function ($item) {
                            return stripos($item, 'C') !== false;
                        });
                        $detailed_names = array_diff($display, $direct_codes);

                        $codes_str = implode('<br>', $direct_codes);
                        $names_str = implode('<br>', $detailed_names);
                        ?>

                        <div class="detail-row">
                            <?php if (!empty($codes_str)): ?>
                                <span class="label"><strong>• </strong> Subject:</span>
                                <span class="value"><?= wp_kses($codes_str, array('a' => array('href' => array()), 'br' => array())); ?></span>
                            <?php endif; ?>

                            <?php if (!empty($names_str)): ?>
                                <br>
                                <span class="label"><strong>• </strong> Subjects:</span>
                                <span class="value"><?= wp_kses($names_str, array('a' => array('href' => array()), 'br' => array())); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>





                    <?php if (!empty($product_data['publisher'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Published:</span>
                            <span class="value"><?= esc_html($product_data['publisher']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['author'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Author:</span>
                            <span class="value"><?= esc_html($product_data['author']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['publication_date'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Published Date:</span>
                            <span class="value"><?= esc_html($product_data['publication_date']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['isbn'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> ISBN (International Standard Book Number):</span>
                            <span class="value"><?= esc_html($product_data['isbn']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['page'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Pages:</span>
                            <span class="value"><?= esc_html($product_data['page']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['languages'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Languages:</span>
                            <span class="value"><?= esc_html($product_data['languages']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['formats'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Formats:</span>
                            <span class="value"><?= esc_html($product_data['formats']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_data['keywords'][0])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Keywords:</span>
                            <span class="value">
                                <?php foreach ($product_data['keywords'] as $keyword): ?>
                                    <span class="keyword"><?= esc_html($keyword); ?></span>
                                <?php endforeach; ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>




        </div>
        <div id="full-description" class="tab-content" style="display:none;">
            <!-- Nội dung mô tả đầy đủ -->
            <div class="preface">
                <h2 class="title">Preface</h2>
                <p class="content"><?= esc_html($product_data['abstract']); ?> </p>
            </div>


        </div>

        <!-- Các tài liệu liên quan -->
        <div class="versions">
            <h2>Document History</h2>
            <!-- <div class="news-selector">
                <label for="news">Sort by:</label>
                <select id="news" name="news">
                    <option value="newest">Newest</option>
                    <option value="Oldest">Oldest</option>
                </select>
            </div> -->
        </div>

        <div class="related-items">

        </div>
        <div class="document-list">
            <?php
            if ($product) {
                // Kiểm tra xem file product-list-book1.php có tồn tại hay không
                if (file_exists(get_template_directory() . '/template-parts/techbook/product-list/product-list-book1.php')) {
                    include get_template_directory() . '/template-parts/techbook/product-list/product-list-book1.php';
                } else {
                    echo '<p>Template not found.</p>';
                }
            } else {
                // Nếu không tìm thấy sản phẩm, hiển thị thông báo
                echo '<p>No product found for this ID.</p>';
            }
            ?>
        </div>
    </div>