jQuery(document).ready(function($) {
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

    var $searchButton = $('.btn-search');
    var $hiddenDocuments = $('.document-list.hidden-document');

    $searchButton.on('click', function(e) {
        e.preventDefault();
        $hiddenDocuments.addClass('show'); 

        // Đếm số lượng các phần tử .document-item
        var totalItems = $('.document-item').length;
        $('#dem-so-luong').text(totalItems);
    });

    $('.document-item').on('click', function() {
        var baseUrl = window.location.origin;
        window.location.href = baseUrl + '/techbook/detail-publisher/';
    });

});
