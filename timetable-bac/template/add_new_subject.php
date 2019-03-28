<section class="pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div id="notifier"></div>
				<div class="card">
					<h5 class="card-header">Add New Subject</h5>
					<div class="card-body">
						<form method="post" action="" role="form" id="new_subject">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="sub_course">Course *</label>
									<select class="custom-select" id="sub_course" name="sub_course[]" required>
										<option disabled selected>Open this select menu</option>
										<?php foreach (course_list('') as $course_result) { ?>
											<option value="<?php echo $course_result->course_id; ?>" id="<?php echo $course_result->course_id; ?>"><?php echo $course_result->course_name; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="sub_academic">Academic *</label>
								<select class="custom-select" id="sub_academic" name="sub_academic[]" required>
								<option disabled selected>Select (or) change course tab</option>
								</select>
							</div>
							<div>
								<label for="add" class="invisible">add</label><br>
								<button type="button"  name="add" class="btn btn-success btn-sm text-white add"><i class="fa fa-plus"></i></button>
							</div>
						</div>
						<div class="form-row col-sm-12 p-0" id="course_append"></div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="new_subject">Subject *</label>
								<input class="form-control" id = "new_subject"  name = "new_subject" type="text">
							</div>
							<div class="col-md-3 mb-3">
								<label for="sub_campus">Campus *</label>
								<select class="custom-select" id="sub_campus" name="sub_campus" required>
									<option disabled selected>Open this select menu</option>
									<option value = "KL">KL</option>
									<option value = "PJ">PJ</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="sub_lecturer">Lecturer *</label>
								<select class="custom-select" id="e2" name="sub_lecturer" required>
									<option disabled selected>Open this select menu</option>
									<?php foreach (teacher_results('') as $teacher_results) { ?>
										<option value="<?php echo $teacher_results->tid; ?>">
											<?php echo $teacher_results->first_name; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="sub_classtype">Class Type *</label>
								<select class="custom-select" id="sub_classtype" name="sub_classtype" required>
									<option disabled selected>Open this select menu</option>
									<option value="class">Class</option>
									<option value="tutorial">Tutorial</option>
									<option value="lab">Lab</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="sub_classduration">Class Duration *</label>
								<input class="form-control" id = "sub_classduration" name = "sub_classduration" type="text" placeholder="Ex: 2">
							</div>
							<div class="col-md-3 mb-3">
								<label for="sub_recurrence">recurrence *</label>
								<input class="form-control" name = "sub_recurrence" type="text" placeholder="Ex: 2">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<input type="hidden" name = "sub_submit" id = "sub_submit" value = "sub_submit">
								<button type="submit" id="submit" class="btn btn-primary btn-block">
									<i class="fa fa-paper-plane "></i> Submit
								</button>
							</div></div>
						</form>
						<div class="text-muted"><strong>*</strong> These fields are required.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<script type="text/javascript">
	$(document).ready(function(){
		$('.add').click(function(){
			var x = new Date();
			var n = x.valueOf();
			$('<div class="col-md-12 p-0 ml-1 form-row" id="remove"><div class="col-md-3 mb-3"><select class="custom-select" id="sub_course'+n+'" name="sub_course[]" required><option disabled selected>Open this select menu</option><?php foreach (course_list('') as $course_result) { ?><option value="<?php echo $course_result->course_id; ?>" id="<?php echo $course_result->course_id; ?>"><?php echo $course_result->course_name; ?></option><?php } ?></select></div><div class="col-md-3 mb-3"><select class="custom-select" id="sub_academic'+n+'" name="sub_academic[]" required><option disabled selected>Select (or) change course tab</option></select></div><div><button type="button" role="button" name="remove" class="btn btn-danger btn-sm text-white remove"><i class="fa fa-minus"></i></button></div></div>').clone().appendTo("#course_append");
			$('#sub_course'+n+'').change(function() {
				// var id = $(this).val();
				var id = $(this).children(":selected").val();
				var name = "COURSE";
	           //	alert(id);
	           $.ajax({
	           	url:"<?php echo plugins_url( 'ajax/ajax_results.php?id=', __FILE__ );?>"+id+"&name="+name,
	           	type:'POST',
	           	success:function(data){
			 		//	alert(data);
			 		$('#sub_academic'+n+'').html(data);
			 	}
			 });
	       });
			$('.remove').click(function(){
				$(this).closest('#remove').remove();
			});
		});
	});
</script>

<script type="text/javascript">
	jQuery(document).ready( function () {
		$("#sub_course").change(function() {
			//alert("testing");
			// var id = $(this).val();
			var id = $(this).children(":selected").val();
			var name = "COURSE";
           //	alert(id);
           $.ajax({
           	url:"<?php echo plugins_url( 'ajax/ajax_results.php?id=', __FILE__ );?>"+id+"&name="+name,
           	type:'POST',
           	success:function(data){
		 		//	alert(data);
		 		$('#sub_academic').html(data);
		 	}
		 });
       });
	});
</script>


<script>
	$(document).ready(function() { $("#e2").select2(); });
</script>

<script>
	$(document).ready(function(){
		$('#new_subject').on('submit', function(event){
			event.preventDefault();
			var form_data = $(this).serialize();
				//alert(form_data);
				$.ajax({
					url:"<?php echo plugins_url( 'ajax/ajax_results.php', __FILE__ );?>",
					method:"POST",
					data:form_data,
					success:function(data)
					{
						$("form").trigger("reset");
						if ($.trim(data) =='success') {
					output = '<div class="alert alert-success" role="alert">Location details added successfully.</div>';
					
				} else {
					output = '<div class="alert alert-danger" role="alert">Error occured.</div>';
				}
				$("#notifier").hide().html(output).show().fadeOut(10000);
			
                }
            });
		});
	});
</script>




