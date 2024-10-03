<?php
/**
 * Plugin Name: TechBook API
 * Description: Plugin để lấy và hiển thị danh sách sub-category từ API.
 * Version: 1.0
 * Author: Your Name
 */

// Chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa các hằng số cần thiết
define('TECHBOOKAPI_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Kích hoạt và hủy kích hoạt plugin
register_activation_hook(__FILE__, 'techbookapi_activate');
register_deactivation_hook(__FILE__, 'techbookapi_deactivate');

function techbookapi_activate() {
    techbookapi_create_database_table(); // Tạo bảng cho items
    techbook_create_books_table(); // Tạo bảng cho books
    techbook_create_publishers_table(); // Tạo bảng cho publishers (thêm dòng này)
}


function techbookapi_deactivate() {
    // Thực hiện các thao tác khi hủy kích hoạt plugin
}


function techbookapi_create_database_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'techbookapi_items';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        api_url text NOT NULL,
        api_params text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function techbook_create_books_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_books_cache';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) DEFAULT NULL,
        author VARCHAR(255) DEFAULT NULL,
        edition VARCHAR(255) DEFAULT NULL,
        documentStatus VARCHAR(255) DEFAULT NULL,
        publicationDate VARCHAR(255) DEFAULT NULL,
        publisher VARCHAR(255) DEFAULT NULL,
        doi VARCHAR(255) DEFAULT NULL,
        page INT DEFAULT NULL,
        isbn VARCHAR(255) DEFAULT NULL,
        subjectsCode VARCHAR(255) DEFAULT NULL,
        subjects VARCHAR(255) DEFAULT NULL,
        abstract TEXT DEFAULT NULL,
        keywords TEXT DEFAULT NULL,
        pricePrint DECIMAL(10, 2) DEFAULT NULL,
        priceeBook DECIMAL(10, 2) DEFAULT NULL,
        previewPath VARCHAR(255) DEFAULT NULL,
        fullContentBookPath VARCHAR(255) DEFAULT NULL,
        createdDate DATETIME DEFAULT NULL,
        updatedDate DATETIME DEFAULT NULL,
        deleted BOOLEAN DEFAULT FALSE,
        newArrival BOOLEAN DEFAULT FALSE,
        bestSellers BOOLEAN DEFAULT FALSE,
        isFree BOOLEAN DEFAULT FALSE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Tải các file cần thiết
require_once(TECHBOOKAPI_PLUGIN_PATH . 'includes/enqueue.php');
require_once(TECHBOOKAPI_PLUGIN_PATH . 'includes/functions.php');
require_once(TECHBOOKAPI_PLUGIN_PATH . 'includes/books-page.php');
require_once(TECHBOOKAPI_PLUGIN_PATH . 'includes/admin-page.php');
require_once(TECHBOOKAPI_PLUGIN_PATH . 'includes/shortcode.php');
require_once(TECHBOOKAPI_PLUGIN_PATH . 'includes/publishers-page.php');


// Thêm menu quản trị vào WordPress
add_action('admin_menu', 'techbookapi_add_admin_menu');

function techbookapi_add_admin_menu() {
    add_menu_page(
        'TecBook API Settings',
        'TecBook API',
        'manage_options',
        'techbookapi',
        'techbookapi_admin_page',
        'dashicons-admin-generic',
        11
    );
}
add_action('admin_menu', 'techbook_add_books_menu');

function techbook_add_books_menu() {
    add_menu_page(
        'Books',                // Tên của trang
        'Books',                // Tên của menu
        'manage_options',       // Quyền truy cập
        'techbook_books_page',  // Slug của trang
        'techbook_books_page',  // Callback function hiển thị nội dung trang
        'dashicons-admin-generic',// Icon cho menu (có thể là icon mặc định hoặc thêm SVG)
        12                       // Vị trí của menu
    );
}





//publisher

function techbook_create_publishers_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_publishers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        publisherCode VARCHAR(255) DEFAULT NULL,
        englishTitle VARCHAR(255) DEFAULT NULL,
        englishDescription TEXT DEFAULT NULL,
        vietnameseDescription TEXT DEFAULT NULL,
        abstract TEXT DEFAULT NULL,
        reference VARCHAR(255) DEFAULT NULL,
        keyword VARCHAR(255) DEFAULT NULL,
        relatedICSCode VARCHAR(255) DEFAULT NULL,
        createdDate DATETIME DEFAULT NULL,
        updatedDate DATETIME DEFAULT NULL,
        deleted BOOLEAN DEFAULT FALSE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}



add_action('admin_menu', 'techbook_add_publishers_menu');

function techbook_add_publishers_menu() {
    add_menu_page(
        'Publishers',              // Tên trang
        'Publishers',              // Tên menu
        'manage_options',          // Quyền truy cập
        'techbook_publishers_page',// Slug của trang
        'techbook_publishers_page',// Callback function hiển thị nội dung trang
        'dashicons-admin-generic', // Icon của menu
        13                         // Vị trí của menu
    );
}


function get_api_base_url() {
    return 'https://115.84.178.66:8028/api';
}

// Hàm trả về tokenKey
function get_api_token() {
    return '4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7';
}

