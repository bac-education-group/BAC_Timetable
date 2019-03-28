<?php
ob_start();
require_once('../../../../../wp-load.php');
ob_end_clean();
global $wpdb;

////////////////////////////////
///// ADMIN TIME TABLE PAGE ////
///////////////////////////////


if (isset($_GET['name']) && $_GET['name'] == "COURSE") {
	$departid = $_GET['id'];
	$academic_results=$wpdb->get_results("SELECT a.*,co.course_name,co.course_id FROM wp_qrs_academic a
		LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id where co.course_id = '$departid'");
// echo json_encode($academic_results);
	foreach ($academic_results as  $value) {
		echo '<option value="'.$value->academic_id.'">'.$value->academic_name.'</option>';
	}
}
if (isset($_GET['del']) && $_GET['del'] == "DEL") {
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	if($id){
		$delresults = $wpdb->query("DELETE FROM wp_qrs_timetable WHERE timetable_id = $id");
	}
}


////////////////////////////////
////// ADD COURSE PAGE /////
///////////////////////////////

if (isset($_POST['c_form']) && $_POST['c_form'] == "courseForm") {
	$data = array(
		'course_code'=> $_POST['c_code'],
		'course_name'=> $_POST['c_name'],
		'college'=> $_POST['college'],
	);
	$table = 'wp_qrs_course';
	$query = $wpdb->insert($table, $data);
	if ($query) {
		echo 'success';
	} else {
		echo 'error';
	}
}


////////////////////////////////
////// ADD ACADEMIC PAGE /////
///////////////////////////////

if (isset($_POST['a_form']) && $_POST['a_form'] == "academicForm") {
	$data = array(
		'course_id'=> $_POST['course'],
		'academic_name'=> $_POST['academic'],
		'start_date'=> $_POST['s_date'],
		'end_date'=> $_POST['e_date'],
	);
	$table = 'wp_qrs_academic';
	$query = $wpdb->insert($table, $data);
	if ($query) {
		echo 'success';
	} else {
		echo 'error';
	}
}


////////////////////////////////
////// ADD LOCATION PAGE /////
///////////////////////////////

if (isset($_POST['l_form']) && $_POST['l_form'] == "locationForm") {
	$data = array(
		'loc_campus'=> $_POST['campus'],
		'loc_floor'=> $_POST['floor'],
		'loc_room'=> $_POST['room'],
		'capacity'=> $_POST['capacity'],
		'roomtype'=> $_POST['room_type'],
		'status'=> $_POST['status'],
		'open_time'=> date('h:i a', strtotime($_POST[ 'o_time' ])),
		'close_time'=> date('h:i a', strtotime($_POST[ 'c_time' ])),
	);
	$table = 'wp_qrs_location';
	$query = $wpdb->insert($table, $data);
	if ($query) {
		echo 'success';
	} else {
		echo 'error';
	}
}

////////////////////////////////
///// LEVEL 1 & 2 APPROVES ////
///////////////////////////////

if (isset($_GET['apr']) && $_GET['apr'] == "APPROVE") {
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	$level = isset($_GET['level']) ? $_GET['level'] : '';
	if($id){
		$approve = $wpdb->query("UPDATE wp_qrs_timetable SET approve = $level WHERE timetable_id = $id");
		if ($approve) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

////////////////////////////////
///// UPDATE INFOMATION PAGE ////
///////////////////////////////

if (isset($_GET['name']) && $_GET['name'] == "ACADEMIC") {
	$id = $_GET['id'];
	$subjects=$wpdb->get_results("SELECT sub_id,sub_name FROM wp_qrs_subject WHERE academic_id = $id");
	foreach ($subjects as  $value) {
		echo '<option value="'.$value->sub_id.'">'.$value->sub_name.'</option>';
	}
}

/////////////////////////////////////////
////// Teacher Information insert AND UPDATE /////
////////////////////////////////////////

if(isset($_POST['te_info_submit']) && $_POST['te_info_submit'] == 'te_info_submit'){
	$data_array = array(
		'teacher_id'=> $_POST['te_name'],
		'day'=> $_POST['te_day'],
		'start_time'=> $_POST['te_starttime'],
		'end_time'=> $_POST['te_endtime'],
		'status'=> $_POST['te_status'],
		'te_location'=> $_POST['te_location'],
	);
	$table = 'wp_teacher_information';
	$rowResult = $wpdb->insert($table, $data_array);

	if ($rowResult) {
		echo 'success';
	} else {
		echo 'error';
	}
}

if(isset($_POST['te_update_submit']) && $_POST['te_update_submit'] == 'te_update_submit'){

	$teacher_id = $_POST['te_update_tid'];
	$id = $_POST['te_update_id'];
	$day = $_POST['te_update_day'];
	$start_time =  $_POST['te_update_starttime'];
	$end_time =  $_POST['te_update_endtime'];
	$status = $_POST['te_update_status'];
	$te_location = $_POST['te_update_location'];

	$te_update = $wpdb->query("UPDATE `wp_teacher_information` SET `day`= '$day', `start_time`= '$start_time', `end_time`= '$end_time' ,`status`= '$status' ,`te_location`= '$te_location' WHERE id = '$id'" );

	if ($te_update) {
		echo 'success';
	} else {
		echo 'error';
	}
}

///////////////////////////////////////////////
////// Teacher Information Delete Started /////
///////////////////////////////////////////////

if (isset($_GET['del']) && $_GET['del'] == "DEL") {
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	if($id){
		$delresults = $wpdb->query("DELETE FROM wp_teacher_information WHERE id = $id");
	}
}

///////////////////////////////////////////////
////// New Subject insert /////
///////////////////////////////////////////////

if(isset($_POST['sub_submit']) == "sub_submit"){
 
	$data_array = array(
		'course_id'=> implode(', ', $_POST['sub_course']),
		'academic_id'=> implode(', ', $_POST['sub_academic']),
		'sub_name'=> $_POST['new_subject'],
		'sub_campus'=> $_POST['sub_campus'],
		'sub_lecturer'=> $_POST['sub_lecturer'],
		'sub_classtype'=> $_POST['sub_classtype'],
		'sub_classduration'=> $_POST['sub_classduration'],
		'sub_recurrence'=> $_POST['sub_recurrence'],
	);
	$table = 'wp_qrs_subject';
	$rowResult = $wpdb->insert($table, $data_array);

	if ($rowResult) {
		echo 'success';
	} else {
		echo 'error';
	}

}