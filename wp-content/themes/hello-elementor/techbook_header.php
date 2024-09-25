<?php

function advanced_search_shortcode() {

    $appPath = get_bloginfo('wpurl');
    //HTML
    $output = '
    <div class="advanced-search-container">
        <button class="advanced-search-btn">
            <img src="' . $appPath . '/wp-content/uploads/2024/09/Icon-3.svg" alt="Icon Left" class="icon-left">
            <span class="text-label">Advanced search</span>
            <img src="' . $appPath . '/wp-content/uploads/2024/09/Symbol.svg" alt="Icon Right" class="icon-right">
        </button>
        <div class="advanced-search-dropdown">
           <a href="' . $appPath . '/techbook/search-book/" >Books</a>
            <a href="' . $appPath . '/search-publisher/" >Publisher</a>
        </div>
    </div>';

    // CSS để tạo giao diện
    $output .= '
    <style>
        .advanced-search-container {
            position: relative;
            display: inline-block;
        }

        .advanced-search-btn {
            background-color: #fff;
            color: #157FFF;
            border: 1.3px solid #157FFF;
            padding: 15px 30px 15px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .icon-left {
            height: 20px;
            margin-right: 4px;
            margin-left: -10px;
        }

        .icon-right {
            height: 15px;
            margin-left: 4px;
        }

        .text-label {
            font-weight: bold;
            color: #157FFF;
            font-size: 14px;
            font-family: Ford Antenna;
            font-weight: 400;
            line-height: 19.6px;

        }

        .advanced-search-btn:hover {
            background-color: #f1f1f1;
        }
        
        .advanced-search-btn:action {
            background-color: #f1f1f1;
        }

        .advanced-search-dropdown {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            min-width: 165px;
            padding: 12px 16px;
            z-index: 1;
            border-radius: 5px;
        }

        .advanced-search-dropdown a {
            color: black;
            text-decoration: none;
            display: block;
            border-radius: 8px;
            margin: 5px;
            text-align: center;
            background: #F5F5F5;
            border: 1px solid #E8E8E8;
        }

        .advanced-search-dropdown a:hover {
            background-color: #ddd;
        }

        .advanced-search-container:hover .advanced-search-dropdown {
            display: block;
        }

    </style>';

    // JavaScript 
    $output .= '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var btn = document.querySelector(".advanced-search-btn");
            var dropdown = document.querySelector(".advanced-search-dropdown");

            btn.addEventListener("click", function(e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            });

            document.addEventListener("click", function() {
                dropdown.style.display = "none";
            });

             btn.addEventListener("mouseleave", function() {
                this.style.backgroundColor = "#fff";
            });
        });
    </script>';

    return $output;
}
add_shortcode('advanced_search', 'advanced_search_shortcode');



//usd-english
function currency_language_shortcode() {
    $appPath = get_site_url(); 

    $output = '
    <div class="currency-language-container">
        <!-- Phần chọn USD/VND -->
        <div class="dropdown">
            <button class="dropdown-btn" id="currency-btn">
                USD <img src="' . $appPath . '/wp-content/uploads/2024/09/Symbol.svg" alt="Dropdown Icon" class="dropdown-icon">
            </button>
            <div class="dropdown-content" id="currency-dropdown">
                <a href="#" id="currency-switch">VND</a>
            </div>
        </div>

        <!-- Phần chọn English/Vietnamese -->
        <div class="dropdown">
            <button class="dropdown-btn" id="language-btn">
                English <img src="' . $appPath . '/wp-content/uploads/2024/09/Symbol.svg" alt="Dropdown Icon" class="dropdown-icon">
            </button>
            <div class="dropdown-content" id="language-dropdown">
                <a href="#" id="language-switch">Vietnamese</a>
            </div>
        </div>
    </div>';

    // CSS để tạo giao diện
    $output .= '
    <style>
        .currency-language-container {
            display: flex;
            gap: 20px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-btn {
            color: #fff;
            padding: 0px;
            font-size: 16px;
            border: 1px solid #1e00ae;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-icon {
            width: 10px;
            height: 10px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 100px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: black;
            padding: 5px 5px;
            text-decoration: none;
            display: block;
            border-radius: 5px;
            margin: 5px;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }
    </style>';

    return $output;
}
add_shortcode('currency_language', 'currency_language_shortcode');



