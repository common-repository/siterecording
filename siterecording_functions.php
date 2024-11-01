<?php

/**
 * initializing the plugin
 * @param $class_name
 */
function siterecording_class_loader($class_name)
{
    $class_file = siterecording_DIR . 'classes/class.'
        . trim(strtolower(str_replace('\\', '_', $class_name)), '\\') . '.php';
    if (is_file($class_file)) {
        require_once $class_file;
    }
}

/**
 * To add the token to DB
 */
function siterecording_addtoken()
{
    $token_value = sanitize_text_field($_POST['token_value']);
    if (get_option('user_token')) {
        update_option('user_token', $token_value);
        echo "updated";
    } else if (get_option('user_token') == "") {
        update_option('user_token', $token_value);
        echo "updated";
    } else {
        add_option('user_token', $token_value);
        echo "added";
    }
}


/** To extract the Token **/
function siterecording_extract_token()
{
    $token         = get_option('user_token');
    $tokenParts    = explode(".", $token);
    $tokenHeader   = base64_decode($tokenParts[0]);
    $tokenPayload  = base64_decode($tokenParts[1]);
    $jwtHeader     = json_decode($tokenHeader);
    $jwtPayload    = json_decode($tokenPayload);
    return $jwtPayload;
}

/**
 * To save the website name
 */
function siterecording_save_website() {
  $website_region = sanitize_text_field($_POST['website_region']);
  $pushninja_website_key = sanitize_text_field($_POST['website_apikey']);
  $pushninja_installscript = sanitize_text_field($_POST['website_installscript']);
  $pushninja_verify = sanitize_text_field($_POST['website_verify']);
  if($_POST && isset($pushninja_website_key)){
    $results = json_decode(get_option('siterecording_website'), true);
    if ( ! is_array($results)) {
      $results = array();
    }
    $results['website_region'] = $website_region;
    $results['website_apikey'] = $pushninja_website_key;
    $results['website_installscript'] = $pushninja_installscript;
    $results['website_verify'] = $pushninja_verify;
    update_option('siterecording_website', json_encode($results));
    echo "updated";
  }
  else {
    echo "not update";
  }
}

/**
 * To append the siterecording script to footer
 */
function siterecording_script() {
  $results = json_decode(get_option('siterecording_website'), true);
  $website_apiKey = $results['website_apikey'];
  $website_region = $results['website_region'];
  ?>
   <script>
        (function(s, i, t, e, r, p) {
      p = i.getElementsByTagName('head')[0];
      r = i.createElement('script');
      r.async = 1;
      r.src = t + e;
      r.onload = () => {
          s._sr_r_.init('<?php echo esc_html($website_apiKey) ?>',5,'<?php echo esc_html($website_region) ?>')
    };
    p.appendChild(r);
    })(window, document, 'https://infinity-public-js.500apps.com/siterecording/', 'siterecorder.min.js');
    </script>
   <?php
 }