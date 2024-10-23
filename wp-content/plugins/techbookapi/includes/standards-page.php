<?php


function techbook_standards_page() {
    global $wpdb;

    // Kiểm tra nếu có tham số 'item_id' thì chuyển sang trang chi tiết
    if (isset($_GET['item_id'])) {
        echo hte_standard_detail_page(intval($_GET['item_id']));
        return;
    }

    $tokenKey = get_api_token();
    $api_url = get_api_base_url() . '/Standards/getpaging';
    $pageIndex = 1;
    $pageSize = 50;
    $standards = [];

    // Lặp để lấy toàn bộ dữ liệu từ API
    while (true) {
        $body = json_encode(array(
            "tokenKey" => $tokenKey,
            "pageIndex" => $pageIndex,
            "pageSize" => $pageSize,
            "keyWord" => ""
        ));

        $response = wp_remote_post($api_url, array(
            'method'    => 'POST',
            'body'      => $body,
            'headers'   => array('Content-Type' => 'application/json'),
        ));

        if (is_wp_error($response)) {
            echo 'Có lỗi xảy ra: ' . $response->get_error_message();
            return;
        }

        $data = json_decode(wp_remote_retrieve_body($response));

        if (!isset($data->data->items) || empty($data->data->items)) {
            break;
        }

        // Lưu các mục vào mảng $standards
        $standards = array_merge($standards, $data->data->items);

        // Kiểm tra nếu đã lấy hết dữ liệu
        if (count($data->data->items) < $pageSize) {
            break;
        }

        $pageIndex++;
    }

    // Gọi hàm lưu toàn bộ tiêu chuẩn vào cơ sở dữ liệu
    if (!empty($standards)) {
        hte_save_standards_to_cache($standards);
    }

    // Lấy tham số tìm kiếm từ URL
    $search = isset($_GET['s']) ? trim($_GET['s']) : '';

    // Lấy dữ liệu phân trang từ cơ sở dữ liệu và hiển thị
    $current_page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
    $offset = ($current_page - 1) * $pageSize;

    // Xây dựng điều kiện WHERE cho truy vấn nếu có tham số tìm kiếm
    if (!empty($search)) {
        $search_sql = $wpdb->prepare("WHERE standardTitle LIKE %s", '%' . $wpdb->esc_like($search) . '%');
    } else {
        $search_sql = '';
    }

    $sql = "SELECT * FROM {$wpdb->prefix}tecbook_standards $search_sql LIMIT %d OFFSET %d";
    $items = $wpdb->get_results($wpdb->prepare($sql, $pageSize, $offset));

    $totalRows_sql = "SELECT COUNT(*) FROM {$wpdb->prefix}tecbook_standards $search_sql";
    $totalRows = $wpdb->get_var($totalRows_sql);
    $totalPages = ceil($totalRows / $pageSize);

    ?>
    <div class="wrap">
        <h1>Danh sách Tiêu chuẩn</h1>

        <!-- Form tìm kiếm -->
        <form method="get" action="" class="search-form">
            <input type="hidden" name="page" value="techbook_standards_page" />
            <input type="text" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Tìm kiếm theo Standard Title" class="search-input" />
            <input type="submit" value="Tìm kiếm" class="button search-button" />
        </form>

        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Standard Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($items)) : ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo esc_html($item->id); ?></td>
                        <td><a href="?page=techbook_standards_page&item_id=<?php echo esc_html($item->id); ?>"><?php echo esc_html($item->standardTitle); ?></a></td>
                        <td><?php echo esc_html($item->status); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">Không tìm thấy kết quả phù hợp.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <?php
        // Phân trang
        if ($totalPages > 1): ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    $big = 999999999;
                    echo paginate_links(array(
                        'base'    => str_replace($big, '%#%', (admin_url('admin.php?page=techbook_standards_page&paged=%#%'))),
                        'format'  => '&paged=%#%',
                        'current' => max(1, $current_page),
                        'total'   => $totalPages,
                        'type'    => 'plain',
                        'add_args' => array(
                            's' => $search,
                        ),
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <style>
        /* CSS cho form tìm kiếm */
        .search-form {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 10px;
            flex-direction: row;
        }

        .search-input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: #007cba;
            outline: none;
        }

        .search-button {
            background-color: #007cba;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: #005a9e;
        }

        .search-button:active {
            background-color: #004880;
        }
    </style>
    <?php
}



function hte_standard_detail_page($id) {
}
