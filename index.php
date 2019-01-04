<?php
/*
Plugin Name: Gym Managment
Plugin URI: https://spidyhost.com/
Description: Add members, membership start date, end date, fees, time slot, trainee allocate, member details like phone number, email etc.
Version: 1.0
Author: Sufyan
Author URI: https://sufyan.in
License: GPLv2 or later
*/


function hs_gym_member_add(){
    include (dirname(__FILE__).'/member_add.php');
}

function hs_gym_members_list(){
	include (dirname(__FILE__).'/member_list.php');
}

function hs_gym_admin_menu(){
    add_menu_page('Gym Members','Gym Members','manage_options','hs_gym_members_list','hs_gym_members_list','dashicons-heart','2');
    add_submenu_page('hs_gym_members_list','Add new member','Add new member','manage_options','hs_gym_member_add','hs_gym_member_add');
    /*add_submenu_page('hs-matrimony','Matrimony Settings','Matrimony Settings','manage_options','hsmat-settings','hsmat_settings'); //**/
}
add_action('admin_menu' , 'hs_gym_admin_menu');

function hs_gym_activate() {
	global $wpdb;
	$table_name = 'hs_gym';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		user_name text NOT NULL,
		gender text NULL,
		phone text NULL,
		email text NULL,
		start_date date NULL,
		end_date date NULL,
		fees text NULL,
		slot text NULL,
		trainee text NULL,
		status text NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'hs_gym_activate' );
