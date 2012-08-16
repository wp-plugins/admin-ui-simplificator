<?php

// this will make the plugin not call WordPress functions to register.
// we just need access to the crawler class
//$_ENV['ORBISIUS_WP_ADMIN_UI_SIMPLIFICATOR_TEST'] = 1;

require_once(dirname(__FILE__) . '/' . 'wp-admin-ui-simplificator.bootstrap.php');
require_once(dirname(__FILE__) . '/' . 'wp-admin-ui-simplificator.php');

// http://codex.wordpress.org/Function_Reference/wp_upload_dir
$upload_dir = wp_upload_dir();

$buff = '';

$default_content = <<<EOF
<!-- wp_content: default -->
<div class="dashed_border">
    <h3>FREE e-book</h3>
    <a target="_blank" href="http://orbisius.com/go/intro2site?s=wp_admin_ui_simplificator">Free e-book: How to Build a Website Using WordPress: Beginners Guide</a>
</div>

<h3>More Plugins by <a href="http://orbisius.com" target="_blank">http://orbisius.com</a></h3>
<div class="link_list_container">
    <ul class="link_list">
        <li><a href='http://webweb.ca/site/products/digishop/' target='_blank'>DigiShop</a></li>
        <li><a href='http://webweb.ca/site/products/admin_ui_simplificator/' target='_blank'>Admin UI Simplificator</a></li>
        <li><a href='http://webweb.ca/site/products/wordpress-simple-paypal-shopping-cart-ui/' target='_blank'>UI for WordPress Simple Paypal Shopping Cart</a></li>
        <li><a href='http://webweb.ca/site/products/wp-mibew/' target='_blank'>WP Mibew</a></li>
        <li><a href='http://webweb.ca/site/products/wp-member-status' target='_blank'>WP Member Status</a></li>
        <li><a href='http://webweb.ca/site/products/wp-partner-watcher/' target='_blank'>WP Partner Watcher</a></li>
        <li><a href='http://webweb.ca/site/products/like-gate/' target='_blank'>Like Gate</a></li>
    </ul>
</div>

<!-- /wp_content: default -->

EOF;

if (!empty($upload_dir['basedir'])) {
    $file = $upload_dir['basedir'] . '/' . $orb_wp_simple_ui_obj->get('plugin_id_str') . '.cache.html';

    // cache is good and hasn't expired yet. then use it.
    if (file_exists($file) && (abs(time() - filemtime($file)) <= 24 * 3600)) {
        $buff = Orbisius_WP_Admin_UI_SimplificatorUtil::read($file);
    } else {
        $params = array(
            'plugin_id_str' => $orb_wp_simple_ui_obj->get('plugin_id_str'),
        );
        
        $service = new Orbisius_WP_Admin_UI_SimplificatorService('wp.get_content', $params);

        if ($service->call()) { // cache the result and save it in the db
            $data = $service->get_data();
            $buff = $data['content'];

            if (!empty($buff)) {
                $buff .= "<!-- fetched on: " . date('r') . " --> \n";
                Orbisius_WP_Admin_UI_SimplificatorUtil::write($file, $buff);
            }
        }
    }
}

$buff = empty($buff) ? $default_content : $buff;

echo $buff;
