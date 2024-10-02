<?php

function techbook_books_page() {
    // Xử lý hiển thị chi tiết khi nhấn vào title
if (isset($_GET['item_id'])) {
    function hte_books_detail_page($id) {
        $url = 'https://115.84.178.66:8028/api/Documents/GetById';
        $url_update = 'https://115.84.178.66:8028/api/Documents/Update';
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
                "id" => $id,
                "title" => "string",
                "author" => "string",
                "edition" => "string",
                "documentStatus" => "string",
                "publicationDate" => "string",
                "publisher" => "string",
                "doi" => "string",
                "page" => 0,
                "isbn" => "string",
                "subjectsCode" => "string",
                "subjects" => "string",
                "abstract" => "string",
                "keywords" => "string",
                "pricePrint" => 0,
                "priceeBook" => 0,
                "previewPath" => "string",
                "fullContentBookPath" => "string",
                "createdDate" => date('Y-m-d\TH:i:s\Z'),
                "updatedDate" => date('Y-m-d\TH:i:s\Z'),
                "deleted" => true,
                "newArrival" => true,
                "bestSellers" => true,
                "isFree" => true,
                "totalRows" => 0
            ]
        ]);
    
        $response = wp_remote_post($url, [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    
        if (is_wp_error($response)) {
            return 'Failed to retrieve data';
        }
    
        $data = json_decode(wp_remote_retrieve_body($response), true);
        if (!isset($data['data'])) {
            return 'No data found';
        }
    
        $item = $data['data'];
    
        // Hiển thị thông tin chi tiết dưới dạng input
        ob_start();
        ?>
        <style>

        #updateBookForm h1 {
            text-align: center;
            color: #333;
        }
        form#updateBookForm {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        #updateBookForm div {
            margin-bottom: 15px;
        }
        #updateBookForm label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        #updateBookForm input[type="text"],
        #updateBookForm input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #updateBookForm input[type="checkbox"] {
            margin-right: 10px;
        }
        #updateBookForm button {
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
        #updateBookForm button:hover {
            background-color: #218838;
        }
        #updateBookForm .checkbox-group {
            display: flex;
            align-items: center;
        }
    </style>

    <h1>Book Details</h1>
    <form id="updateBookForm">
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo esc_attr($item['id']); ?>">
        </div>
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo esc_attr($item['title']); ?>" required>
        </div>
        <div>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo esc_attr($item['author']); ?>" required>
        </div>
        <div>
            <label for="edition">Edition:</label>
            <input type="text" id="edition" name="edition" value="<?php echo esc_attr($item['edition']); ?>" required>
        </div>
        <div>
            <label for="documentStatus">Document Status:</label>
            <input type="text" id="documentStatus" name="documentStatus" value="<?php echo esc_attr($item['documentStatus']); ?>" required>
        </div>
        <div>
            <label for="publicationDate">Publication Date:</label>
            <input type="text" id="publicationDate" name="publicationDate" value="<?php echo esc_attr($item['publicationDate']); ?>" required>
        </div>
        <div>
            <label for="publisher">Publisher:</label>
            <input type="text" id="publisher" name="publisher" value="<?php echo esc_attr($item['publisher']); ?>" required>
        </div>
        <div>
            <label for="doi">DOI:</label>
            <input type="text" id="doi" name="doi" value="<?php echo esc_attr($item['doi']); ?>" required>
        </div>
        <div>
            <label for="page">Page:</label>
            <input type="number" id="page" name="page" value="<?php echo esc_attr($item['page']); ?>" required>
        </div>
        <div>
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo esc_attr($item['isbn']); ?>" required>
        </div>
        <div>
            <label for="subjectsCode">Subjects Code:</label>
            <input type="text" id="subjectsCode" name="subjectsCode" value="<?php echo esc_attr($item['subjectsCode']); ?>" required>
        </div>
        <div>
            <label for="subjects">Subjects:</label>
            <input type="text" id="subjects" name="subjects" value="<?php echo esc_attr($item['subjects']); ?>" required>
        </div>
        <div>
            <label for="abstract">Abstract:</label>
            <input type="text" id="abstract" name="abstract" value="<?php echo esc_attr($item['abstract']); ?>" required>
        </div>
        <div>
            <label for="keywords">Keywords:</label>
            <input type="text" id="keywords" name="keywords" value="<?php echo esc_attr($item['keywords']); ?>" required>
        </div>
        <div>
            <label for="pricePrint">Price (Print):</label>
            <input type="number" id="pricePrint" name="pricePrint" value="<?php echo esc_attr($item['pricePrint']); ?>" required>
        </div>
        <div>
            <label for="priceeBook">Price (eBook):</label>
            <input type="number" id="priceeBook" name="priceeBook" value="<?php echo esc_attr($item['priceeBook']); ?>" required>
        </div>
        <div>
            <label for="previewPath">Preview Path:</label>
            <input type="text" id="previewPath" name="previewPath" value="<?php echo esc_attr($item['previewPath']); ?>" required>
        </div>
        <div>
            <label for="fullContentBookPath">Full Content Path:</label>
            <input type="text" id="fullContentBookPath" name="fullContentBookPath" value="<?php echo esc_attr($item['fullContentBookPath']); ?>" required>
        </div>
        <div class="checkbox-group">
            <label for="deleted">Deleted:</label>
            <input type="checkbox" id="deleted" name="deleted" <?php checked($item['deleted']); ?>>
        </div>
        <div class="checkbox-group">
            <label for="newArrival">New Arrival:</label>
            <input type="checkbox" id="newArrival" name="newArrival" <?php checked($item['newArrival']); ?>>
        </div>
        <div class="checkbox-group">
            <label for="bestSellers">Best Sellers:</label>
            <input type="checkbox" id="bestSellers" name="bestSellers" <?php checked($item['bestSellers']); ?>>
        </div>
        <div class="checkbox-group">
            <label for="isFree">Is Free:</label>
            <input type="checkbox" id="isFree" name="isFree" <?php checked($item['isFree']); ?>>
        </div>
        <button type="button" id="updateButton">Update</button>
    </form>
    
    <script>
        document.getElementById('updateButton').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('updateBookForm'));
            const data = {
                id: 'string',
                tokenKey: '4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7',
                intValue: 0,
                boolValue: true,
                stringValue: 'string',
                pageIndex: 0,
                pageSize: 0,
                keyword: 'string',
                item: {
                    id: parseInt(formData.get('id')),
                    title: formData.get('title'),
                    author: formData.get('author'),
                    edition: formData.get('edition'),
                    documentStatus: formData.get('documentStatus'),
                    publicationDate: formData.get('publicationDate'),
                    publisher: formData.get('publisher'),
                    doi: formData.get('doi'),
                    page: parseInt(formData.get('page')),
                    isbn: formData.get('isbn'),
                    subjectsCode: formData.get('subjectsCode'),
                    subjects: formData.get('subjects'),
                    abstract: formData.get('abstract'),
                    keywords: formData.get('keywords'),
                    pricePrint: parseFloat(formData.get('pricePrint')),
                    priceeBook: parseFloat(formData.get('priceeBook')),
                    previewPath: formData.get('previewPath'),
                    fullContentBookPath: formData.get('fullContentBookPath'),
                    createdDate: new Date().toISOString(),
                    updatedDate: new Date().toISOString(),
                    deleted: formData.get('deleted') === 'on',
                    newArrival: formData.get('newArrival') === 'on',
                    bestSellers: formData.get('bestSellers') === 'on',
                    isFree: formData.get('isFree') === 'on',
                    totalRows: 0
                }
            };
            console.log('data:', data);

            fetch('<?php echo esc_url($url_update); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                if(data.code == 200 || data.code == 201){
                    alert('Book updated successfully!');
                    window.location.reload();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Error updating book.');
            });
        });
    </script>
        <?php
        return ob_get_clean();
    }
    
    
    echo hte_books_detail_page(intval($_GET['item_id']));
    return;
}

    // Số trang hiện tại
    $pageIndex = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

    // Gọi API lấy dữ liệu
    $api_url = 'https://115.84.178.66:8028/api/Documents/GetPaging';
    $body = json_encode(array(
        "id" => "string",
        "tokenKey" => "4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7",
        "intValue" => 0,
        "boolValue" => true,
        "stringValue" => "string",
        "pageIndex" => $pageIndex,
        "pageSize" => 50,
        "keyword" => "",
        "item" => array(
            "id" => 0,
            "title" => "string",
            "author" => "string",
            "edition" => "string",
            "documentStatus" => "string",
            "publicationDate" => "string",
            "publisher" => "string",
            "doi" => "string",
            "page" => 0,
            "isbn" => "string",
            "subjectsCode" => "string",
            "subjects" => "string",
            "abstract" => "string",
            "keywords" => "string",
            "pricePrint" => 0,
            "priceeBook" => 0,
            "previewPath" => "string",
            "fullContentBookPath" => "string",
            "createdDate" => "2024-09-24T03:01:25.160Z",
            "updatedDate" => "2024-09-24T03:01:25.160Z",
            "deleted" => true,
            "newArrival" => true,
            "bestSellers" => true,
            "isFree" => true,
            "totalRows" => 0
        )
    ));

    // Sử dụng wp_remote_post để gọi API
    $response = wp_remote_post($api_url, array(
        'method'    => 'POST',
        'body'      => $body,
        'headers'   => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        echo 'Something went wrong: ' . $response->get_error_message();
        return;
    }

    $data = json_decode(wp_remote_retrieve_body($response));

    if (!isset($data->data->items)) {
        echo 'No items found.';
        return;
    }
    if (!empty($data->data->items)) {
        // Lưu dữ liệu từ API vào bảng tecbook_books_cache
        hte_save_books_to_cache((array)$data->data->items);
    }

    // Hiển thị bảng dữ liệu
    $items = $data->data->items;
    $totalRows = $data->data->totalRows;
    $pageSize = 50;
    $totalPages = ceil($totalRows / $pageSize);

    ?>
    <div class="wrap">
        <h1>Book List</h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Publisher</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo esc_html($item->id); ?></td>
                    <td><a href="?page=techbook_books_page&item_id=<?php echo esc_html($item->id); ?>"><?php echo esc_html($item->title); ?></a></td>
                    <td><?php echo esc_html($item->publisher); ?></td>
                    <td><?php echo esc_html($item->isbn); ?></td>
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
                    $big = 999999999; // cần số lớn để phân trang hoạt động
                    echo paginate_links(array(
                        'base'    => str_replace($big, '%#%', (admin_url('admin.php?page=techbook_books_page&paged=%#%'))),
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
