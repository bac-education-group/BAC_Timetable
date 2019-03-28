<section class="pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div id="notifier"></div>
				<div class="card">
					<h5 class="card-header">Add New Location</h5>
					<div class="card-body">
						<form method="post" id="locationForm">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="campus">Campus *</label>
									<select class="custom-select" id="campus" name="campus" required>
										<option disabled selected>Open this select menu</option>
										<option value="KL">KL</option>
										<option value="PJ">PJ</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="floor">Floor *</label>
									<input type="text" class="form-control" id="floor" name="floor" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="room">Room *</label>
									<input type="text" class="form-control" id="room" name="room" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="capacity">Capacity *</label>
									<input type="text" class="form-control" id="capacity" name="capacity" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="room_type">Room Type *</label>
									<select class="custom-select" id="room_type" name="room_type" required>
										<option disabled selected>Open this select menu</option>
										<option value="Class">Class</option>
										<option value="Lab">Lab</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="status">Status *</label>
									<select class="custom-select" id="status" name="status" required>
										<option disabled selected>Open this select menu</option>
										<option value="available">Available</option>
										<option value="not available">Not Available</option>
									</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="o_time">Open Time *</label>
									<input type="text" class="form-control time start" id="o_time" name="o_time" required>
								</div>
								<div class="col-md-3 mb-3">
									<label for="c_time">Close Time *</label>
									<input type="text" class="form-control time end" id="c_time" name="c_time" required>
								</div>
								<!-- <script type="text/javascript">
									document.getElementById("o_time").onchange = function () {
										var input = document.getElementById("c_time");
										input.setAttribute("min", this.value);
									}
								</script> -->
								<div class="col-md-3 mb-3">
									<label for="serach" class="invisible">Submit</label>
									<input type="hidden" name="l_form" value="locationForm">
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
	$('#locationForm').on('submit', function(e){
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
					output = '<div class="alert alert-success" role="alert">Location details added successfully.</div>';
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
	$('.time').timepicker();
</script>