<?php
add_filter('query_vars', function ($vars) {
    $vars[] = 'my_custom_page_type';
    $vars[] = 'step';
    $vars[] = 'second_page';
    $vars[] = 'third_page';
    $vars[] = 'username';
    $vars[] = 'pid';
    $vars[] = 'post_id';
    $vars[] = 'page';
    return $vars;
});
add_action('generate_rewrite_rules', function($wp_rewrite) {
    global $wp_rewrite;
    $new_rules = array(
        'user/?$' => 'index.php?my_custom_page_type=user&step=1',
        'user/([^/]+)/?$' => 'index.php?my_custom_page_type=user&paged=1&second_page=' . $wp_rewrite->preg_index(1)
    );  
    $wp_rewrite->rules = $new_rules+$wp_rewrite->rules ;
});
add_action("template_redirect", function () {
    global $wp;
    global $wp_query, $wp_rewrite;
    if(!empty($wp_query->query_vars['my_custom_page_type'])){
        if ($wp_query->query_vars['my_custom_page_type'] == "user") {
            require ('templates_loader.php');
            die();
        }
    }
});
?>