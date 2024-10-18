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
