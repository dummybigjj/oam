    <!-- View History Modal -->
    <div id="viewStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formviewStudent">
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-user-o" aria-hidden="true"></i> Personal Information</div>
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label">Student No.</div>
                <input type="text" name="student_no" readonly="" class="form-control" required="">
                <div class="form-control-label">National ID</div>
                <input type="text" name="national_id" readonly="" class="form-control" required="">
                <div class="form-control-label">Email</div>
                <input type="text" name="email_address" readonly="" class="form-control" required="">
                <div class="form-control-label">Mobile No.</div>
                <input type="text" name="mobile_no" readonly="" class="form-control" required="">
                <div class="form-control-label">English Name</div>
                <input type="text" name="english_name" readonly="" class="form-control" required="">
                <div class="form-control-label">Arabic Name</div>
                <input type="text" name="arabic_name" readonly="" class="form-control" required="">
                <div class="form-control-label">Nationality</div>
                <input type="text" name="nationality" readonly="" class="form-control" required="">
                <div class="form-control-label">Sign Contract</div>
                <input type="text" name="sign_contract" readonly="" class="form-control" required="">
                <div class="form-control-label">Preferred Course</div>
                <input type="text" name="remarks" readonly="" class="form-control" required="">
              </div>
<!-- 
              <div class="line"></div>

              <div class="form-group col-md-12">
                <div class="form-control-label"> Batch Year Enrolled</div>
                <input type="text" name="batch_year_enrolled" readonly="" class="form-control" required="">
              </div> -->

              <div class="line"></div><br>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-info-circle" aria-hidden="true"></i> Other Details</div>
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"> Created By</div>
                <input type="text" name="created_by" readonly="" class="form-control" required="">
                <div class="form-control-label"> Updated by</div>
                <input type="text" name="updated_by" readonly="" class="form-control" required="">
                <div class="form-control-label"> Created</div>
                <input type="text" name="created" readonly="" class="form-control" required="">
                <div class="form-control-label"> Modified</div>
                <input type="text" name="modified" readonly="" class="form-control" required="">
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