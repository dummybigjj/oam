    <!-- View History Modal -->
    <div id="editStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formeditStudent">
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-user-o" aria-hidden="true"></i> Personal Information</div>
              </div>
              <div class="form-group col-md-12">
                <input type="hidden" name="student_id" class="form-control" required="">
                <div class="form-control-label"><font style="color: red">*</font> Student No.</div>
                <input type="text" name="student_no" maxlength="5" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> National ID</div>
                <input type="text" name="national_id" maxlength="10" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Email</div>
                <input type="text" name="email_address" maxlength="60" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Mobile No.</div>
                <input type="text" data-mask="(999) 999-9999" name="mobile_no" class="form-control" required=""><small class="help-block-none">(999) 999-9999</small>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> English Name</div>
                <input type="text" name="english_name" maxlength="60" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Arabic Name</div>
                <input type="text" name="arabic_name" maxlength="60" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Nationality</div>
                <input type="text" name="nationality" maxlength="60" class="form-control" required="">
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Sign Contract</div>
                <input type="text" name="sign_contract" data-mask="9999-99-99" class="form-control" required=""><small class="help-block-none">YYYY-MM-DD</small>
              </div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Preferred Course</div>
                <input type="text" name="remarks" maxlength="60" class="form-control" required="">
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp&nbsp Close &nbsp&nbsp&nbsp</button>
              <button type="submit" onclick="save_student()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>