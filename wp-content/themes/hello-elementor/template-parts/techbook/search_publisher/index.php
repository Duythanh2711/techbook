<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



$standards = get_all_standards() ;
?>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/search_publisher/index.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/search_publisher/index.js"></script>

<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>


<div class="container-fullwidth">
    <div class="container-boxed">
        <div class=" title-home">
        <a href="<?php echo home_url(); ?>/home/" class="home-link">Home</a> > <a href="<?php echo home_url(); ?>/book/" class="home-link">  Publisher</a> > <span style="color: #1E00AE;"> Advanced search </span>
        </div>
    </div>

    <div class="container-boxed-banner">
        <div class="titile-banner">Search Standard</div>
    </div>

    <div class="container-boxed-form">
    <div class="search-box">
        <h2>Advanced search</h2>
        <div class="search-panel">
            <div class="search-table-1">
                <div class="input-field">
                    <label for="ref-number">Reference number</label>
                    <input type="text" id="ref-number" placeholder="Example: ISO 9001">
                </div>

                <div class="input-field">
                    <label for="std-title">Standard Title</label>
                    <input type="text" id="std-title" placeholder="Example: Quality management systems - Requirements">
                </div>

                <!-- Select Publisher -->
                <!-- <div class="input-field">
                    <label for="select-publisher">Publisher</label>
                    <select id="select-publisher">
                        <option value="">All</option>
                        <?php
                        $publishers = get_all_publishers();

                        // Lọc các publisher_code duy nhất và hiển thị
                        if ( ! empty( $publishers ) ) {
                            $publisher_codes = array_unique( array_column( $publishers, 'publisherCode' ) );
                            foreach ( $publisher_codes as $publisher_code ) : ?>
                                <option value="<?php echo esc_attr( $publisher_code ); ?>"><?php echo esc_html( $publisher_code ); ?></option>
                            <?php endforeach;
                        } else {
                            echo '<option value="">No publishers found</option>';
                        }
                        ?>
                    </select>
                </div> -->

                <div class="input-field">
                    <label for="select-ics">ICS Code</label>
                    <select id="select-ics">
                        <option value="">All</option>
                        <?php
                        // Gọi hàm để lấy tất cả dữ liệu ICS codes
                        $ics_codes = get_all_ics_codes();

                        // Kiểm tra và hiển thị các `nameInEnglish` duy nhất với giá trị là `icsCode`
                        if ( ! empty( $ics_codes ) ) {
                            foreach ( $ics_codes as $ics_code ) : ?>
                                <option value="<?php echo esc_attr( $ics_code->icsCode ); ?>">
                                    <?php echo esc_html( $ics_code->nameInEnglish ); ?>
                                </option>
                            <?php endforeach;
                        } else {
                            echo '<option value="">No ICS codes found</option>';
                        }
                        ?>
                    </select>
                </div>



                <div class="input-field">
                    <label for="pub-year-min">Published year</label>
                    <div class="year-selection">
                    <select id="pub-year">
                        <option value="">Chọn năm</option>
                        <?php
                        // Lấy năm hiện tại
                        $currentYear = date('Y');

                        // Hiển thị các năm từ 2000 đến năm hiện tại
                        for ($year = 2000; $year <= $currentYear; $year++): ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                </div>

                <div class="input-field">
                    <label for="replace-to-text">By technology</label>
                    <select id="by-technology-text">
                        <option value="" selected disabled hidden>Select by technology</option>
                        <option value="Automation and Control">Automation and Control</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Engineering and Manufacturing">Engineering and Manufacturing</option>
                        <option value="Lab and Test">Lab and Test</option>
                        <option value="Material Handling and Packaging">Material Handling and Packaging</option>
                        <option value="Materials and Chemicals">Materials and Chemicals</option>
                        <option value="Mechanical Components">Mechanical Components</option>
                        <option value="Networking and Computing">Networking and Computing</option>
                        <option value="Process Equipment">Process Equipment</option>
                    </select>

                </div>

            </div>


            <div class="search-table-2">
                

                <div class="input-field">
                    <label for="replace-to-text">Replace to</label>
                    <input type="text" id="replace-to-text" placeholder="Text">
                </div>

                <div class="input-field">
                    <label for="replace-by-text">Replace by</label>
                    <input type="text" id="replace-by-text" placeholder="Text">
                </div>

                <div class="input-field">
                    <label for="replace-by-text">Referenced Standards</label>
                    <input type="text" id="referenced-standards-text" placeholder="Text">
                </div>

                <div class="input-field">
                    <label for="replace-by-text">Referencing Standards</label>
                    <input type="text" id="referencing-standards-text" placeholder="Text">
                </div>
                <div class="input-field">
                    <label for="replace-to-text">By industry</label>
                    <select id="by-industry-text">
                        <option value="" selected disabled hidden>Select by industry</option>
                        <option value="Aerospace and Defense">Aerospace and Defense</option>
                        <option value="Automotive">Automotive</option>
                        <option value="Building and Construction">Building and Construction</option>
                        <option value="Consumer">Consumer</option>
                        <option value="Energy and Natural Resources">Energy and Natural Resources</option>
                        <option value="Environmental, Health and Safety">Environmental, Health and Safety</option>
                        <option value="Food and Beverage">Food and Beverage</option>
                        <option value="Life Sciences">Life Sciences</option>
                        <option value="Maritime">Maritime</option>
                        <option value="Supply Chain">Supply Chain</option>
                    </select>

                </div>


            </div>

            <div class="search-table-3">
            <div class="input-field status-options">
                <label>Status</label>
                <select id="select-status">
                <option value="" selected disabled hidden>Select status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Revised">Revised</option>
                    <option value="Withdrawn">Withdrawn</option>
                </select>
            </div>


                <div class="input-field">
                    <label for="select-lang">Publisher</label>
                    <select id="select-lang">
                        <option value="">All</option>
                        <?php
                        $publishers = get_all_publishers();

                        // Lọc các publisher_code duy nhất và hiển thị
                        if ( ! empty( $publishers ) ) {
                            $publisher_codes = array_unique( array_column( $publishers, 'publisherCode' ) );
                            foreach ( $publisher_codes as $publisher_code ) : ?>
                                <option value="<?php echo esc_attr( $publisher_code ); ?>"><?php echo esc_html( $publisher_code ); ?></option>
                            <?php endforeach;
                        } else {
                            echo '<option value="">No publishers found</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="input-field keyword-field">
                    <label for="keyword-search">Keyword</label>
                    <textarea id="keyword-search" placeholder="Text"></textarea>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn-refresh">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/refresh-cw-05.svg" alt="icon" class="icon1">    
                    Refresh</button>
                    <button type="submit" class="btn-search">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/search-md.svg" alt="icon" class="icon2">     
                    Search</button>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- phần dưới -->
<div class="container-boxed">
    <div class="container-title">
        <p>Search results: <span id="dem-so-luong">0</span></p>
        <!-- <div class="sort-container">
            <div class="sort-by">
                <p>Sort by: </p>
                <select id="sort-reference">
                    <option value="reference-number">Reference number</option>
                    <option value="date">Date</option>
                    
                </select>
            </div>
            <div class="sort-newest">
                <select id="sort-order">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    
                </select>
            </div>
        </div> -->
    </div>

    <!-- phần dưới -->
    <div class="document-list"></div>

    <div id="page-size-select-container">
            <label for="page-size-select">Number of products per page</label>
            <select id="page-size-select">
                <option value="12" selected>10</option>
                <option value="36">20</option>
                <option value="60">50</option>
                <option value="120">100</option>
            </select>
        </div>
        

    <div class="custom-pagination"></div>

    
        <div id="loading-container">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </div>


</div> 


<script>
    const priceFactor = <?php echo json_encode(get_option('techbookapi_price_factor', 1)); ?>;
</script>