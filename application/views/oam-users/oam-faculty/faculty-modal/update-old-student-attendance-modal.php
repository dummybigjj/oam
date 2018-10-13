
    <!-- Edit Student Attendance Modal -->
    <div id="updateAttendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formupdateAttendance">
              <input type="hidden" name="student_id" class="form-control" required="">
              <input type="hidden" name="subject_id" class="form-control" required="">
              <input type="hidden" name="subject_code" class="form-control" required="">
              <input type="hidden" name="batch_year_id" class="form-control" required="">
              <input type="hidden" name="schedule_day" value="<?php echo !empty($schedules['day'])?$schedules['day']:''; ?>" class="form-control" required="">

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Attendance Date</div>
                <input type="text" name="attendance_date" id="datetimepicker1" value="<?php echo $this->faculty_model->getScheduledDate($schedules['day']); ?>" class="form-control" autocomplete="off">
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

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Remarks</div>
                <textarea name="remarks" maxlength="100" class="form-control"></textarea>
              </div>

            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <button type="button" onclick="update_old_student_attendance()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
 
var startTime = $('#datetimepicker1');
$('#datetimepicker1').datetimepicker({
  format:'Y-m-d',
  timepicker:false
});


</script>