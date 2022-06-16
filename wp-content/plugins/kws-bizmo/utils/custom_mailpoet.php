<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * This file can be optimized to externalize the post views updation
*/
// Header
add_filter('mailpoet_newsletter_shortcode', 'mailpoet_custom_shortcode_header', 10, 6);
function mailpoet_custom_shortcode_header($shortcode, $newsletter, $subscriber, $queue, $newsletter_body, $arguments) {

  // always return the shortcode if it doesn't match your own!

  if ($shortcode !== '[custom:news_header]') return $shortcode;

  $news_header = '<div style="font-family:system-ui;background-color:#F8F8F8;max-width: 660px;margin: auto;"><div style=" border-bottom: 1px solid #e0e0e0;"><div style="background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAAGCAYAAAAffeByAAAABHNCSVQICAgIfAhkiAAAALRJREFUaEPt1rENwkAQRNFzB1RC6jqoiy5ogdRy5IyIIsiQKMFETtzAaLXvGrjR2+RP1+e6D48AAQIESghc5q3EzvPI+1hK7j5Gf76Psvtv+7vs9vH6ld0+CayytzOcAIGGAgIrc3SBlXEXWCF33xIgQKCbgMDKXFxgZdwFVsjdtwQIEOgmILAyFxdYGXeBFXL3LQECBLoJCKzMxQVWxl1ghdx9S4AAgW4CAitzcYGVca8cWH8zTUN70gN/JgAAAABJRU5ErkJggg==); height: 6px; background-size: 100%; background-repeat: no-repeat;"></div><div style="margin: 0 40px;"> <a href="#" target="_blank" style="display:inline-block;"><img src="data:image/png;base64,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" alt="img" style="margin:22px 0;display:inline-block;max-width:100%;"></a></div></div></div>';

  return $news_header;

}

// footer
add_filter('mailpoet_newsletter_shortcode', 'mailpoet_custom_shortcode_footer', 10, 6);
function mailpoet_custom_shortcode_footer($shortcode, $newsletter, $subscriber, $queue, $newsletter_body, $arguments) {

  // always return the shortcode if it doesn't match your own!

  if ($shortcode !== '[custom:social_icon]') return $shortcode;

  $footer =   '<div style=" margin-bottom: 50px;text-align: center;">
  <ul style="padding: 0; margin: 0; list-style: none;">
      <li style=" display: inline-block; margin-right: 30px;"><a href="#"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAsAAAAUCAYAAABbLMdoAAAABHNCSVQICAgIfAhkiAAAAKNJREFUKFNjZMACpk6dmsDIyJgPlDJAkj7IiK522rRpC4Bi8VjMQFUMNXE+NtuAYqiKgaZeAArqE6v4P7LCnz9/ChYWFn6AiaG4GWgyiuKsrCwUedIUT58+3eE/EECtOoDmXgcYH6jkIyO61Tg8BxJeSLRioMmJRCsGxqgiSDGyO+3RnHEQxAcq/JCZmRlAWmggm0TdcB4GJqOkDWCqg6cNkN8ANmFbcj3GWI4AAAAASUVORK5CYII="
                  alt="img" style=" vertical-align: middle;max-width:100%;"></a></li>
      <li style=" display: inline-block; margin-right: 30px;"><a href="#"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAARCAYAAAAyhueAAAAABHNCSVQICAgIfAhkiAAAAelJREFUOE+NlM9RwlAQxg0MAzewAqECsAJiBcYKxCNwgFQgVEA8AEehArACoQOoQKxAvMEF/H2ZPOYRgpCZnST759vdb98+5yZ6hsNhsV6vr8x/0nswGHjoW4iLrBzHmW02Gz+XyxX2+30PXaXRaJQcBQPoovxEXprN5igJsN/vdwB5xfaLLJACUkbW0bfCvgEthqBUIKBnfScBm6SYl9vt1vV9X0CmmGlURJ7YLkV1DKjalmMRySMBwV0rOCCgRaWlOEWiDduXndCA7lHOAfKy2awyV6PsU4AWBNWUkNZCf/uxqAurlM0GHROk4Bv4q6VSKQ+wRwsg5CsOGg1vQvIHupjFQecEuUmVRLpV0ukwA0wCVYYyoLdx0Ev/tH/Cd9i+yfbfkToHTvsr2WxqQtBer1dgQDL+MKx7M/UrqgzPN62/QU3b+B+mqeFgfMew4P10absEQJWirRo/akdHxAJe4xgA3D1XrbVhh1NzUqlRWM5S+XAVxIGpUK1q15fYK3G7IweqKsNNEaMctNN6xvDbtvmNuJ9gcwVInJdEk0C1nlpN82iDdLHo0giHmMlkqul0WstQk06D4XbqnBuoE2WXs1q6i7di/wP2AfCIls0lkuh+NCjt8W63cwkWFRJVpcp1d06vORGK+QPljCEh9OG5wgAAAABJRU5ErkJggg=="
                  alt="img" style=" vertical-align: middle; max-width:100%;"> </a></li>
      <li style=" display: inline-block; margin-right: 30px;"><a href="#"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABHNCSVQICAgIfAhkiAAAAidJREFUOE+dVUtOAkEQtUMMLCEewHHpivEE4gmUE4iJCQEWMicQl64GF0BYiSdwdi7RE4g3GE4g7gATxvfabtJ0oBnopEN/al69qnpdiANj9Ho9L0mSOxz5mCXzbsN6JIQY4e6lVqu9mzZCb7rdbhPre8w85hgzTgFM26Kya89ms4cgCCbcS2AFGhIQDCq2d5eDMAzzuVxugEgvYRfV6/WyBFbhf2L9A4++9piC7YoJcNoqjQHA2wSWB2B6sQtTFektfo8A9Ejm2WyW+U6wPxFIA5PuYeO5WHY6HX8+n8dmRPj2DaS8RqNxym81SUReIHCCsw8Al2xgxYIFrWCyUBxUQqCj6/f7h9Vq9ZcXcF7B3TOj3wisQIewp/S+wCzCB3R+ThDsb8B0YJIB4xLOh05geG/BgGzLiCbSAKrYOpeFnYGRIupxtC5FDqfbGbtyr0OGYyktI5pUwGT8TenYRTWLZEo0VY7BmIW5tvWtisoHVYCsPFN+qYAVQEwBADxCtflsfazZU9is9lOF0iWBmEMpMTV+ANq0pcY7RHmFn1ctNy2dMzuXes9XB2MPc+J69lotsJNPWuaSz3DfBqQJAIskiyi4YBOSEsHBsuVtYu46160XbJ8QVVP2Y6PlrTTrtA6MP4ll65XAVrOmEviEGRbXa8dischnMhkf0bJg7CdjrlFUfvf/D2LkiFLiPE7LVoIg/Ol02jJrtAKswVQEZLFtxMjn2qj+ACvLi/WZBcLyAAAAAElFTkSuQmCC"
                  alt="img" style=" vertical-align: middle;max-width:100%;"></a></li>
      <li style=" display: inline-block; margin-right: 30px;"><a href="#"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAATCAYAAACQjC21AAAABHNCSVQICAgIfAhkiAAAATRJREFUOE9jnDZtWgoDA0MnEP/6//9/QXZ29kogm2zACDTwLVC3ENSEO1lZWapkmwbUCDLwOZCWgBpyHWigFkUGTp06NZyRkbEFaMhvIC4FGriVIgMp0YxNLyPVDZwyZYo8sqE5OTkPsVkyffp0BaB4PTAlBABpAaiaC0B6AjCYFsL0gCLlP5IB74CSwugGAg1zABq0HskgdCUbfv78mVhYWPiBoIEglwENO4/HMLDhwIidmJmZWUDQQKAPFgDVx6M56SKQDwoCfmRxoKGKxBj4AU1jIDBYNvT39wuws7NvAMrZwwwF+qQRr4FQTe+RXHERaJgBjA90PSiCQGELAwvxGgiNjP1IGg4CDXSA8bHJjxrIgJKwB00YrkJOnMBYDIPxgUWbATCxToDnU0bGC6DcgE8eAAUa6/vaOKdoAAAAAElFTkSuQmCC"
                  alt="img" style=" vertical-align: middle;max-width:100%;"></a></li>
      <li style=" display: inline-block;"><a href="#"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAASCAYAAABfJS4tAAAABHNCSVQICAgIfAhkiAAAAYJJREFUOE/tlDFSwkAUhrM00MkN4AbkBnIDba2ExplAITmB4QRJAxk77OzUG4TSwhm8AdwAO2iI3+9smIAg0bTuzJvs7uz73v9e3q5xGHEcR2maXjOta11iLPGd9Ho934zH4wGLEFtg8xJQuTaxBiK7As9YtIwxV57nPZYBw7rB/x7wq6EMMyYtC4zW6/XQ932lVHiEYVivVqt3OCh7jTcpTpicY1P7VaBuv99XJifHaDRyyfbJliFjTLdgCp6vt8PhgNIMfyIDDTgnpR9YACNCaCqRO2BBrIKJ6o4lOHYJMM8HoHxNspJKF3tn3skyPArOALYFb1kvcfRxVDDHdpFU1tkfsh/kg54E6zDwNs4CNrBnC7jkuyCTDpkk+6UqBJaT/nitVpsQ4MJCHuicwbHOKQzOFOEgpQ4/KFO+L/Zr/WvwQcqBzX/wtigqBR3zYnK3J8q1VNGS7pxTC+qyqL/1COkW6V04+xPtu9OCdnRNrlfdzWbTLgOvVCrJarWaqcc/AbdV8cz0HrC+AAAAAElFTkSuQmCC"
                  alt="img" style=" vertical-align: middle;max-width:100%;"></a></li>
  </ul>
</div>';

  return $footer;

}


function select_subscriber($post_id){
  global $wpdb;
  $result_sub = $wpdb->get_results("SELECT * FROM `kws_mailpoet_subscribers` where `status` = 'subscribed' AND `deleted_at` IS NULL");

 // echo "<pre>";   

 $resultJson_sub = json_encode($result_sub);

 // echo "<script>var resultJson = ".$resultJson."; console.log(resultJson);</script>";

  echo "<script>var resultJson_subscriber = ".$resultJson_sub.";</script>";

  //print_r($resultJson);

  return $resultJson_sub;

}

add_action( 'wp_head', 'select_subscriber' );