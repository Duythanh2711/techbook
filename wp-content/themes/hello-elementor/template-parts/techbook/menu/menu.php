<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/menu/menu.css">

<script src="<?php echo get_template_directory_uri(); ?>/template-parts/techbook/menu/menu.js"></script>


<body>
    <div id="uniqueModal123" class="hiddenModal">
        <div class="modalContent456">
            <span class="closeButton789">&times;</span>
            <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Book</a></li>
            <li><a href="#">Publisher</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
            <li class="dropdown123">
                <a href="#">USD <span>&#9660;</span></a>
                <ul class="dropdown123-content">
                    <li><a href="#">China</a></li>
                    <li><a href="#">Vietnam</a></li>
                </ul>
            </li>
            <li class="dropdown123">
                <a href="#">English <span>&#9660;</span></a>
                <ul class="dropdown123-content">
                    <li><a href="#">Vietnam</a></li>
                    <li><a href="#">China</a></li>
                </ul>
            </li>
            <div class="button__search">
                <button class="button__search__book">Search book</button>
                <button class="button__search__publisher">Search publisher</button>
            </div>

        </ul>
        </div>
    </div>
        
</body>
