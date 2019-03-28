
<html>
	<head>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<!--	<script src="/wp-content/plugins/timetable-bac/vendor/jquery/jquery-3.2.1.min.js"></script> -->
		<script src="/wp-content/plugins/timetable-bac/vendor/bootstrap/js/popper.js"></script>
		<script src="/wp-content/plugins/timetable-bac/vendor/select2/select2.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/wp-content/plugins/timetable-bac/css/main.css">
		<link rel="stylesheet" type="text/css" href="/wp-content/plugins/timetable-bac/vendor/perfect-scrollbar/perfect-scrollbar.css">
		<link rel="stylesheet" type="text/css" href="/wp-content/plugins/timetable-bac/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/wp-content/plugins/timetable-bac/vendor/animate/animate.css">
		<link rel="stylesheet" type="text/css" href="/wp-content/plugins/timetable-bac/vendor/select2/select2.min.css">
		<style>
		.footer-box{
		background:#c4d3f6; }
		.container{
			height:100% !important;
		}
		
		</style>
	</head>
	<body style="background-color: #c4d3f6">
		<div class="container-fluid py-3" style="border-color: #eae7dd!important;">
			
			<form id="contact-form" method="post" action="" role="form">
				<div class="messages"></div>
				<div class="controls">
					<div class="row r_table col-sm-12 col-sm-offset-1" style="width: 960px;border-radius: 10px;padding-top: 10px;bottom: 195px;/*margin-left: 75px;*/padding-bottom:5px">
						<div class="col-sm-3">
							<div class="form-group">
								<label for="form_name">College *</label>
								<select name="college1" class="form-control"  required>
									<option value="">--Select--</option>
									<option>BAC</option>
									<option>Iact</option>
									<option>Veritas</option>
								</select>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="form_name">Course *</label>
								<input id="selected" list="browsers" class="form-control border" name="course1" autocomplete="off" style="border: 1px solid!important;
    border-color: rgba(169, 169, 169, 0.56)!important;" >
								<?php global $wpdb;
								$course_results = $wpdb->get_results("select course_id, course_name from wp_qrs_course");?>
								
								<?php foreach ($course_results as $course_result) { ?>
								<datalist id="browsers">
								<option value="<?php echo $course_result->course_name ;?>"></option>
								<?php	} ?>
								</datalist>
								<div class="help-block with-errors"></div>
							</div></div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="form_phone">academic *</label>
									<select name="academic1" class="form-control" id="select_academic" >
										<option value="">--Select--</option>
									</select>
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="form_phone"><br></label>
									<button type="submit" id="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i> Search</button>
								</div>
							</div>
						</div>
					</div>
					
				</form>
				
			</div>
			<div id= "primary" class="content-area">
				<?php global $wpdb;
				$college_value = isset($_POST['college1']) ? $_POST['college1'] : '';
				$course_value = isset($_POST['course1']) ? $_POST['course1'] : '';
				$academic_value = isset($_POST['academic1']) ? $_POST['academic1'] : '';
			if(isset($_POST['college1']) && $_POST['course1'] && $_POST['academic1'] ){
				$results1 = $wpdb->get_results("SELECT a.*,co.course_name,se.academic_name,sub.sub_name,lo.loc_room,lo.loc_floor,lo.loc_campus,te.tid,te.first_name FROM wp_qrs_timetable a
					LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id
					LEFT OUTER JOIN wp_qrs_academic se ON a.academic_id = se.academic_id
					LEFT OUTER JOIN wp_qrs_subject sub ON a.subject_id = sub.sub_id
					LEFT OUTER JOIN wp_qrs_location lo ON a.location = lo.id 
					LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid 
					where a.college ='$college_value'  And co.course_name = '$course_value' And a.academic_id= '$academic_value'  And  a.approve = 2");
			}else{
				$results1 = $wpdb->get_results("SELECT a.*,co.course_name,se.academic_name,sub.sub_name,lo.loc_room,lo.loc_floor,lo.loc_campus,te.tid,te.first_name FROM wp_qrs_timetable a
					LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id
					LEFT OUTER JOIN wp_qrs_academic se ON a.academic_id = se.academic_id
					LEFT OUTER JOIN wp_qrs_subject sub ON a.subject_id = sub.sub_id
					LEFT OUTER JOIN wp_qrs_location lo ON a.location = lo.id 
					LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid 
					where a.college ='$college_value' And  a.approve = 2");
			}	
				if(!empty($results1)){  ?>
				<div class="limiter">
					<div class="container-table100">
						<div class="wrap-table100">
							<div class="table">
								<div class="row r_table header">
									<div class="cell c1">
										<center>ID</center>
									</div>
									<div class="cell c1">
										<center>COLLEGE</center>
									</div>
									<div class="cell c1">
										<center>COURSE</center>
									</div>
									<div class="cell c1">
										<center>ACADEMIC</center>
									</div>
									<div class="cell c1">
										<center>SUBJECT</center>
									</div>
									<div class="cell c1">
										<center>DATE</center>
									</div>
									<div class="cell c1">
										<center>TIME</center>
									</div>
									<div class="cell c1">
										<center>LOCATION</center>
									</div>
									<!-- <div class="cell">
										<center>TEACHER</center>
									</div> -->
								</div>
								
								<?php	foreach ($results1 as $result1) { ?>
								<div class="row r_table">
									<div class="cell c1" data-title="ID">
									<?php echo $result1->timetable_id; ?>
									</div>
									<div class="cell c1" data-title="COLLEGE">
										<?php echo strtoupper($result1->college); ?>
									</div>
									<div class="cell c1" data-title="COURSE">
										<?php echo strtoupper($result1->course_name); ?>
									</div>
									<div class="cell c1" data-title="ACADEMIC">
										<?php echo strtoupper($result1->academic_name);?>
									</div>
									<div class="cell c1" data-title="SUBJECT">
										<?php echo strtoupper($result1->sub_name);?>
									</div>
									<div class="cell c1" data-title="DATE">
										<?php echo $result1->date;?>
									</div>
									<div class="cell c1" data-title="TIME">
										<?php echo date('h:i A ', strtotime($result1->start_time))."- ".date('h:i A ', strtotime($result1->end_time)) ?>
									</div>
									<div class="cell c1" data-title="LOCATION">
										<?php echo strtoupper($result1->loc_campus."/".$result1->loc_floor."/".$result1->loc_room); ?>
									</div>
									
								</div>
								<?php } ?>
								
							</div>
						</div>
					</div>
				</div>
				
				<?php	$results1=null; } ?>
			</div>
			
			<script>
						$(document).ready(function(){
							$("#selected").change(function(){
								var deptid = $(this).val();
													$.ajax({
			url:"/wp-content/plugins/timetable-bac/template/course_datalist.php", //Page with data
			data:{depart: deptid},
			type: "POST",
			success:function(action){
			console.log(action);
				$("#select_academic").empty();
			var obj = JSON.parse(action);
			for(var i = 0; i <= obj.length; i++) {
				var id = obj[i].academic_id;
				var name = obj[i].academic_name;
				$("#select_academic").append("<option value='"+id+"'>"+name+"</option>");
				
			};}
			});
							});
						});
			</script>
				
		</body>
	</html>