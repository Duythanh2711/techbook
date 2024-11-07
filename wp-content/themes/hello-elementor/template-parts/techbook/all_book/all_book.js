let pageIndex = 1;
let pageSize = 20;
jQuery(document).ready(function($) {

    var baseURL;
    if (window.location.hostname === 'localhost') {
        baseURL = '/techbook';
    } else {
        baseURL = '';
    }

       

        $('#select-ics').select2({
            width: '100%',
            placeholder: 'All',
            allowClear: true
        });

        $('#pub-year').select2({
            placeholder: "Select Year",
            allowClear: true,
            width: 'style'
        });

        var priceRange = document.getElementById('priceRange');
        var priceValue = document.getElementById('priceValue');

        priceRange.addEventListener('input', function() {
            priceValue.innerText = '$' + priceRange.value;
        });


        var categories = [
            'AASHTO Collection', 'Aerodynamics', 'Biological engineering', 
            'Chemistry and Chemical Engineering Discipline', 'Civil Engineering Discipline', 
            'Earth Sciences Discipline', 'General Electronic Engineering', 'Fluid Dynamics', 
            'Highway Transportation', 'Process Safety', 'Process Safety', 'Process Safety'
            , 'Process Safety', 'Process Safety', 'Process Safety', 'Process Safety'
            , 'Process Safety', 'Process Safety', 'Process Safety', 'Process Safety'
            , 'Process Safety', 'Process Safety', 'Process Safety', 'Process Safety'
            , 'Process Safety', 'Process Safety', 'Process Safety', 'Process Safety'
        ];
    
        categories.forEach(function(category) {
            $('.modal-content-book .categories').append(
                '<label class="category-checkbox">' +
                '<input type="checkbox" value="' + category + '"> ' + category + 
                '</label>'
            );
        });
    
        var modal = $('#bookCategoryModal');
        var selectedOption = $('.selected-option');
        var searchCategory = $('.search-category-book');
    
        searchCategory.on('click', function(event) {
            event.stopPropagation();
    
            var offset = $(this).offset();
            var width = $(this).outerWidth();
            var height = $(this).outerHeight();
            var modalWidth = modal.outerWidth();
    
            var leftPosition = offset.left + width - modalWidth;

            modal.css({
                top: offset.top + height + 'px',  
                left: leftPosition + 'px',  
                position: 'absolute'
            }).show(); 
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.modal-book, .search-category-book').length) {
                modal.hide();
            }
        });
    
        $(document).on('click', '.category-checkbox input', function() {
        });
    
        $('.view-all').on('click', function(event) {
            event.preventDefault();
            alert('View all categories');
        });






        //reposive

        function checkScreenWidth() {
            if ($(window).width() <= 1224) {
                $('.drag-handle').show();
                $('.drag-handle').off('click').on('click', function() {
                    $('.sidebar').addClass('active');
                    $('.overlay').show();
                    $('body').addClass('sidebar-open');
                    $('.drag-handle').hide();
                });
        
                $('.overlay').off('click').on('click', function() {
                    $('.sidebar').removeClass('active');
                    $('.overlay').hide();
                    $('body').removeClass('sidebar-open');
                    $('.drag-handle').show();
                });
            } else {
                $('.drag-handle').hide();
                $('.overlay').hide();
                $('.sidebar').removeClass('active').css('left', '0');
                $('body').removeClass('sidebar-open');
            }
        }
        
        checkScreenWidth();
    
        $(window).resize(function() {
            checkScreenWidth();
        });














        $(".search-button").on("click", function() {
            pageIndex = 1; 
            fetchData();
        });

        $(".filter-button").on("click", function() {
            pageIndex = 1; 
            fetchData();
        });


        function fetchData() {
            $("#loading-container").show();
        
            const title = $(".search-input").val();
            const subjects = $("#std-title").val();
            const author = $("#author-text").val();
            const publicationDate = $("#pub-year").val();
            const pricePrint = $("#priceValue").text().replace('$', ''); 
        
            const item = {};
        
            if (title) item.title = title;
            if (subjects) item.subjects = subjects;
            if (author) item.author = author;
            if (publicationDate) item.publicationDate = publicationDate;
            if (pricePrint) item.pricePrint = parseFloat(pricePrint);
        
            const data = {
                tokenKey: "4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7",
                pageIndex: pageIndex,
                pageSize: pageSize,
                item: item
            };
        
            $.ajax({
                url: "https://115.84.178.66:8028/api/Documents/GetPaging",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(data),
                success: function(response) {
                    const products = response.data.items || [];
                    const totalRows = response.data.totalRows || 0;
        
                    renderProducts(products);
        
                    if (totalRows > pageSize) {
                        renderPagination(totalRows, pageSize);
                        $(".custom-pagination").show();
                    } else {
                        $(".custom-pagination").hide();
                    }
        
                    $("#loading-container").hide();
                },
                error: function(error) {
                    console.error("Lỗi khi lấy dữ liệu: ", error);
                    $("#loading-container").hide();
                }
            });
        }
        


        function renderProducts(products) {
            let productHtml = '';
        
            if (products.length > 0) {
                products.forEach(product => {
                    productHtml += `
                        <div class="product-item">
                            <p class="discount ${product.discount ? 'has-discount' : 'no-discount'}">
                                ${product.discount ? product.discount : '&nbsp;'}
                            </p>
        
                            <a href="${baseURL}/detail/book-${product.id ? product.id : ''}" class="product-link">
                                <img src="${product.image ? product.image : `${baseURL}/wp-content/uploads/2024/09/Rectangle-17873.png`}" alt="Product Image" class="product-image">
                            </a>
        
                            <p class="product-category">${product.subjects ? product.subjects : '&nbsp;'}</p>
        
                            <h3 class="product-title">${product.title ? product.title : '&nbsp;'}</h3>
        
                            <p class="product-group">${product.author ? product.author : '&nbsp;'}</p>
        
                            <p class="product-price">${product.pricePrint ? `$${product.pricePrint}` : '&nbsp;'}</p>
        
                            <div class="product-icons-list-book">
                                <div class="icon-list-book1">
                                    <img src="${baseURL}/wp-content/uploads/2024/09/shopping-bag-02-3.svg" alt="Add to Cart">
                                </div>
                                <div class="icon-list-book2">
                                    <img src="${baseURL}/wp-content/uploads/2024/09/Icon-13.svg" alt="Add to Favorites">
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                productHtml = '<p>Hiện không có sản phẩm nào.</p>';
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
        
            $(".btn-page").on("click", function () {
                pageIndex = parseInt($(this).data("page")); 
                fetchData(); 
            });
        }


        const urlParams = new URLSearchParams(window.location.search);
    const subject = urlParams.get('subject');

    if (subject) {
        $("#std-title").val(decodeURIComponent(subject));

        $(".filter-button").click();
    }
        
        
});




