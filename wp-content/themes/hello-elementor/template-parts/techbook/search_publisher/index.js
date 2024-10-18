
let pageIndex = 1; 
const pageSize = 12; 
jQuery(document).ready(function($) {

    var baseURL;
    if (window.location.hostname === 'localhost') {
        baseURL = '/techbook';
    } else {
        baseURL = '';
    }
    const startYear = 2000;
    const currentYear = new Date().getFullYear();

    function populateYearSelect(selectElement) {
        for (let year = startYear; year <= currentYear; year++) {
            const option = new Option(year, year, false, false);
            selectElement.append(option);
        }
    }

    const $minYearSelect = $('#pub-year-min');
    const $maxYearSelect = $('#pub-year-max');

    populateYearSelect($minYearSelect);
    populateYearSelect($maxYearSelect);

    $minYearSelect.select2({
        placeholder: "Min to",
        allowClear: true,
        width: 'style'
    });

    $maxYearSelect.select2({
        placeholder: "Max to",
        allowClear: true,
        width: 'style'
    });

    function validateYearRange() {
        const minYear = parseInt($minYearSelect.val());
        const maxYear = parseInt($maxYearSelect.val());

        if (minYear && maxYear && minYear > maxYear) {
            alert("Năm tối thiểu không thể lớn hơn năm tối đa.");
            $minYearSelect.val(null).trigger('change');
        }
    }

    $minYearSelect.on('change', validateYearRange);
    $maxYearSelect.on('change', validateYearRange);

    $('#select-publisher').select2({
        placeholder: "Select Publisher",
        allowClear: true,
        width: 'style'
    });

    $('#pub-year').select2({
        placeholder: "Select Year",
        allowClear: true,
        width: 'style'
    });

    $('#select-ics').select2({
        placeholder: "Select ICS Code",
        allowClear: true,
        width: 'style'
    });

    $('#select-lang').select2({
        placeholder: "Select Language",
        allowClear: true,
        width: 'style'
    });

    $('.btn-refresh').prop('disabled', true).addClass('disabled').removeClass('enabled');
    $('.icon1').prop('disabled', true).addClass('disabled').removeClass('enabled');

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

        if ($('input[name="status"]:checked').val() !== 'most-recent') {
            isFilled = true;
        }

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
        $('.search-box input[type="text"], .search-box textarea').val('');
        $('.search-box select').val(null).trigger('change');
        $('input[name="status"][value="most-recent"]').prop('checked', true).trigger('change');
        $(this).prop('disabled', true).addClass('disabled').removeClass('enabled');
    });

    checkInputs();






    $(".btn-search").on("click", function () {
        pageIndex = 1;
        fetchData();
    });

    function fetchData() {
        $("#loading-container").show();
    
        
        const referenceNumber = $("#ref-number").val();
        const standardTitle = $("#std-title").val();
        const icsCode = $("#select-ics").val();
        const publishedDate = $("#pub-year").val();
        const replace = $("#replace-to-text").val();
        const repalcedBy = $("#replace-by-text").val();
        const referencedStandards = $("#referenced-standards-text").val();
        const referencingStandards = $("#referencing-standards-text").val();
        const status = $("#select-status").val();
        const languages = $("#select-lang").val();
        const keyword = $("#keyword-search").val();
        

        const item = {
            icsCode : null
        };

        // Thêm các trường có giá trị 
        if (referenceNumber) item.referenceNumber = referenceNumber;
        if (standardTitle) item.standardTitle = standardTitle;
        if (icsCode) item.icsCode = icsCode;
        if (publishedDate) item.publishedDate = publishedDate;
        if (replace) item.replace = replace;
        if (repalcedBy) item.repalcedBy = repalcedBy;
        if (referencedStandards) item.referencedStandards = referencedStandards;
        if (referencingStandards) item.referencingStandards = referencingStandards;
        if (status) item.status = status;
        if (languages) item.languages = languages;     
        if (keyword) item.keyword = keyword;
        
    
        const data = {
            tokenKey: "4XwMBElYC3xgZeIW0IZ1H42zyvDNM5h7",
            pageIndex: pageIndex,
            pageSize: pageSize,
            item: item 

        };
    
        $.ajax({
            url: "https://115.84.178.66:8028/api/Standards/GetPaging",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (response) {
                const standards = response.data.items || [];
                renderProducts(standards);
                renderPagination(response.data.totalRows, pageSize);
                $("#dem-so-luong").text(response.data.totalRows);
    
                $("#loading-container").hide();
                
                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: {
                        action: "save_standards_to_cache",
                        standards: standards
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












    function renderProducts(standards) {
        let productHtml = '';
    
        if (standards.length > 0) {
            standards.forEach(standard => {
                productHtml += `
                    <a href="${baseURL}/detail-standard/?id=${standard.id}" class="document-item">
                    <div class="document-info">
                        <h3 class="document-title">${standard.referenceNumber || '&nbsp;'}</h3>
                        <p class="document-description">${standard.standardTitle || '&nbsp;'}</p>
                        <div class="document-meta">
                            <span>
                                <img src="${baseURL}/wp-content/uploads/2024/09/calendar.svg" alt="Date Icon">
                                Published Date: ${standard.publishedDate || '&nbsp;'}
                            </span>
                            <span>
                                <img src="${baseURL}/wp-content/uploads/2024/09/book-square.svg" alt="Pages Icon">
                                Pages: ${standard.pages || '&nbsp;'}
                            </span>
                            <span>
                                <img src="${baseURL}/wp-content/uploads/2024/09/Icon-7.svg" alt="Status Icon">
                                Status: ${standard.status || '&nbsp;'}
                            </span>
                        </div>
                    </div>
                        <div class="document-action">
                            <img src="${baseURL}/wp-content/uploads/2024/09/Icon-8.svg" alt="Arrow Icon" class="icon-card">
                        </div>
                    </a>
    
                `;
            });
        } else {
            productHtml = '<p>No products available at the moment.</p>';
        }
    
        $(".document-list").html(productHtml);
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


