
    <!-- Edit Student Attendance Modal -->
    <div id="MassupdateAttendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formMassupdateAttendance">
              <div class="form-group col-md-12">
                <label class="form-control-label"><font style="color: red">*</font> <i class="fa fa-user-o"></i> Students </label>
                <select multiple="multiple" id="multiselect1" required="" name="student_ids[]">
                  <?php if(!empty($students)): ?>
                    <?php foreach ($students as  $value): ?>
                      <option value="<?php echo $value['student_id'] ?>"><?php echo (!empty($value['arabic_name']))?$value['arabic_name']:$value['english_name']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>


              <input type="hidden" name="subject" value="<?php echo $schedules['subject_id']; ?>" class="form-control" required="">
              <input type="hidden" name="subject_c" value="<?php echo $schedules['subject_code']; ?>" class="form-control" required="">
              <input type="hidden" name="batch_year" value="<?php echo $schedules['batch_year_id']; ?>" class="form-control" required="">
              <input type="hidden" name="schedule_id" value="<?php echo $schedules['schedule_id']; ?>" class="form-control" required="">

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Attendance Date</div>
                <input type="text" name="attendance_date" class="form-control datetimepicker2" autocomplete="off">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Attendance Status</div>
                <select name="status" required="" class="form-control">
                  <option> </option>
                  <option value="P">PRESENT</option>
                  <option value="A">ABSENT</option>
                  <option value="L">LATE</option>
                  <option value="E">EXCUSE</option>
                  <option value="V">VACATION</option>
                </select>
              </div>

            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <button type="button" onclick="override_update_student_attendance()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
 
var startTime = $('.datetimepicker2');
$('.datetimepicker2').datetimepicker({
  format:'Y-m-d',
  timepicker:false
});
$('#multiselect1').multiSelect();


</script>