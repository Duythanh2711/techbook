jQuery(document).ready(function($) {

        $('#pub-year-min').select2({
            width: '100%',
            placeholder: 'Min to',
            allowClear: true
        });

        $('#pub-year-max').select2({
            width: '100%',
            placeholder: 'Max to',
            allowClear: true
        });

        $('#select-ics').select2({
            width: '100%',
            placeholder: 'All',
            allowClear: true
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
});




