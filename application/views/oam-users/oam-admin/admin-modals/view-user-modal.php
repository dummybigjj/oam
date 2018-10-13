    <!-- View History Modal -->
    <div id="viewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formviewUser">
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="icon-user"></i> Personal Information</div>                
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Name</div>
                <input type="text" name="name" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Email</div>
                <input type="text" name="email" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Designation</div>
                <input type="text" name="designation" readonly="" class="form-control" required="">
              </div>

              <div class="line"></div><br>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-history"></i> Login History</div>                
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Recent Login</div>
                <input type="text" name="recent_login" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Device Name</div>
                <input type="text" name="device_name" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Device IP Address</div>
                <input type="text" name="device_ip_address" readonly="" class="form-control" required="">
              </div>

              <div class="line"></div><br>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-info-circle" aria-hidden="true"></i> Other Information</div>                
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Password Reset Date</div>
                <input type="text" name="password_reset_date" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Created by</div>
                <input type="text" name="created_by" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Updated by</div>
                <input type="text" name="updated_by" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Created</div>
                <input type="text" name="created" readonly="" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Modified</div>
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