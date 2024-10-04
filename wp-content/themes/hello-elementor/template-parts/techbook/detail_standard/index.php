
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
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Rectangle-17872.png" alt="Book Image" class="book-image">
                    <div class="book-icons">
                    <button class="butoon-book-icon1" id="butoon-book-icon3"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-6.svg" alt="Icon 2"></button>
                    <button class="butoon-book-icon1" id="butoon-book-icon1"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-5.svg" alt="Icon 2"></button>
                    <button class="butoon-book-icon1" id="butoon-book-icon2"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-4.svg" alt="Icon 2"></button>
                    </div>
                </div>

                <!-- Bên phải: Thông tin sách -->
                <div class="book-info" id="book-info-container">
                    <h1 id="book-title" class="book-title">AAMA/WDMA/CSA 101/I.S.2/A440:22</h1>
                    <h2 id="book-subtitle" class="book-subtitle">North American Fenestration Standard/ Specification for windows, doors, and skylights, includes Errata (2023) and Update No.1 (2024)</h2>
                    <p><strong>Standard by:</strong> <span id="book-standard-by" class="book-standard-by">CSA Group</span></p>
                    <p><strong>Published date:</strong> <span id="book-published-date" class="book-published-date">21/02/2023</span></p>
                    <p><strong>Status:</strong> 
                        <span id="book-status" class="status-label">
                            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/Icon-7.svg" alt="Status Icon" class="status-icon"> Most recent
                        </span>
                    </p>


                    <p><strong>Abstract:</strong> </p>
                    <p>
                    <span id="book-abstract" class="abstract-text">
                            This is the fifth edition of AAMA/WDMA/CSA 101/I.S.2/A440, North American Fenestration Standard/Specification for windows, doors, and skylights. It supersedes the previous edition published in 2017 under the same title. It is jointly published and maintained by the Fenestration and Glazing Industry Alliance (FGIA), a unified organization consisting of the American Architectural Manufacturers Association (AAMA) and Insulating Glass Manufacturers Alliance, the Window & Door Manufacturers Association (WDMA), and the Canadian Standards Association (CSA).
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
                    <span class="discount">30$</span>
                    <del>40$</del>
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
                    <span class="discount">59.95$</span>
                    <del>49.95$</del>
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
                <div class="detail-row">
                    <span class="label"><strong>• </strong> Reference number:</span>
                    <span class="value">AAMA/WDMA/CSA 101/I.S.2/A440:22</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Standard Title:</span>
                    <span class="value">North American Fenestration Standard / Specification for windows, doors, and skylights, Includes Errata (2023) and Update No.1 (2024)</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  ICS Code:</span>
                    <span class="value"><a href="#">91.060.50 Door & window</a></span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Published Date:</span>
                    <span class="value">21/02/2023</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Equivalent standards:</span>
                    <span class="value">--</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Referenced standards:</span>
                    <span class="value">--</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Replace for:</span>
                    <span class="value"><a href="#">AAMA/WDMA/CSA 101/I.S.2/A440-08 (2008-07-01)</a></span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Replaced by:</span>
                    <span class="value">--</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Standard by:</span>
                    <span class="value">CSA Group</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Pages:</span>
                    <span class="value">40</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>•</strong>  Languages:</span>
                    <span class="value">English, France, Vietnamese</span>
                </div>
                <div class="detail-row">
                    <span class="label"><strong>• </strong>  Formats:</span>
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
                This is the fifth edition of AAMA/WDMA/CSA 101/I.S.2/A440, North American Fenestration Standard/Specification for windows, doors, and skylights. It supersedes the previous edition published in 2017 under the same title. It is jointly published and maintained by the Fenestration and Glazing Industry Alliance (FGIA), a unified organization consisting of the American Architectural Manufacturers Association (AAMA) and Insulating Glass Manufacturers Alliance, the Window & Door Manufacturers Association (WDMA), and the Canadian Standards Association (CSA).
            </p>
            <p class="content">
                This Standard/Specification was developed as an advisory document and is published as a public service. FGIA, WDMA, CSA, the individual members of the CSA Technical Committee on Performance Standard for Windows, and the U.S.A./Canada Joint Document Management Group (JDMG) disclaim all liability for the use, application, or adaptation of the material published in this Standard/Specification. Intended users of this Standard/Specification include building officials, manufacturers, architects, engineers, consumers, builders, contractors, trade associations, test laboratories, specifiers, product evaluation and certification agencies, and government agencies. FGIA, WDMA, and CSA intend for this Standard/Specification to be referenced in U.S. International Code Council (ICC) model codes and in the National Building Code (NBC) of Canada. This Standard/Specification presents provisions addressing fenestration product requirements, under the control of the product manufacturer, contained in those codes. CSA A440S1, Canadian Supplement to AAMA/WDMA/CSA 101/I.S.2/A440, North American Fenestration Standard/Specification for windows, doors, and skylights, provides additional requirements to AAMA/WDMA/CSA 101/I.S.2/A440 for compliance in Canada. The Canadian Supplement is considered suitable for use for conformity assessment within the stated scope of the Standard.
            </p>
            <p class="content">
                The Canadian Supplement was prepared by the CSA Technical Committee on the Performance Standard for Windows, under the jurisdiction of the Strategic Steering Committee on Building Products and Systems, and has been formally approved by the Technical Committee. This Standard/Specification was jointly prepared by the CSA Technical Committee on Performance Standard for Windows, under the jurisdiction of the Strategic Steering Committee on Building Products and Systems, and by the U.S.A./Canada Joint Document Management Group (JDMG). This body includes representatives from FGIA, WDMA, CSA and other interested parties. This Standard/Specification has been formally approved by the members of the Fenestration and Glazing Industry Alliance, the members of the Window & Door Manufacturers Association and by the CSA Technical Committee. A list of the members of the CSA Technical Committee is available upon request. This Standard/Specification has been developed in compliance with Standards Council of Canada requirements for National Standards of Canada. It has been published as a National Standard of Canada by CSA Group.
            </p>
        </div>

        <div class="scope">
            <h2 class="title">Scope</h2>
            <p class="content">
            This fenestration Standard/Specification applies to both operating and fixed, new construction and replacement windows, doors, SSPs, TDDs, roof windows, and unit skylights. This fenestration Standard/Specification is material-neutral and establishes performance requirements for windows, doors, SSPs, TDDs, roof windows, and unit skylights including their components and materials. This Standard/Specification concerns itself with the determination of Performance Grade (PG), Allowable Stress Design (ASD) design pressure (DP), and related performance ratings for windows, doors, SSPs, TDDs, roof windows, and unit skylights and is based on laboratory testing of products in standard fixtures. This Standard/Specification is not intended to test or address the use or installation of the product. Performance requirements are used in this Standard/Specification when possible. Prescriptive requirements are used when necessary. When products successfully pass all applicable performance tests, a rating is determined and a test report may be issued. The primary purpose of this Standard/Specification is to enable end-product performance evaluation as may be required for certain U.S. and Canadian model building codes for windows, doors, SSPs, TDDs, roof windows, and unit skylights. Performance-based product comparison, durability assessment, and technical issues related to certification programs are secondary purposes of this Standard/Specification. This Standard/Specification applies to testing and rating products. The tested rating applies to products of functionally identical construction, with both width and height less than or equal to the tested size. Programs have been developed or are proposed for determining fenestration energy performance ratings and for fenestration product sustainability. These programs are outside the scope of this Standard/Specification. Fenestration products excluded from the scope of this Standard/Specification include: interior windows, interior access doors, interior accessory windows (IAWs), and interior doors, vehicular-access doors (garage doors), roof-mounted smoke and heat-relief vents, sloped glazing (other than unit skylights or roof windows), curtain walls and storefronts, commercial entrance systems, sunrooms, revolving doors, commercial steel doors, skylights according to AAMA SKY-3, and motorized operators.
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
    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $document): ?>
                            <?php include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher.php'; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products available at the moment.</p>
                    <?php endif; ?>
</div>
    </div>
</div>