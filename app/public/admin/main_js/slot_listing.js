$("document").ready(function() { 
    $(".slot_tab").trigger('click');
    $(".slot_listing").css({"color": "white"});
});

var table = $('#slotl_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});