$(document).ready(function() {

    console.log("aiji");
    $('.carousel1').each(function() {
        const $carousel = $(this);
        const $productList = $carousel.find('.product-list');
        const $products = $productList.find('.product-item');
        const $prevBtn = $carousel.find('.prev-btn');
        const $nextBtn = $carousel.find('.next-btn');
        
        let visibleProducts = $(window).width() <= 1024 ? 2 : 6;
        let currentIndex = 0;
        const productWidth = 236;
        
        $productList.css('width', productWidth * $products.length + 'px');
        
        function updateButtons() {
            if (currentIndex === 0) {
                $prevBtn.hide();
            } else {
                $prevBtn.show();
            }
    
            if (currentIndex >= $products.length - visibleProducts) {
                $nextBtn.hide();
            } else {
                $nextBtn.show();
            }
        }
    
        $nextBtn.on('click', function() {
            if (currentIndex < $products.length - visibleProducts) {
                currentIndex++;
                updateCarousel();
            }
        });
    
        $prevBtn.on('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });
    
        function updateCarousel() {
            const translateValue = -(currentIndex * (productWidth + 10));
            $productList.css({
                'transform': `translateX(${translateValue}px)`,
                'transition': 'transform 0.5s ease-in-out'
            });
            updateButtons();
        }
    
        updateButtons();
    
        $(window).resize(function() {
            visibleProducts = $(window).width() <= 1024 ? 2 : 6;
            updateButtons();
            updateCarousel();
        });
    
        console.log(`Total products in carousel:`, $products.length);
        console.log(`Product width (set to 236px):`, productWidth);
    });
});