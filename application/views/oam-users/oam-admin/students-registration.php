          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">

                <!-- Basic Form-->
                <div class="col-lg-6" style="margin: 0 auto">
                  <div class="card">

                    <div class="card-close">
                      <div class="dropdown">
                      </div>
                    </div>

                    <div class="card-header statistic d-flex align-items-center">
                      <div class="icon bg-green"><i class="fa fa-user-o"></i></div>
                      <div class="text"><small class="h4">Register Students for <?php echo "'".$batch_year['batch_name']."'"; ?></small></div>
                    </div>

                    <div class="card-body">
                      <form action="<?php echo site_url('student/set_students_subjects_mass_reg'); ?>" method="post"  enctype="multipart/form-data" accept-charset="utf-8">
                        <?php if($batch_year['is_active']=='FALSE'): ?>
                        <div class="form-group col-md-12">
                          <div class="alert alert-danger" role="alert">
                            <i class="fa fa-question-circle-o"></i> Batch Year is 'Disabled'. You are not allowed to 'Register Student'. Make sure to 'Enable' Batch Year before you can 'Register Student' again.
                          </div>
                        </div>
                        <?php else: ?>
                        <p class="col-md-12">Fields with (<font style="color: red">*</font>) are required.</p>
                        <input type="hidden" name="batch_year" value="<?php echo $batch_year['batch_year_id']; ?>" required="" class="form-control">

                        <!-- <div class="form-group col-md-12">
    	                    <label class="form-control-label"><font style="color: red">*</font> <i class="fa fa-user-o"></i> Students </label>
    	                    <select multiple="multiple" id="multiselect1" required="" name="student_id[]">
    	                      <?php //if(!empty($students)): ?>
    	                        <?php //foreach ($students as  $value): ?>
    	                          <option value="<?php //echo $value['student_id'] ?>"><?php //echo (!empty($value['arabic_name']))?$value['arabic_name']:$value['english_name']; ?></option>
    	                        <?php //endforeach; ?>
    	                      <?php //endif; ?>
    	                    </select>
                        </div> -->

                        <div class="form-group col-md-12">
                          <label for="exampleFormControlFile1"><font style="color: red">*</font> Import Students</label>
                          <input type="file" name="file" class="form-control-file" aria-describedby="Help" id="exampleFormControlFile1" required accept=".xls, .xlsx">
                          <small id="Help" class="form-text text-muted">
                            Accepted File formats are .xls or .xlsx<br>
                            Put "Student Number" at column "A" only and data start at row 2
                          </small>
                        </div>

                        <!-- <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Student</label>
                          <select name="student_id" required="" class="form-control">
                            <option> </option>
                            <?php //if(!empty($students)): ?>
                              <?php //foreach ($students as  $value): ?>
                              <option value="<?php //echo $value['student_id'] ?>"><?php //echo $value['arabic_name']; ?></option>
                              <?php //endforeach; ?>
                            <?php //endif; ?>
                          </select>
                        </div> -->

                        <div class="line"></div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Vocational Program</label>
                          <select name="vocational_program[]" required="" class="form-control">
                            <option> </option>
                            <?php if(!empty($voc_program)): ?>
                              <?php foreach ($voc_program as  $value): ?>
                              <option value="<?php echo $value['voc_program_id'] ?>"><?php echo $value['voc_program'].' - '.$value['voc_program_acronym']; ?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                        </div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Subject</label>
                          <select name="subject[]" required="" class="form-control">
                            <option> </option>
                            <?php if(!empty($subjects)): ?>
                              <?php foreach ($subjects as  $value): ?>
                              <option value="<?php echo $value['subject_id'] ?>"><?php echo $value['subject_title']; ?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                        </div>

                        <div class="form-group col-md-12">       
                          <label class="form-control-label"><font style="color: red">*</font> Subject Code</label>
                          <input type="text" name="subject_code[]"  oninput="handleInput(event)" maxlength="60" required="" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Time</label>
                          <select name="time[]" required="" class="form-control">
                            <option> </option>
                            <option value="08:00:00"> 08:00AM - 09:30AM </option>
                            <option value="10:00:00"> 10:00AM - 11:30AM </option>
                            <option value="12:30:00"> 12:30PM - 02:00PM </option>
                            <option value="14:30:00"> 02:30PM - 04:00PM </option>
                            <option value="16:30:00"> 04:30PM - 06:00PM </option>
                            <option value="18:30:00"> 06:30PM - 08:00PM </option>
                          </select>
                        </div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Hall</label>
                          <select name="room[]" required="" class="form-control">
                            <option> </option>
                            <?php if(!empty($rooms)): ?>
                              <?php foreach ($rooms as  $value): ?>
                              <option value="<?php echo $value['room_id'] ?>"><?php echo $value['room_name']; ?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                        </div>

                        <div class="form-group col-md-12">
                          <label class="form-control-label"><font style="color: red">*</font> Day</label>
                          <select name="day[]" required="" class="form-control">
                            <option> </option>
                            <option value="MONDAY"> MONDAY </option>
                            <option value="TUESDAY"> TUESDAY </option>
                            <option value="WEDNESDAY"> WEDNESDAY </option>
                            <option value="THURSDAY"> THURSDAY </option>
                            <option value="FRIDAY"> FRIDAY </option>
                            <option value="SATURDAY"> SATURDAY </option>
                            <option value="SUNDAY"> SUNDAY </option>
                          </select>
                        </div>
                        

                        <div class="line"></div>
                        <div id="TextBoxesGroup"></div>

                        <div class="form-footer">
                          <div class="form-group col-md-12">
                            <div class="btn-group">
                              <button id="addButton" type="button" class="btn btn-success">&nbsp&nbsp&nbsp<i class="fa fa-plus-square-o"></i> Add&nbsp&nbsp&nbsp</button>
                              <button id="removeButton" type="button" class="btn btn-danger"><i class="icon-close"></i> Remove</button>  
                            </div>
                            <button type="submit" class="btn btn-primary" style="float: right;"><i class="fa fa-floppy-o"></i> Save</button>
                          </div>
                        </div>
                        <?php endif; ?>
                      </form>

                    </div>

                  </div>
                </div>

              </div>
            </div>
          </section>


<script type="text/javascript">

var startTime = $('#datetimepicker1');
$('#datetimepicker1').datetimepicker({
    format:'H:i:00',
    formatTime: 'h:i:00',
    datepicker:false,
    // step:30,
    allowTimes:['08:00:00','10:00:00','12:30:00','14:30:00','16:00:00']
});

$('#multiselect1').multiSelect();

$(document).ready(function(){
  var counter = 1;
  $("#addButton").click(function () {
    if(counter>10){
        alert("Only 10 forms are allowed");
        return false;
    }
        
    var new_user = $(document.createElement('div')).attr("id", 'new_user' + counter);
    new_user.after().html(

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Vocational Program</label>'+
        '<select name="vocational_program[]" required="" class="form-control">'+
          '<option> </option>'+
          '<?php if(!empty($voc_program)): ?>'+
            '<?php foreach ($voc_program as  $value): ?>'+
            '<option value="<?php echo $value['voc_program_id'] ?>"><?php echo $value['voc_program'].' - '.$value['voc_program_acronym']; ?></option>'+
            '<?php endforeach; ?>'+
          '<?php endif; ?>'+
        '</select>'+
      '</div>'+

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Subject</label>'+
        '<select name="subject[]" required="" class="form-control">'+
          '<option> </option>'+
          '<?php if(!empty($subjects)): ?>'+
            '<?php foreach ($subjects as  $value): ?>'+
            '<option value="<?php echo $value['subject_id'] ?>"><?php echo $value['subject_title']; ?></option>'+
            '<?php endforeach; ?>'+
          '<?php endif; ?>'+
        '</select>'+
      '</div>'+

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Subject Code</label>'+
        '<input type="text" name="subject_code[]"  oninput="handleInput(event)" maxlength="60" required="" class="form-control">'+
      '</div>'+

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Time</label>'+
        '<select name="time[]" required="" class="form-control">'+
          '<option> </option>'+
          '<option value="08:00:00"> 08:00AM - 09:30AM </option>'+
          '<option value="10:00:00"> 10:00AM - 11:30AM </option>'+
          '<option value="12:30:00"> 12:30PM - 02:00PM </option>'+
          '<option value="14:30:00"> 02:30PM - 04:00PM </option>'+
          '<option value="16:30:00"> 04:30PM - 06:00PM </option>'+
          '<option value="18:30:00"> 06:30PM - 08:00PM </option>'+
        '</select>'+
      '</div>'+

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Hall</label>'+
        '<select name="room[]" required="" class="form-control">'+
          '<option> </option>'+
          '<?php if(!empty($rooms)): ?>'+
            '<?php foreach ($rooms as  $value): ?>'+
            '<option value="<?php echo $value['room_id'] ?>"><?php echo $value['room_name']; ?></option>'+
            '<?php endforeach; ?>'+
          '<?php endif; ?>'+
        '</select>'+
      '</div>'+

      '<div class="form-group col-md-12">'+
        '<label class="form-control-label"><font style="color: red">*</font> Day</label>'+
        '<select name="day[]" required="" class="form-control">'+
          '<option> </option>'+
          '<option value="MONDAY"> MONDAY </option>'+
          '<option value="TUESDAY"> TUESDAY </option>'+
          '<option value="WEDNESDAY"> WEDNESDAY </option>'+
          '<option value="THURSDAY"> THURSDAY </option>'+
          '<option value="FRIDAY"> FRIDAY </option>'+
          '<option value="SATURDAY"> SATURDAY </option>'+
          '<option value="SUNDAY"> SUNDAY </option>'+
        '</select>'+
      '</div>'+
      '<div class="line"></div>'

    );

    new_user.appendTo("#TextBoxesGroup");
    counter++;
  });

  $("#removeButton").click(function (){
    if(counter==1){
      alert("No more forms to remove");
      return false;
    }
    counter--;
    $("#new_user" + counter).remove();
  });

});


</script>