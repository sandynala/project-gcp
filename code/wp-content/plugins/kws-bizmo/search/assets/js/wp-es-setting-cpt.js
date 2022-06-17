/* 
    Setting CPT JS
    Author     : kwstech
*/

// jQuery ready function.
jQuery(document).ready(function (){
    
    // Select and copy the code to clipboard.
    jQuery('.kwses-display-input').click(function (){
        jQuery(this).select();
        document.execCommand('copy');
        jQuery(this).parent('td').append('<span class="kwses-copied">'+ kwses_admin_cpt_vars.str_copy +'</span>');
        jQuery('.kwses-copied').fadeOut(2000, function (){
            jQuery(this).remove();
        });
    });
    
});
