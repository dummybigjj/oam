    <!-- View History Modal -->
    <div id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formeditUser">
              <input type="hidden" name="user_id" class="form-control" required="">
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Name</div>
                <input type="text" name="name" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Email</div>
                <input type="text" name="email" class="form-control" required="">
              </div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><font style="color: red">*</font> Designation</div>
                <select name="designation" required="" class="form-control">
                  <option> </option>
                  <option value="Faculty">Faculty</option>
                  <option value="Administrator">Administrator</option>
                  <option value="Registrar">Registrar</option>
                  <option value="Program Head">Program Head</option>
                </select>
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <button type="submit" onclick="save_user()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>