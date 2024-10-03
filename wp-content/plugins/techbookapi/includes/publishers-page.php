<?php

function techbook_publishers_page() {
    // Kiểm tra nếu có tham số 'item_id' thì chuyển sang trang chi tiết
    if (isset($_GET['item_id'])) {
        echo hte_publisher_detail_page(intval($_GET['item_id']));
        return;
    }

    // Số trang hiện tại
    $pageIndex = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
    $pageSize = 50;

    // Lấy dữ liệu nhà xuất bản từ API
    $api_url = 'https://115.84.178.66:8028/api/Publishers/getpaging';
    $body = json_encode(array(
        "tokenKey" => "4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7",
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

    if (!isset($data->data->items)) {
        echo 'Không có nhà xuất bản nào được tìm thấy.';
        return;
    }

    // Lưu dữ liệu vào cơ sở dữ liệu
    if (!empty($data->data->items)) {
        hte_save_publishers_to_cache($data->data->items); // Gọi hàm lưu dữ liệu
    }

    $items = $data->data->items;
    $totalRows = $data->data->totalRows;
    $totalPages = ceil($totalRows / $pageSize);

    ?>
    <div class="wrap">
        <h1>Danh sách Nhà xuất bản</h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PublisherCode</th>
                    <th>EnglishTitle</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo esc_html($item->id); ?></td>
                    <td><a href="?page=techbook_publishers_page&item_id=<?php echo esc_html($item->id); ?>"><?php echo esc_html($item->publisherCode); ?></a></td>
                    <td><?php echo esc_html($item->englishTitle); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Phân trang
        if ($totalPages > 1): ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    $big = 999999999; // Số lớn để paginate_links hoạt động
                    echo paginate_links(array(
                        'base'    => str_replace($big, '%#%', (admin_url('admin.php?page=techbook_publishers_page&paged=%#%'))),
                        'format'  => '&paged=%#%',
                        'current' => max(1, $pageIndex),
                        'total'   => $totalPages,
                        'type'    => 'plain',
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function hte_publisher_detail_page($id) {
    // URL API GetById
    $url = 'https://115.84.178.66:8028/api/Publishers/GetById';
    $url_update = 'https://115.84.178.66:8028/api/Publishers/Update';
    
    // Dữ liệu JSON truyền vào API, bao gồm "id" trong "item"
    $body = json_encode([
        "id" => "string", 
        "tokenKey" => "4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7",
        "intValue" => 0,
        "boolValue" => true,
        "stringValue" => "string",
        "pageIndex" => 0,
        "pageSize" => 0,
        "keyword" => "string",
        "item" => [
            "id" => $id, // Truyền vào ID thực của nhà xuất bản
            "publisherCode" => "",
            "englishTitle" => "",
            "englishDescription" => "",
            "vietnameseDescription" => "",
            "abstract" => "",
            "reference" => "",
            "keyword" => "",
            "relatedICSCode" => "",
            "totalRows" => 0
        ]
    ]);

    // Gọi API để lấy thông tin chi tiết
    $response = wp_remote_post($url, [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ]);

    // Xử lý lỗi khi gọi API
    if (is_wp_error($response)) {
        return 'Có lỗi xảy ra khi lấy dữ liệu.';
    }

    // Parse JSON trả về
    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (!isset($data['data'])) {
        return 'Không tìm thấy dữ liệu.';
    }

    // Lấy thông tin chi tiết của nhà xuất bản từ API
    $item = $data['data'];

    // Hiển thị form cập nhật thông tin
    ob_start();
    ?>
    <style>
        #updatePublisherForm h1 {
            text-align: center;
            color: #333;
        }
        form#updatePublisherForm {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        #updatePublisherForm div {
            margin-bottom: 15px;
        }
        #updatePublisherForm label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        #updatePublisherForm input[type="text"],
        #updatePublisherForm textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #updatePublisherForm button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 0 auto;
        }
        #updatePublisherForm button:hover {
            background-color: #218838;
        }
    </style>

    <h1>Chi tiết Nhà xuất bản</h1>
    <form id="updatePublisherForm">
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo esc_attr($item['id']); ?>">
        </div>
        <div>
            <label for="publisherCode">Publisher Code:</label>
            <input type="text" id="publisherCode" name="publisherCode" value="<?php echo esc_attr($item['publisherCode']); ?>" required>
        </div>
        <div>
            <label for="englishTitle">English Title:</label>
            <input type="text" id="englishTitle" name="englishTitle" value="<?php echo esc_attr($item['englishTitle']); ?>" required>
        </div>
        <div>
            <label for="englishDescription">English Description:</label>
            <textarea id="englishDescription" name="englishDescription" required><?php echo esc_textarea($item['englishDescription']); ?></textarea>
        </div>
        <div>
            <label for="vietnameseDescription">Vietnamese Description:</label>
            <textarea id="vietnameseDescription" name="vietnameseDescription" required><?php echo esc_textarea($item['vietnameseDescription']); ?></textarea>
        </div>
        <div>
            <label for="abstract">Abstract:</label>
            <textarea id="abstract" name="abstract" required><?php echo esc_textarea($item['abstract']); ?></textarea>
        </div>
        <div>
            <label for="reference">Reference:</label>
            <input type="text" id="reference" name="reference" value="<?php echo esc_attr($item['reference']); ?>">
        </div>
        <div>
            <label for="keyword">Keyword:</label>
            <input type="text" id="keyword" name="keyword" value="<?php echo esc_attr($item['keyword']); ?>">
        </div>
        <div>
            <label for="relatedICSCode">Related ICS Code:</label>
            <input type="text" id="relatedICSCode" name="relatedICSCode" value="<?php echo esc_attr($item['relatedICSCode']); ?>">
        </div>

        <button type="button" id="updateButton">Cập nhật</button>
    </form>

    <script>
        document.getElementById('updateButton').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('updatePublisherForm'));
            const data = {
                id: formData.get('id'),
                tokenKey: '4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7',
                publisherCode: formData.get('publisherCode'),
                englishTitle: formData.get('englishTitle'),
                englishDescription: formData.get('englishDescription'),
                vietnameseDescription: formData.get('vietnameseDescription'),
                abstract: formData.get('abstract'),
                reference: formData.get('reference'),
                keyword: formData.get('keyword'),
                relatedICSCode: formData.get('relatedICSCode')
            };

            fetch('<?php echo esc_url($url_update); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.code == 200 || data.code == 201) {
                    alert('Cập nhật nhà xuất bản thành công!');
                    window.location.reload();
                } else {
                    alert('Đã có lỗi xảy ra khi cập nhật.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi gửi dữ liệu cập nhật.');
            });
        });
    </script>
    <?php
    return ob_get_clean();
}


