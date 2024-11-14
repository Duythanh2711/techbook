
document.addEventListener('DOMContentLoaded', function() {
    function getCartItemsFromLocalStorage() {
        const data = localStorage.getItem('cartItems');
        return data ? JSON.parse(data) : [];
    }
    const initialCartItems = getCartItemsFromLocalStorage();
    const carts = document.querySelectorAll('.icon-cart');  

    carts.forEach(cart => {
        cart.addEventListener('click', function(event) {
            event.preventDefault();

            const productItem = this.closest('.product-item-book');
            const productId = productItem.getAttribute('data-book-id');
            const quantityInput = productItem.querySelector('.product-quantity');
            let quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            }

            if (!productId) {
                console.error("Product ID not found.");
                return;
            }

            let storedCartItems = getCartItemsFromLocalStorage();

            const existingProductIndex = storedCartItems.findIndex(item => item.id === productId);

            if (existingProductIndex === -1) {
                storedCartItems.push({ id: productId, quantity: quantity });
                this.classList.add('added');
            } else {
                if (this.classList.contains('added')) {
                    storedCartItems.splice(existingProductIndex, 1);
                    this.classList.remove('added');
                } else {
                    storedCartItems[existingProductIndex].quantity += quantity;
                    this.classList.add('added');
                }
            }

            localStorage.setItem('cartItems', JSON.stringify(storedCartItems));
        });
    });

    // Check trạng thái
    carts.forEach(cart => {
        const productItem = cart.closest('.product-item-book');
        if (productItem) {
            const productId = productItem.getAttribute('data-book-id');
            const storedProduct = initialCartItems.find(item => item.id === productId);

            if (storedProduct) {
                cart.classList.add('added');
                const quantityInput = productItem.querySelector('.product-quantity');
                if (quantityInput) {
                    quantityInput.value = storedProduct.quantity;
                }
            }
        }
    });

    // Show data and display sidebar cart
    var baseURL;
    if (window.location.hostname === 'localhost') {
        baseURL = '/techbook';
    } else {
        baseURL = '';
    }

    var modal = $("#cartModal");
    var overlay = $("#modalOverlay");

    // Total cart money
    function calculateTotal(cartItems) {
        return cartItems.reduce((sum, item) => sum + (item.pricePrint * item.quantity), 0);
    }

    // Đặt hàm vào đối tượng window để làm cho nó toàn cục
    window.loadCartItemsFromServer = function(cartItems, callback) {
        const productIds = cartItems.map(item => item.id);

        if (productIds.length > 0) {
            $.ajax({
                url: ajax_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_books_by_ids',
                    productIds: productIds
                },
                dataType: 'json',
                success: function(response) {
                    const books = response.data.books || [];
                    const standardBooks = response.data.standardBooks || [];

                    if (response.success) {
                        callback(books, standardBooks);
                    } else {
                        console.error('Failed to load books from server.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading books from server:', error);
                }
            });
        } else {
            callback([]); 
        }
    };

    // Hàm chung để tạo HTML cho item trong giỏ hàng
    function generateCartItemHTML(item, quantity, isBook = true) {
        const imageUrl = item.image || `${baseURL}/wp-content/uploads/2024/09/Rectangle-17873.png`;
        const url = `${baseURL}/detail-book/?id=${item.id}`;
        const category = isBook ? item.subjects : item.referenceNumber;
        const title = isBook ? item.title : item.standardTitle;
        const authorOrPrice = isBook ? item.author : `$${item.ebookPrice}`;

        return `
            <a href="${url}" class="cart-item" data-book-id="${item.id}">
                <div class="cart-item-image">
                    <img src="${imageUrl}" alt="${title}">
                </div>
                <div class="cart-item-details">
                    <p class="cart-item-cate">${category}</p>
                    <p class="cart-item-title">${title}</p>
                    <p class="cart-item-author">${authorOrPrice}</p>
                    <p class="cart-item-quantity">${quantity} x $${isBook ? item.pricePrint : item.ebookPrice}</p>
                </div>
            </a>
        `;
    }

    // Show product cart in sidebar
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
                    <span class="close">&times;</span>
                </div>
            </div>
        `;
        
        if (cartItems.length === 0) {
            modalContent.html(`
                ${headerHTML}
                <div class="empty-cart">
                    <img src="${baseURL}/wp-content/uploads/2024/09/shopping-cart-remove-02.svg" alt="Empty Cart" />
                    <p>No products in the cart</p>
                </div>
            `);

            attachCloseEventHandlers();
        } else {
            loadCartItemsFromServer(cartItems, function(books, standardBooks) {
                var cartHTML = `${headerHTML} <div class="cart-items">`;
                var total = 0; 

                books.forEach(function(book) {
                    const cartItem = cartItems.find(item => item.id === book.id); 
                    if (cartItem) {
                        total += book.pricePrint * cartItem.quantity;
                        cartHTML += generateCartItemHTML(book, cartItem.quantity, true);
                    }
                });

                standardBooks.forEach(function(publisher) {
                    const cartItem = cartItems.find(item => item.id === publisher.id); 
                    if (cartItem) {
                        total += publisher.ebookPrice * cartItem.quantity;
                        cartHTML += generateCartItemHTML(publisher, cartItem.quantity, false);
                    }
                });

                cartHTML += `
                    </div>
                    <div class="cart-total">
                        <p>Total:</p> 
                        <span>$${total.toFixed(2)}</span>
                    </div>      
                    <div class="cart-button">
                        <a href="https://tecbook.vn/cart" class="view-cart-btn">View cart</a>
                    </div>
                `;                    

                modalContent.html(cartHTML);
                attachCloseEventHandlers();
            });
        }
    }
    window.renderCartModal = renderCartModal;

    // Function event close for modal and overlay
    function attachCloseEventHandlers() {
        var closeModal = $(".close");
        var overlay = $(".overlay");

        if (closeModal.length) {
            closeModal.off("click").on("click", function() {
                modal.removeClass("active");
                overlay.hide();
            });
        }

        if (overlay.length) {
            overlay.off("click").on("click", function() {
                modal.removeClass("active");
                overlay.hide();
            });
        }
    }
    window.attachCloseEventHandlers = attachCloseEventHandlers;

    // Total quantity
    function getTotalQuantity() {
        const cartItems = getCartItemsFromLocalStorage();
        return cartItems.reduce((total, item) => total + (item.quantity || 0), 0);
    }

    // Total quantity btn cart in header
    function updateCartQuantityDisplay() {
        const totalQuantity = getTotalQuantity();
        const headerGioHangElement = document.querySelector('.header-gio-hang');
        
        if (headerGioHangElement) {
            let quantityDiv = headerGioHangElement.querySelector('.total-number-product');
            
            if (!quantityDiv) {
                quantityDiv = document.createElement('div');
                quantityDiv.classList.add('total-number-product');
                headerGioHangElement.appendChild(quantityDiv);
            }

            quantityDiv.textContent = `${totalQuantity}`;
        }
    }   
    window.updateCartQuantityDisplay = updateCartQuantityDisplay;
    updateCartQuantityDisplay();

    // Gọi hàm hiển thị giỏ hàng khi trang tải
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

    // Click add to cart
    $(document).on('click', '.icon-cart', function(e) {
        // $('#loading-container').show();
        e.preventDefault();
        
        updateCartQuantityDisplay();
        renderCartModal();
    });
});