<?php
/**
 * @package Timetable
 */
/*
Plugin Name: Timetable BAC
Plugin URI: https://akismet.com/
Description: This is 1st version of the timetable plugin for BAC.
Version: 1.0.1
Author: Ajayvarma
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: timetable-bac
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );

register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );


add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
	global $wpdb;
	$current_user   = wp_get_current_user();
	$role_name      = $current_user->roles[0];
	add_menu_page( 'TimeTable Page', 'TimeTable', 'manage_options', 'time-table', 'admin_timetable','dashicons-calendar', null );
	add_submenu_page( 'time-table', 'TimeTable', 'Main TimeTable', 'manage_options', 'time-table', 'admin_timetable');

	if ($role_name == "administrator") {
		add_submenu_page('time-table', 'addcourses', 'Add New Course', 'manage_options', 'add-new-course','add_courses');
		add_submenu_page('time-table', 'addacademic', 'Add New Academic', 'manage_options', 'add-new-academic','add_academic');
		add_submenu_page('time-table', 'addlocation', 'Add New Location', 'manage_options', 'add-new-location','add_location');
		add_submenu_page('time-table', 'addnewsubject', 'Add New Subject', 'manage_options', 'add-new-subject','add_new_subject' );
		add_submenu_page('time-table', 'Hidden!', null, 'manage_options', 'add-teacher-information','add_teacher_information' );
		add_submenu_page('time-table', 'teacherlist', 'Teacher List', 'manage_options', 'teacher-list','teacher_list' );
		
	}
	if($role_name == "administrator" || $role_name == "level1"){
		add_submenu_page('time-table', 'Level1', 'Level1', 'manage_options', 'time-table-level1','admin_level1_timetable' ); 
	}
	if ($role_name == "administrator" || $role_name == "level2") {
		add_submenu_page('time-table', 'Level2', 'Level2', 'manage_options', 'time-table-level2','admin_level2_timetable' );
	}
	if ($role_name == "administrator") {
		add_submenu_page('time-table', 'rejectedtimetable', 'Rejected TimeTable', 'manage_options', 'rejected-time-table','rejected_timetable' );
	}
	add_submenu_page('time-table', 'Hidden!', null, 'manage_options', 'update-time-table','edit_timetable' );
}


function add_courses() {

	include( plugin_dir_path( __FILE__ ) . 'template/add_courses.php');
}

function add_academic() {

	include( plugin_dir_path( __FILE__ ) . 'template/add_academic.php');
}

function add_location() {

	include( plugin_dir_path( __FILE__ ) . 'template/add_location.php');
}

function add_teacher_information() {
	
	include( plugin_dir_path( __FILE__ ) . 'template/add_teacher_information.php');
}
function teacher_list() {
	
	include( plugin_dir_path( __FILE__ ) . 'template/teacher_list.php');
}
function add_new_subject() {
	
	include( plugin_dir_path( __FILE__ ) . 'template/add_new_subject.php');
}


function select_timetable(){

	include( plugin_dir_path( __FILE__ ) . 'template/user_timetable.php');
	
}


function getUsers(){

include( plugin_dir_path( __FILE__ ) . 'template/getUsers.php');

}


function edit_timetable() {

	include( plugin_dir_path( __FILE__ ) . 'template/edit_timetable.php');
}


function admin_timetable(){

	global $wpdb;
	$current_user   = wp_get_current_user();
	$role_name      = $current_user->roles[0];
	if($role_name == "administrator"){

		include( plugin_dir_path( __FILE__ ) . 'template/admin_timetable.php');
	}
}

function rejected_timetable(){

	include( plugin_dir_path( __FILE__ ) . 'template/rejected_timetable.php');
}


function admin_level1_timetable(){

	include( plugin_dir_path( __FILE__ ) . 'template/admin_level1_timetable.php');
};



function admin_level2_timetable(){

	include( plugin_dir_path( __FILE__ ) . 'template/admin_level2_timetable.php');
}


function tfd_shortcode(){

	select_timetable();
	
}
add_shortcode( 'timetable_form_data', 'tfd_shortcode');

function course_list() {
	global $wpdb;
	$course_results = $wpdb->get_results("SELECT course_id, course_name FROM wp_qrs_course");
	return $course_results;
}
add_shortcode('course_list', 'course_list');

function teacher_results() {
	global $wpdb;
	$teacher_results = $wpdb->get_results("select * from wp_qrs_teacher");
	return $teacher_results;
}
add_shortcode('teacher_results', 'teacher_results');

function teacher_info($tinfo) {
	global $wpdb;
	$teacher_info = $wpdb->get_results("select a.*, te.first_name from wp_teacher_information as a LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid where a.teacher_id = $tinfo");
	return $teacher_info;
}


function teacher_info_single($tinfo) {
	global $wpdb;
	$teacher_info_single = $wpdb->get_row("select a.*, te.first_name from wp_teacher_information as a LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid where a.teacher_id = $tinfo");
	return $teacher_info_single;
}

function teacher_info_edit($tinfoid) {
	global $wpdb;
	$teacher_info_edit = $wpdb->get_row("select * from wp_teacher_information where id = $tinfoid");
	return $teacher_info_edit;
}

function rejected_table() {
	global $wpdb;
	$rejected_table = $wpdb->get_results("SELECT a.*,co.course_name,se.academic_name,sub.sub_name,lo.loc_room,lo.loc_floor,lo.loc_campus,te.tid,te.first_name FROM wp_qrs_timetable a 
		LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id
		LEFT OUTER JOIN wp_qrs_academic se ON a.academic_id = se.academic_id
		LEFT OUTER JOIN wp_qrs_subject sub ON a.subject_id = sub.sub_id
		LEFT OUTER JOIN wp_qrs_location lo ON a.location = lo.id
		LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid 
		where a.approve = 3");
	return $rejected_table;
}
add_shortcode('rejected_table', 'rejected_table');

function level1_table() {
	global $wpdb;
	$level1_table = $wpdb->get_results("SELECT a.*,co.course_name,se.academic_name,sub.sub_name,lo.loc_room,lo.loc_floor,lo.loc_campus,te.tid,te.first_name FROM wp_qrs_timetable a 
		LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id
		LEFT OUTER JOIN wp_qrs_academic se ON a.academic_id = se.academic_id
		LEFT OUTER JOIN wp_qrs_subject sub ON a.subject_id = sub.sub_id
		LEFT OUTER JOIN wp_qrs_location lo ON a.location = lo.id 
		LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid 
		where a.approve = 0");
	return $level1_table;
}
add_shortcode('level1_table', 'level1_table');

function level2_table() {
	global $wpdb;
	$level2_table = $wpdb->get_results("SELECT a.*,co.course_name,se.academic_name,sub.sub_name,lo.loc_room,lo.loc_floor,lo.loc_campus,te.tid,te.first_name FROM wp_qrs_timetable a
			LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id
			LEFT OUTER JOIN wp_qrs_academic se ON a.academic_id = se.academic_id
			LEFT OUTER JOIN wp_qrs_subject sub ON a.subject_id = sub.sub_id
			LEFT OUTER JOIN wp_qrs_location lo ON a.location = lo.id 
			LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid 
			where a.approve = 1");
	return $level2_table;
}
add_shortcode('level2_table', 'level2_table');




function load_custom_wp_admin_style($hook) {
	// global $wp_styles;

	/*
	 * Loads our main javascript.
	 */	
	// $uri_path = $_SERVER['REQUEST_URI'];
	// $uri_segments = explode('/', $uri_path);
	// if ( in_array($uri_segments[2], array("courses","course")) || is_page('course') ) {
	// if ( is_page('course') ) { }
	wp_enqueue_style( 'z_bootstrapstyle', plugin_dir_url(__FILE__).'assets/bootstrap.min.css', false, '1.0.0' );
	// wp_enqueue_style( 'z_dataTablesres', plugin_dir_url(__FILE__).'assets/datatables/dataTables.responsive.css' );
	// wp_enqueue_style( 'z_dataTablesboot', plugin_dir_url(__FILE__).'assets/datatables/dataTables.bootstrap.css' );
	wp_enqueue_style( 'z_dataTables', plugin_dir_url(__FILE__).'assets/datatables/jquery.dataTables.min.css' );
	wp_enqueue_style( 'z_fontawesome', plugin_dir_url(__FILE__).'assets/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'z_customstyle', plugin_dir_url(__FILE__).'assets/custom-styles.css' );

	wp_enqueue_style( 'select2', plugin_dir_url(__FILE__).'assets/select2.css' );

	wp_enqueue_style( 'timepicker', plugin_dir_url(__FILE__).'assets/jQuery.timepicker.min.css' );

	wp_enqueue_script( 'jquery3script', plugin_dir_url(__FILE__).'assets/jquery_3.3.1.min.js', array('jquery'), 'v3.0.0', true );
	wp_enqueue_script( 'jquery1script', plugin_dir_url(__FILE__).'assets/jquery_1.10.2.min.js', array('jquery'), 'v1.0.0', 'true' );
	wp_enqueue_script( 'popperscript', plugin_dir_url(__FILE__).'assets/popper.min.js', array('jquery'), 'v1.0.0', true );
	wp_enqueue_script( 'bootstrapscript', plugin_dir_url(__FILE__).'assets/bootstrap.min.js', array('jquery'), 'v4.0.0', true );
	wp_enqueue_script( 'select2', plugin_dir_url(__FILE__).'assets/select2.js', array('jquery'), 'v4.0.5', true );
	wp_enqueue_script( 'dataTablesscript', plugin_dir_url(__FILE__).'assets/datatables/jquery.dataTables.min.js', array('jquery'), 'v1.0.0', true );

	wp_enqueue_script( 'timepicker', plugin_dir_url(__FILE__).'assets/jquery.timepicker.min.js' );
	// wp_enqueue_script( 'dataTablesscript', plugin_dir_url(__FILE__).'assets/datatables/dataTables.bootstrap.min.js', array('jquery'), 'v1.0.0', true );
	// wp_enqueue_script( 'dataTablesscript', plugin_dir_url(__FILE__).'assets/datatables/dataTables.responsive.min.js', array('jquery'), 'v1.0.0', true );
	wp_enqueue_script( 'custom', plugin_dir_url(__FILE__).'assets/custom.js' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style');


?>