    <!-- View History Modal -->
    <div id="viewStudentRegistration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formviewStudentRegistration">
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-user-o" aria-hidden="true"></i> Student Registration Details</div>
              </div>
              <div class="form-group col-md-12">
                <!-- <input type="hidden" name="student_id" class="form-control" required=""> -->
                <div class="form-control-label"><font style="color: red">*</font> Student No.</div>
                <input type="text" name="student_no" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Student Name</div>
                <input type="text" name="arabic_name" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Subject</div>
                <input type="text" name="subject_title" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Subject Code</div>
                <input type="text" name="subject_code" readonly="" class="form-control" required="">
              </div><br>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-calendar" aria-hidden="true"></i> Student Schedule</div>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Hall</div>
                <input type="text" name="room_name" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Day</div>
                <input type="text" name="day" readonly="" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Time</div>
                <input type="text" name="time" readonly="" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Vocational Program</div>
                <input type="text" name="voc_program_acronym" readonly="" class="form-control" required="">
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp&nbsp Close &nbsp&nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>