let pageIndex = 1; // Biến theo dõi trang hiện tại
const pageSize = 12; // Số lượng sản phẩm mỗi trang

jQuery(document).ready(function($) {

    var baseURL;
    if (window.location.hostname === 'localhost') {
        baseURL = '/techbook';
    } else {
        baseURL = '';
    }
    // Initialize Select2 on all select elements
    $('#select-publisher, #select-ics, #select-lang, #pub-year').select2({
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });

    $('.btn-refresh').prop('disabled', true).addClass('disabled').removeClass('enabled');

    function checkInputs() {
        let isFilled = false;

        $('.search-box input[type="text"], .search-box textarea').each(function() {
            if ($(this).val().trim() !== '') {
                isFilled = true;
                return false;
            }
        });

        $('.search-box select').each(function() {
            if ($(this).val() !== null && $(this).val() !== '') {
                isFilled = true;
                return false;
            }
        });

        if (isFilled) {
            $('.btn-refresh').prop('disabled', false).removeClass('disabled').addClass('enabled');
            $('.icon1').prop('disabled', false).removeClass('disabled').addClass('enabled');
        } else {
            $('.btn-refresh').prop('disabled', true).addClass('disabled').removeClass('enabled');
            $('.icon1').prop('disabled', true).addClass('disabled').removeClass('enabled');
        }
    }

    $('.search-box input, .search-box select, .search-box textarea').on('input change', function() {
        checkInputs();
    });

    $('.btn-refresh').on('click', function() {
        if ($(this).prop('disabled')) return;

        $('.search-box input[type="text"], .search-box textarea').val('');
        $('.search-box select').val(null).trigger('change');

        $(this).prop('disabled', true).addClass('disabled').removeClass('enabled');
    });

    checkInputs();



    $(".btn-search").on("click", function () {
        pageIndex = 1;
        fetchData(); 
    });

    function fetchData() {
        $("#loading-container").show();
    
        // Lấy các giá trị từ các trường input
        const title = $("#std-title").val();
        const author = $("#Author-text").val();
        const publisher = $("#select-publisher").val();
        const keyword = $("#keyword-search").val();
        const isbn = $("#ISBN-text").val();
        const subjects = $("#select-ics").val();
        const publicationDate = $("#pub-year").val();
       
    
        const item = {
            previewPath: "string",
            fullContentBookPath: "string",
            createdDate: "2024-10-18T02:23:04.487Z",
            updatedDate: "2024-10-18T02:23:04.487Z",
            deleted: true,
            newArrival: true,
            bestSellers: true,
            isFree: true,
            totalRows: 0
        };
    
        // Thêm các trường có giá trị 
        if (title) item.title = title;
        if (author) item.author = author;
        if (publisher) item.publisher = publisher;
        if (keyword) item.keywords = keyword;
        if (isbn) item.isbn = isbn;
        if (subjects) item.subjects = subjects;
        if (publicationDate) item.publicationDate = publicationDate;
    
        const data = {
            id: "string",
            tokenKey: "4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7",
            intValue: 0,
            boolValue: true,
            stringValue: "string",
            pageIndex: pageIndex,
            pageSize: pageSize,
            orderBy: "string",
            orderWay: "string",
            item: item 
        };
    
        $.ajax({
            url: "https://115.84.178.66:8028/api/Documents/GetPaging",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (response) {
                const products = response.data.items || [];
                renderProducts(products);
                renderPagination(response.data.totalRows, pageSize);
                $("#dem-so-luong").text(response.data.totalRows);
    
                $("#loading-container").hide();
    
            
                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: {
                        action: "save_books_to_cache",
                        books: products
                    },
                    success: function(res) {
                        console.log("Dữ liệu đã được lưu vào database:", res);
                    },
                    error: function(err) {
                        console.error("Lỗi khi lưu dữ liệu vào database:", err);
                    }
                });
            },
            error: function (error) {
                console.error("Error fetching data: ", error);
                $("#loading-container").hide();
            }
        });
    }
    

    function renderProducts(products) {
        let productHtml = '';
    
        if (products.length > 0) {
            products.forEach(product => {
                productHtml += `
                    <a href="${baseURL}/detail-book/?id=${product.id}" class="product-item">
                        <p class="discount ${product.discount ? 'has-discount' : 'no-discount'}">
                            ${product.discount || '&nbsp;'}
                        </p>
                       <img src="${product.image ? product.image : `${baseURL}/wp-content/uploads/2024/09/Rectangle-17873.png`}" alt="Product Image" class="product-image">
                        <p class="product-category">${product.subjects || '&nbsp;'}</p>
                        <h3 class="product-title">${product.title || '&nbsp;'}</h3>
                        <p class="product-group">${product.author || '&nbsp;'}</p>
                        <p class="product-price">${product.pricePrint ? `$${product.pricePrint}` : '&nbsp;'}</p>
                        <div class="product-icons-list-book">
                            <div class="icon-list-book1">
                                <img src="${baseURL}/wp-content/uploads/2024/09/shopping-bag-02-3.svg" alt="Add to Cart">
                            </div>
                            <div class="icon-list-book2">
                                <img src="${baseURL}/wp-content/uploads/2024/09/Icon-13.svg" alt="Add to Favorites">
                            </div>
                        </div>
                    </a>
                `;
            });
        } else {
            productHtml = '<p>No products available at the moment.</p>';
        }
    
        $(".product-list").html(productHtml);
    }
    
    function renderPagination(totalRows, pageSize) {
        const totalPages = Math.ceil(totalRows / pageSize);
        let paginationHtml = '';
    
        if (totalPages <= 1) return; 
    
        paginationHtml += `<button class="btn-page ${pageIndex === 1 ? 'active' : ''}" data-page="1">1</button>`;
    
        if (pageIndex > 3) {
            paginationHtml += `<span class="pagination-ellipsis">...</span>`;
        }
    
        for (let i = Math.max(2, pageIndex - 1); i <= Math.min(totalPages - 1, pageIndex + 1); i++) {
            paginationHtml += `<button class="btn-page ${i === pageIndex ? 'active' : ''}" data-page="${i}">${i}</button>`;
        }
    
        if (pageIndex < totalPages - 2) {
            paginationHtml += `<span class="pagination-ellipsis">...</span>`;
        }
    
        paginationHtml += `<button class="btn-page ${pageIndex === totalPages ? 'active' : ''}" data-page="${totalPages}">${totalPages}</button>`;
    
        $(".custom-pagination").html(paginationHtml);
    
        // Gán sự kiện click cho các nút phân trang
        $(".btn-page").on("click", function () {
            pageIndex = parseInt($(this).data("page")); 
            fetchData(); 
        });
    }
      
});






