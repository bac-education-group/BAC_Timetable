<section class="pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div id="notifier"></div>
				<div class="card">
					<h5 class="card-header">Add New Course</h5>
					<div class="card-body">
						<form method="post" id="courseForm">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="c_code">Course Code *</label>
									<input type="text" class="form-control" id="c_code" name="c_code" required placeholder="Enter course code">
								</div>
								<div class="col-md-3 mb-3">
									<label for="c_name">Course Name *</label>
									<input type="text" class="form-control" id="c_name" name="c_name" required placeholder="Enter course name">
								</div>
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
									<label for="serach" class="invisible">Search</label>
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