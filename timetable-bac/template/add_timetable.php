<section class="pt-3">
	<div class="container-fluid">
		<h2>Add Information</h2>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header p-0 text-uppercase">
						<nav>
							<div class="nav nav-tabs nav-pills flex-column flex-sm-row border-0" id="nav-tab" role="tablist">
								<!-- <a class="nav-item nav-link flex-sm-fill text-sm-center active" id="nav-timetable-tab" data-toggle="tab" href="#nav-timetable" role="tab" aria-controls="nav-timetable" aria-selected="true">
									Add New timetable
								</a> -->
								<a class="nav-item nav-link flex-sm-fill text-sm-center" id="nav-course-tab" data-toggle="tab" href="#nav-course" role="tab" aria-controls="nav-course" aria-selected="false">
									Add new course
								</a>
								<a class="nav-item nav-link flex-sm-fill text-sm-center" id="nav-academic-tab" data-toggle="tab" href="#nav-academic" role="tab" aria-controls="nav-academic" aria-selected="false">
									add new academic
								</a>

								<a class="nav-item nav-link flex-sm-fill text-sm-center" id="nav-subject-tab" data-toggle="tab" href="#nav-subject" role="tab" aria-controls="nav-subject" aria-selected="false">
									add new subject
								</a>
								<a class="nav-item nav-link flex-sm-fill text-sm-center" id="nav-location-tab" data-toggle="tab" href="#nav-location" role="tab" aria-controls="nav-location" aria-selected="false">
									add new location
								</a>
								<a class="nav-item nav-link flex-sm-fill text-sm-center" id="nav-teacher-tab" data-toggle="tab" href="#nav-teacher" role="tab" aria-controls="nav-teacher" aria-selected="false">
									add teacher data
								</a>
							</div>
						</nav>
					</div>
					<div class="card-body">
						<div class="tab-content" id="nav-tabContent">
							<!-- <div class="tab-pane fade show active" id="nav-timetable" role="tabpanel" aria-labelledby="nav-timetable-tab">
								<?php //include( plugin_dir_path( __FILE__ ) . 'forms/timetable.php'); ?>
							</div> -->
							<div class="tab-pane fade" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab">
								<?php include( plugin_dir_path( __FILE__ ) . 'forms/timetable.php'); ?>
							</div>
							<div class="tab-pane fade" id="nav-academic" role="tabpanel" aria-labelledby="nav-academic-tab">
								Add new academic
							</div>
							<div class="tab-pane fade" id="nav-subject" role="tabpanel" aria-labelledby="nav-subject-tab">
								Add new subject
							</div>
							<div class="tab-pane fade" id="nav-location" role="tabpanel" aria-labelledby="nav-location-tab">
								Add new location
							</div>
							<div class="tab-pane fade" id="nav-teacher" role="tabpanel" aria-labelledby="nav-teacher-tab">
								Add new teacher
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready( function () {
		$("#course").change(function() {
			var id = $(this).children(":selected").val();
			var name = "COURSE";
			$.ajax({
				url:"<?php echo plugins_url( 'ajax/ajax_results?id=', __FILE__ );?>"+id+"&name="+name,
				type:'POST',
				success:function(data) {
		 			$('#academic').html(data);
		 		}
		 	});
		});
	});
</script>