    <!-- View History Modal -->
    <div id="editRoom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left forms">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title"></h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          
          <div class="modal-body">

            <form id="formeditRoom">
              <input type="hidden" name="room_id" class="form-control" required="">
              <div class="form-group col-md-12">
                <label class="form-control-label"><font style="color: red">*</font> Room Name</label>
                <input type="text" name="room_name" class="form-control" required="">
              </div>
            </form>
            
          </div>
          <div class="modal-footer col-md-12">
            <div class="btn-group">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">&nbsp&nbsp Close &nbsp&nbsp</button>
              <button type="submit" onclick="save_room()" class="btn btn-success">&nbsp&nbsp Save &nbsp&nbsp</button>
            </div>
          </div>
        </div>
      </div>
    </div>