
<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$products = get_products();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_book/index.css">
<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_book/index.js"></script>


<div class="container-fullwidth">
    <div class="container-boxed">
        <div class="product-detail">
            <div class="book-detail-container">
                <!-- Bên trái: Hình ảnh sách và các nút -->
                <div class="book-image-container">
                
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17872-1.png" alt="Book Image" class="book-image">
                    <div class="book-icons">
                        
                        <a href="#"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-5.svg" alt="Icon 2"></a>
                        <a href="#"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-4.svg" alt="Icon 3"></a>
                    </div>
                </div>

                <!-- Bên phải: Thông tin sách -->
                <div class="book-info" id="book-info-container">
                    <h1 id="book-title" class="book-title">ASME BPVC.V-2023</h1>
                    <h2 id="book-subtitle" class="book-subtitle">2023 ASME Boiler and Pressure Vessel Code, Section V: Nondestructive Examination</h2>
                    <p><strong>Publisher:</strong> <span id="book-standard-by" class="book-standard-by">ASME International</span></p>
                    <p><strong>Publication date:</strong> <span id="book-published-date" class="book-published-date">07/01/2023</span></p>

                    <p><strong>Abstract:</strong> </p>
                    <p>
                    <span id="book-abstract" class="abstract-text">
                    Section V contains requirements,   methods, and techniques for nondestructive examination (NDE), which are Code requirements to the extent that they are specifically referenced and required   by other Code Sections or referencing documents. These NDE methods are   intended to detect surface and internal imperfections in materials, welds,   fabricated parts, and components. Careful application of this   Section will help users to comply with applicable regulations within their jurisdictions, while achieving the operational, cost and safety benefits to   be gained from the many industry best-practices detailed within these volumes.
                    </span>
                    </p>
                    <a href="#" class="view-more" id="view-more-link">View more ></a>
                </div>

            </div>
        </div>


        <!-- Các phiên bản -->


        <div class="versions">
            <h2>Versions</h2>
            <div class="language-selector">
                <label for="language">Language:</label>
                <select id="language" name="language">
                    <option value="english">English</option>
                    <option value="vietnamese">Vietnamese</option>
                </select>
            </div>
        </div>
            
            

        <div class="formats-container">
            <div class="format-row">
                <div class="format-label">
                    <strong class="Formats1" >Available Formats </strong>
                </div>
                <div class="availability">
                    <strong class="Formats1" >Availability </strong>
                </div>
                <div class="price">
                    <div><strong class="Formats1" >Priced</strong></div>
                    <div class="discount-header">20%</div>
                    
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="format-row">
                <div class="format-label">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225.svg" alt="PDF">
                </div>
                <div class="availability">15mb, download</div>
                <div class="price">
                    <span class="discount">29.59$</span>
                    <del>39$</del>
                </div>
                <div class="actions">
                    <button class="add-to-cart">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon"> Add to cart
                    </button>
                    <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon">Instant purchase 
                    </button>
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="format-row">
                <div class="format-label">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225-1.svg" alt="E-Book">
                </div>
                <div class="availability">27mb, download</div>
                <div class="price">
                    <span class="discount">30$</span>
                    <del>40$</del>
                </div>
                <div class="actions">
                    <button class="add-to-cart">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon"> Add to cart
                    </button>
                    <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon">Instant purchase 
                    </button>
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="format-row">
                <div class="format-label">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Frame-225-2.svg" alt="Printed">
                </div>
                <div class="availability">Ships in 1-2 business days</div>
                <div class="price">
                    <span class="discount">59.95$</span>
                    <del>49.95$</del>
                </div>
                <div class="actions">
                    <button class="add-to-cart">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon"> Add to cart
                    </button>
                    <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon">Instant purchase 
                    </button>
                </div>
            </div>
        </div>



            

        <!-- Các phần mô tả -->
        <div class="tabs">
            <button class="tab-link active" onclick="openTab(event, 'product-details')">Product Details</button>
            <button class="tab-link" onclick="openTab(event, 'full-description')">Full Description</button>
        </div>



        <div id="product-details" class="tab-content">
            <div class="book-details">
                <div class="detail-row">
                    <span class="label"><strong>• </strong> Code:</span>
                    <span class="value">ASME BPVC.V-2023</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong> Title:</span>
                    <span class="value">2023 ASME Boiler and Pressure Vessel Code, Section V: Nondestructive Examination</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong> Industry:</span>
                    <span class="value"><a href="#">Mechanical engineering</a></span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Published:</span>
                    <span class="value">ASME International</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Author:</span>
                    <span class="value"><a href="#">Rudy Wojtecki</a></span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Published Date:</span>
                    <span class="value">07/01/2023</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong> ISBN (International Standard Book Number):</span>
                    <span class="value">9780791875797</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>   Pages:</span>
                    <span class="value">1007</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong> Languages:</span>
                    <span class="value">English, France, Vietnamese</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong> Formats:</span>
                    <span class="value">PDF, Online, Hard book (printed)</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Keyword:</span>
                    <span class="value">
                        <span class="keyword">AAMA</span>
                        <span class="keyword">Kiến trúc</span>
                        <span class="keyword">Xây dựng</span>
                        <span class="keyword">Architectural</span>
                    </span>
                </div>
            </div>

        </div>
        <div id="full-description" class="tab-content" style="display:none;">
            <!-- Nội dung mô tả đầy đủ -->
            <div class="preface">
            <h2 class="title">Preface</h2>
            <p class="content">
            Section V contains requirements, methods, and techniques for nondestructive examination (NDE), which are Code requirements to the extent that they are specifically referenced and required by other Code Sections or referencing documents. These NDE methods are intended to detect surface and internal imperfections in materials, welds, fabricated parts, and components.
            Careful application of this Section will help users to comply with applicable regulations within their jurisdictions, while achieving the operational, cost and safety benefits to be gained from the many industry best-practices detailed within these volumes.
            </p>
        </div>


        </div>

        <!-- Các tài liệu liên quan -->
        <div class="versions">
            <h2>Document History</h2>
            <div class="news-selector">
                <label for="news">Sort by:</label>
                <select id="news" name="news">
                    <option value="newest">Newest</option>
                    <option value="Oldest">Oldest</option>
                </select>
            </div>
        </div>

            <div class="related-items">
                
            </div>
        <!-- phần dưới -->
    <div class="document-list">
    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-book1.php'; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products available at the moment.</p>
                    <?php endif; ?>
</div>
    </div>
</div>