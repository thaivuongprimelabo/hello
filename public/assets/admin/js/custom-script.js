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
	$('#table tbody tr').tooltip();
	$('#datetimepicker-from, #datetimepicker-to').datetimepicker({
		format: 'YYYY-MM-DD',
	    locale: 'ja',
	    toolbarPlacement: 'bottom',
	    showTodayButton: true,
	    showClear: true,
	    ignoreReadonly: true,
	    allowInputToggle: true
	});

	$(document).on('click', '#search', function (event) {
		var data = {
        	type 		: $('#type').val(),
        	call_number	: $('#call_number').val(),
        	status		: $('#status').val(),
        	datefrom	: $('#datefrom').val(),
        	dateto		: $('#dateto').val()
        };
        getLogs(1, data);
	});
	
    $(document).on('click', '.pagination a', function (event) {
        console.log('Click');
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // S102
        var divId = $(this).parent().parent().parent().attr('id');
        if(divId === 'paging-monitoring') {
            var data = {
            	type 		: $('#type').val(),
            	call_number	: $('#call_number').val(),
            	status		: $('#status').val(),
            	datefrom	: $('#datefrom').val(),
            	dateto		: $('#dateto').val(),
            	page		: page
            };
            getLogs(page, data);
        } else {
        	getPosts(page);
        }
    });
});
function getLogs(page, data) {
    $.ajax({
        url: '?page=' + page,
        type: "post",
        data: data,
        datatype: "html",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (data) {
        $('#logBox').empty().html(data);
        location.hash = page;
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert(jqXHR.status);
    });
}

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

function detail(ob) {
    window.location.href = '/admin/monitoring/detail/' + $(ob).attr("data-id") + '?_token=' + $(ob).attr("data-token");
}

function edit(ob) {
    window.location.href = '/admin/users/edit/' + $(ob).attr("data-id") + '?_token=' + $(ob).attr("data-token");
}