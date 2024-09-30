<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.1.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Admin notice
if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}


//kết nối js
function enqueue_custom_dropdown_script() {
    $appPath = get_template_directory_uri(); 

    wp_enqueue_script('custom-dropdown', $appPath . '/assets/js/custom-dropdown.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_dropdown_script');


// code đoạn đăng nhập đăng kí
// Xử lý form đăng nhập
function handle_custom_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log']) && isset($_POST['pwd'])) {
        $user_login = sanitize_text_field($_POST['log']);
        $user_password = $_POST['pwd'];
        $remember_me = isset($_POST['rememberme']) ? true : false;

        $creds = array(
            'user_login'    => $user_login,
            'user_password' => $user_password,
            'remember'      => $remember_me,
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            set_transient('login_failed', true, 60);
            set_transient('login_error', $user->get_error_message(), 60);

            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        } else {
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('init', 'handle_custom_login');

// Xử lý form đăng ký
function handle_custom_registration() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_username']) && isset($_POST['reg_email']) && isset($_POST['reg_password'])) {
        $reg_username = sanitize_user($_POST['reg_username']);
        $reg_email = sanitize_email($_POST['reg_email']);
        $reg_password = $_POST['reg_password'];

        $registration_failed = false;
        $registration_error = '';

        if (empty($reg_username) || empty($reg_email) || empty($reg_password)) {
            $registration_error = 'Vui lòng điền đầy đủ các trường.';
            $registration_failed = true;
        } else {
            if (username_exists($reg_username)) {
                $registration_error = 'Tên người dùng đã tồn tại.';
                $registration_failed = true;
            } elseif (email_exists($reg_email)) {
                $registration_error = 'Email đã tồn tại.';
                $registration_failed = true;
            } else {
                $user_id = wp_create_user($reg_username, $reg_password, $reg_email);
                if (is_wp_error($user_id)) {
                    $registration_error = $user_id->get_error_message();
                    $registration_failed = true;
                } else {
                    // Đăng ký thành công
                    set_transient('registration_successful', true, 60);

                    wp_redirect($_SERVER['REQUEST_URI']);
                    exit;
                }
            }
        }

        if ($registration_failed) {
            set_transient('registration_failed', true, 60);
            set_transient('registration_error', $registration_error, 60);

            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }
    }
}
add_action('init', 'handle_custom_registration');

// Xử lý khôi phục mật khẩu
function handle_custom_password_reset() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_email'])) {
        if (!isset($_POST['password_reset_nonce_field']) || !wp_verify_nonce($_POST['password_reset_nonce_field'], 'password_reset_nonce')) {
            // Nonce không hợp lệ
            $password_reset_error = 'Security check failed. Please try again.';
            set_transient('password_reset_failed', true, 60);
            set_transient('password_reset_error', $password_reset_error, 60);
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }

        $reset_email = sanitize_email($_POST['reset_email']);
        $password_reset_failed = false;
        $password_reset_error = '';
        $password_reset_successful = false;

        if (empty($reset_email)) {
            $password_reset_error = 'Vui lòng nhập địa chỉ email của bạn.';
            $password_reset_failed = true;
        } elseif (!email_exists($reset_email)) {
            $password_reset_error = 'Không tìm thấy người dùng với địa chỉ email này.';
            $password_reset_failed = true;
        } else {
            $user = get_user_by('email', $reset_email);
            $reset_key = get_password_reset_key($user);

            if (is_wp_error($reset_key)) {
                $password_reset_error = 'Đã xảy ra lỗi khi tạo liên kết đặt lại mật khẩu.';
                $password_reset_failed = true;
            } else {
                $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');

                $message = "Ai đó đã yêu cầu đặt lại mật khẩu cho tài khoản sau:\n\n";
                $message .= 'Tên trang web: ' . get_bloginfo('name') . "\n\n";
                $message .= 'Tên đăng nhập: ' . $user->user_login . "\n\n";
                $message .= "Nếu đây là một nhầm lẫn, hãy bỏ qua email này và không có gì xảy ra.\n\n";
                $message .= "Để đặt lại mật khẩu của bạn, hãy truy cập liên kết sau:\n\n";
                $message .= $reset_url . "\n";

                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

                $title = sprintf('[%s] Đặt lại mật khẩu', $blogname);

                if (!wp_mail($reset_email, $title, $message)) {
                    $password_reset_error = 'Không thể gửi email đặt lại mật khẩu.';
                    $password_reset_failed = true;
                } else {
                    $password_reset_successful = true;
                }
            }
        }

        if ($password_reset_failed) {
            set_transient('password_reset_failed', true, 60);
            set_transient('password_reset_error', $password_reset_error, 60);
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }

        if ($password_reset_successful) {
            set_transient('password_reset_successful', true, 60);
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }
    }
}
add_action('init', 'handle_custom_password_reset');


//tách trang all_publisher
function enqueue_all_publisher_scripts() {
    $organizations = get_organizations();
    $total_organizations = count($organizations);
    $max_pages = ceil($total_organizations / 10);

    wp_enqueue_script(
        'all-publisher-script', 
        get_template_directory_uri() . '/template-parts/techbook/all_publisher/all_publisher.js', 
        array('jquery'), 
        '1.0', 
        true 
    );

    wp_localize_script(
        'all-publisher-script',
        'my_ajax_object', 
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'max_pages' => $max_pages
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_all_publisher_scripts');


add_action('wp_ajax_load_more_products', 'load_more_products_callback');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products_callback');

function load_more_products_callback() {
    $page = intval($_POST['page']);
    $offset = ($page - 1) * 10;
    $organizations = get_organizations();
    $organizations = array_slice($organizations, $offset, 10);

    foreach($organizations as $organization) {
        include get_template_directory() . '/template-parts/techbook/product-list/product-list-publisher1.php';
    }

    wp_die();
}


include 'techbook_header.php';
include 'techbook_footer.php';
include 'techbook_data.php';


// Shortcode cho Tabs và Accordion
function tabs_with_accordion_shortcode() {
    ob_start();
    ?>
    <div class="tabs-container">
        <ul class="tab-list">
            <li class="active"><a href="#faqs">FAQs</a></li>
            <li><a href="#return-policy">Return Policy</a></li>
            <li><a href="#buying-guide">Buying Guide</a></li>
        </ul>

        <!-- Tab Nội Dung -->
        <div class="tab-content">
            <!-- FAQs Tab -->
            <div id="faqs" class="tab active">
                <h3>Shopping</h3>
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">Tôi có thể hủy đơn hàng không?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Tôi có thể thay đổi thông tin số điện thoại/địa chỉ nhận hàng sau khi đã đặt hàng không?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>Nội dung trả lời cho câu hỏi này...</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Tôi cần chờ bao lâu để nhận được đơn hàng?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>Nội dung trả lời cho câu hỏi này...</p>
                        </div>
                    </div>
                </div>


                <h3>Lorem ipsum dolor sit amet</h3>
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return Policy Tab -->
            <div id="return-policy" class="tab">
                <h3>Return Policy</h3>
                <div class="accordion">
                <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buying Guide Tab -->
            <div id="buying-guide" class="tab">
                <h3>Buying Guide</h3>
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit?<span class="toggle-sign">+</span></div>
                        <div class="accordion-content">
                            <p>A placerat ac vestibulum integer vehicula suspendisse nostra aptent fermentum tempor a magna erat ligula parturient curae sem conubia vestibulum ac inceptos sodales condimentum cursus nunc mi consectetur condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tabs-container {
            width: 100%;
        }

        .tab-content {
            padding: 0 20px;
            border: 1px solid #EDEDED;
            border-radius: 8px;
        }
        .tab-list {
            display: flex;
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .tab-list li {
            margin-right: 10px;
        }

        .tab-list li a {
            display: block;
            padding: 10px 0;
            background-color: #ffffff;
            border: 1px solid #1E00AE;
            border-radius: 5px;
            color: #1E00AE;
            text-decoration: none;
            width: 270px;
            text-align: center;
            font-family: Ford Antenna;
            font-size: 18px;
            font-weight: 500;
            line-height: 36px;
        }
        .tab-list li.active a {
            background-color: #1E00AE;
            color: #fff;
        }

        .tab h3{
            font-family: Ford Antenna;
            font-size: 20px;
            font-weight: 500;
            line-height: 24px;
            margin-top: 30px;

        }

        .tab {
            display: none;
        }

        .tab.active {
            display: block;
        }


        .accordion-item {
            margin-bottom: 10px;
        }

        .accordion-header {
            padding: 20px;
            border: 1px solid #EDEDED;
            cursor: pointer;
            position: relative;
            font-family: Ford Antenna;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            border-radius: 8px;
        }

        .accordion-header.active{
            border: 1px solid #157FFF;
        }


        .accordion-content {
            display: none;
            padding: 10px;
            background-color: #fff;
        }


        .toggle-sign {
            position: absolute;
            right: 10px;
            font-size: 18px;
        }

        @media screen and (max-width: 1300px) {
            .tab-list li a {
            width: 200px;
        }
        }

        @media screen and (max-width: 700px) {
            .tab-list li a {
            width: 100px;
            padding: 0;
        }
        .tab-list li a {
        width: 100px;
        padding: 0;
        font-size: 12px;
    }
    .tab-list {
    margin-left: -10px;
}


        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            // Tab Switching
            $('.tab-list li a').click(function(e) {
                e.preventDefault();
                var target = $(this).attr('href');
                // Remove active class from all tabs and tab contents
                $('.tab-list li').removeClass('active');
                $('.tab').removeClass('active');
                // Add active class to clicked tab and corresponding content
                $(this).parent().addClass('active');
                $(target).addClass('active');
            });

            $('.tab-list li:first-child a').trigger('click');

            // Accordion Toggle
            $('.accordion-header').click(function() {
                $(this).toggleClass('active');
                $(this).next('.accordion-content').slideToggle();

                // Update the sign
                var sign = $(this).find('.toggle-sign');
                if ($(this).hasClass('active')) {
                    sign.text('-');
                } else {
                    sign.text('+');
                }
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('tabs_with_accordion', 'tabs_with_accordion_shortcode');



