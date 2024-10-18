<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$products = get_all_products();


$documents = get_all_standards();
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/Home/index.css">
<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/Home/index.js"></script>





<div class="container-fullwidth">
    <div class="container-boxed">
        <div class="container">
                <!-- Sidebar Left (25%) -->
                <div class="sidebar" id="sidebar">
                <!-- Header toggle buttons -->
                <div class="sidebar-header">
                    <button id="publisher-btn" class="tab active">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03.svg" alt="Publisher Icon" class="icon">
                        Publisher
                    </button>
                    <button id="books-btn" class="tab">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/book.svg" alt="Books Icon" class="icon">
                        Books
                    </button>
                </div>


                <!-- Publisher Content -->
                <div id="publisher-content" class="content active">
                    <h3 class="header-with-icon">
                        <span class="icon-text">
                            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-1.svg" alt="Publisher Icon" class="icon">
                            List of Publisher
                        </span>
                        <span class="view-more"><a href="#">View more ></a></span>
                    </h3>

                <div class="publisher-container">
                <div class="letters-column">
                    <ul class="letters-list">
                        <?php foreach (range('A', 'Z') as $letter): ?>
                            <li><a href="#" class="letter"><?php echo $letter; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Danh sách nhà xuất bản -->
                <div class="publishers-column">
                    <div id="loading-container">
                        <i class="fas fa-spinner"></i> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    </div>


                    <ul class="publishers-list">
                        <!-- Nội dung nhà xuất bản sẽ được cập nhật tại đây -->
                    </ul>
                </div>
            </div>

                </div>

                <!-- Books Content -->
                <div id="books-content" class="content">
                    <h3 class="header-with-icon">
                            <span class="icon-text">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-1.svg" alt="Publisher Icon" class="icon">
                                Topics
                            </span>
                        <span class="view-more"><a href="#">View more ></a></span>
                    </h3>
                    <ul class="topics-list">
                        <?php
                        // Fetch all subjects
                        $subjects = get_all_subjects();

                        // Randomly select 20 subjects
                        if ($subjects) {
                            shuffle($subjects);
                            $random_subjects = array_slice($subjects, 0, 21);

                            // Loop through the selected subjects and display them
                            foreach ($random_subjects as $subject) {
                                echo '<li><a href="#">' . esc_html($subject->subjects) . '</a><span class="arrow">&rsaquo;</span></li>';
                            }
                        } else {
                            echo '<li>No topics found.</li>';
                        }
                        ?>
                    </ul>
                    <!-- <div class="thanhngang" ></div>
                    <h4><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/award.svg" alt="Publisher Icon" class="icon">Special Book Collections</h4>
                    <ul class="collections-list">
                        <li><a href="#">Food Science Discipline</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Extraction and Production</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Environmental Engineering</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Facility and Maintenance Engineering</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Fire Protection and Safety</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Heat and Mass Transfer</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Highway Transportation</a><span class="arrow">&rsaquo;</span></li>
                        <li><a href="#">Process Safety</a><span class="arrow">&rsaquo;</span></li>
                    </ul>-->
                </div> 
            </div>
            <div class="drag-handle">
                <span class="arrow"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/right-arrow.png" alt="icon"></span>
            </div>
            

            <!-- Overlay -->
            <div class="overlay"></div>

            <!-- Main Content (75%) -->
            <div class="main-content">
                <!-- Banner Slider -->
                <div class="slider-container">
                    <div class="slide">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner.png" alt="Banner 1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner.png" alt="Banner 2">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner.png" alt="Banner 3">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner.png" alt="Banner 4">
                    </div>
                    <div class="dots">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div>


                


                <!-- Featured Standards Section -->
                <div class="featured-section">
                    <h2> <span> Featured Standards </span>
                    <span class="view-more"><a href="#">View more ></a></span>
                    </h2>
                </div>

                <div class="standard-tabs">
                    <button class="tab-item active">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        ANSI/ (AAMA) 001
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>ISO 9001</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>ISO 20121</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>CAC/GL 68</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>CODEX STAN 177</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>CAC/GL 3</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a> TCVN 4032:1985</a>
                    </button>
                </div>


                <div class="carousel">
                    <button class="prev-btn" id="prev-btn1">&#10094;</button> <!-- Nút trái -->
                    <div class="product-slider1">
                        <div class="product-list1">
                            <?php if (!empty($documents)): ?>
                                <?php foreach ($documents as $document): ?>
                                    <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher2.php'; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No products available at the moment.</p>
                            <?php endif; ?>
                        </div>
                </div>
                <button class="next-btn" id="next-btn1">&#10095;</button> <!-- Nút phải -->
            </div>
                  
                

                <!-- Featured Books Section-->
               <div class="featured-section">
                    <h2> <span> Featured Books </span>
                    <span class="view-more"><a href="#">View more ></a></span>
                    </h2>
                </div>

                <div class="standard-tabs">
                    <button class="tab-item active">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        ANSI/ (AAMA) 001
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>ISO 9001</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>ISO 20121</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>CAC/GL 68</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>CODEX STAN 177</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>CAC/GL 3</a>
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a> TCVN 4032:1985</a>
                    </button>
                </div>


                <div class="carousel">
                    <button class="prev-btn" id="prev-btn2">&#10094;</button> 
                    <!-- Product Slider -->
                    <div class="product-slider2">
                        <div class="product-list2">
                           
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No products available at the moment.</p>
                            <?php endif; ?>

                        </div>
                    </div>
                    <button class="next-btn" id="next-btn2">&#10095;</button> 
                </div>
            </div>   
    </div>
</div>


<!-- phần tiếp -->

<div class="container-fullwidth1">
    <div class="container-boxed">
        <div class="title1">New Arrivals</div>

        <div class="buton1">
            <button id="Standards1" class="Standards1">Standards</button>
            <button id="Books1" class="Books1">Books</button>
        </div>

        <div id="standards1-content" class="content-section" >
            
        <div class="carousel1">
            <button class="prev-btn" id="prev-btn">&#10094;</button> 
            <div class="product-slider">
                <div class="product-list">
                    
                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $document): ?>
                            <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher2.php'; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products available at the moment.</p>
                    <?php endif; ?>

                </div>
            </div>
            <button class="next-btn" id="next-btn">&#10095;</button> 
        </div>
             
        </div>

        <div id="books1-content" class="content-section" style="display: none;">
            <div class="carousel1-book">
                <button class="prev-btn" id="prev-btn-book">&#10094;</button> 
                <div class="product-slider-book">
                    <div class="product-list-book">
                        
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No products available at the moment.</p>
                        <?php endif; ?>

                    </div>
                </div>
                <button class="next-btn" id="next-btn-book">&#10095;</button> 
            </div>
        </div>

    </div>
</div>


<!-- Phần 3 -->

<!-- Phần 3 -->

<div class="container-fullwidth">
    <div class="container-boxed">

        <div class="special-offer">
            <div class="title2">Special Offer</div>
            <div class="filter-buttons">
                <button id="all" class="filter-btn active">All</button>
                <button id="standards" class="filter-btn">Standards</button>
                <button id="books" class="filter-btn">Books</button>
            </div>
        </div>

        <div class="product-display">
    <!-- Left Section (30%) -->
        <div class="left-section">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <?php if (isset($products[$i])): ?>
                    <?php 
              
                $product = $products[$i]; 
                include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; 
            ?>
                <?php else: ?>
                    <p>No product available in this slot.</p>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

<!-- Center Section (40%) -->
<div class="center-section">
    <?php if (isset($products[4])): ?>
        <div class="product-card center-product">
            <p class="discount"> <?= isset($product->discount) && !empty($product->discount) ? 'has-discount' : 'no-discount'; ?>">
                <?= isset($product->discount) && !empty($product->discount) ? $product->discount : '&nbsp;'; ?>
            </p>

            <img src="<?= isset($product->image) && !empty($product->image) ? $product->image : home_url() . '/wp-content/uploads/2024/09/Rectangle-17873.png'; ?>" alt="Product Image" class="product-image-center">
            <p class="product-category1"><?= isset($product->subjects) && !empty($product->subjects) ? $product->subjects : '&nbsp;'; ?></p>
            <h3 class="product-title1"><?= isset($product->title) && !empty($product->title) ? $product->title : '&nbsp;'; ?></h3>
            <p class="product-group1"><?= isset($product->author) && !empty($product->author) ? $product->author : '&nbsp;'; ?></p>
            <p class="product-price1"><?= isset($product->pricePrint) && !empty($product->pricePrint) ? $product->pricePrint : '&nbsp;'; ?></p>
            <p class="product-info"><?= isset($product->abstract) && !empty($product->abstract) ? $product->abstract : '&nbsp;'; ?></p>
            <div class="button-container">
                <button class="btn-wishlist">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/heart-rounded.svg" alt="wishlist icon"> Add to wishlist
                </button>
                <button class="btn-cart">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/shopping-bag-02-2.svg" alt="cart icon"> Add to cart
                </button>
            </div>
        </div>
    <?php else: ?>
        <p>No featured product available.</p>
    <?php endif; ?>
</div>

<!-- Right Section (30%) -->
<div class="right-section">
<?php for ($i = 0; $i < 4; $i++): ?>
                <?php if (isset($products[$i])): ?>
                    <?php 
              
                $product = $products[$i]; 
                include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; 
            ?>
                <?php else: ?>
                    <p>No product available in this slot.</p>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</div>

<!-- Phần 4 -->

<div class="container-fullwidth">
    <div class="container-boxed">
            <div class="banner-container">
            <div class="banner-item banner1">
                <h2>Banner 1</h2>
                <a href="#" class="view-more">View more</a>
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Container-20.png" alt="Banner 1 Image" class="banner-image">
            </div>
            
            <div class="banner-item banner2">
                <h2>Banner 2</h2>
                <a href="#" class="view-more">View more</a>
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/img1-21.png.png" alt="Banner 2 Image" class="banner-image">
            </div>
            
            <div class="banner-item banner3">
                <h2>Banner 3</h2>
                <a href="#" class="view-more">View more</a>
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Container-21.png" alt="Banner 3 Image" class="banner-image">
            </div>
        </div>

        
    </div>
</div>



 <!-- Phần 5 --> 

<div class="container-fullwidth2">
    <div class="container-boxed">
        <div class="thanh-ngang"></div>

        <div class="featured-section">
            <h2> <span> Top Seller Books </span>
            <span class="view-more"><a href="#">View more ></a></span>
            </h2>
        </div>

        <div class="top-sell-book">
            <div class="anhphu">
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Background-16.png" alt="anh" class="anhphu-banner">
            </div>
            <div class="san-pham-top-sell">
            <div class="carousel">
                    <button class="prev-btn" id="prev-btn3">&#10094;</button> 
                    <div class="product-slider3">
                        <div class="product-list3">
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No products available at the moment.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                    <button class="next-btn" id="next-btn3">&#10095;</button> 
                </div>
            </div>
        </div>

        <div class="thanh-ngang1"></div>

        <div class="featured-section">
            <h2> <span> Top Seller Standards </span>
            <span class="view-more"><a href="#">View more ></a></span>
            </h2>
        </div>


        <div class="top-sell-standards">
            <div class="anhphu">
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Background-16.png" alt="anh" class="anhphu-banner">
            </div>
            <div class="san-pham-top-standards">
                <div class="carousel">
                    <button class="prev-btn" id="prev-btn4">&#10094;</button> 
                    <div class="product-slider4">
                        <div class="product-list4">
                            <?php if (!empty($documents)): ?>
                                <?php foreach ($documents as $document): ?>
                                    <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher2.php'; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No products available at the moment.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                    <button class="next-btn" id="next-btn4">&#10095;</button> 
                </div>
            </div>
        </div>

    </div>
    

</div>
