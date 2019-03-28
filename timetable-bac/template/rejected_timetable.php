<?php
$role_name  = wp_get_current_user()->roles[0];
if(!empty(rejected_table(''))){ ?>
<section class="mt-4">
	<div class="container-fluid">
		<h2 class="mb-3">Rejected Time Table</h2>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<div id="form_data" >
					<table  id="myTable" class="wp-list-table widefat  striped " style="right: 8px;">
						<thead>
							<tr>
								<th>ID</th>
								<th>College</th>
								<th>Course</th>
								<th>academic</th>
								<th>Subject</th>
								<th>Date</th>
								<th>Time</th>
								<th>Location</th>
								<th>Teacher</th>
								<th>Reject Reason</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach (rejected_table('') as $result1) { ?>
								<tr>
									<td><?php echo $result1->timetable_id;?></td>
									<td><?php echo strtoupper($result1->college);?></td>
									<td><?php echo strtoupper($result1->course_name);?></td>
									<td><?php echo strtoupper($result1->academic_name);?></td>
									<td><?php echo strtoupper($result1->sub_name);?></td>
									<td><?php echo strtoupper($result1->date);?></td>
									<td>
										<?php echo date('h:i A ', strtotime($result1->start_time))."- ".date('h:i A ', strtotime($result1->end_time));?>
									</td>
									<td>
										<?php echo strtoupper($result1->loc_campus."/".$result1->loc_floor."/".$result1->loc_room);?>
									</td>
									<td><?php echo strtoupper($result1->first_name);?></td>
									<td><?php echo strtoupper($result1->reject_reason);?></td>
									<?php if($role_name == "administrator" ) { ?>
										<td> 
											<a href="<?php echo site_url('/wp-admin/admin.php')?>?page=update-time-table&id=<?php echo $result1->timetable_id?>&&name=rejectupdate" class="btn btn-primary btn-sm text-white">
												<i class="fa fa-pencil"></i>
											</a> 

											<a href="javascript:;" id="<?php echo $result1->timetable_id; ?>" class="btn btn-danger btn-sm delete_row text-white">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									<?php } ?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>

<script type="text/javascript">
	$(document).ready( function () {
		$('#myTable').DataTable();
	});
</script>

<script type="text/javascript">
	$('.delete_row').click(function(){
		if(confirm("Are you sure you want to delete?")) {
			var tr = $(this).closest('tr'),
			var del_id = $(this).attr('id');
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