$(function () {
    $messageList = $('.flash-message');

    if ($messageList.length) {
        setTimeout(function () {
            $messageList.slideUp(200);
        }, 3000);
    }

    // $('.toggle-comment-form .toggle').on('click', function () {
    //     $('.toggle-comment-form').toggleClass('s-expanded');
    // });
});