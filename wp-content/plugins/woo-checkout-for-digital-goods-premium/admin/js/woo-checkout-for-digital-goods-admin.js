(function($) {
    'use strict';
    $(document).ready(function() {
       // $('.multiselect2').select2();
        $('.wcdg-data-table').DataTable();
        $(".multiselect2").chosen();

        // description toggle
        $   ('span.wcdg_tooltip_icon').click(function (event) {
            event.preventDefault();
            $(this).next('p.description').toggle();
        });


        /*jQuery('#selectall').click(function(event) {  //on click
            if (this.checked) { // check select status
                jQuery('.woo_chk').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            } else {
                jQuery('.woo_chk').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });
            }
        });*/
    });
})(jQuery);