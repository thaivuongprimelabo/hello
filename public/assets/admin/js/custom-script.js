$(window).on('hashchange', function () {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getPosts(page);
        }
    }
});
$(document).ready(function () {
    $(document).on('click', '.pagination a', function (event) {
        console.log('Click');
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getPosts(page);
    });
});
function getPosts(page) {
    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
    }).done(function (data) {
        $('.users').empty().html(data);
        location.hash = page;
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('No response from server');
    });
}

function edit(ob) {
    window.location.href = '/admin/users/edit/' + $(ob).attr("data-id") + '?_token=' + $(ob).attr("data-token");
}