<section class="container-fluid mt-4">
	<div id="form_data" >
		<table id="example" class="table table-striped table-bordered">
			<thead class="text-center">
				<th >
					Teacher List
				</th>
			</thead>
			<tbody>
				<tr>
					<?php foreach (teacher_results('') as $teacher_result) { ?>
					<td class="text-center">
						<a href="<?php echo site_url('/wp-admin/admin.php?page=add-teacher-information')?>&tid=<?php echo $teacher_result->tid;?>">
							<?php echo $teacher_result->first_name;?>
						</a>
					</td>
				</tr>
				<?php  } ?>
			</tbody>
		</table>
	</div>
</section>

<script type="text/javascript">
	jQuery(document).ready( function () {
		$('#example').DataTable();
	});
</script>