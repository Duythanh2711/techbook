<?php 

function techbook_subjects_page() {
    // Check if 'item_id' is set, redirect to the detail page
    if (isset($_GET['item_id'])) {
        echo hte_subject_detail_page(intval($_GET['item_id']));
        return;
    }

    // Current page index and size
    $pageIndex = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
    $pageSize = 10;

    $tokenKey = get_api_token();

    // Correct URL for fetching paginated data
    $api_url = 'https://115.84.178.66:8028/api/SubjectType/GetAll';
    $body = json_encode(array(
        "id" => "string",
        "tokenKey" => $tokenKey,
        "intValue" => 0,
        "boolValue" => true,
        "stringValue" => "string",
        "pageIndex" => $pageIndex, // Dynamic page index
        "pageSize" => $pageSize,   // Dynamic page size
        "keyword" => "string",
        "orderBy" => "string",
        "orderWay" => "string",
        "item" => array(
            "id" => 0,
            "code" => "string",
            "subjects" => "string",
            "notes" => "string"
        )
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

    // Updated: Use the correct data structure
    if (!isset($data->data) || empty($data->data)) {
        echo 'Không có dữ liệu nào được tìm thấy.';
        return;
    }

    // Save data to the database if needed
    if (!empty($data->data)) {
        hte_save_subjects_to_cache($data->data); // Call function to save data
    }

    $items = $data->data; // Updated to match API structure
    $totalRows = count($items); // Manually count since we don't get totalRows in the API response
    $totalPages = ceil($totalRows / $pageSize);

    ?>
    <div class="wrap">
        <h1>Danh sách Subjects</h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Subjects</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo esc_html($item->id); ?></td>
                    <td><a href="?page=techbook_subjects_page&item_id=<?php echo esc_html($item->id); ?>"><?php echo esc_html($item->code); ?></a></td>
                    <td><?php echo esc_html($item->subjects); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Pagination
        if ($totalPages > 1): ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    $big = 999999999; // Large number to make pagination work
                    echo paginate_links(array(
                        'base'    => str_replace($big, '%#%', (admin_url('admin.php?page=techbook_subjects_page&paged=%#%'))),
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




function hte_subject_detail_page($id) {
    $tokenKey = get_api_token();

    // URL API GetById
    $url = 'https://115.84.178.66:8028/api/SubjectType/GetById';
    $url_update = get_api_base_url() . '/SubjectType/Update';

    // Prepare JSON data for API request
    $body = json_encode([
        "id" => "string",
        "tokenKey" => $tokenKey,
        "intValue" => 0,
        "boolValue" => true,
        "stringValue" => "string",
        "pageIndex" => 0,
        "pageSize" => 0,
        "keyword" => "string",
        "orderBy" => "string",
        "orderWay" => "string",
        "item" => [
            "id" => $id, // The actual subject ID
            "code" => "",
            "subjects" => "",
            "notes" => ""
        ]
    ]);

    // Call API to get details
    $response = wp_remote_post($url, [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ]);

    if (is_wp_error($response)) {
        return 'Có lỗi xảy ra khi lấy dữ liệu.';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (!isset($data['data'])) {
        return 'Không tìm thấy dữ liệu.';
    }

    // Retrieve the detailed data
    $item = $data['data'];

    // Display the update form
    ob_start();
    ?>
    <style>
        #updateSubjectForm h1 {
            text-align: center;
            color: #333;
        }
        form#updateSubjectForm {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        #updateSubjectForm div {
            margin-bottom: 15px;
        }
        #updateSubjectForm label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        #updateSubjectForm input[type="text"],
        #updateSubjectForm textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #updateSubjectForm button {
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
        #updateSubjectForm button:hover {
            background-color: #218838;
        }
    </style>

    <h1>Chi tiết Subject</h1>
    <form id="updateSubjectForm">
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo esc_attr($item['id']); ?>">
        </div>
        <div>
            <label for="code">Code:</label>
            <input type="text" id="code" name="code" value="<?php echo esc_attr($item['code']); ?>" required>
        </div>
        <div>
            <label for="subjects">Subjects:</label>
            <input type="text" id="subjects" name="subjects" value="<?php echo esc_attr($item['subjects']); ?>" required>
        </div>
        <div>
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" required><?php echo esc_textarea($item['notes']); ?></textarea>
        </div>

        <button type="button" id="updateButton">Cập nhật</button>
    </form>

    <script>
        document.getElementById('updateButton').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('updateSubjectForm'));
            const data = {
                id: formData.get('id'),
                tokenKey: '<?php echo esc_js($tokenKey); ?>',
                code: formData.get('code'),
                subjects: formData.get('subjects'),
                notes: formData.get('notes')
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
                    alert('Cập nhật Subject thành công!');
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
