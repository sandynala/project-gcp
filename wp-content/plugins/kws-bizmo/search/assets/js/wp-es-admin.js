/* 
    Admin page JavaScript
    Author     : kwstech
*/

// jQuery ready function.
jQuery(document).ready(function (){
    
    // Load the options on setting change.
    jQuery('#kwsessid').change(function (){
        var value = jQuery(this).val();
        
        if ( value === 'new' ) {
            window.location.href = kwses_admin_vars.new_setting_url;
        } else if ( value !== '' ) {
            window.location.href = kwses_admin_vars.admin_setting_page + '&kwsessid=' + parseInt(value);
        } else {
            window.location.href = kwses_admin_vars.admin_setting_page;
        }
    });
    
    // Save the setting when WC optimization clicked.
    jQuery('#es_wc_search').change(function (){
        var response = confirm( kwses_admin_vars.wc_setting_alert_txt );
        if (response) {
            jQuery('#submit').trigger('click');
        } else {
            jQuery(this).prop('checked', !jQuery(this).prop('checked'));
        }
    });
    
    // Load the jQuery UI datepicker.
    jQuery('#es_exclude_date').datepicker({ 
        maxDate: new Date(),
        changeYear: true,
        dateFormat: "MM dd, yy" 
    });
    
    // Bind Select2.
    jQuery('.kwses-select2').select2({
        placeholder: kwses_admin_vars.select2_str_placeholder,
        language: {
            noResults: function () {
                return kwses_admin_vars.select2_str_noResults;
            }
        }
    });
    
});

