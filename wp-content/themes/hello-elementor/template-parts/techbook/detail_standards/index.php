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
$items_per_page = 18;
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$total_products = count($products);
$total_pages = ceil($total_products / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;

// Cắt mảng products để lấy sản phẩm cho trang hiện tại
$products_to_display = array_slice($products, $offset, $items_per_page);

$big = 999999999;

$pagination_args = array(
    'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format'    => '?paged=%#%',
    'total'     => $total_pages,
    'current'   => max(1, $current_page),
    'show_all'  => false,
    'end_size'  => 1, 
    'mid_size'  => 1, 
    'prev_next' => true,
    'prev_text' => __('« Trước'),
    'next_text' => __('Tiếp »'),
    'type'      => 'plain',
);

$pagination_links = paginate_links($pagination_args);
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_standards/index.css">

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_standards/index.js"></script>


<body>
    <div class="container-fullwidth">
        <div class="container-boxed">
            <div class=" title-home">
                <p id="home-header">Home ></p>
                <p id="publisher-header">Publisher ></p>
                <p style="color:#1E00AE" id="title-header-id">AAMA - American Architectural Manufacturers Association</p>
            </div>
        </div>

        <div class="container-boxed-standards">
            <div class="header-standards"  style="background: linear-gradient(rgba(30, 0, 174, 0.7), rgba(30, 0, 174, 0.7)), url(<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner-6.png);">
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17873-1.png" alt="AAMA Logo" class="header__logo">
                <div class="header__info">
                    <h1 class="header__title">AAMA - American Architectural Manufacturers Association</h1>
                    <div class="header__publications">
                        <span>25 Publications</span>
                    </div>
                </div>
            </div>

            <div class="about-standards">
                <h2 class="about__title">About</h2>
                <p class="about__text">
                Since 1936, the American Architectural Manufacturers Association has stood as a strong advocate for manufacturers and professionals in the fenestration industry and is dedicated to the promotion of quality window, door, curtain wall, storefront and skylight products. And today, as the leading trade association representing both the residential and commercial sectors and all framing materials, our mission remains strong. Building on a solid foundation of achievement in these areas, we continue to: Lead efforts to address the technical and marketing needs of fenestration product manufacturers, suppliers and test labs, work to improve product, material and component performance standards for the fenestration industry and address regulatory issues that affect our membership.
                </p>
            </div>

            <div class="tags">
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/tag.svg" alt="icon" class="icon-tag">
                <span class="title-tag">Tag:</span>
                <span class="tag">AAMA</span>
                <span class="tag">Hiệp hội Các nhà Kiến trúc Hoa Kỳ (AAMA)</span>
                <span class="tag">American Architectural Manufacturers Association (AAMA)</span>
                <span class="tag">Kiến trúc</span>
            </div>
        </div>

        <div class="container-boxed">
            <div class="container-title">
                <p>Featured Publications</p>

                <div class="form-az">
                    <select id="form-az">
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                    
                    </select>
                </div>
            </div>

            <div class="carousel1">
                <button class="prev-btn" id="prev-btn">&#10094;</button> 
                <div class="product-slider">
                    <div class="product-list">
                        
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No products available at the moment.</p>
                        <?php endif; ?>

                    </div>
                </div>
                <button class="next-btn" id="next-btn">&#10095;</button> 
            </div>


            <div class="container-title">
                <p>List of Publications</p>
                <div class="flex2">
                    <p>Showing  <span id="showing-book">1-15 of 25 results</span></p>
                    <div class="thanh-doc"></div>

                    <div class="sort-newest">
                        <select id="sort-order">
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                           
                        </select>
                    </div>
                </div>
            </div>

            <div class="product-list1">
                    <?php if (!empty($products_to_display)): ?>
                        <?php foreach ($products_to_display as $product): ?>
                            <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-book.php'; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Hiện không có sản phẩm nào.</p>
                    <?php endif; ?>
                </div>

               <!-- Hiển thị phân trang -->
                <div class="custom-pagination">
                    <?php echo $pagination_links; ?>
                </div>
        </div>

    </div>
    
</body>
