<section class="pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div id="notifier"></div>
				<div class="card">
					<h5 class="card-header">Add New Academic</h5>
					<div class="card-body">
						<form method="post" id="AcademicForm">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="course">Course *</label>
									<select class="custom-select" id="course" name="course" required>
										<option disabled selected>Open this select menu</option>
										<?php foreach (course_list('') as $course_result) { ?>
											<option value="<?php echo $course_result->course_id; ?>">
												<?php echo $course_result->course_name; ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="academic">Academic *</label>
									<input type="text" class="form-control" id="academic" name="academic" required placeholder="Ex: Sem-1">
								</div>
								<div class="col-md-3 mb-3">
									<label for="s_date">Start Date *</label>
									<input type="date" class="form-control" id="s_date" name="s_date" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="e_date">End Date *</label>
									<input type="date" class="form-control" id="e_date" name="e_date" required>
								</div>
								<script type="text/javascript">
									document.getElementById("s_date").onchange = function () {
										var input = document.getElementById("e_date");
										input.setAttribute("min", this.value);
									}
								</script>
								<div class="col-md-3 mb-3">
									<label for="serach" class="invisible">Submit</label>
									<input type="hidden" name="a_form" value="academicForm">
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
	$('#AcademicForm').on('submit', function(e){
		var form_data = $(this).serialize();
		e.preventDefault();
		alert(form_data);
		$.ajax({
			url:"<?php echo plugins_url( 'ajax/ajax_results.php', __FILE__ );?>",
			method:"POST",
			data:form_data,
			success:function(data) {
				// alert(data);
				if (data=='success') {
					output = '<div class="alert alert-success" role="alert">Academic details added successfully.</div>';
					$("form").trigger("reset");
				} else {
					output = '<div class="alert alert-danger" role="alert">Error occured.</div>';
				}
				$("#notifier").hide().html(output).show().fadeOut(10000);
			}
		});
	});
</script>