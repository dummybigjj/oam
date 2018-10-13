    <!-- Remove Student Permanently Modal -->
    <div id="removeStudentRegistration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formremoveStudentRegistration">
              <input type="hidden" name="student_id" class="form-control" required="">
              <div class="form-group col-md-12">
                <div class="alert alert-danger" role="alert">
                  <i class="fa fa-question-circle-o"></i> <small class="h4" style="color: #111">Are you sure do you want to "Delete Permanently" this student from the registration list ?. "Attendance Record", "Student Assigned Subjects and Schedules" will be permanently deleted also. <br><br>(Click "Yes" to continue).</small>
                </div>
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp No &nbsp&nbsp</button>
              <button type="submit" onclick="remove_student()" class="btn btn-success">&nbsp&nbsp Yes &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>