<?php

//tách trang all_publisher
function enqueue_all_publisher_scripts() {
    $organizations = get_organizations();
    $total_organizations = count($organizations);
    $max_pages = ceil($total_organizations / 10);

    wp_enqueue_script(
        'all-publisher-script', 
        get_template_directory_uri() . '/template-parts/techbook/all_publisher/all_publisher.js', 
        array('jquery'), 
        '1.0', 
        true 
    );

    wp_localize_script(
        'all-publisher-script',
        'my_ajax_object', 
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'max_pages' => $max_pages
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_all_publisher_scripts');


add_action('wp_ajax_load_more_products', 'load_more_products_callback');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products_callback');

function load_more_products_callback() {
    $page = intval($_POST['page']);
    $offset = ($page - 1) * 10;
    $organizations = get_organizations();
    $organizations = array_slice($organizations, $offset, 10);

    foreach($organizations as $organization) {
        include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher1.php';
    }

    wp_die();
}