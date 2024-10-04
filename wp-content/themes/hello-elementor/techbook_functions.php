<?php
function hte_add_query_vars($vars) {
    $vars[] = 'book_id'; 
    $vars[] = 'standard_id';
    $vars[] = 'publisher_id';
    $vars[] = 'subject_id';
    return $vars;
}
add_filter('query_vars', 'hte_add_query_vars');

function hte_add_rewrite_rules() {
    add_rewrite_rule(
        '^detail/book-([0-9]+)/?', 
        'index.php?book_id=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^detail/standard-([0-9]+)/?', 
        'index.php?standard_id=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^detail/publisher-([0-9]+)/?', 
        'index.php?publisher_id=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^detail/subject-([0-9]+)/?', 
        'index.php?subject_id=$matches[1]',
        'top'
    );
}
add_action('init', 'hte_add_rewrite_rules');

function hte_load_template_for_books($template) {
    $book_id = get_query_var('book_id');
    $standard_id = get_query_var('standard_id');
    $publisher_id = get_query_var('publisher_id');
    $subject_id = get_query_var('subject_id');

    if (!empty($book_id)) {
        $new_template = locate_template('template-parts/book-detail.php');
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    if (!empty($standard_id)) {
        $new_template = locate_template('template-parts/standard-detail.php');
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    if (!empty($publisher_id)) {
        $new_template = locate_template('template-parts/publisher-detail.php');
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    if (!empty($subject_id)) {
        $new_template = locate_template('template-parts/book-detail.php');
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    
    return $template;
}
add_filter('template_include', 'hte_load_template_for_books');

function hte_flush_rewrite_rules() {
    flush_rewrite_rules();
}
add_action('init', 'hte_flush_rewrite_rules');