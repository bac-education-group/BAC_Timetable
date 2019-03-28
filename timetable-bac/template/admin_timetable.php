<?php 
global $wpdb;
$college_value = isset($_POST['college']) ? $_POST['college'] : '';
$course_value = isset($_POST['course']) ? $_POST['course'] : '';
$academic_value = isset($_POST['academic']) ? $_POST['academic'] : '';
$current_user   = wp_get_current_user();
$role_name      = $current_user->roles[0];
// echo $college_value;
$results1 = $wpdb->get_results("SELECT a.*,co.course_name,se.academic_name,sub.sub_name,lo.loc_room,lo.loc_floor,lo.loc_campus,te.tid,te.first_name FROM wp_qrs_timetable a
	LEFT OUTER JOIN wp_qrs_course co ON a.course_id = co.course_id
	LEFT OUTER JOIN wp_qrs_academic se ON a.academic_id = se.academic_id
	LEFT OUTER JOIN wp_qrs_subject sub ON a.subject_id = sub.sub_id
	LEFT OUTER JOIN wp_qrs_location lo ON a.location = lo.id 
	LEFT OUTER JOIN wp_qrs_teacher te ON a.teacher_id = te.tid 
	where a.college ='$college_value' And co.course_id = '$course_value' And a.academic_id= '$academic_value' And  a.approve = 2");
// print_r($results1);
?>
<section class="pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<h5 class="card-header">Admin Time Table</h5>
					<div class="card-body">
						<form method="post" action="" role="form" id="myForm">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="college">College *</label>
									<select class="custom-select" id="college" name="college" required>
										<option disabled selected>Open this select menu</option>
										<option value="BAC">BAC</option>
										<option value="IACT">IACT</option>
										<option value="VERITAS">VERITAS</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="course">Course *</label>
									<select class="custom-select" id="course" name="course" required>
										<option disabled selected>Open this select menu</option>
										<?php foreach (course_list('') as $course_result) { ?>
											<option value="<?php echo $course_result->course_id; ?>" id="<?php echo $course_result->course_id; ?>">
												<?php echo $course_result->course_name; ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="academic">Academic *</label>
									<select class="custom-select" id="academic" name="academic" required>
										<option disabled selected>Select (or) change course tab</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="serach" class="invisible">Search</label>
									<button type="submit" id="submit" class="btn btn-primary btn-block">
										<i class="fa fa-search"></i> Search
									</button>
								</div>
							</div>
						</form>
						<div class="text-muted"><strong>*</strong> These fields are required.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php if(!empty($results1)) { ?>
<section class="container-fluid mt-4">
	<div id="form_data">
		<table id="myTable" class="wp-list-table widefat striped hover">
			<thead class="text-uppercase">
				<tr>
					<th>ID</th>
					<th>COLLEGE</th>
					<th>COURSE</th>
					<th>academic</th>
					<th>SUBJECT</th>
					<th>DATE</th>
					<th>TIME</th>
					<th>LOCATION</th>
					<th>TEACHER</th>
					<?php if($role_name == "administrator"){ ?>
						<th>ACTION</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($results1 as $result1) { ?>
				<tr>
					<td><?php echo $result1->timetable_id; ?></td>
					<td><?php echo strtoupper($result1->college); ?></td>
					<td><?php echo strtoupper($result1->course_name); ?></td>
					<td><?php echo strtoupper($result1->academic_name);?></td>
					<td><?php echo strtoupper($result1->sub_name);?></td>
					<td><?php echo $result1->date;?></td>
					<td><?php echo date('h:i A',strtotime($result1->start_time))."-".date('h:i A',strtotime($result1->end_time)) ?></td>
					<td><?php echo strtoupper($result1->loc_campus."/".$result1->loc_floor."/".$result1->loc_room); ?></td>
					<td><?php echo strtoupper($result1->first_name);?></td>
					<?php if($role_name == "administrator"){ ?>
					<td> 
						<a href="<?php echo site_url('/wp-admin/admin.php')?>?page=update-time-table&id=<?php echo $result1->timetable_id?>&name=adminupdate" class="btn btn-primary btn-sm text-white">
							<i class="fa fa-pencil"></i>
						</a> 
						<a href="javascript:;" id="<?php echo $result1->timetable_id?>" class="btn btn-danger btn-sm delete_row text-white">
							<i class="fa fa-trash"></i>
						</a>
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>
<?php } ?>


<script type="text/javascript">
	$(document).ready( function () {
		$('#myTable').DataTable();
	});
</script>

<script type="text/javascript">
	$(document).ready( function () {
		$("#course").change(function() {
			// var id = $(this).val();
			var id = $(this).children(":selected").val();
			var name = "COURSE";
			// alert(id);
			$.ajax({
				url:"<?php echo plugins_url( 'ajax/ajax_results.php?id=', __FILE__ );?>"+id+"&name="+name,
				type:'POST',
				success:function(data){
		 			// alert(data);
		 			$('#academic').html(data);
		 		}
		 	});
		});
	});
</script>
<script type="text/javascript">
    $('.delete_row').click(function(){
    	if(confirm("Are you sure you want to delete?")) {
	        var tr = $(this).closest('tr'),
	            del_id = $(this).attr('id');
	            // alert(del_id);
	            var del = "DEL"

	        $.ajax({
	            url: "<?php echo plugins_url( 'ajax/ajax_results.php?id=', __FILE__ );?>"+del_id+"&del="+del,
	            cache: false,
	            success:function(result){
	                tr.fadeOut(1000, function(){
	                    $(this).remove();
	                });
	            }
	        });
	    }
    });
</script>

<script type="text/javascript">
	$("#submit").click(function() {
		$("#myForm").reset();
	});
</script>
