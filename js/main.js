$(function () {
    $messageList = $('.flash-message');

    if ($messageList.length) {
        setTimeout(function () {
            $messageList.slideUp(200);
        }, 3000);
    }

    $('.toggle-comment-form .toggle').on('click', function () {
        $('.toggle-comment-form').toggleClass('s-expanded');
    });

    var favourite = $('a.favourite');
    favourite.on('click', function (e) {
        e.preventDefault();
        var userId = favourite.attr('data-user_id');
        var nationalTeamId = favourite.attr('data-team_id');
        $.ajax({
            url: 'nationalTeamSite.php',
            type: 'POST',
            dataType: 'json',
            data: {user_id: userId, national_team_id: nationalTeamId},
            complete: function () {
                $('div.vote').html('<div class="text-center alert alert-success">' +
                    '<strong>Kibicujesz :)</strong>' +
                    '</div>');
            }
        });
    });

});