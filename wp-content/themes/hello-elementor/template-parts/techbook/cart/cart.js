$(document).ready(function() {

    var baseURL;
    if (window.location.hostname === 'localhost') {
        baseURL = '/techbook';
    } else {
        baseURL = '';
    }

    // Lưu ID sản phẩm và số lượng vào localStorage 
    if (!localStorage.getItem('cartItems')) {
        var initialCartItems = [
            { id: 1, quantity: 1 },
            { id: 2, quantity: 1 }
        ];
        localStorage.setItem('cartItems', JSON.stringify(initialCartItems));
    }

    function getCartItemsFromLocalStorage() {
        return JSON.parse(localStorage.getItem('cartItems')) || [];
    }

    var allProducts = [
        {
            id: 1,
            discount: '-20%',
            image: baseURL + '/wp-content/uploads/2024/09/Rectangle-17872.png',
            category: '91.060.50. Door & window',
            title: 'AAMA/WDMA/CSA 101/I.S.2 A440:22',
            group: 'CSA Group',
            price: 255,
            description: 'PDF, English'
        },
        {
            id: 2,
            discount: '-15%',
            image: baseURL + '/wp-content/uploads/2024/09/Rectangle-17872.png',
            category: 'Mechanical engineering',
            title: 'AAMA/WDMA/CSA 101/I.S.2 A440:22',
            group: 'CSA Group',
            price: 65,
            description: 'Printed, Vietnamese'
        }
    ];

    var modal = $("#cartModal");
    var overlay = $("#modalOverlay");

    if (!modal.length || !overlay.length) {
        console.error("Modal or overlay element not found!");
        return;
    }

    // Hàm hiển thị nội dung giỏ hàng
    function renderCartModal() {
        var modalContent = $(".modal-content");

        var cartItems = getCartItemsFromLocalStorage();

        var headerHTML = `
            <div class="header1">
                <div class="title1-header">
                    <img src= "${baseURL}/wp-content/uploads/2024/09/Icon-11.svg" alt="Cart Icon" class="cart-icon" /> Cart
                </div>
                <div class="close-section">
                    <p class="close-text">Close</p>
                    <span class="close">&times</span>
                </div>
            </div>
        `;

        var total = 0;

        if (cartItems.length === 0) {
            modalContent.html(`
                ${headerHTML}
                <div class="empty-cart">
                    <img src="${baseURL}/wp-content/uploads/2024/09/shopping-cart-remove-02.svg" alt="Empty Cart" />
                    <p>No products in the cart</p>
                </div>
            `);
        } else {
            var cartHTML = `${headerHTML} <div class="cart-items">`;

            cartItems.forEach(function(cartItem) {
                var product = allProducts.find(function(p) { return p.id === cartItem.id; });

                if (product) {
                    var itemTotal = cartItem.quantity * product.price;
                    total += itemTotal;

                    cartHTML += `
                        <div class="cart-item">
                            <img src="${product.image}" alt="${product.title}" class="cart-item-image" />
                            <div class="cart-item-details">
                                <p class="cart-item-category">${product.category}</p>
                                <h3 class="cart-item-title">${product.title}</h3>
                                <p class="cart-item-description">${product.description}</p>
                                <p class="cart-item-quantity">${cartItem.quantity} x $${product.price}</p>
                            </div>
                            <div class="close1">&times</div>
                        </div>
                    `;
                } else {
                    console.error("Product not found for ID:", cartItem.id);
                }
            });

            cartHTML += `
                    </div>
                    <div class="cart-total">
                        <p>Total:</p> 
                        <span>$${total.toFixed(2)}</span>
                    </div>   
                    <div class="cart-button">
                        <button class="checkout-btn">Checkout</button>
                        <button class="view-cart-btn">View Cart</button>
                    </div>
                `;

            modalContent.html(cartHTML);
        }

        var closeModal = $(".close");
        if (closeModal.length) {
            closeModal.on("click", function() {
                modal.removeClass("active");
                overlay.hide();
            });
        }

        overlay.on("click", function() {
            modal.removeClass("active");
            overlay.hide();
        });
    }

    // Gọi hàm hiển thị giỏ hàng 
    renderCartModal();

    var cartIcon = $(".header-gio-hang");

    if (cartIcon.length) {
        cartIcon.on("click", function() {
            modal.addClass("active");
            overlay.show();
        });
    } else {
        console.error("Cart icon not found!");
    }
});
