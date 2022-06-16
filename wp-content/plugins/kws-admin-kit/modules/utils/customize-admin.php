<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


function kws_login_logo() { ?>
    <style type="text/css">
        body.login {
            background-color: #EFF6F7;
        }
        #login h1 a, .login h1 a {
            background-image: url(wp-content/uploads/logo.png);
            height: 51px;
            width:300px;
            background-size: 300px 51px;
            background-repeat: no-repeat;
            padding-bottom: 10px;
        }
        .login #loginform, .login #lostpasswordform {
            background: #069EA55E;
            border: 1px solid #088A91;
        }
        .login #loginform input, .login #lostpasswordform input {
            border: 1px solid #088A91;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'kws_login_logo' );



function kws_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'kws_login_logo_url' );
 
function kws_login_logo_url_title() {
    return 'K W S';
}
add_filter( 'login_headertitle', 'kws_login_logo_url_title' );