$("document").ready(function() { 
    $(".dashboards").css({"color": "white"});
});


$(function() {
    var start = moment().subtract(0, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.sales_day').html(''+start.format('MMM D, YYYY'));
        sales_day();
    }

    $('.custome_date').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.sal_month').html('  '+start.format('MMM D') + ' - ' + end.format('MMM D'));
        // alert(start);
        s_month_result(start.format('MMM D, YYYY'), end.format('MMM D, YYYY'));
    }

    $('.sales_month').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.del_order').html('  '+start.format('MMM D') + ' - ' + end.format('MMM D'));
        del_order(start.format('MMM D, YYYY'), end.format('MMM D, YYYY'));
    }

    $('.delivered_order').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.canc_order').html('  '+start.format('MMM D') + ' - ' + end.format('MMM D'));
        can_order(start.format('MMM D, YYYY'), end.format('MMM D, YYYY'));
    }

    $('.canceled_order').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.pend_order').html('  '+start.format('MMM D') + ' - ' + end.format('MMM D'));
        pen_order(start.format('MMM D, YYYY'), end.format('MMM D, YYYY'));
    }

    $('.pending_order').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.t_cus').html('  '+start.format('MMM D') + ' - ' + end.format('MMM D'));
        total_customer(start.format('MMM D, YYYY'), end.format('MMM D, YYYY'));
    }

    $('.total_cus').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.to_order').html('  '+start.format('MMM D') + ' - ' + end.format('MMM D'));
        total_order(start.format('MMM D, YYYY'), end.format('MMM D, YYYY'));
    }

    $('.total_order').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,
        startDate: start,
        endDate: end,
    }, cb);

    cb(start, end);
});


function sales_day() 
{
    var s_value = $('.sales_day').html();
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/sales_day",
        data: {s_value:s_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.sales_day_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

function s_month_result(s_value,e_value) 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/sales_month",
        data: {s_value:s_value,e_value:e_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.sales_month_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

$(document).ready(function() {
    total_sale_result();
});


function total_sale_result() 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/total_sale",
        data: {},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.total_s_no').html(append);
            }
        }
    });
}


function del_order(s_value,e_value) 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/delivered_order",
        data: {s_value:s_value,e_value:e_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.delivered_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

function can_order(s_value,e_value) 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/canceled_order",
        data: {s_value:s_value,e_value:e_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.canceled_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

function pen_order(s_value,e_value) 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/pending_order",
        data: {s_value:s_value,e_value:e_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.pending_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

function total_customer(s_value,e_value) 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/total_customer",
        data: {s_value:s_value,e_value:e_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.customer_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

function total_order(s_value,e_value) 
{
    $.ajax({
        type: 'POST',
        url: "./admin/dashboard/total_order",
        data: {s_value:s_value,e_value:e_value},
        // contentType: false,
        // cache: false,
        // processData:false,
        success: function(response)
        {
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var append = '<span class="counter-value" data-target="'+response.data+'">'+response.data+'</span>';
                $('.total_order_no').html(append);
            }
            else
            {
                // toastr.warning(response.message, 'Warning');
            }
        }
    });
}

var table = $('#dashboard_order_listing').DataTable({
    pageLength : 10,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

var table = $('#dashboard_un_sold_listing').DataTable({
    pageLength : 10,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});