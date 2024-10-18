<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// Lấy ID nhà xuất bản từ URL
$organization_id = get_query_var('publisher_id');
$organization = get_publisher_by_id($organization_id);
$organization_data = prepare_publisher_data($organization);
$custom_title = !empty($organization_data['english_title']) ? $organization_data['english_title'] : 'Trang chi tiết';
add_filter('pre_get_document_title', function($title) use ($custom_title) {
    return $custom_title;
});


$documents = get_all_standards();
$items_per_page = 18;
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$total_documents = count($documents);
$total_pages = ceil($total_documents / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;


$documents_to_display = array_slice($documents, $offset, $items_per_page);

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

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_publisher/index.css">

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/detail_publisher/index.js"></script>


<body>
    <div class="container-fullwidth">
        <div class="container-boxed">
            <div class=" title-home">
            <a href="<?php echo home_url(); ?>/home/" class="home-link">Home</a> > <a href="<?php echo home_url(); ?>/book/" class="home-link">  Publisher</a> > 
                <p style="color:#1E00AE" id="title-header-id"><?= esc_html( $organization_data['publisher_code'] ); ?></p>
            </div>
        </div>

        <div class="container-boxed-standards">
            <div class="header-standards"  style="background: linear-gradient(rgba(30, 0, 174, 0.7), rgba(30, 0, 174, 0.7)), url(<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner-6.png);">
            <?php if (!empty($organization_data['related_ics_code'])): ?>
                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17873-1.png" alt="<?= esc_html($organization_data['related_ics_code']); ?> Logo" class="header__logo">
            <?php else: ?>
        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17873.png" alt="Default Logo" class="header__logo">
        <?php endif; ?>

                <div class="header__info">
                    <h1 class="header__title"><?= esc_html( $organization_data['publisher_code'] ); ?></h1>
                    
                        
                            <?php if (!empty($organization_data['related_ics_code'])): ?>
                                <div class="header__publications">
                                <span><?= esc_html($organization_data['related_ics_code']); ?> Publications</span>
                                </div>
                            <?php endif; ?>

                      
                    
                </div>
            </div>

            <div class="about-standards">
                <h2 class="about__title">About</h2>
                <p class="about__text">
                <?= esc_html( $organization_data['english_description'] ); ?>
                </p>
            </div>

            <?php
            // Giả sử $organization_data chứa dữ liệu của nhà xuất bản và có trường 'reference'
            $reference = $organization_data['reference'];

            // Kiểm tra nếu $reference không rỗng
            if (!empty($reference)) {
                // Chuyển đổi các giá trị 'reference' thành một mảng bằng cách tách chuỗi
                $tags = explode(',', $reference);
                ?>
                <div class="tags">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/tag.svg" alt="icon" class="icon-tag">
                    <span class="title-tag">Tag:</span>
                    <?php foreach ($tags as $tag): ?>
                        <span class="tag"><?= esc_html(trim($tag)); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php
            }
            ?>
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
                    <?php if (!empty($documents_to_display)): ?>
                        <?php foreach ($documents_to_display as $document): ?>
                            <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher2.php'; ?>
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
