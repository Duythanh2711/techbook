<?php

function techbook_standards_page() {
    // Kiểm tra nếu có tham số 'item_id' thì chuyển sang trang chi tiết
    if (isset($_GET['item_id'])) {
        echo hte_standard_detail_page(intval($_GET['item_id']));
        return;
    }

    // Số trang hiện tại
    $pageIndex = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
    $pageSize = 50;

    $tokenKey = get_api_token();
    // Lấy dữ liệu standards từ API
    $api_url = get_api_base_url() . '/Standards/getpaging';
    $body = json_encode(array(
        "tokenKey" => $tokenKey,
        "pageIndex" => $pageIndex,
        "pageSize" => $pageSize,
        "item" => array("icsCode" => null)
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

    if (!isset($data->data->items)) {
        echo 'Không có tiêu chuẩn nào được tìm thấy.';
        return;
    }

    // Lưu dữ liệu vào cơ sở dữ liệu (nếu cần)
    if (!empty($data->data->items)) {
        hte_save_standards_to_cache($data->data->items);
    }

    $items = $data->data->items;
    $totalRows = $data->data->totalRows;
    $totalPages = ceil($totalRows / $pageSize);

    ?>
    <div class="wrap">
        <h1>Danh sách Tiêu chuẩn</h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Standard Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo esc_html($item->id); ?></td>
                    <td><a href="?page=techbook_standards_page&item_id=<?php echo esc_html($item->id); ?>"><?php echo esc_html($item->standardTitle); ?></a></td>
                    <td><?php echo esc_html($item->status); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Phân trang với logic hiển thị số trang xung quanh trang hiện tại
        if ($totalPages > 1): ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    $big = 999999999; // Số lớn để paginate_links hoạt động
                    $currentPage = max(1, $pageIndex); // Trang hiện tại
                    $range = 2; // Số trang hiển thị xung quanh trang hiện tại

                    // Bắt đầu và kết thúc phạm vi trang hiển thị
                    $start = ($currentPage - $range > 0) ? $currentPage - $range : 1;
                    $end = ($currentPage + $range < $totalPages) ? $currentPage + $range : $totalPages;

                    // Hiển thị nút "Previous"
                    if ($currentPage > 1) {
                        echo '<a href="' . esc_url(add_query_arg('paged', $currentPage - 1)) . '" class="page-numbers prev">« Previous</a>';
                    }

                    // Hiển thị các trang trong phạm vi
                    for ($i = $start; $i <= $end; $i++) {
                        if ($i == $currentPage) {
                            echo '<span class="page-numbers current">' . $i . '</span>';
                        } else {
                            echo '<a href="' . esc_url(add_query_arg('paged', $i)) . '" class="page-numbers">' . $i . '</a>';
                        }
                    }

                    // Hiển thị nút "Next"
                    if ($currentPage < $totalPages) {
                        echo '<a href="' . esc_url(add_query_arg('paged', $currentPage + 1)) . '" class="page-numbers next">Next »</a>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function hte_standard_detail_page($id) {
}
