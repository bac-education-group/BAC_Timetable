<?php
if (isset($_GET['id'])) {
	ob_start();
	require_once('../../../../../wp-load.php');
	ob_end_clean();
	global $wpdb;
	$departid = $_GET['id'];
	$academic_results=$wpdb->get_results("SELECT a.*,co.course_name,co.course_id FROM wp_qrs_academic a
		LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id where co.course_name = '$departid'");
// echo json_encode($academic_results);
	foreach ($academic_results as  $value) {
		echo '<option value="'.$value->academic_id.'">'.$value->academic_name.'</option>';
	}
}

?>