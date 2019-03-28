<?php
global $wpdb;
$tinfo= isset($_GET['tid']) ? $_GET['tid'] : '';
$tinfoid= isset($_GET['id']) ? $_GET['id'] : '';
$name= isset($_GET['name']) ? $_GET['name'] : '';
if(isset($_GET['tid'])){ ?>
  <section class="container-fluid mt-4">
    <div id="notifier"></div>
    <h3 class="text-center text-primary"><?php echo teacher_info_single($tinfo)->first_name ?> Teacher Information</h3>
    <div id="form_data" >
        <table id="example" class="table table-striped table-bordered"><br>
            <thead>
                <tr class="text-center">
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Action &nbsp &nbsp<button type="button" onClick="toggle();" name="add" class="btn btn-success btn-sm text-white add"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($_GET['id'])){?>
                 <tr id="update_row" style="display: table-row;" >
                    <form method="post" name="update_te_form" id="update_te_form">
                        <div class="table-repsonsive">
                            <td>
                                <select name="te_update_day" id="te_update_day" class="custom-select te_update_day" required="required">
                                    <option value="<?php echo teacher_info_edit($tinfoid)->day?>"><?php echo teacher_info_edit($tinfoid)->day?></option>
                                    <option value="">Select Day</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="te_update_starttime" id="te_update_starttime" class="form-control time te_update_starttime " autocomplete="off" required="required" value="<?php echo teacher_info_edit($tinfoid)->start_time?>">
                            </td>
                            <td>
                                <input type="text" name="te_update_endtime" id="te_update_endtime" class="form-control time te_update_endtime" autocomplete="off" required="required" value="<?php echo teacher_info_edit($tinfoid)->end_time?>">
                            </td>
                            <td>
                                <select name="te_update_status" class="custom-select te_update_status" required="required">
                                    <option value="<?php echo teacher_info_edit($tinfoid)->status?>"><?php echo teacher_info_edit($tinfoid)->status?></option>
                                    <option value="">Select Status</option>
                                    <option value="available">Available</option>
                                    <option value="notavailable">Not Available</option>
                                </select>
                            </td>
                            <td>
                                <select name="te_update_location" class="custom-select te_update_location" required="required">
                                    <option value="<?php echo teacher_info_edit($tinfoid)->te_location?>"><?php echo teacher_info_edit($tinfoid)->te_location?></option>
                                    <option value="">Select Location</option>
                                    <option value="PJ">PJ</option>
                                    <option value="KL">KL</option>
                                </select>
                            </td>
                            <td class="text-center"><input type="hidden" id="te_update_id" name="te_update_id" value="<?php echo $tinfoid; ?>" class="form-control " />
                                <input type="hidden" name="te_update_tid" value="<?php echo $tinfo; ?>" class="form-control " />
                                <input type="hidden" name="te_update_submit" value="te_update_submit"/>
                                <input type="submit" name="te_update_submit" class="btn btn-info" value="Update" />&nbsp &nbsp
                                <button onClick="update_remove();" type="button" name="remove" class="btn btn-danger btn-sm remove">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </div>
                    </form>
                </tr>                    
            <?php } ?>
            <tr id="hidethis" style="display:none !important; ">
                <form method="post" name="insert_form" id="insert_form">
                    <div class="table-repsonsive">
                        <td>
                          <select name="te_day" id="te_day" class="custom-select te_day" required="required">
                            <option value="">Select Day</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="te_starttime" id="te_start_time" class="form-control time te_starttime " autocomplete="off" required="required">
                    </td>
                    <td>
                        <input type="text" name="te_endtime" id="te_end_time" class="form-control time te_endtime" autocomplete="off" required="required">
                    </td>
                    <td>
                        <select name="te_status" class="custom-select te_status" required="required">
                            <option value="">Select Status</option>
                            <option value="available">Available</option>
                            <option value="notavailable">Not Available</option>
                        </select>
                    </td>
                    <td>
                        <select name="te_location" class="custom-select te_location" required="required">
                            <option value="">Select Location</option>
                            <option value="PJ">PJ</option>
                            <option value="KL">KL</option>
                        </select>
                    </td>
                    <td style="text-align: center;font-size: 20px">
                        <input type="hidden" name="te_name" value="<?php echo $tinfo; ?>" class="form-control " />
                        <input type="hidden" name="te_info_submit" value="te_info_submit"/>
                        <input type="submit" name="te_submit" onclick="validateForm()" class="btn btn-info" value="Save" />
                        &nbsp &nbsp
                        <button onClick="toggle();" type="button" name="remove" class="btn btn-danger btn-sm remove">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                </div>
            </form>
        </tr>
        <?php foreach (teacher_info($tinfo) as $teacher_result) { ?>
            <tr class="text-center">
                <td><?php echo $teacher_result->day ?></td>
                <td><?php echo $teacher_result->start_time ?></td>
                <td><?php echo $teacher_result->end_time ?></td>
                <td><?php echo $teacher_result->status ?></td>
                <td><?php echo $teacher_result->te_location ?></td>
                <td>
                 <a href="<?php echo site_url('/wp-admin/admin.php?page=add-teacher-information')?>&tid=<?php echo $tinfo ?>&id=<?php echo $teacher_result->id;?>" class="btn btn-primary btn-sm text-white"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" id="<?php echo $teacher_result->id?>" class="btn btn-danger btn-sm delete_row text-white"><i class="fa fa-trash"></i>
                 </a>

             </td>
         </tr>
     <?php  } ?>
 </tbody>
</table>
</div>
</section>
<?php } ?>

<script>
    function toggle() {
        if( document.getElementById("hidethis").style.display=='none' ){
            document.getElementById("hidethis").style.display = 'table-row';
            document.getElementById("update_row").style.display = 'none'
        }else{
            document.getElementById("hidethis").style.display = 'none';
        }
    }
</script>
<script>
    function update_remove() {
        if( document.getElementById("update_row").style.display=='table-row' ){
            document.getElementById("update_row").style.display = 'none';
        }
    }
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
        console.log(result);
        tr.fadeOut(1000, function(){
            $(this).remove();
        });
    }
});
}
});
</script>

<script>
    $(document).ready(function(){
        $('#update_te_form').on('submit', function(event){
            event.preventDefault();

            var x = document.forms["update_te_form"]["te_update_day"].value;
            var y = document.forms["update_te_form"]["te_update_starttime"].value;
            var z = document.forms["update_te_form"]["te_update_endtime"].value;
            var a = document.forms["update_te_form"]["te_update_id"].value;
            <?php foreach (teacher_info($tinfo) as $teacher_result) { ?>
                if(y > z){
                  //  alert("Start Time must be less than End Time");
                  output = '<div class="alert alert-danger" role="alert">Start Time must be less than End Time.</div>';
                  $("#notifier").hide().html(output).show().fadeOut(10000);
                  return false;
              }
              if(y == z){
                   // alert("Start Time End Time should not be same");
                   output = '<div class="alert alert-danger" role="alert">Start Time End Time should not be same.</div>';
                   $("#notifier").hide().html(output).show().fadeOut(10000);
                   return false;
               }
               if(x == "<?php echo $teacher_result->day ?>" &&  y == "<?php echo $teacher_result->start_time ?>" && a !== "<?php echo $teacher_result->id ?>"){
                   // alert("Start Time already taken");
                   output = '<div class="alert alert-danger" role="alert">Start Time already taken.</div>';
                   $("#notifier").hide().html(output).show().fadeOut(10000);
                   return false;
               }
               if(x == "<?php echo $teacher_result->day ?>" &&  z == "<?php echo $teacher_result->end_time ?>" && a !== "<?php echo $teacher_result->id ?>"){
                   // alert("End Time already taken");
                   output = '<div class="alert alert-danger" role="alert">End Time already taken.</div>';
                   $("#notifier").hide().html(output).show().fadeOut(10000);
                   return false;
               }
               if(x == "<?php echo $teacher_result->day ?>" &&  y > "<?php echo $teacher_result->start_time ?>" && y < "<?php echo $teacher_result->end_time ?>" || x == "<?php echo $teacher_result->day ?>" &&  z > "<?php echo $teacher_result->start_time ?>" && z < "<?php echo $teacher_result->end_time ?>"){
                  //  alert("Time already taken");
                  output = '<div class="alert alert-danger" role="alert">Time already taken.</div>';
                  $("#notifier").hide().html(output).show().fadeOut(10000);
                  return false;
              }
          <?php } ?>

          var form_data = $(this).serialize();
//alert(form_data);
$.ajax({
    url:"<?php echo plugins_url( 'ajax/ajax_results.php', __FILE__ );?>",
    method:"POST",
    data:form_data,
    success:function(res){
// alert(res);
if (res =='success') {
    output = '<div class="alert alert-success" role="alert">Location details added successfully.</div>';
    window.location = "<?php echo site_url('/wp-admin/admin.php?page=add-teacher-information&tid=').$tinfo ?>"
} else {
    output = '<div class="alert alert-danger" role="alert">Error occured.</div>';
}
$("#notifier").hide().html(output).show().fadeOut(10000);

}
});
});
    });
</script>


<script>
    $(document).ready(function(){
        $('#insert_form').on('submit', function(event){
            event.preventDefault();
            var x = document.forms["insert_form"]["te_day"].value;
            var y = document.forms["insert_form"]["te_starttime"].value;
            var z = document.forms["insert_form"]["te_endtime"].value;
            <?php foreach (teacher_info($tinfo) as $teacher_result) { ?>
                if(y > z){
                  //  alert("Start Time must be less than End Time");
                  output = '<div class="alert alert-danger" role="alert">Start Time must be less than End Time.</div>';
                  $("#notifier").hide().html(output).show().fadeOut(10000);
                  return false;
              }
              if(y == z){
                   // alert("Start Time End Time should not be same");
                   output = '<div class="alert alert-danger" role="alert">Start Time End Time should not be same.</div>';
                   $("#notifier").hide().html(output).show().fadeOut(10000);
                   return false;
               }
               if(x == "<?php echo $teacher_result->day ?>" &&  y == "<?php echo $teacher_result->start_time ?>"){
                   // alert("Start Time already taken");
                   output = '<div class="alert alert-danger" role="alert">Start Time already taken.</div>';
                   $("#notifier").hide().html(output).show().fadeOut(10000);
                   return false;
               }
               if(x == "<?php echo $teacher_result->day ?>" &&  z == "<?php echo $teacher_result->end_time ?>"){
                   // alert("End Time already taken");
                   output = '<div class="alert alert-danger" role="alert">End Time already taken.</div>';
                   $("#notifier").hide().html(output).show().fadeOut(10000);
                   return false;
               }
               if(x == "<?php echo $teacher_result->day ?>" &&  y > "<?php echo $teacher_result->start_time ?>" && y < "<?php echo $teacher_result->end_time ?>" || x == "<?php echo $teacher_result->day ?>" &&  z > "<?php echo $teacher_result->start_time ?>" && z < "<?php echo $teacher_result->end_time ?>"){
                  //  alert("Time already taken");
                  output = '<div class="alert alert-danger" role="alert">Time already taken.</div>';
                  $("#notifier").hide().html(output).show().fadeOut(10000);
                  return false;
              }
          <?php } ?>
          var form_data = $(this).serialize();
          $.ajax({
            url:"<?php echo plugins_url( 'ajax/ajax_results.php', __FILE__ );?>",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                if (data=='success') {
                    output = '<div class="alert alert-success" role="alert">Teacher Information added successfully.</div>';
                    window.location = "<?php echo site_url('/wp-admin/admin.php?page=add-teacher-information&tid=').$tinfo ?>"
                } else {
                    output = '<div class="alert alert-danger" role="alert">Error occured.</div>';
                }
                $("#notifier").hide().html(output).show().fadeOut(10000);

            }
        });
      });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
<script type="text/javascript">
    $('.time').timepicker();
</script>


