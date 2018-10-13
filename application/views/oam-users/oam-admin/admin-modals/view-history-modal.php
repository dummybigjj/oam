    <!-- View History Modal -->
    <div id="viewHistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formviewHistory">
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Activity</div>
                <textarea type="text" name="activity" class="form-control" readonly=""></textarea>
              </div>

              <div class="line"></div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="icon-user" aria-hidden="true"></i> Created by</div>
                <input type="text" name="name" class="form-control" required="" readonly="">
              </div>
              <div class="form-group col-md-12">
                <input type="text" name="email" class="form-control" required="" readonly="">
              </div>
              <div class="form-group col-md-12">
                <input type="text" name="designation" class="form-control" required="" readonly="">
              </div>

              <div class="line"></div>

              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="icon-padnote" aria-hidden="true"></i> Device Information</div>
                <input type="text" name="device_use" class="form-control" required="" readonly="">
              </div>
              <div class="form-group col-md-12">
                <input type="text" name="device_name" class="form-control" required="" readonly="">
              </div>
              <div class="form-group col-md-12">
                <input type="text" name="device_ip" class="form-control" required="" readonly="">
              </div>

              <div class="line"></div>
              <div class="form-group col-md-12">
                <div class="form-control-label"><i class="fa fa-pencil" aria-hidden="true"></i> Created</div>
                <input type="text" name="created" class="form-control" required="" readonly="">
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