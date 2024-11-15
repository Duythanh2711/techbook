<?php


function custom_wpcf7_success_message_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('.wpcf7-form');

        form.addEventListener('wpcf7mailsent', function() {
            setTimeout(function() {
                var successMessage = form.querySelector('.wpcf7-response-output');
                if (successMessage) {
                    
                    successMessage.style.display = 'block'; 
                    successMessage.style.opacity = '1';

                    // Bắt đầu ẩn thông báo sau 3 giây
                    successMessage.style.transition = 'opacity 1s ease-in-out';
                    setTimeout(function() {
                        successMessage.style.opacity = '0';
                        setTimeout(function() {
                            successMessage.style.display = 'none';
                        }, 1000);
                    }, 3000); 
                }
            }, 0);
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'custom_wpcf7_success_message_script');

add_filter('wpcf7_validate_text*', 'custom_cf7_email_validation', 20, 2);
function custom_cf7_email_validation($result, $tag) {
    // Chỉ kiểm tra khi người dùng nhấn nút gửi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tag = new WPCF7_FormTag($tag);
        $name = $tag->name;

        // Kiểm tra cho trường email 'email-179'
        if ($name == 'your-email' || $name == 'email-179') {
            $emailValue = isset($_POST[$name]) ? trim($_POST[$name]) : '';
			// Nếu trường email để trống
            if (empty($emailValue)) {
                $result->invalidate($tag, "This field cannot be left blank.");
            }

            // Kiểm tra định dạng email cơ bản
            if (!is_email($emailValue)) {
                $result->invalidate($tag, "Please enter a valid email address.");
            }

            // Kiểm tra dấu '-' ở bất kỳ đâu hoặc dấu '.' ở đầu hoặc cuối
            if (strpos($emailValue, '-') !== false || strpos($emailValue, '.') === 0 || substr($emailValue, -1) === '.') {
                $result->invalidate($tag, "Please enter a valid email address.");
            }

            // Kiểm tra các ký tự đặc biệt khác ngoài dấu '.'
            if (preg_match('/[^a-zA-Z0-9.@]/', $emailValue)) {
                $result->invalidate($tag, "Please enter a valid email address.");
            }
        }
    }

    return $result;
}
