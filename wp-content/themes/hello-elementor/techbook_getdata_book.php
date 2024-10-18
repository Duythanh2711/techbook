<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TECBOOK_BOOKS_TABLE', $wpdb->prefix . 'tecbook_books_cache' );

function get_all_products() {
    global $wpdb;
    $table_name = TECBOOK_BOOKS_TABLE;
    $results = $wpdb->get_results( "SELECT * FROM $table_name" );
    return $results;
}

function get_product_by_id( $product_id ) {
    global $wpdb;
    $table_name = TECBOOK_BOOKS_TABLE;
    $product_id = intval( $product_id );
    $query = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $product_id );
    $product = $wpdb->get_row( $query );
    return $product;
}

// Function to prepare product data
function prepare_product_data( $product ) {
    $default_image = home_url( '/wp-content/uploads/2024/09/Rectangle-17873.png' );

    if ( $product ) {
        $data = array(
            'id'                    => intval( $product->id ),
            'title'                 => ! empty( $product->title ) ? $product->title : '',
            'author'                => ! empty( $product->author ) ? $product->author : '',
            'edition'               => ! empty( $product->edition ) ? $product->edition : '',
            'document_status'       => ! empty( $product->documentStatus ) ? $product->documentStatus : '',
            'publication_date'      => ! empty( $product->publicationDate ) ? date( 'Y-m-d', strtotime( $product->publicationDate ) ) : '',
            'publisher'             => ! empty( $product->publisher ) ? $product->publisher : '',
            'doi'                   => ! empty( $product->doi ) ? $product->doi : '',
            'page'                  => ! empty( $product->page ) ? intval( $product->page ) : '',
            'isbn'                  => ! empty( $product->isbn ) ? $product->isbn : '',
            'subjects_code'         => ! empty( $product->subjectsCode ) ? $product->subjectsCode : '',
            'subjects'              => ! empty( $product->subjects ) ? $product->subjects : '',
            'abstract'              => ! empty( $product->abstract ) ? $product->abstract : '',
            'keywords'              => ! empty( $product->keywords ) ? explode( ',', $product->keywords ) : array( '' ),
            'price_print'           => ! empty( $product->pricePrint ) ? floatval( $product->pricePrint ) : '',
            'price_ebook'           => ! empty( $product->priceeBook ) ? floatval( $product->priceeBook ) : '',
            'preview_path'          => ! empty( $product->previewPath ) ? $product->previewPath : $default_image,
            'full_content_path'     => ! empty( $product->fullContentBookPath ) ? $product->fullContentBookPath : '',
            'created_date'          => ! empty( $product->createdDate ) ? date( 'Y-m-d', strtotime( $product->createdDate ) ) : '',
            'updated_date'          => ! empty( $product->updatedDate ) ? date( 'Y-m-d', strtotime( $product->updatedDate ) ) : '',
            'deleted'               => isset( $product->deleted ) ? intval( $product->deleted ) : 0,
            'new_arrival'           => isset( $product->newArrival ) ? intval( $product->newArrival ) : 0,
            'best_sellers'          => isset( $product->bestSellers ) ? intval( $product->bestSellers ) : 0,
            'is_free'               => isset( $product->isFree ) ? intval( $product->isFree ) : 0,
        );
    } else {
        // Default values when product is not found
        $data = array(
            'id'                    => 0,
            'title'                 => '',
            'author'                => '',
            'edition'               => '',
            'document_status'       => '',
            'publication_date'      => '',
            'publisher'             => '',
            'doi'                   => '',
            'page'                  => '',
            'isbn'                  => '',
            'subjects_code'         => '',
            'subjects'              => '',
            'abstract'              => '',
            'keywords'              => array( '' ),
            'price_print'           => '',
            'price_ebook'           => '',
            'preview_path'          => $default_image,
            'full_content_path'     => '',
            'created_date'          => '',
            'updated_date'          => '',
            'deleted'               => 0,
            'new_arrival'           => 0,
            'best_sellers'          => 0,
            'is_free'               => 0,
        );
    }

    return $data;
}

function get_books_by_ids() {
    global $wpdb;

    if (!isset($_POST['productIds']) || !is_array($_POST['productIds'])) {
        wp_send_json_error('Không có ID sản phẩm hoặc dữ liệu không hợp lệ.');
    }

    $product_ids = array_map('intval', $_POST['productIds']);

    if (empty($product_ids)) {
        wp_send_json_error('Danh sách ID sản phẩm rỗng.');
    }

    $placeholders = implode(',', array_fill(0, count($product_ids), '%d'));

    $query_books = $wpdb->prepare(
        "SELECT * FROM wp_tecbook_books_cache WHERE id IN ($placeholders)",
        ...$product_ids
    );
    $books = $wpdb->get_results($query_books);

    $query_publisher = $wpdb->prepare(
        "SELECT * FROM wp_tecbook_standards WHERE id IN ($placeholders)",
        ...$product_ids
    );
    $publisher = $wpdb->get_results($query_publisher); 

    if (empty($books) && empty($publisher)) {
        wp_send_json_error(array('message' => 'Không tìm thấy sách hoặc nhà xuất bản nào.'));
    }

    $response = array(
        'success' => true,
        'books' => $books,         
        'standardBooks' => $publisher 
    );

    wp_send_json_success($response); 

    wp_die(); // AJAX end
}

add_action('wp_ajax_get_books_by_ids', 'get_books_by_ids');
add_action('wp_ajax_nopriv_get_books_by_ids', 'get_books_by_ids'); 


// Truyền biến AJAX URL
function enqueue_custom_scripts2() {
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/template-parts/techbook/wishlist/index.js', array('jquery'), null, true);
    wp_localize_script('custom-js', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts2');






