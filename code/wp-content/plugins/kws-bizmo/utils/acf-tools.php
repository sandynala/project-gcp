<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


function hide_acf_field($field) {
  return false;
}

function hide_readonly_fields() {
    $fields = ["view_count", "share_count", "like_count", "bookmark_count", "thumbs_up_count", "thumbs_down_count"];
    foreach($fields as $field) {
        add_filter("acf/prepare_field/name=" . $field, "hide_acf_field");
    }
}

hide_readonly_fields();