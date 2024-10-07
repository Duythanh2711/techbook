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

$standards = get_all_standards() ;
?>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/search_publisher/index.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/search_publisher/index.js"></script>


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
                <div class="input-field">
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
                </div>

                <div class="input-field">
                    <label for="select-ics">ICS Code</label>
                    <select id="select-ics">
                        <option value="">All</option>
                        <?php
                        // Lọc các publisher_code duy nhất và hiển thị
                        if ( ! empty( $standards ) ) {
                            $standard_codes = array_unique( array_column( $standards, 'referenceNumber' ) );
                            foreach ( $standard_codes as $standard_code ) : ?>
                                <option value="<?php echo esc_attr( $standard_code ); ?>"><?php echo esc_html( $standard_code ); ?></option>
                            <?php endforeach;
                        } else {
                            echo '<option value="">No publishers found</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>


            <div class="search-table-2">
                <div class="input-field">
                    <label for="pub-year-min">Published year</label>
                    <div class="year-selection">
                    <select id="pub-year-min">
                        <option value="">Min to</option>
                    </select>
                    <select id="pub-year-max">
                        <option value="">Max to</option>
                    </select>
                    </div>
                </div>

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


            </div>

            <div class="search-table-3">
                <div class="input-field status-options">
                    <label>Status</label>
                    <select id="select-status">
                        <option value="">All</option>
                        <?php
                        // Lọc các publisher_code duy nhất và hiển thị
                        if ( ! empty( $standards ) ) {
                            $standard_codes = array_unique( array_column( $standards, 'status' ) );
                            foreach ( $standard_codes as $standard_code ) : ?>
                                <option value="<?php echo esc_attr( $standard_code ); ?>"><?php echo esc_html( $standard_code ); ?></option>
                            <?php endforeach;
                        } else {
                            echo '<option value="">No publishers found</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="input-field">
                    <label for="select-lang">Languages</label>
                    <select id="select-lang">
                        <option value="">All</option>
                        <?php
                        // Lọc các publisher_code duy nhất và hiển thị
                        if ( ! empty( $standards ) ) {
                            $standard_codes = array_unique( array_column( $standards, 'languages' ) );
                            foreach ( $standard_codes as $standard_code ) : ?>
                                <option value="<?php echo esc_attr( $standard_code ); ?>"><?php echo esc_html( $standard_code ); ?></option>
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
        <div class="sort-container">
            <div class="sort-by">
                <p>Sort by: </p>
                <select id="sort-reference">
                    <option value="reference-number">Reference number</option>
                    <option value="date">Date</option>
                    <!-- Thêm các tùy chọn khác nếu cần -->
                </select>
            </div>
            <div class="sort-newest">
                <select id="sort-order">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <!-- Thêm các tùy chọn khác nếu cần -->
                </select>
            </div>
        </div>
    </div>

    <!-- phần dưới -->
    <div class="document-list hidden-document">
    <?php 
    
    // Vòng lặp qua từng tài liệu và hiển thị thông tin
    foreach ($standards as $standard) : ?>
        <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher.php'; ?>
    <?php endforeach; ?>
</div>


</div> 