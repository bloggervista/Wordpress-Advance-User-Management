<?php
if(!is_user_logged_in()) { wp_redirect(home_url()."/wp-login.php"); exit; }
global $wpdb,$wp_rewrite,$wp_query;

add_action( 'wp_print_footer_scripts', function(){
	echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
});
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'users.css', get_template_directory_uri()."/data/css/users.css" );
	wp_enqueue_style( 'Color Navigation', get_template_directory_uri()."/data/css/small-colored-navigation.css" );
});

$current_page = !empty($wp_query->query_vars['second_page'])?$wp_query->query_vars['second_page']:"home";
	global $current_user;
	get_currentuserinfo();
	$user_id = $current_user->ID;

	if(get_user_meta($user_id,"new_user",true)=="1"){
		include('templates/user_information_form.php');
		die();
	}
	get_header();
	include("templates/navigation.php");
	switch ($current_page) {
	case "home":
	include('templates/dashboard.php');
	break;
	case "edit":
	include('templates/edit-post.php');
	break;
	case "delete":
	include('templates/delete-item.php');
	break;
	case "download-page":
	include('templates/download-page.php');
	break;
	case "settings":
	include('templates/settings.php');
	break;
	case "notes":
	include('templates/notes.php');
	break;
	case "post-published":
	include('templates/post-published.php');
	break;
	case "new-note":
	include('templates/new-note.php');
	break;
	case "entrance":
	include('templates/entrance.php');
	break;
	default:
	include('templates/dashboard.php');
	break;
	break;
}
get_footer();
?>