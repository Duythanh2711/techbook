
<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$documents = get_documents();
$standard_id = get_query_var('standard_id');
$standard = get_standard_by_id( $standard_id );
$data = prepare_standard_data( $standard );
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_standard/index.css">
<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_standard/index.js"></script>


<div class="container-fullwidth">
    <div class="container-boxed">
        <div class="product-detail">
            <div class="book-detail-container">
                <!-- Bên trái: Hình ảnh sách và các nút -->
                <div class="book-image-container">
                <img src="<?= isset($data['idProduct']) && !empty($data['idProduct']) 
                    ? 'https://techdoc-storage.s3.ap-southeast-1.amazonaws.com/standards/cover/' . $data['idProduct'] . '.jpg' 
                    : esc_url(home_url() . '/wp-content/uploads/2024/09/Rectangle-17873.png'); ?>" 
                    alt="Book Image" class="book-image">

                    <div class="book-icons">
                    <button class="butoon-book-icon1" id="butoon-book-icon3"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-6.svg" alt="Icon 2"></button>
                    <button class="butoon-book-icon1" id="butoon-book-icon1"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-5.svg" alt="Icon 2"></button>
                    <button class="butoon-book-icon1" id="butoon-book-icon2"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-4.svg" alt="Icon 2"></button>
                    </div>
                </div>



                <!-- Bên phải: Thông tin sách -->
                <div class="book-info" id="book-info-container">
                    <h1 id="book-title" class="book-title"><?= esc_html( $data['referenceNumber'] ); ?></h1>
                    <h2 id="book-subtitle" class="book-subtitle"><?= esc_html( $data['standardTitle'] ); ?></h2>

                    <?php if (!empty($data['standardBy'])): ?>
                    <p><strong>Standard by:</strong> <span id="book-standard-by" class="book-standard-by"><?= esc_html( $data['standardBy'] ); ?></span></p>
                    <?php endif; ?>

                    <p><strong>Published date:</strong> <span id="book-published-date" class="book-published-date"><?= esc_html( $data['publishedDate'] ); ?></span></p>
                    <p><strong>Status:</strong> 
                        <span id="book-status" class="status-label">
                            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-7.svg" alt="Status Icon" class="status-icon"> <?= esc_html( $data['status'] ); ?>
                        </span>
                    </p>


                    <p><strong>Abstract:</strong> </p>
        
                    <p><span id="book-abstract" class="abstract-text"><?= esc_html( $data['fullDescription'] ); ?></span></p>
    
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
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1"> <p class="add_botton">Add to cart</p>
                    </button>
                    <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon"> <p class="add_botton">Instant purchase</p> 
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
                    <span class="discount"><?= esc_html( $data['ebookPrice'] ); ?>$</span>
                    <!-- <del>40$</del> -->
                </div>
                <div class="actions">
                    <button class="add-to-cart">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1"> <p class="add_botton">Add to cart</p>
                    </button>
                    <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon"> <p class="add_botton">Instant purchase</p> 
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
                    <span class="discount"><?= esc_html( $data['printPrice'] ); ?>$</span>
                    <!-- <del>49.95$</del> -->
                </div>
                <div class="actions">
                    <button class="add-to-cart">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02.svg" alt="Cart Icon" class="cart-icon1"> <p class="add_botton">Add to cart</p>
                    </button>
                    <button class="contact-order">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/credit-card-check.svg" alt="purchase Icon" class="purchase-icon"> <p class="add_botton">Instant purchase</p> 
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
                    <?php if (!empty($data['referenceNumber'])): ?>
                    <div class="detail-row">
                        <span class="label"><strong>• </strong> Reference number:</span>
                        <span class="value"><?= esc_html( $data['referenceNumber'] ); ?></span>
                    </div>
                    <?php endif; ?>


                
                
                <?php if (!empty($data['standardTitle'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Standard Title:</span>
                    <span class="value"><?= esc_html( $data['standardTitle'] ); ?></span>
                    </div>
                    <?php endif; ?>

                
                <?php if (!empty($data['icsCode'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  ICS Code:</span>
                    <span class="value"><a href="#"><?= esc_html( $data['icsCode'] ); ?></a></span>
                    </div>
                    <?php endif; ?>

     
           
                <?php if (!empty($data['publishedDate'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Published Date:</span>
                    <span class="value"><?= esc_html( $data['publishedDate'] ); ?></span>
                    </div>
                    <?php endif; ?>


               
                <?php if (!empty($data['equivalentStandards'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Equivalent standards:</span>
                    <span class="value"><?= esc_html( $data['equivalentStandards'] ); ?></span>
                    </div>
                    <?php endif; ?>

       
          
                <?php if (!empty($data['referencedStandards'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Referenced standards:</span>
                    <span class="value"><?= esc_html( $data['referencedStandards'] ); ?></span>
                    </div>
                    <?php endif; ?>
  
             
                <?php if (!empty($data['standardBy'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Replace for:</span>
                    <span class="value"><a href="#"><?= esc_html( $data['standardBy'] ); ?></a></span>
                    </div>
                    <?php endif; ?>

          
  
                <?php if (!empty($data['replacedByStandard'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Replaced by:</span>
                    <span class="value"><?= esc_html( $data['replacedByStandard'] ); ?></span>
                    </div>
                    <?php endif; ?>

 
  
                <?php if (!empty($data['standardBy'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Standard by:</span>
                    <span class="value"><?= esc_html( $data['standardBy'] ); ?></span>
                    </div>
                    <?php endif; ?>

        

                <?php if (!empty($data['pages'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>• </strong>  Pages:</span>
                    <span class="value"><?= esc_html( $data['pages'] ); ?></span>
                    </div>
                    <?php endif; ?>

              
 
                <?php if (!empty($data['languages'])): ?>
                    <div class="detail-row">
                    <span class="label"><strong>•</strong>  Languages:</span>
                    <span class="value"><?= esc_html( $data['languages'] ); ?></span>
            
                    </div>
                    <?php endif; ?>

                
                    <?php 
                    // Kiểm tra nếu `printPrice` hoặc `ebookPrice` có giá trị thì hiển thị phần Formats
                    if (!empty($data['printPrice']) || !empty($data['ebookPrice'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Formats:</span>
                            <span class="value">
                                <?php 
                                    $formats = [];

                                    // Kiểm tra và thêm "Printed" nếu `printPrice` có giá trị
                                    if (isset($data['printPrice']) && !empty($data['printPrice'])) {
                                        $formats[] = 'Printed';
                                    }

                                    // Kiểm tra và thêm "eBook" nếu `ebookPrice` có giá trị
                                    if (isset($data['ebookPrice']) && !empty($data['ebookPrice'])) {
                                        $formats[] = 'eBook';
                                    }

                                    // Hiển thị các định dạng nếu có
                                    if (!empty($formats)) {
                                        echo implode(', ', $formats);
                                    }
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>


                
                    <?php if (!empty($data['keywords']) && is_array($data['keywords'])): ?>
                        <div class="detail-row">
                            <span class="label"><strong>• </strong> Keyword:</span>
                            <span class="value">
                                <?php
                                    // Nối các từ khóa với dấu phẩy
                                    echo implode(', ', array_map('esc_html', $data['keywords']));
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>

            </div>

        </div>
        <div id="full-description" class="tab-content" style="display:none;">
        <div class="preface">
            <h2 class="title">Preface</h2>
            <p class="content"><?= esc_html( $data['fullDescription'] ); ?> </p>
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
    <?php
    if ($standard) {
        // Kiểm tra xem file product-list-book1.php có tồn tại hay không
        if (file_exists(get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher.php')) {
            include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher.php';
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lấy giá trị idProduct từ PHP và kiểm tra xem có tồn tại không
        const idProduct = "<?= esc_js($data['idProduct']); ?>";
        const buttonIcon1 = document.getElementById('butoon-book-icon1');
        console.log('idProduct:', idProduct);


        if (buttonIcon1 && idProduct) {
            buttonIcon1.addEventListener('click', function () {
                // Tạo URL cho file PDF dựa trên idProduct
                const pdfUrl = `https://techdoc-storage.s3.ap-southeast-1.amazonaws.com/standards/preview/${idProduct}.pdf`;

                // Mở PDF trong tab mới
                window.open(pdfUrl, '_blank');
            });
        }
    });
</script>












