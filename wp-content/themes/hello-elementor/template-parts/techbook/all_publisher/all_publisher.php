<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$organizations = get_all_publishers();


$items_per_page = 10;
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$total_products = count($organizations);
$total_pages = ceil($total_products / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;

// Cắt mảng products để lấy sản phẩm cho trang hiện tại
$organizations_to_display = array_slice($organizations, $offset, $items_per_page);

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


<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/all_publisher/all_publisher.css">

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/all_publisher/all_publisher.js"></script>


<div class="container-fullwidth">
    <div class="container-boxed">
        <div class=" title-home">
        <a href="<?php echo home_url(); ?>/home/" id="home-link">Home</a> > <span style="color: #1E00AE;"> Publisher </span>
        </div>
    </div>

    <div class="container-boxed-banner" style="background: linear-gradient(rgba(30, 0, 174, 0.8), rgba(30, 0, 174, 0.8)), url(<?php echo home_url(); ?>/wp-content/uploads/2024/09/Banner-5.png);">
         <div class="titile-banner">Search publusher</div>
        <div class="search-bar">
            <input type="text" placeholder="Keyword" class="search-input">
            <div class="search-category">
            <span class="selected-option">publusher</span>
            </div>
            <!-- Modal -->
            <div id="bookCategoryModal" class="modal-book">
              <div class="modal-content-publisher">
                <h2>Popular Publishers</h2>
                <div class="thanh-blue"></div>
                <div class="categories">
         
                </div>
                <button class="view-all">View all ></button>
              </div>
            </div>
            
            <button class="search-button"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-14.svg" alt="icon"></button>
        </div>
        <div class="advan-search" id="advan-search">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/settings-01.svg" alt="icon">
            <a href="<?php echo home_url(); ?>/search-book/" class="advanced-search">Advanced search</a>
        </div>
    </div>


    <!-- phần dưới -->
    <div class="container-boxed">
        <div class="container">
                <!-- Sidebar Left (25%) -->
                <div class="sidebar" id="sidebar">
                    <div class="categories-standards">
                        <div class="header-standards">
                            <span class="icon"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/book-1.svg" alt="icon"></span> Featured standards
                        </div>
                        <ul class="category-list-standards">
                        <p><span style="color:blue;">ANSI/(AAMA) 001</span> - Numerically Controlled Fabric Cutting Machines - Data Format...</p>
                        <p><span style="color:blue;">ISO 9001</span> - Quality management system</p>
                        <p><span style="color:blue;">ISO 20121</span> - Sustainable Events Management</p>
                        <p><span style="color:blue;">ANSI/AAMI ST 72</span> - Bacterial endotoxin - Test methodologies, routine monitoring and...</p>
                        <p><span style="color:blue;">EIA TEP 161</span> - Typical Characteristics of Photosensitive Surfaces R(1980)</p>
                        <p><span style="color:blue;">EIA JESD 12-1B</span> - Terms and Definitions for Gate Arrays and Cell-Based Digital Integrated Circuits</p>
                        <p><span style="color:blue;">JVAS 1001</span> - Testing method for plasticized polyvinyl chloride films and sheets</p>
                        <p><span style="color:blue;">OIML D 1</span> - Considerations for a Law on Metrology</p>

                        </ul>
                    </div>

                    <div class="categories-standards">
                        <div class="header-standards">
                            <span class="icon"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/annotation-question.svg" alt="icon"></span> Consulting support
                        </div>
                        <div class="title-support">Get In Touch</div>
                        <div class="form-consulting-support"> <?php echo do_shortcode('[contact-form-7 id="7fbcdd3" title="form support"]'); ?></div>
                        <div class="anh-support"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17878-1.png" alt="banner-support" ></div>
                    </div>


                </div>
                <div class="drag-handle">
                <span class="arrow"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/right-arrow.png" alt="icon"></span>
            </div>
            

            <!-- Overlay -->
            <div class="overlay"></div>

            <!-- Main Content (75%) -->
            <div class="main-content">
                <div class="container-title">
                    <p>List of Publisher</p>

                    <div class="form-az">
                        <select id="form-az">
                            <option value="newest">Form A - Z</option>
                            <option value="oldest">Form Z - A</option>
                         
                        </select>
                    </div>
                </div>

                <div class="jump-bar">
                    <button id="jump-to">Jump to</button>
                        <button class="letter">A</button>
                        <button class="letter">B</button>
                        <button class="letter">C</button>
                        <button class="letter">D</button>
                        <button class="letter">E</button>
                        <button class="letter">F</button>
                        <button class="letter">G</button>
                        <button class="letter">H</button>
                        <button class="letter">I</button>
                        <button class="letter">J</button>
                        <button class="letter">K</button>
                        <button class="letter">L</button>
                        <button class="letter">M</button>
                        <button class="letter">N</button>
                        <button class="letter">O</button>
                        <button class="letter">P</button>
                        <button class="letter">Q</button>
                        <button class="letter">R</button>
                        <button class="letter">S</button>
                        <button class="letter">T</button>
                        <button class="letter">U</button>
                        <button class="letter">V</button>
                        <button class="letter">W</button>
                        <button class="letter">X</button>
                        <button class="letter">Y</button>
                        <button class="letter">Z</button>
                    </div>



                    <div id="loading-container">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                                        <div class="organization-list">
                    </div>




                
    </div>
</div>
