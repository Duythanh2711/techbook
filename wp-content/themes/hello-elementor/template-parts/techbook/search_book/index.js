jQuery(document).ready(function($) {
    // Initialize Select2 on all select elements
    $('#select-publisher, #select-ics, #select-lang, #pub-year-min, #pub-year-max').select2({
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
        } else {
            $('.btn-refresh').prop('disabled', true).addClass('disabled').removeClass('enabled');
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


    $('.product-list').hide();

    $('.btn-search').on('click', function(e) {
        e.preventDefault();
        $('.product-list').show();
        var visibleItems = $('.product-item').length;
        $('#dem-so-luong').text(visibleItems);
    });
});