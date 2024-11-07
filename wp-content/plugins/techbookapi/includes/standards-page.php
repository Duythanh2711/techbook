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
    $tokenKey = get_api_token();

    // API URLs
    $url = get_api_base_url() . '/Standards/GetPaging';
    $url_update = get_api_base_url() . '/Standards/Update';

    // Prepare the request body for fetching standard details
    $body = json_encode([
        "tokenKey" => $tokenKey,
        "pageIndex" => 1,
        "pageSize" => 1,
        "item" => [
            "id" => $id
        ]
    ]);

    // Fetch standard details from the API
    $response = wp_remote_post($url, [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ]);

    // Handle API errors
    if (is_wp_error($response)) {
        return 'Có lỗi xảy ra khi lấy dữ liệu.';
    }

    // Parse the JSON response
    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Check if data exists and get the first item
    if (!isset($data['data']['items'][0])) {
        return 'Không tìm thấy dữ liệu.';
    }

    $item = $data['data']['items'][0]; // Lấy phần tử đầu tiên từ `items`

    // Display the update form
    ob_start();
    ?>
    <style>
        #updateStandardForm h1 {
            text-align: center;
            color: #333;
        }
        form#updateStandardForm {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        #updateStandardForm div {
            margin-bottom: 15px;
        }
        #updateStandardForm label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        #updateStandardForm input[type="text"],
        #updateStandardForm textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #updateStandardForm button {
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
        #updateStandardForm button:hover {
            background-color: #218838;
        }
    </style>

    <h1>Chi tiết Tiêu chuẩn</h1>
    <form id="updateStandardForm">
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo esc_attr($item['id'] ?? ''); ?>">
        </div>
        <div>
            <label for="idProduct">ID Product:</label>
            <input type="text" id="idProduct" name="idProduct" value="<?php echo esc_attr($item['idProduct'] ?? ''); ?>">
        </div>
        <div>
            <label for="referenceNumber">Reference Number:</label>
            <input type="text" id="referenceNumber" name="referenceNumber" value="<?php echo esc_attr($item['referenceNumber'] ?? ''); ?>">
        </div>
        <div>
            <label for="standardTitle">Standard Title:</label>
            <input type="text" id="standardTitle" name="standardTitle" value="<?php echo esc_attr($item['standardTitle'] ?? ''); ?>">
        </div>
        <div>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="<?php echo esc_attr($item['status'] ?? ''); ?>">
        </div>
        <div>
            <label for="referencedStandards">Referenced Standards:</label>
            <input type="text" id="referencedStandards" name="referencedStandards" value="<?php echo esc_attr($item['referencedStandards'] ?? ''); ?>">
        </div>
        <div>
            <label for="referencingStandards">Referencing Standards:</label>
            <input type="text" id="referencingStandards" name="referencingStandards" value="<?php echo esc_attr($item['referencingStandards'] ?? ''); ?>">
        </div>
        <div>
            <label for="equivalentStandards">Equivalent Standards:</label>
            <input type="text" id="equivalentStandards" name="equivalentStandards" value="<?php echo esc_attr($item['equivalentStandards'] ?? ''); ?>">
        </div>
        <div>
            <label for="replace">Replace:</label>
            <input type="text" id="replace" name="replace" value="<?php echo esc_attr($item['replace'] ?? ''); ?>">
        </div>
        <div>
            <label for="repalcedBy">Replaced By:</label>
            <input type="text" id="repalcedBy" name="repalcedBy" value="<?php echo esc_attr($item['repalcedBy'] ?? ''); ?>">
        </div>
        <div>
            <label for="standardby">Standard By:</label>
            <input type="text" id="standardby" name="standardby" value="<?php echo esc_attr($item['standardby'] ?? ''); ?>">
        </div>
        <div>
            <label for="languages">Languages:</label>
            <input type="text" id="languages" name="languages" value="<?php echo esc_attr($item['languages'] ?? ''); ?>">
        </div>
        <div>
            <label for="fullDescription">Full Description:</label>
            <textarea id="fullDescription" name="fullDescription"><?php echo esc_textarea($item['fullDescription'] ?? ''); ?></textarea>
        </div>
        <div>
            <label for="ebookPrice">Ebook Price:</label>
            <input type="text" id="ebookPrice" name="ebookPrice" value="<?php echo esc_attr($item['ebookPrice'] ?? ''); ?>">
        </div>
        <div>
            <label for="printPrice">Print Price:</label>
            <input type="text" id="printPrice" name="printPrice" value="<?php echo esc_attr($item['printPrice'] ?? ''); ?>">
        </div>
        <div>
            <label for="bothPrice">Both Price:</label>
            <input type="text" id="bothPrice" name="bothPrice" value="<?php echo esc_attr($item['bothPrice'] ?? ''); ?>">
        </div>
        <div>
            <label for="currency">Currency:</label>
            <input type="text" id="currency" name="currency" value="<?php echo esc_attr($item['currency'] ?? ''); ?>">
        </div>
        <div>
            <label for="historicalEditions">Historical Editions:</label>
            <input type="text" id="historicalEditions" name="historicalEditions" value="<?php echo esc_attr($item['historicalEditions'] ?? ''); ?>">
        </div>
        <div>
            <label for="documentHistoryProductId">Document History Product ID:</label>
            <input type="text" id="documentHistoryProductId" name="documentHistoryProductId" value="<?php echo esc_attr($item['documentHistoryProductId'] ?? ''); ?>">
        </div>
        <div>
            <label for="icsCode">ICS Code:</label>
            <input type="text" id="icsCode" name="icsCode" value="<?php echo esc_attr($item['icsCode'] ?? ''); ?>">
        </div>
        <div>
            <label for="keyword">Keyword:</label>
            <input type="text" id="keyword" name="keyword" value="<?php echo esc_attr($item['keyword'] ?? ''); ?>">
        </div>
        <div>
            <label for="identicalStandards">Identical Standards:</label>
            <input type="text" id="identicalStandards" name="identicalStandards" value="<?php echo esc_attr($item['identicalStandards'] ?? ''); ?>">
        </div>
        <div>
            <label for="publishedDate">Published Date:</label>
            <input type="text" id="publishedDate" name="publishedDate" value="<?php echo esc_attr($item['publishedDate'] ?? ''); ?>">
        </div>
        <div>
            <label for="pages">Pages:</label>
            <input type="text" id="pages" name="pages" value="<?php echo esc_attr($item['pages'] ?? ''); ?>">
        </div>
        <div>
            <label for="byTechnology">By Technology:</label>
            <input type="text" id="byTechnology" name="byTechnology" value="<?php echo esc_attr($item['byTechnology'] ?? ''); ?>">
        </div>
        <div>
            <label for="byIndustry">By Industry:</label>
            <input type="text" id="byIndustry" name="byIndustry" value="<?php echo esc_attr($item['byIndustry'] ?? ''); ?>">
        </div>
        <div>
            <label for="previewPath">Preview Path:</label>
            <input type="text" id="previewPath" name="previewPath" value="<?php echo esc_attr($item['previewPath'] ?? ''); ?>">
        </div>
        <div>
            <label for="coverPath">Cover Path:</label>
            <input type="text" id="coverPath" name="coverPath" value="<?php echo esc_attr($item['coverPath'] ?? ''); ?>">
        </div>
        <div>
            <label for="fullPath">Full Path:</label>
            <input type="text" id="fullPath" name="fullPath" value="<?php echo esc_attr($item['fullPath'] ?? ''); ?>">
        </div>

        <button type="button" id="updateButton">Cập nhật</button>
    </form>

    <script>
        document.getElementById('updateButton').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('updateStandardForm'));
            const data = {
                tokenKey: '<?php echo $tokenKey; ?>',
                item: {
                    id: formData.get('id'),
                    idProduct: formData.get('idProduct'),
                    referenceNumber: formData.get('referenceNumber'),
                    standardTitle: formData.get('standardTitle'),
                    status: formData.get('status'),
                    referencedStandards: formData.get('referencedStandards'),
                    referencingStandards: formData.get('referencingStandards'),
                    equivalentStandards: formData.get('equivalentStandards'),
                    replace: formData.get('replace'),
                    repalcedBy: formData.get('repalcedBy'),
                    standardby: formData.get('standardby'),
                    languages: formData.get('languages'),
                    fullDescription: formData.get('fullDescription'),
                    ebookPrice: formData.get('ebookPrice'),
                    printPrice: formData.get('printPrice'),
                    bothPrice: formData.get('bothPrice'),
                    currency: formData.get('currency'),
                    historicalEditions: formData.get('historicalEditions'),
                    documentHistoryProductId: formData.get('documentHistoryProductId'),
                    icsCode: formData.get('icsCode'),
                    keyword: formData.get('keyword'),
                    identicalStandards: formData.get('identicalStandards'),
                    publishedDate: formData.get('publishedDate'),
                    pages: formData.get('pages'),
                    byTechnology: formData.get('byTechnology'),
                    byIndustry: formData.get('byIndustry'),
                    previewPath: formData.get('previewPath'),
                    coverPath: formData.get('coverPath'),
                    fullPath: formData.get('fullPath')
                }
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
                    alert('Cập nhật tiêu chuẩn thành công!');
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


