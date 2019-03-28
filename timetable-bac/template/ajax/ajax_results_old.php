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
////// Teacher Information Update Started /////
///////////////////////////////

if(isset($_POST['te_update_submit'])){
	$teacher_id = $_POST['te_update_tid'];
	$id = $_POST['te_update_id'];
	$day = $_POST['te_update_day'];
	$start_time =  $_POST['te_update_starttime'];
	$end_time =  $_POST['te_update_endtime'];
	$status = $_POST['te_update_status'];
	$te_location = $_POST['te_update_location'];
	$teachers_info2 = $wpdb->get_results("SELECT * FROM `wp_teacher_information` where teacher_id = $teacher_id  and day = '$day'");
	$x = "true";
	foreach ($teachers_info2 as $teacher_info2){
		if(strtotime($teacher_info2->start_time) < strtotime($start_time) && strtotime($teacher_info2->end_time) > strtotime($start_time) || strtotime($teacher_info2->start_time) < strtotime($end_time) && strtotime($teacher_info2->end_time) > strtotime($end_time) || strtotime($start_time) < strtotime($teacher_info2->start_time) && strtotime($end_time) > strtotime($teacher_info2->start_time)  || strtotime($start_time) == strtotime($end_time)){
			$x= "false";
		}
	}
	if(strtotime($start_time) > strtotime($end_time) || $x == "false") {
		echo "fail";
	}else{
		$te_update = $wpdb->query("UPDATE `wp_teacher_information` SET `day`= '$day', `start_time`= '$start_time', `end_time`= '$end_time' ,`status`= '$status' ,`te_location`= '$te_location' WHERE id = '$id'" );

		if($te_update == 1){
			echo "success";
		}
	}
}

/////////////////////////////////////////
////// Teacher Information insert Started /////
////////////////////////////////////////

if(isset($_POST['te_info_submit'])){
	$teacher_id = $_POST['te_name'];
	$day = $_POST['te_day'];
	$start_time =  $_POST['te_starttime'];
	$end_time =  $_POST['te_endtime'];
	$status = $_POST['te_status'];
	$te_location = $_POST['te_location'];
	$teachers_info2 = $wpdb->get_results("SELECT * FROM `wp_teacher_information` where teacher_id = $teacher_id  and day = '$day'");
	$x = "true";
	foreach ($teachers_info2 as $teacher_info2){
		if(strtotime($teacher_info2->start_time) < strtotime($start_time) && strtotime($teacher_info2->end_time) > strtotime($start_time) || strtotime($teacher_info2->start_time) < strtotime($end_time) && strtotime($teacher_info2->end_time) > strtotime($end_time) || strtotime($start_time) < strtotime($teacher_info2->start_time) && strtotime($end_time) > strtotime($teacher_info2->start_time) || strtotime($teacher_info2->start_time) == strtotime($start_time) || strtotime($teacher_info2->end_time) == strtotime($end_time) || strtotime($start_time) == strtotime($end_time) ){
			$x= "false";
		}
	}
	if(strtotime($start_time) > strtotime($end_time) || $x == "false") {
		echo "fail";
	}else{

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
		if($rowResult == 1){
			echo "success";
		}
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
		if($rowResult == 1){
			echo "ok";
		}

}