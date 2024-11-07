<?php
function techbook_orders_page() {
    global $wpdb;

    wp_enqueue_style('techbook-order-style', plugin_dir_url(__FILE__) . 'assets/order-style.css');


    // Check if an order ID is provided to display order details
    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);
        $table_name = $wpdb->prefix . 'techbook_order';

        // Retrieve the specific order
        $order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $order_id));

        if ($order) {
            ?>
            <div class="wrap">
                <h1>Order Details</h1>
                <table class="form-table">
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo esc_html($order->full_name); ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?php echo esc_html($order->phone_number); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo esc_html($order->email); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo esc_html($order->address); ?></td>
                    </tr>
                    <tr>
                        <th>Note</th>
                        <td><?php echo esc_html($order->note); ?></td>
                    </tr>
                    <tr>
                        <th>Products</th>
                        <td>
                            <?php
                            $products = json_decode($order->products, true);
                            if ($products) {
                                echo '<ul>';
                                foreach ($products as $product) {
                                    echo '<li>';
                                    echo esc_html($product['product_name']) . ' x ' . intval($product['quantity']);
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Total Amount</th>
                        <td><?php echo esc_html($order->total_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td><?php echo esc_html($order->order_status); ?></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td><?php echo esc_html($order->created_at); ?></td>
                    </tr>
                </table>
                <p><a href="<?php echo admin_url('admin.php?page=techbook_orders_page'); ?>" class="button">Back to Orders</a></p>
            </div>
            <?php
        } else {
            echo '<div class="wrap"><h1>Order not found</h1></div>';
        }
    } else {
        // Display the list of orders with pagination
        $table_name = $wpdb->prefix . 'techbook_order';
        $items_per_page = 10;
        $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($current_page - 1) * $items_per_page;

        // Get total number of orders
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

        // Retrieve orders for the current page
        $orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT %d OFFSET %d", $items_per_page, $offset));

        ?>
        <div class="wrap">
    <h1>Orders</h1>
    <div class="table-container">
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Products</th> <!-- New Products Column -->
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo esc_html($order->id); ?></td>
                        <td><?php echo esc_html($order->full_name); ?></td>
                        <td><?php echo esc_html($order->phone_number); ?></td>
                        <td><?php echo esc_html($order->email); ?></td>
                        <td class="product-cell">
                            <ul class="product-list">
                                <?php
                                $products = json_decode($order->products, true);
                                if ($products) {
                                    foreach ($products as $product) {
                                        echo '<li>' . esc_html($product['product_name']) . ' - SL: ' . intval($product['quantity']) . '</li>';
                                    }
                                } else {
                                    echo '<li>No products found.</li>';
                                }
                                ?>
                            </ul>
                        </td>
                        <td><?php echo esc_html($order->total_amount); ?></td>
                        <td><?php echo esc_html($order->order_status); ?></td>
                        <td><?php echo esc_html($order->created_at); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=techbook_orders_page&order_id=' . $order->id); ?>" class="button">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9">No orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

    <?php
        // Display pagination if necessary
        $total_pages = ceil($total_items / $items_per_page);

        if ($total_pages > 1) {
            $page_links = paginate_links(array(
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => $total_pages,
                'current' => $current_page,
                'type' => 'array', // This outputs the links as an array
            ));

            if ($page_links) {
                echo '<div class="techbook-pagination"><ul class="pagination-list">';
                foreach ($page_links as $link) {
                    echo '<li class="pagination-item">' . $link . '</li>';
                }
                echo '</ul></div>';
            }
        }
    ?>
</div>

        <?php
    }
}
