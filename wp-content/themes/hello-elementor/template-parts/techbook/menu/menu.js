// Kiểm tra xem nút có tồn tại trên màn hình không
$(document).ready(function() {
    const $button = $('.header-mobile-wp');
    if ($button.length) {
        console.log('Nút đã được tìm thấy trên màn hình:', $button);
    } else {
        console.log('Không tìm thấy nút phone trên màn hình.');
    }

    // Lấy các phần tử cần thiết
    const $modal = $('#uniqueModal123');
    const $openModalBtn = $('.header-mobile-wp');
    const $closeModalBtn = $('.closeButton789');

    // Khi nhấn vào icon để mở modal
    $openModalBtn.on('click', function() {
        $modal.css('display', 'block');
        setTimeout(function() {
            $modal.addClass('showModal');
        }, 10);  // Thêm một chút độ trễ để hiển thị animation kéo từ trái qua phải
    });

    // Khi nhấn vào nút X để đóng modal
    $closeModalBtn.on('click', function() {
        $modal.removeClass('showModal');
        setTimeout(function() {
            $modal.css('display', 'none');
        }, 400);  // Phù hợp với thời gian của animation
    });

    // Khi nhấn ra ngoài modal thì đóng modal
    $(window).on('click', function(event) {
        if ($(event.target).is($modal)) {
            $modal.removeClass('showModal');
            setTimeout(function() {
                $modal.css('display', 'none');
            }, 400);
        }
    });
});

