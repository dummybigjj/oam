    <!-- View History Modal -->
    <div id="editStudentRegistration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formeditStudentRegistration">
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-user-o" aria-hidden="true"></i> Student Registration Details</div>
              </div>
              <div class="form-group col-md-12">
                <input type="hidden" name="tbl_id" required="" class="form-control">
                <input type="hidden" name="batch_year" required="" class="form-control">
                <input type="hidden" name="student_id" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Student No.</div>
                <input type="text" name="student_no" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Student Name</div>
                <input type="text" name="arabic_name" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Subject</div>
                <select name="subject" required="" class="form-control">
                  <option> </option>
                  <?php if(!empty($subjects)): ?>
                    <?php foreach ($subjects as  $value): ?>
                    <option value="<?php echo $value['subject_id'] ?>"><?php echo $value['subject_title']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                
                <div class="form-control-label"><font style="color: red">*</font> Subject Code</div>
                <input type="text" name="subject_code" class="form-control" required="">
              </div><br>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-calendar" aria-hidden="true"></i> Student Schedule</div>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Hall</div>
                <select name="room" required="" class="form-control">
                  <option> </option>
                  <?php if(!empty($rooms)): ?>
                    <?php foreach ($rooms as  $value): ?>
                    <option value="<?php echo $value['room_id'] ?>"><?php echo $value['room_name']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                
                <div class="form-control-label"><font style="color: red">*</font> Day</div>
                <select name="day" required="" class="form-control">
                  <option> </option>
                  <option value="MONDAY"> MONDAY </option>
                  <option value="TUESDAY"> TUESDAY </option>
                  <option value="WEDNESDAY"> WEDNESDAY </option>
                  <option value="THURSDAY"> THURSDAY </option>
                  <option value="FRIDAY"> FRIDAY </option>
                  <option value="SATURDAY"> SATURDAY </option>
                  <option value="SUNDAY"> SUNDAY </option>
                </select>
                <div class="form-control-label"><font style="color: red">*</font> Time</div>
                <select name="time" required="" class="form-control">
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
                <div class="form-control-label"><font style="color: red">*</font> Vocational Program</div>
                <select name="vocational_program" required="" class="form-control">
                  <option> </option>
                  <?php if(!empty($voc_program)): ?>
                    <?php foreach ($voc_program as  $value): ?>
                    <option value="<?php echo $value['voc_program_id'] ?>"><?php echo $value['voc_program'].' - '.$value['voc_program_acronym']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp&nbsp Close &nbsp&nbsp&nbsp</button>
              <button type="submit" onclick="update_new_student_schedule()" class="btn btn-success">&nbsp&nbsp Update &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">
  var startTime = $('#datetimepicker1');
  $('#datetimepicker1').datetimepicker({
      format:'H:i:00',
      formatTime: 'h:i:00',
      datepicker:false,
      // step:30,
      allowTimes:['08:00:00','10:00:00','12:30:00','14:30:00','16:00:00']
  });
</script>