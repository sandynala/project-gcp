<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

function admin_default_page() {
  return '/wp-admin';
}

add_filter('login_redirect', 'admin_default_page');

function suppress_wordpress_errors() {
  return 'Invalid username/password';
}
add_filter('login_errors', 'suppress_wordpress_errors');