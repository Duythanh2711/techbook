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



function save_product_to_db($product_data) {
    global $wpdb;
    $table_name = TECBOOK_BOOKS_TABLE;

    // Chuẩn bị dữ liệu để lưu vào bảng
    $data = array(
        'id'                    => intval($product_data['id']),
        'title'                 => sanitize_text_field($product_data['title']),
        'author'                => sanitize_text_field($product_data['author']),
        'edition'               => sanitize_text_field($product_data['edition']),
        'documentStatus'        => sanitize_text_field($product_data['documentStatus']),
        'publicationDate'       => sanitize_text_field($product_data['publicationDate']),
        'publisher'             => sanitize_text_field($product_data['publisher']),
        'doi'                   => sanitize_text_field($product_data['doi']),
        'page'                  => isset($product_data['page']) ? intval($product_data['page']) : null,
        'isbn'                  => sanitize_text_field($product_data['isbn']),
        'subjectsCode'          => sanitize_text_field($product_data['subjectsCode']),
        'subjects'              => sanitize_text_field($product_data['subjects']),
        'abstract'              => sanitize_textarea_field($product_data['abstract']),
        'keywords'              => isset($product_data['keywords']) ? implode(',', $product_data['keywords']) : '',
        'pricePrint'            => isset($product_data['pricePrint']) ? floatval($product_data['pricePrint']) : 0,
        'priceeBook'            => isset($product_data['priceeBook']) ? floatval($product_data['priceeBook']) : 0,
        'previewPath'           => esc_url_raw($product_data['previewPath']),
        'fullContentBookPath'   => esc_url_raw($product_data['fullContentBookPath']),
        'createdDate'           => sanitize_text_field($product_data['createdDate']),
        'updatedDate'           => sanitize_text_field($product_data['updatedDate']),
        'deleted'               => intval($product_data['deleted']),
        'newArrival'            => intval($product_data['newArrival']),
        'bestSellers'           => intval($product_data['bestSellers']),
        'isFree'                => intval($product_data['isFree']),
    );

    // Lưu hoặc cập nhật bản ghi vào cơ sở dữ liệu
    $result = $wpdb->replace(
        $table_name,
        $data,
        array(
            '%d', // id
            '%s', // title
            '%s', // author
            '%s', // edition
            '%s', // documentStatus
            '%s', // publicationDate
            '%s', // publisher
            '%s', // doi
            '%d', // page
            '%s', // isbn
            '%s', // subjectsCode
            '%s', // subjects
            '%s', // abstract
            '%s', // keywords
            '%f', // pricePrint
            '%f', // priceeBook
            '%s', // previewPath
            '%s', // fullContentBookPath
            '%s', // createdDate
            '%s', // updatedDate
            '%d', // deleted
            '%d', // newArrival
            '%d', // bestSellers
            '%d', // isFree
        )
    );

    // Trả về kết quả
    return $result !== false;
}

// Xử lý yêu cầu AJAX từ JavaScript
add_action('wp_ajax_save_product_to_db', 'handle_save_product_to_db');
add_action('wp_ajax_nopriv_save_product_to_db', 'handle_save_product_to_db');

function handle_save_product_to_db() {
    // Kiểm tra quyền truy cập và dữ liệu
    if (isset($_POST['product'])) {
        $product_data = $_POST['product'];
        $result = save_product_to_db($product_data);

        if ($result) {
            wp_send_json_success('Product saved successfully');
        } else {
            wp_send_json_error('Failed to save product');
        }
    } else {
        wp_send_json_error('Invalid product data');
    }

    wp_die();
}