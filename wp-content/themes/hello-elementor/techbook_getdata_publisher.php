<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TECBOOK_PUBLISHERS_TABLE', $wpdb->prefix . 'tecbook_publishers' );

function get_all_publishers() {
    global $wpdb;
    $table_name = TECBOOK_PUBLISHERS_TABLE;
    $results = $wpdb->get_results( "SELECT * FROM $table_name" );
    return $results;
}

function get_publisher_by_id( $publisher_id ) {
    global $wpdb;
    $table_name = TECBOOK_PUBLISHERS_TABLE;
    $publisher_id = intval( $publisher_id );
    $query = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $publisher_id );
    $publisher = $wpdb->get_row( $query );
    return $publisher;
}

// Function to prepare publisher data
function prepare_publisher_data( $publisher ) {
    if ( $publisher ) {
        $data = array(
            'id'                        => intval( $publisher->id ),
            'publisher_code'            => ! empty( $publisher->publisherCode ) ? $publisher->publisherCode : '',
            'english_title'             => ! empty( $publisher->englishTitle ) ? $publisher->englishTitle : '',
            'english_description'       => ! empty( $publisher->englishDescription ) ? $publisher->englishDescription : '',
            'vietnamese_description'    => ! empty( $publisher->vietnameseDescription ) ? $publisher->vietnameseDescription : '',
            'abstract'                  => ! empty( $publisher->abstract ) ? $publisher->abstract : '',
            'reference'                 => ! empty( $publisher->reference ) ? $publisher->reference : '',
            'keyword'                   => ! empty( $publisher->keyword ) ? $publisher->keyword : '',
            'related_ics_code'          => ! empty( $publisher->relatedICSCode ) ? $publisher->relatedICSCode : '',
        );
    } else {
        // Default values when publisher is not found
        $data = array(
            'id'                        => 0,
            'publisher_code'            => '',
            'english_title'             => '',
            'english_description'       => '',
            'vietnamese_description'    => '',
            'abstract'                  => '',
            'reference'                 => '',
            'keyword'                   => '',
            'related_ics_code'          => '',
        );
    }

    return $data;
}


// Hàm xử lý AJAX
function filter_publishers_by_letter() {
    global $wpdb;
    $letter = isset($_POST['letter']) ? $_POST['letter'] : '';

    // Lấy dữ liệu từ bảng tecbook_publishers bắt đầu bằng chữ cái đã chọn
    $table_name = $wpdb->prefix . 'tecbook_publishers';
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT englishTitle FROM $table_name WHERE englishTitle LIKE %s",
        $letter . '%'
    ));

    // Đổ dữ liệu ra ngoài theo định dạng HTML
    if (!empty($results)) {
        foreach ($results as $publisher) {
            echo '<li><a href="#">' . esc_html($publisher->englishTitle) . '</a><span class="arrow">&rsaquo;</span></li>';
        }
    } else {
        echo '<li>Không có nhà xuất bản nào bắt đầu bằng ' . esc_html($letter) . '</li>';
    }

    wp_die();
}
add_action('wp_ajax_filter_publishers_by_letter', 'filter_publishers_by_letter');
add_action('wp_ajax_nopriv_filter_publishers_by_letter', 'filter_publishers_by_letter');

// Truyền biến AJAX URL
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/template-parts/techbook/Home/index.js', array('jquery'), null, true);
    wp_localize_script('custom-js', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');





