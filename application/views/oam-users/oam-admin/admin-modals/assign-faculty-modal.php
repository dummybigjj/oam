    <!-- View History Modal -->
    <div id="AssignFaculty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formAssignFaculty">

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font><i class="icon-user" aria-hidden="true"></i> Assign Faculty</div>
                <select name="faculty_assigned" required="" class="form-control">
                  <option> </option>
                  <?php if(!empty($faculty)): ?>
                    <?php foreach ($faculty as $value): ?>
                      <option value="<?php echo $value['user_id'] ?>"><?php echo $value['u_full_name']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="line"></div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-calendar" aria-hidden="true"></i> Schedule Information</div>
              </div>
              <div class="form-group col-md-12">
                <input type="hidden" name="schedule_id" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Subject Title</div>
                <select name="subject_id" required="" class="form-control">
                  <?php if(!empty($subjects)): ?>
                    <?php foreach ($subjects as  $value): ?>
                    <option value="<?php echo $value['subject_id'] ?>"><?php echo $value['subject_title']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <div class="form-control-label"><font style="color: red">*</font> Subject Code</div>
                <input type="text" name="subject_code" oninput="handleInput(event)" maxlength="60" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Room Name</div>
                <select name="room_id" required="" class="form-control">
                  <?php if(!empty($rooms)): ?>
                    <?php foreach ($rooms as  $value): ?>
                    <option value="<?php echo $value['room_id'] ?>"><?php echo $value['room_name']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <div class="form-control-label"><font style="color: red">*</font> Schedule Day</div>
                <select name="day" required="" class="form-control">
                  <option value="MONDAY"> MONDAY </option>
                  <option value="TUESDAY"> TUESDAY </option>
                  <option value="WEDNESDAY"> WEDNESDAY </option>
                  <option value="THURSDAY"> THURSDAY </option>
                  <option value="FRIDAY"> FRIDAY </option>
                  <option value="SATURDAY"> SATURDAY </option>
                  <option value="SUNDAY"> SUNDAY </option>
                </select>
                <div class="form-control-label"><font style="color: red">*</font> Schedule Time</div>
                <select name="time" required="" class="form-control">
                  <option value="08:00:00"> 08:00AM - 09:30AM </option>
                  <option value="10:00:00"> 10:00AM - 11:30AM </option>
                  <option value="12:30:00"> 12:30PM - 02:00PM </option>
                  <option value="14:30:00"> 02:30PM - 04:00PM </option>
                  <option value="16:30:00"> 04:30PM - 06:00PM </option>
                  <option value="18:30:00"> 06:30PM - 08:00PM </option>
                </select>
                <input type="hidden" name="sched" readonly="" class="form-control" required="">
              </div>
              
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp&nbsp Close &nbsp&nbsp&nbsp</button>
              <button type="button" onclick="save_schedule()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>