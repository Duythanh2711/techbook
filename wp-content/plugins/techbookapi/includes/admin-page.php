<?php
function techbookapi_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'techbookapi_items';

    ?>
    <div class="hte-api-wrapper">
        <h1>TechBook API Settings</h1>

        <form method="post" action="options.php">
            <?php settings_fields('techbookapi_options_group'); ?>
            <?php do_settings_sections('techbookapi'); ?>
            
            <!-- Input chung cho TokenKey -->
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Token Key:</th>
                    <td><input type="text" name="techbookapi_token_key" value="<?php echo esc_attr(get_option('techbookapi_token_key')); ?>" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>

        <h2>Add New Item</h2>
        <form method="post" action="">
            <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 30px;">
                <input type="text" name="name" placeholder="Item Name" required>
                <br><br>
                <input type="text" name="api_url" placeholder="API URL" required>
                <br><br>
                <textarea name="input_body" placeholder="Input BODY (JSON or other format)" rows="10" cols="50"></textarea>
                <br><br>
                <input type="submit" name="techbookapi_add_item" value="Add Item" class="button button-primary">
            </div>
        </form>

        <h2>Existing Items</h2>

        <?php
        // Hiển thị danh sách các item hiện có
        $items = $wpdb->get_results("SELECT * FROM $table_name");
        foreach ($items as $item) { ?>
            <form method="post" action="" style="border: 1px solid #ccc; padding: 20px; margin-bottom: 30px;">
                <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                
                <label for="name">Item Name:</label><br>
                <input type="text" name="name" value="<?php echo esc_attr($item->name); ?>" required>
                <br><br>

                <label for="api_url">API URL:</label><br>
                <input type="text" name="api_url" value="<?php echo esc_attr($item->api_url); ?>" required>
                <br><br>

                <label for="input_body">Input BODY (JSON or other format):</label><br>
                <textarea name="input_body" rows="10" cols="50"><?php echo((wp_unslash($item->api_params))); ?></textarea>
                <br><br>

                <input type="submit" name="techbookapi_update_item" value="Update Item" class="button button-primary">
                <input type="submit" name="techbookapi_sync_products" value="Sync to Database" class="button button-primary">
                <input type="submit" name="techbookapi_delete_item" value="Delete Item" class="button button-secondary" onclick="return confirm('Are you sure you want to delete this item?');">
            </form>
        <?php } ?>

    </div>

    <?php
    // Xử lý thêm mới item
    if (isset($_POST['techbookapi_add_item'])) {
        techbookapi_add_item($_POST['name'], $_POST['api_url'], $_POST['input_body']);
        echo '<div class="updated"><p>Item added successfully!</p></div>';
        echo '<meta http-equiv="refresh" content="0">'; // Refresh page để hiển thị item mới
    }

    // Xử lý cập nhật item
    if (isset($_POST['techbookapi_update_item'])) {
        techbookapi_update_item($_POST['item_id'], $_POST['name'], $_POST['api_url'], $_POST['input_body']);
        echo '<div class="updated"><p>Item updated successfully!</p></div>';
        echo '<meta http-equiv="refresh" content="0">'; // Refresh page để hiển thị cập nhật
    }

    // Xử lý sync dữ liệu từ API vào DB
    if (isset($_POST['techbookapi_sync_products'])) {
        if (techbookapi_sync_products($_POST['api_url'], $_POST['input_body'])) {
            echo '<div class="updated"><p>Data synced successfully!</p></div>';
        } else {
            echo '<div class="error"><p>Failed to sync data from API.</p></div>';
        }
    }

    // Xử lý xóa item
    if (isset($_POST['techbookapi_delete_item'])) {
        techbookapi_delete_item($_POST['item_id']);
        echo '<div class="updated"><p>Item deleted successfully!</p></div>';
        echo '<meta http-equiv="refresh" content="0">'; // Refresh page để hiển thị sau khi xóa
    }
}
?>
