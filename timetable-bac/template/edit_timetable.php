<section class="pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div id="notifier"></div>
				<div class="card">
					<h5 class="card-header">Update TimeTable Information </h5>
					<div class="card-body">
						<form method="post" id="courseForm">
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
									<label for="subject">Subject *</label>
									<select class="custom-select" id="subject" name="subject" required>
										<option disabled selected>Select (or) change academic tab</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="date">Date *</label>
									<input type="date" class="form-control" id="date" name="date" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="s_time">Start Time *</label>
									<input type="time" class="form-control" id="s_time" name="s_time" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="e_time">End Time *</label>
									<input type="time" class="form-control" id="e_time" name="e_time" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="location">Location *</label>
									<select class="custom-select" id="location" name="location" required>
										<option disabled selected>Open this select menu</option>
										<option value="KL">KL</option>
										<option value="PJ">PJ</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="serach" class="invisible">Submit</label>
									<input type="hidden" name="c_form" value="courseForm">
									<button type="submit" id="submit" class="btn btn-primary btn-block">
										<i class="fa fa-check"></i> Submit
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

<script type="text/javascript">
	$('#courseForm').on('submit', function(e){
		var form_data = $(this).serialize();
		e.preventDefault();
		// alert(form_data);
		$.ajax({
			url:"<?php echo plugins_url( 'ajax/ajax_results.php', __FILE__ );?>",
			method:"POST",
			data:form_data,
			success:function(data) {
				// alert(data);
				if (data=='success') {
					output = '<div class="alert alert-success" role="alert">Course details added successfully.</div>';
					$("form").trigger("reset");
				} else {
					output = '<div class="alert alert-danger" role="alert">Error occured.</div>';
				}
				$("#notifier").hide().html(output).show().fadeOut(10000);
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready( function () {
		$("#course").change(function() {
			var id = $(this).children(":selected").val();
			var name = "COURSE";
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
	$(document).ready( function () {
		$("#academic").change(function() {
			// var id = $(this).val();
			var id = $(this).children(":selected").val();
			var name = "ACADEMIC";
			// alert(id);
			$.ajax({
				url:"<?php echo plugins_url( 'ajax/ajax_results.php?id=', __FILE__ );?>"+id+"&name="+name,
				type:'POST',
				success:function(data){
		 			// alert(data);
		 			$('#subject').html(data);
		 		}
		 	});
		});
	});
</script>