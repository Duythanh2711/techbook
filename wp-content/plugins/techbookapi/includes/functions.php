<?php

// Đăng ký cài đặt chung cho TokenKey
function techbookapi_register_settings() {
    register_setting('techbookapi_options_group', 'techbookapi_token_key');
}
add_action('admin_init', 'techbookapi_register_settings');

// Hàm thêm mới item vào database
function techbookapi_add_item() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'techbookapi_items';
    
    if (isset($_POST['techbookapi_add_item'])) {
        $name = sanitize_text_field($_POST['name']);
        $api_url = sanitize_text_field($_POST['api_url']);
        $input_body = ($_POST['input_body']); // Lưu dưới dạng string

        // Thêm vào database
        $wpdb->insert($table_name, array(
            'name' => $name,
            'api_url' => $api_url,
            'api_params' => $input_body
        ));

        echo '<div class="updated"><p>Item added successfully!</p></div>';
    }
}

// Function xử lý xóa item
function techbookapi_delete_item($item_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'techbookapi_items';

    $wpdb->delete($table_name, array('id' => intval($item_id)));
}

// Hàm cập nhật item
function techbookapi_update_item() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'techbookapi_items';

    if (isset($_POST['techbookapi_update_item'])) {
        $item_id = absint($_POST['item_id']);
        $name = sanitize_text_field($_POST['name']);
        $api_url = sanitize_text_field($_POST['api_url']);
        $input_body = ($_POST['input_body']); // Lưu dưới dạng string

        // Cập nhật vào database
        $wpdb->update($table_name, array(
            'name' => $name,
            'api_url' => $api_url,
            'api_params' => $input_body
        ), array('id' => $item_id));

        echo '<div class="updated"><p>Item updated successfully!</p></div>';

        // Sau khi cập nhật, gọi hàm sync products
        techbookapi_sync_products($api_url, $input_body);
    }
}

// Hàm gọi API để đồng bộ products với các param từ item
// function techbookapi_sync_products($api_url, $input_body) {
//     $token_key = get_option('techbookapi_token_key');
//     $body_json = json_decode(wp_unslash($input_body));
//     $token_key = esc_attr(get_option('techbookapi_token_key'));
//     $body_json->tokenKey = $token_key;
    
//     $args = array(
//         'body'    => json_encode($body_json),
//         'headers' => array(
//             'Authorization' => 'Bearer ' . $token_key,
//             'Content-Type'  => 'application/json',
//         ),
//         'method'  => 'POST'
//     );
    

//     // Gọi API
//     $response = wp_remote_post($api_url, $args);
//     $response_json = json_decode($response["body"]);
    
//     if($response_json['code'] !== 200){
//         echo $response_json['message'];
//     }else{
//         echo'<pre>'; 
//         var_dump($response_json['data']);
//         echo'</pre>'; 
//     }
    
//     die('*-*-*-*-');
//     if (is_wp_error($response)) {
//         $error_message = $response->get_error_message();
//         echo "<div class='error'><p>Failed to sync products: $error_message</p></div>";
//     } else {
//         echo '<div class="updated"><p>Products synced successfully!</p></div>';
//     }
// }

// Hàm để lưu kết quả vào bảng tecbook_books_cache
function hte_save_books_to_cache($books) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_books_cache';

    foreach ($books as $book) {
        $book = (array)$book;
        $wpdb->replace(
            $table_name,
            array(
                'id' => $book['id'],  // ID từ API sẽ được sử dụng
                'title' => $book['title'],
                'author' => $book['author'],
                'edition' => $book['edition'],
                'documentStatus' => $book['documentStatus'],
                'publicationDate' => $book['publicationDate'],
                'publisher' => $book['publisher'],
                'doi' => $book['doi'],
                'page' => isset($book['page']) ? $book['page'] : null,
                'isbn' => $book['isbn'],
                'subjectsCode' => $book['subjectsCode'],
                'subjects' => $book['subjects'],
                'abstract' => $book['abstract'],
                'keywords' => $book['keywords'],
                'pricePrint' => isset($book['pricePrint']) ? $book['pricePrint'] : null,
                'priceeBook' => isset($book['priceeBook']) ? $book['priceeBook'] : null,
                'previewPath' => $book['previewPath'],
                'fullContentBookPath' => $book['fullContentBookPath'],
                'createdDate' => isset($book['createdDate']) ? $book['createdDate'] : current_time('mysql'),
                'updatedDate' => isset($book['updatedDate']) ? $book['updatedDate'] : current_time('mysql'),
                'deleted' => isset($book['deleted']) ? (int)$book['deleted'] : 0,
                'newArrival' => isset($book['newArrival']) ? (int)$book['newArrival'] : 0,
                'bestSellers' => isset($book['bestSellers']) ? (int)$book['bestSellers'] : 0,
                'isFree' => isset($book['isFree']) ? (int)$book['isFree'] : 0
            ),
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%f', '%f', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d') // Format types
        );
    }
}

function hte_get_books_from_cache($args = array()) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_books_cache';

    // Mặc định lấy tất cả các sách
    $default_args = array(
        'limit' => 10,        // Giới hạn số lượng kết quả, mặc định là 10
        'offset' => 0,        // Bắt đầu từ đâu
        'orderby' => 'createdDate',  // Sắp xếp theo
        'order' => 'DESC',    // Thứ tự sắp xếp
        'deleted' => 0        // Lấy sách chưa bị xóa
    );

    // Hợp nhất các tham số truyền vào với các tham số mặc định
    $args = wp_parse_args($args, $default_args);

    // Truy vấn dữ liệu từ bảng tecbook_books_cache
    $query = $wpdb->prepare(
        "SELECT * FROM $table_name 
        WHERE deleted = %d 
        ORDER BY {$args['orderby']} {$args['order']} 
        LIMIT %d OFFSET %d",
        $args['deleted'],
        $args['limit'],
        $args['offset']
    );

    // Lấy kết quả từ database
    $results = $wpdb->get_results($query, ARRAY_A);

    // Trả về kết quả
    return $results;
}





// Hàm để lưu kết quả vào bảng tecbook_publishers
function hte_save_publishers_to_cache($publishers) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_publishers';

    foreach ($publishers as $publisher) {
        $publisher = (array)$publisher;
        $wpdb->replace(
            $table_name,
            array(
                'id' => $publisher['id'],  // ID từ API sẽ được sử dụng
                'publisherCode' => $publisher['publisherCode'],
                'englishTitle' => $publisher['englishTitle'],
                'englishDescription' => $publisher['englishDescription'],
                'vietnameseDescription' => $publisher['vietnameseDescription'],
                'abstract' => $publisher['abstract'],
                'reference' => $publisher['reference'],
                'keyword' => $publisher['keyword'],
                'relatedICSCode' => $publisher['relatedICSCode'],
            ),
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d') // Định dạng dữ liệu
        );
    }
}


function hte_save_standards_to_cache($standards) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_standards';

    foreach ($standards as $standard) {
        $standard = (array)$standard;
        $wpdb->replace(
            $table_name,
            array(
                'id' => $standard['id'],  // ID từ API sẽ được sử dụng
                'idProduct' => isset($standard['idProduct']) ? $standard['idProduct'] : null,
                'referenceNumber' => isset($standard['referenceNumber']) ? $standard['referenceNumber'] : null,
                'standardTitle' => isset($standard['standardTitle']) ? $standard['standardTitle'] : null,
                'status' => isset($standard['status']) ? $standard['status'] : null,
                'referencedStandards' => isset($standard['referencedStandards']) ? $standard['referencedStandards'] : null,
                'referencingStandards' => isset($standard['referencingStandards']) ? $standard['referencingStandards'] : null,
                'equivalentStandards' => isset($standard['equivalentStandards']) ? $standard['equivalentStandards'] : null,
                'replaceStandard' => isset($standard['replaceStandard']) ? $standard['replaceStandard'] : null,
                'replacedByStandard' => isset($standard['replacedByStandard']) ? $standard['replacedByStandard'] : null,
                'standardBy' => isset($standard['standardBy']) ? $standard['standardBy'] : null,
                'languages' => isset($standard['languages']) ? $standard['languages'] : null,
                'fullDescription' => isset($standard['fullDescription']) ? $standard['fullDescription'] : null,
                'ebookPrice' => isset($standard['ebookPrice']) ? $standard['ebookPrice'] : null,
                'printPrice' => isset($standard['printPrice']) ? $standard['printPrice'] : null,
                'bothPrice' => isset($standard['bothPrice']) ? $standard['bothPrice'] : null,
                'currency' => isset($standard['currency']) ? $standard['currency'] : null,
                'historicalEditions' => isset($standard['historicalEditions']) ? $standard['historicalEditions'] : null,
                'documentHistoryStandardId' => isset($standard['documentHistoryStandardId']) ? $standard['documentHistoryStandardId'] : null,
                'icsCode' => isset($standard['icsCode']) ? $standard['icsCode'] : null,
                'keyword' => isset($standard['keyword']) ? $standard['keyword'] : null,
                'identicalStandards' => isset($standard['identicalStandards']) ? $standard['identicalStandards'] : null,
                'publishedDate' => isset($standard['publishedDate']) ? $standard['publishedDate'] : null,
                'pages' => isset($standard['pages']) ? $standard['pages'] : null,
                'byTechnology' => isset($standard['byTechnology']) ? $standard['byTechnology'] : null,
                'byIndustry' => isset($standard['byIndustry']) ? $standard['byIndustry'] : null,
                'previewPath' => isset($standard['previewPath']) ? $standard['previewPath'] : null,
                'coverPath' => isset($standard['coverPath']) ? $standard['coverPath'] : null,
                'fullPath' => isset($standard['fullPath']) ? $standard['fullPath'] : null,
            ),
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d') // Định dạng dữ liệu
        );
    }
}



function hte_save_subjects_to_cache($subjects) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tecbook_subjects';

    foreach ($subjects as $subject) {
        $subject = (array)$subject;
        $wpdb->replace(
            $table_name,
            array(
                'id' => $subject['id'],  // ID from API
                'code' => $subject['code'],
                'subjects' => $subject['subjects'],
                'notes' => $subject['notes'],
            ),
            array('%d', '%s', '%s', '%s')
        );
    }
}




