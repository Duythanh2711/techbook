$(document).ready(function() {
    let total = 0;

    function getCartItemsFromLocalStorage() {
        const data = localStorage.getItem('cartItems');
        return data ? JSON.parse(data) : [];
    }

    function setCartItemsToLocalStorage(cartItems) {
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }

    // Show data and display sidebar cart
    var baseURL;
    if (window.location.hostname === 'localhost') {
        baseURL = '/techbook';
    } else {
        baseURL = '';   
    }

    // Ajax
    window.loadCartItemsFromServer = function(cartItems, callback) {
        const productIds = cartItems.map(item => item.id);

        if (typeof ajax_object === 'undefined' || !ajax_object.ajaxurl) {
            console.error('AJAX object or AJAX URL is not defined.');
            callback([]); 
            return;
        } else {
            console.log('Ajax called');
        }

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

    // Html product cart item
    function generateCartRowHTML(item, priceTypeObj) {
        const price = priceTypeObj.priceType === "price_print" ? (item.printPrice || 0) : (item.ebookPrice || 0); 
        const quantity = priceTypeObj.quantity || 0; 
        const subtotal = price * quantity;

        return `
            <tr class="cart-item-row" data-book-id="${item.id}" data-price-type="${priceTypeObj.priceType}">
                <td class="cart-item-product">
                    <a href="${baseURL}/detail-book/?id=${item.id}">
                        <img src="${item.image || `${baseURL}/wp-content/uploads/2024/09/Rectangle-17873.png`}" 
                             alt="${item.title || item.standardTitle}" 
                             class="cart-item-image">
                        <div class="cart-item-info">
                            <p class="cart-item-cate">${item.subjects || item.referenceNumber || 'N/A'}</p>
                            <p class="cart-item-title">${item.title || item.standardTitle || 'Untitled'}</p>
                            <p class="cart-item-author">${item.author || 'Unknown Author'}</p>
                        </div>
                    </a>
                </td>
                <td class="price cart-item-price">$${price.toFixed(2)}</td>
                <td class="cart-item-quantity">
                    <input type="number" min="0" class="qty-input" value="${quantity}" data-book-quantity="quantity_${priceTypeObj.priceType}" data-id="${item.id}" data-price-type="${priceTypeObj.priceType}">
                </td>
                <td class="price cart-item-subtotal">$${subtotal.toFixed(2)}</td>
                <td class="btn-cart-remove">
                    <div class="icon-cart-remove" data-book-id="${item.id}" data-price-type="${priceTypeObj.priceType}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6L18 18" stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </td>
            </tr>
        `;
    }

    // Html cart table 
    function renderCartList() {
        const cartContainer = $(".list-item-cart");
        const cartItems = getCartItemsFromLocalStorage();

        // Check display button update cart and Form checkout
        if (cartItems.length === 0) { 
            $('.btn-update-cart').hide(); 
            $('.main-content.checkout-cart').hide(); 
        } else {
            $('.btn-update-cart').show(); 
            $('.main-content.checkout-cart').show(); 
        }

        if (cartItems.length === 0) {
            cartContainer.html(`
                <div class="empty-cart">
                    <img src="${baseURL}/wp-content/uploads/2024/09/shopping-cart-remove-02.svg" alt="Empty Cart" />
                    <p>No products in the cart</p>
                </div>
            `);
        } else {
            loadCartItemsFromServer(cartItems, function (books, standardBooks) {
                let cartHTML = `
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>   
                        </thead>
                        <tbody>
                `;

                const allItems = [...books, ...standardBooks];
                allItems.forEach(function (item) {
                    const cartItem = cartItems.find(itemInCart => String(itemInCart.id) === String(item.id));

                    if (cartItem && Array.isArray(cartItem.priceTypes)) {
                        cartItem.priceTypes.forEach(priceTypeObj => {
                            cartHTML += generateCartRowHTML(item, priceTypeObj);
                        });
                    }
                }); 

                cartHTML += `
                        </tbody>
                    </table>
                `;
                cartContainer.html(cartHTML);
                $('#loading-container').hide();
            });
        }
    }

    // Update number quantity mới vào local storage
    function updateQuantity (button) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const $productItem = $(button).closest('.product-item-book'); // Tìm phần tử cha .product-item-book
        const productId = $productItem.data('book-id'); // Lấy productId
        const priceType = $(button).data('book-price'); // Lấy priceType từ nút bấm
        const quantityInput = $productItem.find(`.qty-input[data-book-quantity="quantity_${priceType}"]`); // Tìm input quantity
        const quantity = parseInt(quantityInput.val(), 10); // Lấy giá trị quantity

        if (isNaN(quantity) || quantity < 0) {
            console.error("Invalid quantity");
            return;
        }

        const storedItemIndex = cartItems.findIndex(item => item.id === productId);

        if (storedItemIndex > -1) {
            const priceTypeIndex = cartItems[storedItemIndex].priceTypes.findIndex(pt => pt.priceType === priceType);

            if (priceTypeIndex > -1) {
                if (quantity > 0) {
                    cartItems[storedItemIndex].priceTypes[priceTypeIndex].quantity = quantity; // Cập nhật quantity
                } else {
                    cartItems[storedItemIndex].priceTypes.splice(priceTypeIndex, 1); // Xóa priceType nếu quantity = 0
                }
            } else if (quantity > 0) {
                cartItems[storedItemIndex].priceTypes.push({ priceType: priceType, quantity: quantity }); // Thêm mới priceType
            }

            if (cartItems[storedItemIndex].priceTypes.length === 0) {
                cartItems.splice(storedItemIndex, 1); // Xóa sản phẩm nếu không còn priceType
            }
        } else if (quantity > 0) {
            cartItems.push({
                id: productId,
                priceTypes: [{ priceType: priceType, quantity: quantity }]
            }); // Thêm sản phẩm mới
        }

        localStorage.setItem('cartItems', JSON.stringify(cartItems)); // Lưu vào localStorage
    }

    // Show total sidebar cart
    function totalPrice(callback) {
        const cartItems = getCartItemsFromLocalStorage();  
        var total = 0;
        
        loadCartItemsFromServer(cartItems, function(books, standardBooks) {
            var allItems = [...books, ...standardBooks];

            allItems.forEach(function (item) {
                const cartItem = cartItems.find(itemInCart => String(itemInCart.id) === String(item.id));

                if (cartItem && cartItem.priceTypes && Array.isArray(cartItem.priceTypes)) {
                    let itemTotal = 0;

                    let priceTypeHTML = cartItem.priceTypes.map(priceType => {
                        let price = priceType.price || 0;

                        if (price === 0) {
                            if (priceType.priceType === 'price_print') {
                                price = item.printPrice || 0;
                            } else if (priceType.priceType === 'price_ebook') {
                                price = item.ebookPrice || 0;
                            }
                        }

                        let quantity = priceType.quantity || 0;
                        let subTotal = price * quantity;

                        itemTotal += subTotal;

                    }).join('');

                    total += itemTotal;
                }
            });

            if (callback) callback(total); 
        });
    }

    // Show total sidebar cart
    function renderCartSidebar() {
        const cartItems = getCartItemsFromLocalStorage();
        var cartSidebar = $(".list-info");

        totalPrice(function(total) {
            var cartHTML = `
                <div class="cart-summary">
                    <div class="cart-total"><span class="label-total">Total:</span> <span class="total-price test">$${total.toFixed(2)}</span></div>
                </div>
            `;                 
            cartSidebar.html(cartHTML);
        });
    }

    renderCartList();
    renderCartSidebar();

    // Remove item from cart page
    $(document).on('click', '.icon-cart-remove', function(e) {
        $('#loading-container').show();
        e.preventDefault();

        const productId = $(this).data('book-id').toString(); 
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems = cartItems.filter(item => item.id !== productId);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));

        renderCartList();
        updateCartQuantityDisplay();
        attachCloseEventHandlers();
        renderCartModal();
        renderCartSidebar();
    });
    
    // Update number quantity mới vào local storage
    function updateQuantitiesInLocalStorage() {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        document.querySelectorAll('.qty-input').forEach(input => {
            const productId = input.getAttribute('data-id').toString();
            const quantity = parseInt(input.value);

            const storedItemIndex = cartItems.findIndex(item => item.id === productId);

            if (storedItemIndex > -1) {
                if (quantity > 0) {
                    cartItems[storedItemIndex].quantity = quantity;     
                } else {
                    cartItems.splice(storedItemIndex, 1);
                }
            } else if (quantity > 0) {
                cartItems.push({ id: productId, quantity: quantity });
            }
        });

        localStorage.setItem('cartItems', JSON.stringify(cartItems));                               
        renderCartList(); 
    }

    // Remove item from cart page
    $(document).on('click', '.icon-cart-remove', function(e) {
        $('#loading-container').show();
        e.preventDefault();

        const productId = $(this).data('book-id').toString(); 
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems = cartItems.filter(item => item.id !== productId);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));

        renderCartList();
    });

    // Click button Update cart
    $(document).on('click', '.btn-update-cart', function(e) {
        $('#loading-container').show();
        e.preventDefault();
        
        updateQuantitiesInLocalStorage();
        updateCartQuantityDisplay();
        renderCartModal();
        renderCartSidebar();
        updateQuantity();
    });

    $(document).on('click', '#orderButton', function(e) {
        e.preventDefault();
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const fullname = document.getElementById('fullname').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const address = document.getElementById('address').value;
        const note = document.getElementById('note').value || '';
        let totalAmount = '9999';
        const orderStatus = 'new'; 

        if (!fullname || !phone || !email || !address || cartItems.length === 0) {
            alert('Please fill in all information.');
            return;
        }   

        const data = {
            cartItems: cartItems,
            fullname: fullname,
            phone: phone,
            email: email,
            address: address,
            note: note,
            total_amount: totalAmount,  
            order_status: orderStatus
        };

        console.log(totalAmount);

        jQuery.ajax({
            url: ajax_objectt.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'save_order_to_database',
                cartItems: data.cartItems,
                fullname: data.fullname,
                phone: data.phone,
                email: data.email,
                address: data.address,
                note: data.note,
                total_amount: data.total_amount,
                order_status: data.order_status
            },
            success: function(response) {
                if (response.success) {
                    alert('Đặt hàng thành công!');
                } else {
                    alert('Đặt hàng không thành công: ' + response.data.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
});

// Load page
$(window).on('load', function() {
    $('#loading-container').hide();
});