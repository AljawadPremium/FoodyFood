gcat_ids = null;
$(document).ready(function()
{
    $(".slider-range-bar").slider({
        range: true,
        min: 0,
        max: 1000,
        values: [0, 300],

        slide: function (event, ui) {
            $(".amount").val("£+" + ui.values[0] + " - £" + ui.values[1]);
            loadPagination(0,"call");
        },
    })

    $('.count_show').on('change', function() {
        loadPagination(0,"call");
    });
    
    $('.sort_by').on('change', function() {
        loadPagination(0,"call");
    });

    $(".pagination").on("click","a",function(e){
        e.preventDefault();
        var ajax="call";    
        var href = $(this).attr('href');
        const hrefarr = href.split("=");
        pageno = hrefarr[1];   
        // var search_type = $("#search_type").val();
        // var search = $("#search_val").val();
        loadPagination(pageno,ajax);
        $('html, body'). animate({scrollTop:460}, 'slow');
    });

    $(document).on('click',".click_pcat",function(){
        loadPagination(0,"call");
    });

    $(document).on("click","#search_btn",function(){
        var pagno=0;
        var ajax="call";
        var search_type = $("#search_type").val();
        var search = $("#search_val").val();

        if(search_type=="" || search_type==0){        
            toastr.warning('Please Select Search Type', 'Warning');
            return false;
        }

        if(search==""){
            toastr.warning('Please Enter Search Value', 'Warning');
            return false; 
        }
        loadPagination(pagno,ajax,search,search_type); 
    });

    function loadPagination(pagno,ajax)
    {
        var price_range = $('#s-amount').val();
        var gcat_ids = $('.cat_id_selected').val();
        var rating_selected = $('.rating_selected').val();
        var search = $('.search_product_input').val();

        var view = $('.view_product').val();
        var count = $(".count_show").val();
        var sort_by = $(".sort_by").val();

        $('#loading').show();
        $.ajax({        
            url: "./products",
            type: 'POST',
            data:{pagno:pagno,ajax:ajax,"gcat_ids":gcat_ids,"count":count,"sort_by":sort_by,"view":view,"price_range":price_range,"rating_selected":rating_selected,"search":search},
            dataType: 'json',
            success: function(response)
            {  
                $('#loading').hide();
                if(response.status==true)
                {
                    $('.show-info').html(response.msg); 
                    $('.pagination').html(response.pagination_link); 
                    var tabledata=response.result;
                    $('.append_search_data').html(tabledata);
                    if (tabledata == '') {
                        $(".toolbox-pagination").css({"border-top": "none"});

                        $('.show-info').html("");
                        $('.append_search_data').html("No record found.");
                    }
                    $('.car_pro_count').text(response.total_rows);
                }else{
                    toastr.warning(response.message, 'Warning'); 
                }
            }
        });
    }

    $('.view_product').val("potrait"); 

    $(document).on('click',".view_check_land",function(){
        $('.view_product').val("landscape");
        loadPagination(0,"call");
    });

    $(document).on('click',".view_check_pot",function(){
        $('.view_product').val("potrait");
        loadPagination(0,"call");
    });

    $(document).ready(function() {
        $(".cat_input_check").on("click", function() {
            var selectedCheckboxes = [];
            // Loop through all checked checkboxes and get their IDs
            $(".check-input:checked").each(function() {
                selectedCheckboxes.push($(this).attr("value"));
            });

            // Join the array into a comma-separated string
            var selectedIds = selectedCheckboxes.join(",");

            $('.cat_id_selected').val(selectedIds);
            // Do something with the selected IDs (log to console in this example)
            console.log("Selected Checkbox IDs: " + selectedIds);
            loadPagination(0,"call");
        });
    });

    $(document).ready(function() {
        $(".pro_radio_btn").on("click", function() {
            // Get the value of the selected radio button
            var selectedRating = $(this).attr("value");

            // Log the selected rating (ID of the radio button clicked)
            console.log("Selected Rating ID: " + selectedRating);

            $('.rating_selected').val(selectedRating);
            loadPagination(0,"call");
        });
    });

    $('.search_product_input').on('keyup', function() {
        var query = $(this).val(); // Get the input value
        loadPagination(0,"call");
    });

});