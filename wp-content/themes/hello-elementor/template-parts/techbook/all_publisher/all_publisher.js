jQuery(document).ready(function($) {
    var categories = [
        'AAMA', 'IEEE', 'WRC', 'WRI', 'TCVN', 'QCVN', 'CIE', 'CODEX STAN',
        'IEC', 'ISO', 'ITU', 'CISPR', 'ĐLVN', 'EN', 'ASTM', 'BS', 'ANSI',
        'DIN', 'JIS', 'KS', 'ASME', 'API', 'NFPA', 'AASHTO', 'UL', 'AGA'
    ];

    categories.forEach(function(category) {
        $('.modal-content-publisher .categories').append(
            '<button class="category-item">' + category + '</button>'
        );
    });

    var modal = $('#bookCategoryModal');
    var selectedOption = $('.selected-option');
    var searchCategory = $('.search-category');

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
        if (!$(event.target).closest('.modal-book, .search-category').length) {
            modal.hide();
        }
    });

    $(document).on('click', '.category-item', function() {
        var category = $(this).text();
        selectedOption.text(category);
        modal.hide();
    });

    $('.view-all').on('click', function(event) {
        event.preventDefault();
        alert('View all categories');
    });

    $('.letter').on('click', function() {
        $('.letter').removeClass('active');
        $(this).addClass('active');
        $('#jump-to').addClass('inactive');
    });

    $('#jump-to').on('click', function() {
        $('.letter').removeClass('active');
        $(this).removeClass('inactive');    
    });


    var letter = '';

    function loadPublishersByLetter(letter, page) {
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_publishers_by_letter',
                letter: letter,
                page: page
            },
            success: function(response) {
                $('.organization-list').html(response);
            },
            error: function(error) {
                console.log('Error:', error);
            },
            complete: function() {
                $('#loading-container').hide();
            }
        });
    }

    loadPublishersByLetter('', 1);

    $('.letter').on('click', function() {
        $('#loading-container').show();
        letter = $(this).text().trim();
        loadPublishersByLetter(letter, 1);
    });

    $(document).on('click', '.page-num', function() {
        $('#loading-container').show();
        var page = $(this).data('page');
        loadPublishersByLetter(letter, page);
    });

    $('#jump-to').on('click', function() {
        $('#loading-container').show();
        letter = ''; 
        loadPublishersByLetter('', 1);
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
    
});
