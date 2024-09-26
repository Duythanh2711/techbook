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



$items_per_page = 30;
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/all_book/all_book.css">

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/all_book/all_book.js"></script>







<div class="container-fullwidth">
    <div class="container-boxed">
        <div class=" title-home">
        <a href="<?php echo home_url(); ?>/home/" id="home-link">Home</a> > <span style="color: #1E00AE;"> Books </span>
        </div>
    </div>

    <div class="container-boxed-banner" style="background: linear-gradient(rgba(30, 0, 174, 0.8), rgba(30, 0, 174, 0.8)), url(<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner-4.png);">
        <div class="titile-banner">Search Books</div>
        <div class="search-bar">
            <input type="text" placeholder="Keyword" class="search-input">
            <div class="search-category-book">
            <span class="selected-option">Books categories</span>
            </div>
            <!-- Modal -->
            <div id="bookCategoryModal" class="modal-book">
              <div class="modal-content-book">
                <h2>Popular Books Categories</h2>
                <div class="thanh-blue"></div>
                <div class="categories">
                  <!-- Category items will be populated dynamically -->
                </div>
               
              </div>
              <div class="thanh-trang"></div>
              <button class="view-all">View all ></button>
            </div>
            
            <button class="search-button"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-14.svg" alt="icon"></button>
        </div>
        <div class="advan-search" id="advan-search">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/settings-01.svg" alt="icon">
            <a href="<?php echo home_url(); ?>/search-book/" class="advanced-search">Advanced search</a>
        </div>
    </div>


    <div class="container-boxed">
        <div class="container">
                <!-- Sidebar Left (25%) -->
                <div class="sidebar">
                    <div class="categories-book">
                        <div class="header-book">
                            <span class="icon"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/book-1.svg" alt="icon"></span> Books categories
                        </div>
                        <ul class="category-list-book">
                            <li>• AASHTO Collection</li>
                            <li>• Aerodynamics</li>
                            <li>• Aerospace Engineering Discipline</li>
                            <li>• AeroStructures</li>
                            <li>• Air Pollution Control</li>
                            <li>• Aircraft Stability and Control</li>
                            <li>• Airport Engineering</li>
                            <li>• Alternative and Sustainable Energy</li>
                            <li>• Analytical Techniques</li>
                            <li>• Architectural Engineering</li>
                            <li>• Atmospheric Sciences</li>
                            <li>• Automotive Engineering Discipline</li>
                            <li>• Biological engineering</li>
                            <li>• Biological engineering</li>
                            <li>• Biological engineering</li>
                            <li>• Biological engineering</li>
                            <li>• Biological engineering</li>
                            <li>• Biological engineering</li>
                            <!-- Add more items as needed -->
                        </ul>
                    </div>


                    <div class="categories-author">
                        <div class="header-author">
                            <span class="icon"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/user-edit.svg" alt="icon"></span> Author
                        </div>
                        <ul class="category-list-author">
                            <li>• A G Riddle</li>
                            <li>• Andre Aciman</li>
                            <li>• Anna Banks</li>
                            <li>• Barbara O'Neal</li>
                            <li>• Blake Crouch</li>
                            <li>• Boo Walker</li>
                            <li>• Britney King</li>
                            <li>• Conn Iggulden</li>
                            <li>• Dean Nicholson</li>
                            <li>• Delia Owens</li>
                            <li>• Delia Owens</li>
                            <li>• Delia Owens</li>
                            <li>• Delia Owens</li>
                            <li>• Delia Owens</li>

                        </ul>
                    </div>


                    <div class="categories-ics">
                        <div class="header-ics">
                            <span class="icon"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/building-07.svg" alt="icon"></span> ICS Code
                        </div>
                        
                        <div class="ics-selection">
                        <select id="select-ics">
                            <option value="">All</option>
                            <?php
                            // Extract unique industries from products
                            $industries = array_unique(array_column($products, 'title'));
                            foreach ($industries as $title): ?>
                                <option value="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                        
                    </div>


                    <div class="categories-ics">
                        <div class="header-ics">
                            <span class="icon">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/calendar-1.svg" alt="icon">
                            </span> Published year
                        </div>

                        <div class="year-selection">
                            <select id="pub-year-min">
                                <option value="">Min to</option>
                                <?php
                                // Get current year
                                $currentYear = date('Y');

                                // Display years from 2000 to current year
                                for ($year = 2000; $year <= $currentYear; $year++): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endfor; ?>
                            </select>

                            <select id="pub-year-max">
                                <option value="">Max to</option>
                                <?php
                                // Display years from 2000 to current year
                                for ($year = 2000; $year <= $currentYear; $year++): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="categories-ics">
                        <div class="header-ics">
                            <span class="icon">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/translate-02.svg" alt="icon">
                            </span> Languages
                        </div>

                        <div class="language-selection">
                            <label>
                                <input type="checkbox" name="language" value="English" checked> English
                            </label>
                            <label>
                                <input type="checkbox" name="language" value="Vietnamese"> Vietnamese
                            </label>
                            <label>
                                <input type="checkbox" name="language" value="French"> French
                            </label>
                            <label>
                                <input type="checkbox" name="language" value="Spanish"> Spanish
                            </label>
                            <label>
                                <input type="checkbox" name="language" value="Chinese"> Chinese
                            </label>
                        </div>

                    </div>

                    <div class="categories-ics">
                        <div class="header-ics">
                            <span class="icon">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/bank-note-01.svg" alt="icon">
                            </span> Formats
                        </div>

                        <div class="formats-selection">
                            <label>
                                <input type="checkbox" name="formats" value="PDF" checked> PDF
                            </label>
                            <label>
                                <input type="checkbox" name="formats" value="Online"> Online
                            </label>
                            <label>
                                <input type="checkbox" name="formats" value="French"> Hard book print
                            </label>
                            <label>
                                <input type="checkbox" name="formats" value="Doc"> Doc
                            </label>
                        </div>
                    </div>

                    <div class="categories-ics">
                        <div class="header-ics">
                            <span class="icon">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/bank-note-01.svg" alt="icon">
                            </span> Filter by price
                        </div>

                        <div class="filter-body">
                            <input type="range" id="priceRange" min="0" max="300" value="0">
                            <div class="filter-flex">
                                <label for="priceRange">Price: <span id="priceValue">$0-300$</span></label>
                                <button class="filter-button" onclick="filterPrice()">Filter</button>
                            </div>
                        </div>


                    </div>

                
                </div>

            <!-- Main Content (75%) -->
            <div class="main-content">
                <div class="container-title">
                    <p>List of Publications</p>
                    <div class="flex2">
                        <p>Showing  <span id="showing-book">1-25 of 251 results</span></p>
                        <div class="thanh-doc"></div>

                        <div class="sort-newest">
                            <select id="sort-order">
                                <option value="newest">Newest</option>
                                <option value="oldest">Oldest</option>
                                <!-- Thêm các tùy chọn khác nếu cần -->
                            </select>
                        </div>
                    </div>
                </div>



                <div class="standard-tabs">
                    <button class="tab-item active">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                       <a >New arrival</a> 
                    </button>
                    <button class="tab-item">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/check-verified-03-2.svg" alt="icon" class="icon1">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-10.svg" alt="icon" class="icon2">
                        <a>Best Sellers</a>
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
                </div>

                <div class="product-list">
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


</div>
